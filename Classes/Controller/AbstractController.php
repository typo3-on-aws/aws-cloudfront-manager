<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Controller;

/**
 * Amazon CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Psr\Http\Message\ServerRequestInterface;
use T3rrific\AwsCloudfrontManager\Domain\Repository\AwsAccountRepository;
use T3rrific\AwsCloudfrontManager\Domain\Repository\DistributionRepository;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Abstract action controller.
 */
class AbstractController extends ActionController
{
    const EXTENSION_KEY = 'aws_cloudfront_manager';

    /**
     * Constructor
     */
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly AwsAccountRepository $awsAccountRepository,
        protected readonly DistributionRepository $distributionRepository,
        protected readonly FrontendInterface $cache
    ) {}

    /**
     * Generates the action menu
     */
    protected function initializeModuleTemplate(ServerRequestInterface $request): ModuleTemplate
    {
        $this->view->setLayoutRootPaths(['EXT:' . self::EXTENSION_KEY . '/Resources/Private/Layouts']);
        $this->view->setTemplateRootPaths(['EXT:' . self::EXTENSION_KEY . '/Resources/Private/Templates']);
        $this->view->setPartialRootPaths(['EXT:' . self::EXTENSION_KEY . '/Resources/Private/Partials']);

        // ...
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile('EXT:' . self::EXTENSION_KEY . '/Resources/Public/Css/Backend/aws_cloudfront_manager.css');
        $pageRenderer->loadJavaScriptModule('@typo3/backend/copy-to-clipboard.js');
        $pageRenderer->addInlineLanguageLabelFile('EXT:backend/Resources/Private/Language/locallang_copytoclipboard.xlf');

        // ...
        $menuItems = [
            'backendListDistributions' => [
                'controller' => 'Backend',
                'action' => 'listDistributions',
                'title' => $this->translate('title.listDistributions'),
            ],
            'backendDistributionDetails' => [
                'controller' => 'Backend',
                'action' => 'distributionDetails',
                'title' => $this->translate('title.distributionDetails'),
            ],
        ];

        $moduleTemplate = $this->moduleTemplateFactory->create($request);
        foreach ($menuItems as $menuItemConfig) {
            if ($request->getControllerName() === $menuItemConfig['controller']) {
                $isActive = $request->getControllerActionName() === $menuItemConfig['action'] ? true : false;
            } else {
                $isActive = false;
            }
            if ($isActive) {
                $this->view->assign('title', $menuItemConfig['title']);
            }
        }
        $moduleTemplate->setFlashMessageQueue($this->getFlashMessageQueue());

        return $moduleTemplate;
    }

    /**
     * Translation shortcut
     */
    protected function translate(string $key, ?array $arguments = null): string
    {
        return LocalizationUtility::translate($key, self::EXTENSION_KEY, $arguments) ?? '';
    }
}
