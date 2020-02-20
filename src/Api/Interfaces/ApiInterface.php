<?php

namespace Gitea\Api\Interfaces;

use Gitea\Client;

/**
 * Interface for API classes
 *
 * @author Benjamin Blake (sitelease.ca)
 */
interface ApiInterface
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client, $authToken);

    public function getClient();

    public function getAuthToken();

    /**
     * @return $this
     * @codeCoverageIgnore
     */
    public function configure();

    /**
     * Send a GET request using an underlying reqest library
     *
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     * @param boolean $debugRequest
     * @return mixed
     */
    public function get($path, array $parameters = array(), $requestHeaders = array(), $debugRequest = false);

    /**
     * Send a POST request using an underlying reqest library
     *
     * @param string $path
     * @param array $body
     * @param array $requestHeaders
     * @param boolean $debugRequest
     * @return mixed
     */
    public function post($path, $body, $requestHeaders = array(), $debugRequest = false);

    /**
     * Send a PUT request using an underlying reqest library
     *
     * @param string $path
     * @param array $body
     * @param array $requestHeaders
     * @param boolean $debugRequest
     * @return mixed
     */
    public function put($path, $body, $requestHeaders = array(), $debugRequest = false);

    /**
     * Send a DELETE request using an underlying reqest library
     *
     * @param string $path
     * @param array $requestHeaders
     * @param boolean $debugRequest
     * @return mixed
     */
    public function delete($path, $requestHeaders = array(), $debugRequest = false);
}
