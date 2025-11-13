<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Domain\Model;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Distribution extends AbstractEntity
{
    /**
     * Creation timestamp
     */
    protected int $crdate;

    /**
     * Distribution ID
     */
    protected string $distributionId = '';

    /**
     * AWS account ID
     */
    protected ?AwsAccount $awsAccountId;

    /**
     * CloudFront domain name
     */
    protected ?string $domainName = '';

    /**
     * Comment
     */
    protected ?string $comment = '';

    /**
     * Paths
     */
    protected string $paths = '';

    /**
     * Sets the distribution ID
     */
    public function setDistributionId(string $distributionId)
    {
        $this->distributionId = $distributionId;
    }

    /**
     * Returns the distribution ID
     */
    public function getDistributionId(): string
    {
        return $this->distributionId;
    }

    /**
     * Sets the AWS account ID
     */
    public function setAwsAccountId(?AwsAccount $awsAccountId)
    {
        $this->awsAccountId = $awsAccountId;
    }

    /**
     * Returns the AWS account ID
     */
    public function getAwsAccountId(): ?AwsAccount
    {
        return $this->awsAccountId;
    }

    /**
     * Sets the CloudFront domain name
     */
    public function setDomainName(?string $domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * Returns the CloudFront domain name
     */
    public function getDomainName(): ?string
    {
        return $this->domainName;
    }

    /**
     * Sets the comment
     */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Returns the comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Sets the paths
     */
    public function setPaths(string $paths)
    {
        $this->paths = $paths;
    }

    /**
     * Returns the paths
     */
    public function getPaths(): array
    {
        return explode("\n", $this->paths);
    }
}
