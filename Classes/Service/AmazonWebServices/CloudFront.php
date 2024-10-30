<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Service\AmazonWebServices;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Aws\CloudFront\CloudFrontClient;
use T3rrific\AwsCloudfrontManager\Utility\AwsExceptionHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Amazon Web Services authentication class
 */
class CloudFront extends Authentication
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->configuration = [
            'version' => 'latest',
            'region' => 'us-east-1'
        ];
    }

    /**
     * Create an invalidation request.
     */
    public function createInvalidation(string $distributionId, array $paths, ?string $callerReference = null): ?array
    {
        $cloudFrontClient = new CloudFrontClient($this->getConfiguration());
        try {
            $result = $cloudFrontClient->createInvalidation([
                'DistributionId' => $distributionId,
                'InvalidationBatch' => [
                    'CallerReference' => ($callerReference ?? bin2hex(random_bytes(20))),
                    'Paths' => [
                        'Items' => $paths,
                        'Quantity' => count($paths)
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            $exceptionHandler = GeneralUtility::makeInstance(AwsExceptionHandler::class);
            return $exceptionHandler->getResponse($e);
        }

        if (isset($result)) {
            return [
                'success' => true,
                'invalidationId' => $result->search('Invalidation.Id')
            ];
        }
        // Invalidation request failed
        return null;
    }

    /**
     * Get the information about a distribution.
     */
    public function getDistribution(string $distributionId): ?array
    {
        $cloudFrontClient = new CloudFrontClient($this->getConfiguration());
        try {
            $result = $cloudFrontClient->getDistribution([
                'Id' => $distributionId
            ]);
        } catch (\Exception $e) {
            $exceptionHandler = GeneralUtility::makeInstance(AwsExceptionHandler::class);
            return $exceptionHandler->getResponse($e);
        }

        if (isset($result)) {
            return [
                'success' => true,
                'distribution' => $result->search('Distribution')
            ];
        }
        // Invalidation request failed
        return null;
    }
}
