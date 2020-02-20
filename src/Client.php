<?php

namespace Gitea;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ServerException;

use Gitea\Models\Repository;
use Gitea\Models\Tag;
use Gitea\Models\Branch;

use Gitea\Api\Repositories;
use Gitea\Api\Organizations;

use \JsonSerializable;

/** Represents a Gitea push event. */
class Client {

    /**
     * Stores an instance of Guzzle's Client
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * The base URL for Gitea
     *
     * All API requests will be relative to this URL
     *
     * @var string
     */
    private $giteaURL;

    /**
     * The API authentication token for Gitea
     *
     * @var string
     */
    private $authToken;


    public function __construct($giteaURL, $authToken = null)
    {
        // Append a slash to any URL that doesn't end in '/'
        if (!$this->endsWith($giteaURL, '/')) {
            $giteaURL += "/";
        }
        $this->giteaURL = $giteaURL;
        $this->authToken = $authToken;

        // Create a new Guzzle Client
        $this->guzzleClient = new GuzzleClient(['base_uri' => $giteaURL]);
    }

    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    public function getAuthToken() {
        return $this->authToken;
    }

    public function setAuthToken($value) {
        $this->authToken = $value;
        return $this;
    }

    public function getBaseURL()
    {
        return $this->giteaURL;
    }

    /**
     * Return true if first string ends with the second string.
     * Otherwise return false
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    function endsWith($haystack, $needle)
    {
        return substr($haystack, -strlen($needle))===$needle;
    }

    /**
     * Checks to make sure the auth token is in the right format
     *
     * Will raise errors if the token is in the wrong format
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return boolean
     */
    public function checkAuthToken($softErrors = false) {
        $authToken = $this->authToken;
        if (!$authToken) {
            if ($softErrors) {
                print("No authentication token was passed in"."\n");
            } else {
                trigger_error("No authentication token was passed in");
            }
            return false;
        }

        if (!strlen($authToken) >= 40) {
            if ($softErrors) {
                print("The authentication token is too short, it must be at lease 40 characters long"."\n");
            } else {
                trigger_error("The authentication token is too short, it must be at lease 40 characters long");
            }
            return false;
        }

        return true;
    }

    /**
     * Return the Repositories api object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Repositories
     */
    public function repositories()
    {
        return new Repositories($this, $this->getAuthToken());
    }

    /**
     * Return the Repositories api object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Organizations
     */
    public function organizations()
    {
        return new Organizations($this, $this->getAuthToken());
    }

}
