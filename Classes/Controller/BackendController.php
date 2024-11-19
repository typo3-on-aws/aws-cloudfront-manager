<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Controller;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use T3rrific\AwsCloudfrontManager\Domain\Model\Distribution;
use T3rrific\AwsCloudfrontManager\Domain\Repository\AwsAccountRepository;
use T3rrific\AwsCloudfrontManager\Domain\Repository\DistributionRepository;
use T3rrific\AwsCloudfrontManager\Service\AmazonWebServices\CloudFront;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;

final class BackendController
{
    const EXTENSION_KEY = "aws_cloudfront_manager";

    /**
     * \TYPO3\CMS\Core\Messaging\FlashMessageQueue
     */
    private FlashMessageQueue $messageQueue;

    /**
     * \T3rrific\AwsCloudfrontManager\Service\AmazonWebServices\CloudFront
     */
    private CloudFront $cloudfront;

    /**
     * \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder
     */
    //protected UriBuilder $uriBuilder;

    /**
     * Constructor.
     */
    public function __construct(
        private ModuleTemplateFactory $moduleTemplateFactory,
        private LanguageServiceFactory $languageServiceFactory,
        private AwsAccountRepository $awsAccountRepository,
        private DistributionRepository $distributionRepository,
        private UriBuilder $uriBuilder,
        private FrontendInterface $cache
    ) {}

    /**
     * Initialize the FlashMessage queue and the backend module template. Add CSS and JS files.
     */
    protected function initialize(ServerRequestInterface $request): ModuleTemplate
    {
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $this->messageQueue = $flashMessageService->getMessageQueueByIdentifier();

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:' . self::EXTENSION_KEY . '/Resources/Public/Css/Backend/aws_cloudfront_manager.css');
        $pageRenderer->loadJavaScriptModule('@typo3/backend/copy-to-clipboard.js');
        $pageRenderer->addInlineLanguageLabelFile('EXT:backend/Resources/Private/Language/locallang_copytoclipboard.xlf');

        $moduleTemplate = $this->moduleTemplateFactory->create($request);
        return $moduleTemplate;
    }

    /**
     * List distributions.
     */
    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->initialize($request);
        $view->assign("aws_sdk_php", $this->awsSdkPhpAvailable());

        $distributions = $this->distributionRepository->findAll();
        $view->assign("distributions", $distributions);

        if (count($distributions) == 0) {
            $this->messageQueue->addMessage(
                GeneralUtility::makeInstance(
                    FlashMessage::class,
                    $this->translate('flashMessage.noDistributionsConfigured.message'),
                    $this->translate('flashMessage.noDistributionsConfigured.title'),
                    ContextualFeedbackSeverity::WARNING
                )
            );
        }

