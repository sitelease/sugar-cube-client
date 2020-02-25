<?php

namespace Gitea\Model\Abstracts;

use Gitea\Client;
use Gitea\Api\Interfaces\ApiRequesterInterface;

use \stdClass;

use Gitea\Model\Interfaces\ApiModelInterface;
use \JsonSerializable;

abstract class AbstractApiModel implements ApiModelInterface, JsonSerializable
{
    /**
     * The Gitea client that originally made the
     * Api request for this object
     *
     * @var Client
     */
    protected $giteaClient;

    /**
     * The Api request object that created
     * this model object
     *
     * @var ApiRequesterInterface
     */
    protected $apiRequester;

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
    static function fromJson(object $giteaClient, object $apiRequester, object $map) {
        trigger_error("The abstract 'fromJson()' method must be overwritten");
        return false;
    }

    /**
     * Convert this Api model object to a JSON map.
     *
     * NOTE: This method is required for classes that
     * implement the JsonSerializable interface
     *
     * @return stdClass The map in JSON format corresponding to this object.
     */
    public function jsonSerialize(): \stdClass {
        trigger_error("The abstract 'jsonSerialize()' method must be overwritten");
        return self;
    }

    /**
     * Get the Gitea client that originally made the
     * Api request for this object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Client
     */
    public function getGiteaClient() {
        return $this->giteaClient;
    }

    public function setGiteaClient($object): self {
        $this->giteaClient = $object;
        return $this;
    }

    /**
     * Get the Api request object that created
     * this model object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiRequesterInterface
     */
    public function getApiRequester() {
        return $this->apiRequester;
    }

    public function setApiRequester($object): self {
        $this->apiRequester = $object;
        return $this;
    }


}
