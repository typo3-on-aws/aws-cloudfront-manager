<?php
declare(strict_types=1);
namespace T3rrific\AwsCloudfrontManager\Service;

/**
 * AWS CloudFront Manager
 * @author Michael Schams | https://schams.net | https://t3rrific.com
 * Based on EXT:sf_event_mgt by Torben Hansen <derhansen@gmail.com> | https://github.com/derhansen/sf_event_mgt
 *
 * See README.md and/or LICENSE.txt for copyright and license information.
 */

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

class UserSessionService
{
    private const SESSION_KEY = 'aws-cloudfront-manager';

    /**
     * Returns the session data
     *
     * @return mixed
     */
    public function getSessionData()
    {
        return $this->getBackendUser()->getSessionData(self::SESSION_KEY);
    }

    /**
     * Returns a specific value from the session data by the given key
     *
     * @return mixed|null
     */
    public function getSessionDataByKey(string $key)
    {
        $data = $this->getSessionData();
        if (is_array($data) && isset($data[$key])) {
            $result = $data[$key];
        }
        return $result ?? null;
    }

    /**
     * Stores the given data to the session without persisting it (yet)
     */
    public function setSessionDataByKey(string $key, $data): void
    {
        $this->getBackendUser()->setSessionData($key, $data);
    }

    /**
     * Saves the given data to the session
     */
    public function setAndSaveSessionData(array $data): void
    {
        $this->getBackendUser()->setAndSaveSessionData(self::SESSION_KEY, $data);
    }

    protected function getBackendUser(): ?BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'] ?? null;
    }
}
