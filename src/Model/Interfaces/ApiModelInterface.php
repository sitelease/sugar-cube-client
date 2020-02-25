<?php

namespace Gitea\Model\Interfaces;

use Gitea\Client;
use Gitea\Api\Interfaces\ApiRequesterInterface;

use \stdClass;

interface ApiModelInterface
{

    /**
     * Creates a new API model object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param mixed $args The organization visibility.
     */
    public function __construct(object $giteaClient, object $apiRequester, ...$args);

    /**
     * Create a new API model object from a JSON map object
     *
     * Example:
     * ```
     * ClassName::fromJson(
     *     $giteaClient,
     *     $apiRequester,
     *     json_decode($jsonString)
     * );
     * ```
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param object $map A JSON data object
     */
    static function fromJson(object $giteaClient, object $apiRequester, object $map);

    /**
     * Convert this Api model object to a JSON map.
     *
     * NOTE: This method is required for classes that
     * implement the JsonSerializable interface
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return stdClass The map in JSON format corresponding to this object.
     */
    public function jsonSerialize(): \stdClass;

    /**
     * Get the Gitea client that originally made the
     * Api request for this object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Client
     */
    public function getGiteaClient();

    /**
     * Get the Api request object that created
     * this model object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiRequesterInterface
     */
    public function getApiRequester();


}
