<?php
declare(strict_types=1);

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

$languageFile = 'aws_cloudfront_manager/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_awsaccount',
        'label' => 'access_key_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'distribution_id,paths',
        'iconfile' => 'EXT:aws_cloudfront_manager/Resources/Public/Icons/awsaccount.svg',
        'rootLevel' => 1,
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, access_key_id, secret_access_key, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.crdate',
            'config' => [
                'type' => 'input'
            ],
        ],

        'cruser_id' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'access_key_id' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_awsaccount.label.accessKeyId',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_awsaccount.description.accessKeyId',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'secret_access_key' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_awsaccount.label.secretAccessKey',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_awsaccount.description.secretAccessKey',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
    ],
];
