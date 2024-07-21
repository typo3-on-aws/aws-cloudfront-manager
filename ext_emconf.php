<?php
declare(strict_types=1);

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'AWS CloudFront Manager',
    'description' => 'Backend module that lets backend users trigger Amazon CloudFront invalidations',
    'category' => 'backend',
    'author' => 'Michael Schams',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.99.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ]
];
