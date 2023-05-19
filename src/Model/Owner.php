<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use Gitea\Client;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a Gitea owner. */
class Owner extends AbstractApiModel {

    /** @var int The owner identifier. */
    private $id;

    /** @var string The name of the Gitea account. */
    private $login;

    /** @var string The full name. */
    private $fullName = '';

    /** @var string The mail address. */
    private $email = '';

    /** @var UriInterface|null The URL to the owner's avatar. */
    private $avatarUrl;

    /** @var string The owner locale. */
    private $language = '';

    /** @var boolean If the owner is an admin */
    private $isAdmin = false;

    /** @var string The username of the account or organization */
    private $username = '';

    /**
     * Creates a new owner.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param int $id The owner identifier.
     * @param string $login The name of the Gitea account.
     */
    public function __construct(Client &$client , ?object $caller, ...$args) {
        parent::__construct($client, $caller, $args);
        if (count($args) >= 2) {
            $id = $args[0];
            $login = $args[1];
            if (!is_numeric($id)) {
                $argumentType = gettype($id);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 3rd parameter to be of the integer type, but a \"$argumentType\" was passed in");
            }
            if (!is_string($login)) {
                $argumentType = gettype($login);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            $this->id = $id;
            $this->setLogin($login);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new owner from the specified JSON map.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON map representing a owner.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object &$client , ?object $caller, object $map): self {
        return (
            new static(
                $client,
                $caller,
                isset($map->id) && is_numeric($map->id) ? $map->id : -1,
                isset($map->login) && is_string($map->login) ? $map->login : ''
            )
        )
        ->setAvatarUrl(isset($map->avatar_url) && is_string($map->avatar_url) ? new Uri($map->avatar_url) : null)
        ->setEmail(isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '')
        ->setFullName(isset($map->full_name) && is_string($map->full_name) ? $map->full_name : '')
        ->setLanguage(isset($map->language) && is_string($map->language) ? $map->language : '')
        ->setIsAdmin(isset($map->is_admin) && is_bool($map->is_admin) ? $map->is_admin : false)
        ->setUsername(isset($map->username) && is_string($map->username) ? $map->username : '');
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'id' => $this->getId(),
            'login' => $this->getLogin(),
            'full_name' => $this->getFullName(),
            'email' => $this->getEmail(),
            'avatar_url' => ($url = $this->getAvatarUrl()) ? (string) $url : null,
            'language' => $this->getLanguage(),
            'is_admin' => $this->getIsAdmin(),
            'username' => $this->getUsername()
        ];
    }

    /**
     * Gets the owner identifier.
     * @return int The owner identifier.
     */
    function getId(): int {
        return $this->id;
    }

    /**
     * Gets the name of the Gitea account.
     * @return string The name of the Gitea account.
     */
    function getLogin(): string {
        return $this->login;
    }

    /**
     * Sets the name of the Gitea account.
     * @param string $value The new Gitea account.
     * @return $this This instance.
     */
    function setLogin(string $value): self {
        $this->login = $value;
        return $this;
    }

    /**
     * Gets the full name.
     * @return string The full name.
     */
    function getFullName(): string {
        return $this->fullName;
    }

    /**
     * Sets the full name.
     * @param string $value The new full name.
     * @return $this This instance.
     */
    function setFullName(string $value): self {
        $this->fullName = $value;
        return $this;
    }

    /**
     * Gets the mail address.
     * @return string The mail address.
     */
    function getEmail(): string {
        return $this->email;
    }

    /**
     * Sets the mail address.
     * @param string $value The new mail address.
     * @return $this This instance.
     */
    function setEmail(string $value): self {
        $this->email = $value;
        return $this;
    }

    /**
     * Gets the URL of the avatar image.
     * @return UriInterface|null The URL of the avatar image.
     */
    function getAvatarUrl(): ?UriInterface {
        return $this->avatarUrl;
    }

    /**
     * Sets the URL of the avatar image.
     * @param UriInterface|null $value The new avatar URL.
     * @return $this This instance.
     */
    function setAvatarUrl(?UriInterface $value): self {
        $this->avatarUrl = $value;
        return $this;
    }

    /**
     * Gets the owner locale.
     * @return string The owner locale.
     */
    function getLanguage(): string {
        return $this->language;
    }

    /**
     * Sets the owner locale.
     * @param string $value The new owner locale.
     * @return $this This instance.
     */
    function setLanguage(string $value): self {
        $this->language = $value;
        return $this;
    }

    public function getIsAdmin(): bool {
        return $this->isAdmin;
    }

    public function setIsAdmin($boolean): self {
        $this->isAdmin = $boolean;
        return $this;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername($string): self {
        $this->username = $string;
        return $this;
    }

}
