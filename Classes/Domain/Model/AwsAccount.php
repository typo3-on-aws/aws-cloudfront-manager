<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Domain\Model;

/**
 * Amazon CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class AwsAccount extends AbstractEntity
{
    /**
     * Creation timestamp
     */
    protected int $crdate;

    /**
     * Access key ID
     */
    protected string $accessKeyId = '';

    /**
     * Secret access key
     */
    protected string $secretAccessKey = '';

    /**
     * Sets the access key ID
     */
    public function setAccessKeyId(string $accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
    }

    /**
     * Returns the access key ID
     */
    public function getAccessKeyId(): string
    {
        return $this->accessKeyId;
    }


    /**
     * Sets the secret access key
     */
    public function setSecretAccessKey(string $secretAccessKey)
    {
        $this->secretAccessKey = $secretAccessKey;
    }

    /**
     * Returns the secret access key
     */
    public function getSecretAccessKey(): string
    {
        return $this->secretAccessKey;
    }
}
