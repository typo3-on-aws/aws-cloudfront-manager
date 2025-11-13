<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Service\AmazonWebServices;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Amazon Web Services authentication class
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
     * Set access credentials, e.g. ['key' => $accessKeyId, 'secret' => $secretAccessKey]
     */
    public function setCredentials(array $credentials): void
    {
        $this->configuration['credentials'] = $credentials;
    }

    /**
     * Get configuration
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
