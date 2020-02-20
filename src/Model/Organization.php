<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use \JsonSerializable;

/** Represents a Gitea organization. */
class Organization implements JsonSerializable {

    /** @var UriInterface|null A URL pointing to the organization's avatar. */
    private $avatarURL = '';

    /** @var string The organization description. */
    private $description = '';

    /** @var string The organization's full name. */
    private $fullName = '';

    /** @var int The organization identifier. */
    private $id = -1;

    /** @var string The organization location. */
    private $location;

    /** @var string The username of the organization */
    private $username;

    /** @var string The visibility of the organization */
    private $visibility;

    /** @var UriInterface|null The website URL of the organization */
    private $website = null;

    /**
     * Creates a new organization.
     * @param string $username The organization name.
     * @param string $visibility The organization visibility.
     */
    function __construct(string $username, string $visibility = "private") {
        $this->setUserName($username);
        $this->setVisibility($visibility);
    }

    /**
     * Creates a new organization from the specified JSON map.
     * @param object $map A JSON map representing an organization.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object $map): self {
        return (new static(isset($map->username) && is_string($map->username) ? $map->username : '', isset($map->visibility) && is_string($map->visibility) ? $map->visibility : 'private'))
            ->setAvatarURL(isset($map->avatar_url) && is_string($map->avatar_url) ? new Uri($map->avatar_url) : null)
            ->setDescription(isset($map->description) && is_string($map->description) ? $map->description : '')
            ->setFullName(isset($map->full_name) && is_string($map->full_name) ? $map->full_name : '')
            ->setLocation(isset($map->location) && is_string($map->location) ? $map->location : '')
            ->setWebsite(isset($map->website) && is_string($map->website) ? new Uri($map->website) : null);
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'avatar_url' => ($url = $this->getAvatarURL()) ? (string) $url : null,
            'description' => $this->getDescription(),
            'full_name' => $this->getFullName(),
            'id' => $this->getId(),
            'location' => $this->getLocation(),
            'username' => $this->getUsername(),
            'visibility' => $this->getVisibility(),
            'website' => ($url = $this->getWebsite()) ? (string) $url : null
        ];
    }

    /**
     * Gets the organization identifier.
     * @return int The organization identifier.
     */
    function getId(): int {
        return $this->id;
    }

    public function getAvatarURL(): ?UriInterface {
        return $this->avatarURL;
    }

    public function setAvatarURL(?UriInterface $value): self {
        $this->avatarURL = $value;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription(string $value): self {
        $this->description = $value;
        return $this;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName(string $value): self {
        $this->fullName = $value;
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation(string $value): self {
        $this->location = $value;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername(string $value): self {
        $this->username = $value;
        return $this;
    }

    public function getVisibility() {
        return $this->visibility;
    }

    public function setVisibility(string $value): self {
        $this->visibility = $value;
        return $this;
    }

    public function getWebsite(): ?UriInterface {
        return $this->website;
    }

    public function setWebsite(?UriInterface $value): self {
        $this->website = $value;
        return $this;
    }

}
