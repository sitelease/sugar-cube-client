<?php

namespace Gitea\Model\Abstracts;

use Gitea\Client;
use Gitea\Api\Interfaces\ApiRequesterInterface;

use \stdClass;
use \JsonSerializable;

// Traits
use Gitea\Core\Traits\RequestChainable;

use Gitea\Model\Interfaces\ApiModelInterface;
use Gitea\Core\Interfaces\RequestChainableInterface;

abstract class AbstractApiModel implements ApiModelInterface, JsonSerializable, RequestChainableInterface
{

    use RequestChainable;

    /**
     * Creates a new API model object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param mixed $args The organization visibility.
     */
    public function __construct(Client &$client, ?object $caller, ...$args) {
        $this->setClient($client);
        $this->setCaller($caller);
    }

    /**
     * The Gitea client that originally made the
     * Api request for this object
     *
     * @var Client
     */
    protected $client;

    /**
     * Create a new API model object from a JSON map object
     *
     * Example:
     * ```
     * ClassName::fromJson(
     *     $client,
     *     $this,
     *     json_decode($jsonString)
     * );
     * ```
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON data object
     */
    static function fromJson(object &$client, ?object $caller, object $map) {
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
     * Get the gitea client (by reference)
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Client
     */
    public function getClient(): Client {
        return $this->client;
    }

    /**
     * Set the gitea client (by reference)
     *
     * @author Benjamin Blake (sitelease.ca)
     * @param Client $client
     * @return self
     */
    public function setClient(Client &$client): self {
        $this->client = $client;
        return $this;
    }
}
