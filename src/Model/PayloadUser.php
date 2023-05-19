<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use Gitea\Client;

use stdClass;
use InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents the author or committer of a commit. */
class PayloadUser extends AbstractApiModel
{
    /** @var string The mail address. */
    private $email = '';

    /** @var string The full name. */
    private $name = '';

    /** @var string The name of the Gitea account. */
    private $username;

    /**
     * Creates a new payload user.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param string $username The name of the Gitea account.
     */
    public function __construct(Client &$client, ?object $caller, ...$args)
    {
        parent::__construct($client, $caller, $args);
        if (count($args) >= 1) {
            $username = $args[0];
            if (!is_string($username)) {
                $argumentType = gettype($username);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            $this->username = $username;
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new user from the specified JSON map.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON map representing a user.
     * @return static The instance corresponding to the specified JSON map.
     */
    public static function fromJson(object &$client, ?object $caller, object $map): self
    {
        return (
            new static(
                $client,
                $caller,
                isset($map->username) && is_string($map->username) ? $map->username : ''
            )
        )
        ->setEmail(isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '')
        ->setName(isset($map->name) && is_string($map->name) ? $map->name : '');
    }

    /**
     * Gets the mail address.
     * @return string The mail address.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Gets the full name.
     * @return string The full name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the name of the Gitea account.
     * @return string The name of the Gitea account.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return stdClass The map in JSON format corresponding to this object.
     */
    public function jsonSerialize(): stdClass
    {
        return (object) [
            'email' => $this->getEmail(),
            'name' => $this->getName(),
            'username' => $this->getUsername()
        ];
    }

    /**
     * Sets the mail address.
     * @param string $value The new mail address.
     * @return $this This instance.
     */
    public function setEmail(string $value): self
    {
        $this->email = $value;
        return $this;
    }

    /**
     * Sets the full name.
     * @param string $value The new full name.
     * @return $this This instance.
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }
}
