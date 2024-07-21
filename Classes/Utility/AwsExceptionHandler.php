<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Utility;

/**
 * AWS CloudFront Integration for TYPO3 CMS
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 *
 * See README.md and/or LICENSE.md for copyright and license information.
 */

use Aws\Exception\AwsException;
use Aws\Exception\CredentialsException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Exception Handler
 */
class AwsExceptionHandler
{
    /**
     * Constructor
     */
    public function __construct(private readonly LoggerInterface $logger) {}

    /**
     * Get response for exception
     */
    public function getResponse(\Exception $exception): array
    {
        $response = [
            'success' => false,
            'message' => 'Unknown error'
        ];

        // Aws\CloudFront\Exception\CloudFrontException
        //$exceptionClass = get_class($exception);

        if ($exception instanceof CredentialsException) {
            /**
             * Exception
             * Extended by RuntimeException
             * Extended by Aws\Exception\CredentialsException
             * https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Exception.CredentialsException.html
             */
            $response = [
                'success' => false,
                'message' => 'Invalid access credentials',
                'error' => $exception->getMessage()
            ];
        } elseif ($exception instanceof AwsException) {
            /**
             * Exception
             * Extended by RuntimeException
             * Extended by Aws\Exception\AwsException
             * Extended by Aws\CloudFront\Exception\CloudFrontException
             * https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Exception.AwsException.html
             */
            $response = [
                'success' => false,
                'message' => 'Configuration error: ' . $exception->getAwsErrorCode(),
                'error' => $exception->getAwsErrorMessage()
            ];
        } elseif ($exception instanceof \Exception) {
            $response = [
                'success' => false,
                'message' => 'Fatal error. Please check the system logs.',
                'error' => $exception->getMessage()
            ];
        }

        $this->logger->log(LogLevel::CRITICAL, '{message}', $response);
        return $response;
    }
}
