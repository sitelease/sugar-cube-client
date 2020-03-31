<?php declare(strict_types=1);
namespace Gitea\Model;

use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/** Represents a Gitea user. */
class User implements \JsonSerializable {

    /** @var UriInterface|null The URL to the user's avatar. */
    private $avatarUrl;

    /** @var string The mail address. */
    private $email = '';

    /** @var string The full name. */
    private $fullName = '';

    /** @var int The user identifier. */
    private $id;

    /** @var string The user locale. */
    private $language = '';

    /** @var string The name of the Gitea account. */
    private $login;

    /**
     * Creates a new user.
     * @param int $id The user identifier.
     * @param string $login The name of the Gitea account.
     */
    function __construct(int $id, string $login) {
        $this->id = $id;
        $this->setLogin($login);
    }

    /**
     * Creates a new user from the specified JSON map.
     * @param object $map A JSON map representing a user.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object $map): self {
        return (new static(isset($map->id) && is_numeric($map->id) ? $map->id : -1, isset($map->login) && is_string($map->login) ? $map->login : ''))
            ->setAvatarUrl(isset($map->avatar_url) && is_string($map->avatar_url) ? new Uri($map->avatar_url) : null)
            ->setEmail(isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '')
            ->setFullName(isset($map->full_name) && is_string($map->full_name) ? $map->full_name : '')
            ->setLanguage(isset($map->language) && is_string($map->language) ? $map->language : '');
    }

    /**
     * Gets the URL of the avatar image.
     * @return UriInterface|null The URL of the avatar image.
     */
    function getAvatarUrl(): ?UriInterface {
        return $this->avatarUrl;
    }

    /**
     * Gets the mail address.
     * @return string The mail address.
     */
    function getEmail(): string {
        return $this->email;
    }

    /**
     * Gets the full name.
     * @return string The full name.
     */
    function getFullName(): string {
        return $this->fullName;
    }

    /**
     * Gets the user identifier.
     * @return int The user identifier.
     */
    function getId(): int {
        return $this->id;
    }

    /**
     * Gets the user locale.
     * @return string The user locale.
     */
    function getLanguage(): string {
        return $this->language;
    }

    /**
     * Gets the name of the Gitea account.
     * @return string The name of the Gitea account.
     */
    function getLogin(): string {
        return $this->login;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'avatar_url' => ($url = $this->getAvatarUrl()) ? (string) $url : null,
            'email' => $this->getEmail(),
            'full_name' => $this->getFullName(),
            'id' => $this->getId(),
            'language' => $this->getLanguage(),
            'login' => $this->getLogin()
        ];
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
     * Sets the mail address.
     * @param string $value The new mail address.
     * @return $this This instance.
     */
    function setEmail(string $value): self {
        $this->email = $value;
        return $this;
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
     * Sets the user locale.
     * @param string $value The new user locale.
     * @return $this This instance.
     */
    function setLanguage(string $value): self {
        $this->language = $value;
        return $this;
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
}
