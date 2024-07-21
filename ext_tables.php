<?php
declare(strict_types=1);

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

(function () {

    // Domain model "aws_account"
    ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_awscloudfrontmanager_domain_model_awsaccount',
        'EXT:aws_cloudfront_manager/Resources/Private/Language/locallang_csh_tx_awscloudfrontmanager_domain_model_awsaccount.xlf'
    );
    // Make table available in the backend, for example through the Web -> List module
    ExtensionManagementUtility::allowTableOnStandardPages(
        'tx_awscloudfrontmanager_domain_model_awsaccount'
    );

    // Domain model "distribution"
    ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_awscloudfrontmanager_domain_model_distribution',
        'EXT:aws_cloudfront_manager/Resources/Private/Language/locallang_csh_tx_awscloudfrontmanager_domain_model_distribution.xlf'
    );
    // Make table available in the backend, for example through the Web -> List module
    ExtensionManagementUtility::allowTableOnStandardPages(
        'tx_awscloudfrontmanager_domain_model_distribution'
    );

})();