        return $view->renderResponse('Backend/List');
    }

    /**
     * Show details of a distribution.
     */
    public function detailsAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->initialize($request);
        $view->assign("aws_sdk_php", $this->awsSdkPhpAvailable());

        $refresh = $this->isRefreshRequest($request);

        $routing = $request->getAttribute('routing');
        $distributionId = $routing['distributionId'];
        $distribution = $this->distributionRepository->findOneBy(["distributionId" => $distributionId]);
        $view->assign("distribution", $distribution);

        $cacheHash = md5($distribution->getDistributionId());
        $distributionDetails = ($refresh === true ? null : $this->cache->get($cacheHash));

        if ($distributionDetails) {
            $view->assign("dataFromCache", true);
            $view->assign("distributionDetails", $distributionDetails);
        } else {
            $this->prepareCloudFrontCall($distribution);
            $distributionDetails = $this->cloudfront->getDistribution($distribution->getDistributionId());
            if (is_array($distributionDetails) && array_key_exists("success", $distributionDetails)) {
                if ($distributionDetails["success"] === false) {
                    $this->messageQueue->addMessage(
                        GeneralUtility::makeInstance(
                            FlashMessage::class,
                            $distributionDetails["error"],
                            $distributionDetails["message"],
                            ContextualFeedbackSeverity::ERROR
                        )
                    );
                } else {
                    $this->updateAdditionalInformation($distributionDetails["distribution"]);
                    $view->assign("dataFromCache", false);
                    $view->assign("distributionDetails", $distributionDetails);
                    $this->cache->set($cacheHash, $distributionDetails);
                }
            }
        }

        return $view->renderResponse('Backend/Details');
    }

    /**
     * Trigger an invalidation request.
     */
    public function invalidationAction(ServerRequestInterface $request): ResponseInterface
    {
        $view = $this->initialize($request);

        $routing = $request->getAttribute('routing');
        $distributionId = $routing['distributionId'];
        $distribution = $this->distributionRepository->findOneBy(["distributionId" => $distributionId]);

        $this->prepareCloudFrontCall($distribution);
        $invalidation = $this->cloudfront->createInvalidation($distribution->getDistributionId(), $distribution->getPaths());
        if (is_array($invalidation) && array_key_exists("success", $invalidation)) {
            if ($invalidation["success"] === false) {
                $this->messageQueue->addMessage(
                    GeneralUtility::makeInstance(
                        FlashMessage::class,
                        $invalidation["error"],
                        $invalidation["message"],
                        ContextualFeedbackSeverity::ERROR,
                        true
                    )
                );
            } else {
                $this->messageQueue->addMessage(
                    GeneralUtility::makeInstance(
                        FlashMessage::class,
                        $this->translate('flashMessage.invalidationTriggered.message'),
                        $this->translate('flashMessage.invalidationTriggered.title'),
                        ContextualFeedbackSeverity::OK,
                        true
                    )
                );
            }
        }

        // Using a route path
        $redirectUri = $this->uriBuilder->buildUriFromRoutePath('/module/cloudfront-manager');
        return (new RedirectResponse($redirectUri));
    }

    /**
     * Returns true, if user forced a refresh of the CloudFront distribution details, otherwise false.
     */
    private function isRefreshRequest(ServerRequestInterface $request): bool
    {
        // ?token=abcd&refresh=true
        $queryString = $request->getServerParams()['QUERY_STRING'];
        foreach (explode("&", $queryString) as $keyValuePair) {
            $element = explode("=", $keyValuePair);
            if ($element[0] == "refresh") {
                return ($element[1] == 'true' ? true : false);
            }
        }
        return false;
    }

    /**
     * Prepare CloudFront API call (e.g. set access credentials if available).
     */
    private function prepareCloudFrontCall(Distribution $distribution)
    {
        $this->cloudfront = GeneralUtility::makeInstance(CloudFront::class);
        $awsAccount = $this->awsAccountRepository->findOneBy(["uid" => $distribution->getAwsAccountId()]);
        if ($awsAccount) {
            $accessKeyId = $awsAccount->getAccessKeyId() ?: null;
            $secretAccessKey = $awsAccount->getSecretAccessKey() ?: null;
            if ($accessKeyId && $secretAccessKey) {
                $this->cloudfront->setCredentials([
                    'key' => $accessKeyId,
                    'secret' => $secretAccessKey
                ]);
            }
        }
    }

    /**
     * Store/update additional information about the CloudFront distribution in the database
     */
    private function updateAdditionalInformation(array $distributionDetails)
    {
        $distribution = $this->distributionRepository->findOneBy(["distributionId" => $distributionDetails["Id"]]);
        // @TODO: error handling if distribution not found in repository
        $distribution->setDomainName($distributionDetails["DomainName"]);
        $distribution->setComment($distributionDetails["DistributionConfig"]["Comment"]);
        $this->distributionRepository->update($distribution);
        $persistenceManager = GeneralUtility::makeInstance(PersistenceManagerInterface::class);
        $persistenceManager->persistAll();
    }

    /**
     * Check if the AWS SDK for PHP is available
     */
    private function awsSdkPhpAvailable()
    {
        if(class_exists('Aws\CloudFront\CloudFrontClient')) {
            return true;
        }

        $this->messageQueue->addMessage(
            GeneralUtility::makeInstance(
                FlashMessage::class,
                $this->translate('flashMessage.extensionDependencyError.message'),
                $this->translate('flashMessage.extensionDependencyError.title'),
                ContextualFeedbackSeverity::ERROR,
                true
            )
        );

        return false;
    }

    /**
     * Translation shortcut
     */
    protected function translate(string $key): string
    {
        $languageService = $this->languageServiceFactory->createFromUserPreferences($GLOBALS['BE_USER']);
        return $languageService->sL('LLL:EXT:' . self::EXTENSION_KEY . '/Resources/Private/Language/locallang.xlf:' . $key);
    }
}
