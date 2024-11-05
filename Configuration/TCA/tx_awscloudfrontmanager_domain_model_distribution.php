<?php
declare(strict_types=1);

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

$languageFile = 'aws_cloudfront_manager/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution',
        'label' => 'distribution_id',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'distribution_id,paths',
        'iconfile' => 'EXT:aws_cloudfront_manager/Resources/Public/Icons/distribution.svg',
        'rootLevel' => 1,
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, distribution_id, aws_account_id, domain_name, comment, paths',
    ],
    'types' => [
        '1' => [
            'showitem' => implode(',', [
                'hidden, distribution_id, paths',
                '--div--;LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.tabs.awsAccount, aws_account_id',
                '--div--;LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.tabs.additionalInformation, domain_name, comment',
                '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access'
            ])
        ]
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

        'distribution_id' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.label.distributionId',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.description.distributionId',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'aws_account_id' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.label.awsAccountId',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.description.awsAccountId',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_awscloudfrontmanager_domain_model_awsaccount',
                'foreign_table' => 'tx_awscloudfrontmanager_domain_model_awsaccount',
                'maxitems' => 1,
                'minitems' => 0,
                'size' => 1,
                'suggestOptions' => [
                    'default' => [
                        'additionalSearchFields' => 'nav_title, url',
                        'addWhere' => 'AND tx_awscloudfrontmanager_domain_model_awsaccount.deleted = 0',
                    ],
                ],
            ],
        ],
        'domain_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.label.domainName',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.description.domainName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'readOnly' => true,
                'nullable' => true
            ],
        ],
        'comment' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.label.comment',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.description.comment',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'readOnly' => true,
                'nullable' => true
            ],
        ],
        'paths' => [
            'exclude' => false,
            'label' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.label.paths',
            'description' => 'LLL:EXT:' . $languageFile . ':tx_awscloudfrontmanager_domain_model_distribution.description.paths',
            'config' => [
                'type' => 'text',
                'cols' => 30,
                'rows' => 5,
                'eval' => 'trim,required'
            ],
        ],

    ],
];
