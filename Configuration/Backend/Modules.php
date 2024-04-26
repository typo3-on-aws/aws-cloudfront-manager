<?php

/**
 * Amazon CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use T3rrific\AwsCloudfrontManager\Controller\BackendController;

/**
 * Configure backend module, path, position, etc.
 */
return [
    'admin_cloudfront_manager' => [
        'parent' => 'site',
        'position' => ['after' => 'site_redirects'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/cloudfront-manager',
        'labels' => 'LLL:EXT:aws_cloudfront_manager/Resources/Private/Language/locallang_mod.xlf',
        'iconIdentifier' => 'module-aws-cloudfront-manager',
        'extensionName' => 'AwsCloudfrontManager',
        'controllerActions' => [
            BackendController::class => [
                'listDistributions', 'distributionDetails', 'invalidation'
            ]
        ]
    ]
];
