<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use \InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a set of permissions. */
class Permission extends AbstractApiModel {

    /** @var bool Value indicating whether administrator access is allowed. */
    private $admin;

    /** @var bool Value indicating whether pull is allowed. */
    private $pull;

    /** @var bool Value indicating whether push is allowed. */
    private $push;

    /**
     * Creates a new permission.
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param bool $admin Value indicating whether administrator access is allowed.
     * @param bool $pull Value indicating whether pull is allowed.
     * @param bool $push Value indicating whether push is allowed.
     */
    function __construct(object $giteaClient, object $apiRequester, ...$args) {
        $this->setGiteaClient($giteaClient);
        $this->setApiRequester($apiRequester);
        if (count($args) >= 2) {
            $admin = $args[0];
            $pull = $args[1];
            $push = $args[1];
            if (!is_bool($admin)) {
                $argumentType = gettype($admin);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 3rd parameter to be of the boolean type, but a \"$argumentType\" was passed in");
            }
            if (!is_bool($pull)) {
                $argumentType = gettype($pull);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the boolean type, but a \"$argumentType\" was passed in");
            }
            if (!is_bool($push)) {
                $argumentType = gettype($push);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 5th parameter to be of the boolean type, but a \"$argumentType\" was passed in");
            }
            $this->setAdmin($admin)->setPull($pull)->setPush($push);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new user from the specified JSON map.
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param object $map A JSON map representing a user.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object $giteaClient, object $apiRequester, object $map): self {
        return new static(
            $giteaClient,
            $apiRequester,
            isset($map->admin) && is_bool($map->admin) ? $map->admin : false,
            isset($map->pull) && is_bool($map->pull) ? $map->pull : false,
            isset($map->push) && is_bool($map->push) ? $map->push : false
        );
    }

    /**
     * Gets a value indicating whether administrator access is allowed.
     * @return bool `true` if administrator access is allowed, otherwise `false`.
     */
    function getAdmin(): bool {
        return $this->admin;
    }

    /**
     * Gets a value indicating whether pull is allowed.
     * @return bool `true` if pull is allowed, otherwise `false`.
     */
    function getPull(): bool {
        return $this->pull;
    }

    /**
     * Gets a value indicating whether push is allowed.
     * @return bool `true` if push is allowed, otherwise `false`.
     */
    function getPush(): bool {
        return $this->push;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'admin' => $this->getAdmin(),
            'pull' => $this->getPull(),
            'push' => $this->getPush()
        ];
    }

    /**
     * Sets a value indicating whether administrator access is allowed.
     * @param bool $value `true` to allow administrator access, otherwise `false`.
     * @return $this This instance.
     */
    function setAdmin(bool $value): self {
        $this->admin = $value;
        return $this;
    }

    /**
     * Sets a value indicating whether pull is allowed.
     * @param bool $value `true` to allow pull, otherwise `false`.
     * @return $this This instance.
     */
    function setPull(bool $value): self {
        $this->pull = $value;
        return $this;
    }

    /**
     * Sets a value indicating whether push is allowed.
     * @param bool $value `true` to allow push, otherwise `false`.
     * @return $this This instance.
     */
    function setPush(bool $value): self {
        $this->push = $value;
        return $this;
    }
}
