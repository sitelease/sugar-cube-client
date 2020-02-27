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
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param mixed $args The organization visibility.
     */
    public function __construct(Client &$client , ?object $caller, ...$args);

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
    static function fromJson(object &$client , ?object $caller, object $map);

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

}
