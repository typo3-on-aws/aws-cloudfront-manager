<?php

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use T3rrific\AwsCloudfrontManager\Controller\BackendController;

/**
 * Configure backend module, path, position, etc.
 */
return [
    'aws_cloudfront_manager' => [
        'parent' => 'site',
        'position' => ['bottom'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/cloudfront-manager',
        'labels' => 'LLL:EXT:aws_cloudfront_manager/Resources/Private/Language/locallang_mod.xlf',
        'iconIdentifier' => 'module-aws-cloudfront-manager',
        'routes' => [
            '_default' => [
                'path' => '/list',
                'target' => BackendController::class . '::listAction',
            ],
            'details' => [
                'path' => '/details/{distributionId}',
                'target' => BackendController::class . '::DetailsAction',
            ],
            'invalidation' => [
                'path' => '/invalidation/{distributionId}',
                'target' => BackendController::class . '::InvalidationAction',
            ],
        ]
    ]
];
