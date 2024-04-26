<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Service\AmazonWebServices;

/**
 * Amazon CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 * Based on EXT:sf_event_mgt by Torben Hansen <derhansen@gmail.com> | https://github.com/derhansen/sf_event_mgt
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 */
class Authentication
{
    /**
     *
     */
    protected array $configuration;

    /**
     *
     */
    protected array $credentials;

    /**
     *
     */
    public function setCredentials(array $credentials): void
    {
        $this->configuration['credentials'] = $credentials;
    }

    /**
     *
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
