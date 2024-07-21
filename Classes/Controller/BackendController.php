<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Controller;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Psr\Http\Message\ResponseInterface;
use T3rrific\AwsCloudfrontManager\Domain\Model\Distribution;
use T3rrific\AwsCloudfrontManager\Service\AmazonWebServices\CloudFront;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;

/**
 * BackendController
 */
class BackendController extends AbstractController
{
    private CloudFront $cloudfront;
    private ModuleTemplate $moduleTemplate;

    /**
     * Function will be called before every other action
     */
    protected function initializeAction()
    {
        parent::initializeAction();
    }

    /**
     * List distributions
     */
    public function listDistributionsAction(): ResponseInterface
    {
        $this->moduleTemplate = $this->initializeModuleTemplate($this->request);
        $this->view->assign("aws_sdk_php", $this->awsSdkPhpAvailable());

        $distributions = $this->distributionRepository->findAll();
        $this->view->assign("distributions", $distributions);

        if (count($distributions) == 0) {
            $this->addFlashMessage(
                $this->translate('flashMessage.noDistributionsConfigured.message'),
                $this->translate('flashMessage.noDistributionsConfigured.title'),
                AbstractMessage::WARNING
            );
        }

        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    /**
     * Show details of a distribution
     */
    public function distributionDetailsAction(Distribution $distribution, string $refresh = ""): ResponseInterface
    {
        $this->moduleTemplate = $this->initializeModuleTemplate($this->request);
        $this->view->assign("aws_sdk_php", $this->awsSdkPhpAvailable());
        $this->view->assign("distribution", $distribution);

        $cacheHash = md5($distribution->getDistributionId());
        $distributionDetails = ($refresh === "true" ? null : $this->cache->get($cacheHash));

        if ($distributionDetails) {
            $this->view->assign("dataFromCache", true);
            $this->view->assign("distributionDetails", $distributionDetails);
        } else {
            $this->prepareCloudFrontCall($distribution);
            $distributionDetails = $this->cloudfront->getDistribution($distribution->getDistributionId());
            if (is_array($distributionDetails) && array_key_exists("success", $distributionDetails)) {
                if ($distributionDetails["success"] === false) {
                    $this->addFlashMessage(
                        $distributionDetails["error"],
                        $distributionDetails["message"],
                        AbstractMessage::ERROR
                    );
                } else {
                    $this->updateAdditionalInformation($distributionDetails["distribution"]);
                    $this->view->assign("dataFromCache", false);
                    $this->view->assign("distributionDetails", $distributionDetails);
                    $this->cache->set($cacheHash, $distributionDetails);
                }
            }
        }

        $this->moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($this->moduleTemplate->renderContent());
    }

    /**
     * Trigger an invalidation request
     */
    public function invalidationAction(Distribution $distribution): ResponseInterface
    {
        $this->prepareCloudFrontCall($distribution);
        $invalidation = $this->cloudfront->createInvalidation($distribution->getDistributionId(), $distribution->getPaths());
        if (is_array($invalidation) && array_key_exists("success", $invalidation)) {
            if ($invalidation["success"] === false) {
                $storeInSession = true;
                $this->addFlashMessage(
                    $invalidation["error"],
                    $invalidation["message"],
                    AbstractMessage::ERROR,
                    $storeInSession
                );
            } else {
                $storeInSession = true;
                $this->addFlashMessage(
                    $this->translate('flashMessage.invalidationTriggered.message', [1 => $distribution->getDistributionId()]),
                    $this->translate('flashMessage.invalidationTriggered.title'),
                    AbstractMessage::OK,
                    $storeInSession
                );
            }
        }

        return (new ForwardResponse('listDistributions'))->withArguments(['forwarded' => true]);
    }

    /**
     * Prepare CloudFront API call (e.g. set access credentials if available)
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
    protected function updateAdditionalInformation(array $distributionDetails)
    {
        $distribution = $this->distributionRepository->findOneBy(["distributionId" => $distributionDetails["Id"]]);
        // @TODO: error handling if distribution not found in repository
        $distribution->setDomainName($distributionDetails["DomainName"]);
        $distribution->setComment($distributionDetails["DistributionConfig"]["Comment"]);
        $this->distributionRepository->update($distribution);
    }

    /**
     * Check if the AWS SDK for PHP is available
     */
    private function awsSdkPhpAvailable()
    {
        if(class_exists('Aws\CloudFront\CloudFrontClient')) {
            return true;
        }
        $storeInSession = true;
        $this->addFlashMessage(
            $this->translate('flashMessage.extensionDependencyError.message'),
            $this->translate('flashMessage.extensionDependencyError.title'),
            AbstractMessage::ERROR,
            $storeInSession
        );

        return false;
    }
}
