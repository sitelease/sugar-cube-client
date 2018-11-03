<?php
declare(strict_types=1);
namespace Gitea\Models;

use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/**
 * Represents a repository.
 */
class Repository implements \JsonSerializable {

  /**
   * @var string The name of the default branch.
   */
  public $defaultBranch = '';

  /**
   * @var string The repository description.
   */
  public $description = '';

  /**
   * @var int The number of forks of this repository.
   */
  public $forksCount = 0;

  /**
   * @var string The full name.
   */
  public $fullName = '';

  /**
   * @var int The repository identifier.
   */
  public $id = -1;

  /**
   * @var bool Value indicating whether this repository is empty.
   */
  public $isEmpty = false;

  /**
   * @var bool Value indicating whether this repository is a fork.
   */
  public $isFork = false;

  /**
   * @var bool Value indicating whether this repository is a mirror.
   */
  public $isMirror = false;

  /**
   * @var bool Value indicating whether this repository is private.
   */
  public $isPrivate = false;

  /**
   * @var string The repository name.
   */
  public $name = '';

  /**
   * @var int The number of open issues of this repository.
   */
  public $openIssuesCount = 0;

  /**
   * @var User|null The repository owner.
   */
  public $owner;

  /**
   * @var Repository|null The parent repository, if this repository is a fork or a mirror.
   */
  public $parent;

  /**
   * @var Permission|null The repository permissions.
   */
  public $permissions;

  /**
   * @var int The repository size, in kilobytes.
   */
  public $size = 0;

  /**
   * @var int The number of stars of this repository.
   */
  public $starsCount = 0;

  /**
   * @var int The number of watchers of this repository.
   */
  public $watchersCount = 0;

  /**
   * @var UriInterface|null The HTTP-based URL for cloning this repository.
   */
  private $cloneUrl;

  /**
   * @var \DateTime|null The date the repository was created.
   */
  private $createdAt;

  /**
   * @var UriInterface|null The Gitea URL of this repository.
   */
  private $htmlUrl;

  /**
   * @var UriInterface|null The SSH-based URL for cloning this repository.
   */
  private $sshUrl;

  /**
   * @var \DateTime|null The date the repository was updated.
   */
  private $updatedAt;

  /**
   * @var UriInterface|null The URL of the repository website.
   */
  private $website;

  /**
   * Creates a new repository from the specified JSON map.
   * @param object $map A JSON map representing a repository.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'cloneUrl' => isset($map->clone_url) && is_string($map->clone_url) ? new Uri($map->clone_url) : null,
      'createdAt' => isset($map->created_at) && is_string($map->created_at) ? new \DateTime($map->created_at) : null,
      'defaultBranch' => isset($map->default_branch) && is_string($map->default_branch) ? $map->default_branch : '',
      'description' => isset($map->description) && is_string($map->description) ? $map->description : '',
      'forksCount' => isset($map->forks_count) && is_int($map->forks_count) ? $map->forks_count : 0,
      'fullName' => isset($map->full_name) && is_string($map->full_name) ? $map->full_name : '',
      'htmlUrl' => isset($map->html_url) && is_string($map->html_url) ? new Uri($map->html_url) : null,
      'id' => isset($map->id) && is_int($map->id) ? $map->id : -1,
      'isEmpty' => isset($map->empty) && is_bool($map->empty) ? $map->empty : false,
      'isFork' => isset($map->fork) && is_bool($map->fork) ? $map->fork : false,
      'isMirror' => isset($map->mirror) && is_bool($map->mirror) ? $map->mirror : false,
      'isPrivate' => isset($map->private) && is_bool($map->private) ? $map->private : false,
      'name' => isset($map->name) && is_string($map->name) ? $map->name : '',
      'openIssuesCount' => isset($map->open_issues_count) && is_int($map->open_issues_count) ? $map->open_issues_count : 0,
      'owner' => isset($map->owner) && is_object($map->owner) ? User::fromJson($map->owner) : null,
      'parent' => isset($map->parent) && is_object($map->parent) ? Repository::fromJson($map->parent) : null,
      'permissions' => isset($map->permissions) && is_object($map->permissions) ? Permission::fromJson($map->permissions) : null,
      'size' => isset($map->size) && is_int($map->size) ? $map->size : 0,
      'sshUrl' => isset($map->ssh_url) && is_string($map->ssh_url) ? new Uri($map->ssh_url) : null,
      'starsCount' => isset($map->stars_count) && is_int($map->stars_count) ? $map->stars_count : 0,
      'updatedAt' => isset($map->updated_at) && is_string($map->updated_at) ? new \DateTime($map->updated_at) : null,
      'watchersCount' => isset($map->watchers_count) && is_int($map->watchers_count) ? $map->watchers_count : 0,
      'website' => isset($map->website) && is_string($map->website) ? new Uri($map->website) : null,
    ]);
  }

  /**
   * Gets the HTTP-based URL for cloning this repository.
   * @return UriInterface|null The HTTP-based URL for cloning this repository.
   */
  function getCloneUrl(): ?UriInterface {
    return $this->cloneUrl;
  }

