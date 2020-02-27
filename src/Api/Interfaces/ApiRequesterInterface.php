<?php

namespace Gitea\Api\Interfaces;

use Gitea\Client;

/**
 * Interface for API classes
 *
 * @author Benjamin Blake (sitelease.ca)
 */
interface ApiRequesterInterface
{
    /**
     * @param Client $client
     * @param object|null $caller
     */
    public function __construct(Client &$client , ?object $caller);

    /**
     * Get the gitea client (by reference)
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Client
     */
    public function getClient(): Client;

    /**
     * Set the gitea client (by reference)
     *
     * @author Benjamin Blake (sitelease.ca)
     * @param Client $client
     * @return self
     */
    public function setClient(Client &$client): self;

    /**
     * Get the authentication token
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return string
     */
    public function getAuthToken(): string;


    /**
     * Set the authentication token
     *
     * @author Benjamin Blake (sitelease.ca)
     * @param string $authToken
     * @return self
     */
    public function setAuthToken(string $authToken): self;

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