  /**
   * Gets the date the repository was created.
   * @return \DateTime|null The date the repository was created.
   */
  function getCreatedAt(): ?\DateTime {
    return $this->createdAt;
  }

  /**
   * Gets the Gitea URL of this repository.
   * @return UriInterface|null The Gitea URL of this repository.
   */
  function getHtmlUrl(): ?UriInterface {
    return $this->htmlUrl;
  }

  /**
   * Gets the SSH-based URL for cloning this repository.
   * @return UriInterface|null The SSH-based URL for cloning this repository.
   */
  function getSshUrl(): ?UriInterface {
    return $this->sshUrl;
  }

  /**
   * Gets the date the repository was updated.
   * @return \DateTime|null The date the repository was updated.
   */
  function getUpdatedAt(): ?\DateTime {
    return $this->updatedAt;
  }

  /**
   * Gets the URL of the repository website.
   * @return UriInterface|null The URL of the repository website.
   */
  function getWebsite(): ?UriInterface {
    return $this->website;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'clone_url' => ($url = $this->getCloneUrl()) ? (string) $url : null,
      'created_at' => ($date = $this->getCreatedAt()) ? $date->format('c') : null,
      'default_branch' => 'defaultBranch',
      'description',
      'empty' => 'isEmpty',
      'fork' => 'isFork',
      'forks_count' => 'forksCount',
      'full_name' => 'fullName',
      'html_url' => ($url = $this->getHtmlUrl()) ? (string) $url : null,
      'id',
      'mirror' => 'isMirror',
      'name',
      'open_issues_count' => 'openIssuesCount',
      'owner',
      'parent',
      'permissions',
      'private' => 'isPrivate',
      'size',
      'ssh_url' => ($url = $this->getSshUrl()) ? (string) $url : null,
      'stars_count' => 'starsCount',
      'updated_at' => ($date = $this->getUpdatedAt()) ? $date->format('c') : null,
      'watchers_count' => 'watchersCount',
      'website' => ($url = $this->getWebsite()) ? (string) $url : null,
    ];
  }

  /**
   * Sets the HTTP-based URL for cloning this repository.
   * @param UriInterface|string|null $value The new URL for cloning this repository.
   * @return $this This instance.
   */
  function setCloneUrl($value): self {
    $this->cloneUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }

  /**
   * Sets the date the repository was created.
   * @param \DateTime|string|null $value The new date of creation.
   * @return $this This instance.
   */
  function setCreatedAt($value): self {
    $this->createdAt = is_string($value) ? new \DateTime($value) : $value;
    return $this;
  }

  /**
   * Sets the Gitea URL of this repository.
   * @param UriInterface|string|null $value The new Gitea URL.
   * @return $this This instance.
   */
  function setHtmlUrl($value): self {
    $this->htmlUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }

  /**
   * Sets the SSH-based URL for cloning this repository.
   * @param UriInterface|string|null $value The new URL for cloning this repository.
   * @return $this This instance.
   */
  function setSshlUrl($value): self {
    $this->sshUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }

  /**
   * Sets the date the repository was updated.
   * @param \DateTime|string|null $value The new date of update.
   * @return $this This instance.
   */
  function setUpdatedAt($value): self {
    $this->updatedAt = is_string($value) ? new \DateTime($value) : $value;
    return $this;
  }

  /**
   * Sets the URL of the repository website.
   * @param UriInterface|string|null $value The new repository website.
   * @return $this This instance.
   */
  function setWebsite($value): self {
    $this->website = is_string($value) ? new Uri($value) : $value;
    return $this;
  }
}
