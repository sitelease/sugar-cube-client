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
   * @var UriInterface|null The HTTP-based URL for cloning this repository.
   */
  private $cloneUrl;

  /**
   * @var \DateTime|null The date the repository was created.
   */
  private $createdAt;

  /**
   * @var string The name of the default branch.
   */
  private $defaultBranch = '';

  /**
   * @var string The repository description.
   */
  private $description = '';

  /**
   * @var int The number of forks of this repository.
   */
  private $forksCount = 0;

  /**
   * @var string The full name.
   */
  private $fullName;

  /**
   * @var UriInterface|null The Gitea URL of this repository.
   */
  private $htmlUrl;

  /**
   * @var int The repository identifier.
   */
  private $id;

  /**
   * @var bool Value indicating whether this repository is empty.
   */
  private $isEmpty = true;

  /**
   * @var bool Value indicating whether this repository is a fork.
   */
  private $isFork = false;

  /**
   * @var bool Value indicating whether this repository is a mirror.
   */
  private $isMirror = false;

  /**
   * @var bool Value indicating whether this repository is private.
   */
  private $isPrivate = false;

  /**
   * @var string The repository name.
   */
  private $name = '';

  /**
   * @var int The number of open issues of this repository.
   */
  private $openIssuesCount = 0;

  /**
   * @var User|null The repository owner.
   */
  private $owner;

  /**
   * @var Repository|null The parent repository, if this repository is a fork or a mirror.
   */
  private $parent;

  /**
   * @var Permission|null The repository permissions.
   */
  private $permissions;

  /**
   * @var int The repository size, in kilobytes.
   */
  private $size = 0;

  /**
   * @var UriInterface|null The SSH-based URL for cloning this repository.
   */
  private $sshUrl;

  /**
   * @var int The number of stars of this repository.
   */
  private $starsCount = 0;

  /**
   * @var \DateTime|null The date the repository was updated.
   */
  private $updatedAt;

  /**
   * @var int The number of watchers of this repository.
   */
  private $watchersCount = 0;

  /**
   * @var UriInterface|null The URL of the repository website.
   */
  private $website;

  /**
   * Creates a new repository.
   * @param int $id The repository identifier.
   * @param string $fullName The full name of the repository.
   */
  function __construct(int $id, string $fullName) {
    $this->id = $id;
    $this->setFullName($fullName);
  }

  /**
   * Creates a new repository from the specified JSON map.
   * @param object $map A JSON map representing a repository.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return (new static(isset($map->id) && is_int($map->id) ? $map->id : -1, isset($map->full_name) && is_string($map->full_name) ? $map->full_name : ''))
      ->setCloneUrl(isset($map->clone_url) && is_string($map->clone_url) ? new Uri($map->clone_url) : null)
      ->setCreatedAt(isset($map->created_at) && is_string($map->created_at) ? new \DateTime($map->created_at) : null)
      ->setDefaultBranch(isset($map->default_branch) && is_string($map->default_branch) ? $map->default_branch : '')
      ->setDescription(isset($map->description) && is_string($map->description) ? $map->description : '')
      ->setEmpty(isset($map->empty) && is_bool($map->empty) ? $map->empty : true)
      ->setFork(isset($map->fork) && is_bool($map->fork) ? $map->fork : false)
      ->setForksCount(isset($map->forks_count) && is_int($map->forks_count) ? $map->forks_count : 0)
      ->setHtmlUrl(isset($map->html_url) && is_string($map->html_url) ? new Uri($map->html_url) : null)
      ->setMirror(isset($map->mirror) && is_bool($map->mirror) ? $map->mirror : false)
      ->setName(isset($map->name) && is_string($map->name) ? $map->name : '')
      ->setOpenIssuesCount(isset($map->open_issues_count) && is_int($map->open_issues_count) ? $map->open_issues_count : 0)
      ->setOwner(isset($map->owner) && is_object($map->owner) ? User::fromJson($map->owner) : null)
      ->setParent(isset($map->parent) && is_object($map->parent) ? Repository::fromJson($map->parent) : null)
      ->setPermissions(isset($map->permissions) && is_object($map->permissions) ? Permission::fromJson($map->permissions) : null)
      ->setPrivate(isset($map->private) && is_bool($map->private) ? $map->private : false)
      ->setSize(isset($map->size) && is_int($map->size) ? $map->size : 0)
      ->setSshUrl(isset($map->ssh_url) && is_string($map->ssh_url) ? new Uri($map->ssh_url) : null)
      ->setStarsCount(isset($map->stars_count) && is_int($map->stars_count) ? $map->stars_count : 0)
      ->setUpdatedAt(isset($map->updated_at) && is_string($map->updated_at) ? new \DateTime($map->updated_at) : null)
      ->setWatchersCount(isset($map->watchers_count) && is_int($map->watchers_count) ? $map->watchers_count : 0)
      ->setWebsite(isset($map->website) && is_string($map->website) ? new Uri($map->website) : null);
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
   * Gets the name of the default branch.
   * @return string The name of the default branch.
   */
  function getDefaultBranch(): string {
    return $this->defaultBranch;
  }

  /**
   * Gets the repository description.
   * @return string The repository description.
   */
  function getDescription(): string {
    return $this->description;
  }

  /**
   * Gets the number of forks of this repository.
   * @return int The number of forks of this repository.
   */
  function getForksCount(): int {
    return $this->forksCount;
  }

  /**
   * Gets the full name.
   * @return string The full name.
   */
  function getFullName(): string {
    return $this->fullName;
  }

  /**
   * Gets the Gitea URL of this repository.
   * @return UriInterface|null The Gitea URL of this repository.
   */
  function getHtmlUrl(): ?UriInterface {
    return $this->htmlUrl;
  }

  /**
   * Gets the repository identifier.
   * @return int The repository identifier.
   */
  function getId(): int {
    return $this->id;
  }

  /**
   * Gets the repository name.
   * @return string The repository name.
   */
  function getName(): string {
    if (mb_strlen($this->name)) return $this->name;
    return mb_strlen($fullName = $this->getFullName()) ? explode('/', $fullName, 2)[0] : '';
  }

  /**
   * Gets the number of open issues of this repository.
   * @return int The number of open issues of this repository.
   */
  function getOpenIssuesCount(): int {
    return $this->openIssuesCount;
  }

  /**
   * Gets the repository owner.
   * @return User|null The repository owner.
   */
  function getOwner(): ?User {
    return $this->owner;
  }

  /**
   * Gets the parent repository, if this repository is a fork or a mirror.
   * @return User|null The parent repository, if this repository is a fork or a mirror.
   */
  function getParent(): ?Repository {
    return $this->parent;
  }

  /**
   * Gets the repository permissions.
   * @return Permission|null The repository permissions.
   */
  function getPermissions(): ?Permission {
    return $this->permissions;
  }

  /**
   * Gets the repository size, in kilobytes.
   * @return int The repository size, in kilobytes.
   */
  function getSize(): int {
    return $this->size;
  }

  /**
   * Gets the SSH-based URL for cloning this repository.
   * @return UriInterface|null The SSH-based URL for cloning this repository.
   */
  function getSshUrl(): ?UriInterface {
    return $this->sshUrl;
  }

  /**
   * Gets the number of stars of this repository.
   * @return int The number of stars of this repository.
   */
  function getStarsCount(): int {
    return $this->starsCount;
  }

  /**
   * Gets the date the repository was updated.
   * @return \DateTime|null The date the repository was updated.
   */
  function getUpdatedAt(): ?\DateTime {
    return $this->updatedAt;
  }

  /**
   * Gets the number of watchers of this repository.
   * @return int The number of watchers of this repository.
   */
  function getWatchersCount(): int {
    return $this->watchersCount;
  }

  /**
   * Gets the URL of the repository website.
   * @return UriInterface|null The URL of the repository website.
   */
  function getWebsite(): ?UriInterface {
    return $this->website;
  }

  /**
   * Gets a value indicating whether this repository is empty.
   * @return bool `true` if this repository is empty, otherwise `false`.
   */
  function isEmpty(): bool {
    return $this->isEmpty;
  }

  /**
   * Gets a value indicating whether this repository is a fork.
   * @return bool `true` if this repository is a fork, otherwise `false`.
   */
  function isFork(): bool {
    return $this->isFork;
  }

  /**
   * Gets a value indicating whether this repository is a mirror.
   * @return bool `true` if this repository is a mirror, otherwise `false`.
   */
  function isMirror(): bool {
    return $this->isMirror;
  }

  /**
   * Gets a value indicating whether this repository is private.
   * @return bool `true` if this repository is private, otherwise `false`.
   */
  function isPrivate(): bool {
    return $this->isPrivate;
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
   * Sets the name of the default branch.
   * @param string $value The new default branch.
   * @return $this This instance.
   */
  function setDefaultBranch(string $value): self {
    $this->defaultBranch = $value;
    return $this;
  }

  /**
   * Sets the repository description.
   * @param string $value The new repository description.
   * @return $this This instance.
   */
  function setDescription(string $value): self {
    $this->description = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether this repository is empty.
   * @param bool $value `true` if this repository is empty, otherwise `false`.
   * @return $this This instance.
   */
  function setEmpty(bool $value): self {
    $this->isEmpty = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether this repository is a fork.
   * @param bool $value `true` if this repository is a fork, otherwise `false`.
   * @return $this This instance.
   */
  function setFork(bool $value): self {
    $this->isFork = $value;
    return $this;
  }

  /**
   * Sets the number of forks of this repository.
   * @param int $value The new number of forks.
   * @return $this This instance.
   */
  function setForksCount(int $value): self {
    $this->forksCount = $value;
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
   * Sets the Gitea URL of this repository.
   * @param UriInterface|string|null $value The new Gitea URL.
   * @return $this This instance.
   */
  function setHtmlUrl($value): self {
    $this->htmlUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }

  /**
   * Sets a value indicating whether this repository is a mirror.
   * @param bool $value `true` if this repository is a mirror, otherwise `false`.
   * @return $this This instance.
   */
  function setMirror(bool $value): self {
    $this->isMirror = $value;
    return $this;
  }

  /**
   * Sets the repository name.
   * @param string $value The new repository name.
   * @return $this This instance.
   */
  function setName(string $value): self {
    $this->name = $value;
    return $this;
  }

  /**
   * Sets the number of open issues of this repository.
   * @param int $value The new number of open issues.
   * @return $this This instance.
   */
  function setOpenIssuesCount(int $value): self {
    $this->openIssuesCount = $value;
    return $this;
  }

  /**
   * Sets the repository owner.
   * @param User|null $value The new owner.
   * @return $this This instance.
   */
  function setOwner(?User $value): self {
    $this->owner = $value;
    return $this;
  }

  /**
   * Sets the parent repository, if this repository is a fork or a mirror.
   * @param Repository|null $value The new parent repository.
   * @return $this This instance.
   */
  function setParent(?Repository $value): self {
    $this->parent = $value;
    return $this;
  }

  /**
   * Sets the repository permissions.
   * @param Permission|null $value The new permissions.
   * @return $this This instance.
   */
  function setPermissions(?Permission $value): self {
    $this->permissions = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether this repository is private.
   * @param bool $value `true` if this repository is private, otherwise `false`.
   * @return $this This instance.
   */
  function setPrivate(bool $value): self {
    $this->isPrivate = $value;
    return $this;
  }

  /**
   * Sets the repository size, in kilobytes.
   * @param int $value The new repository size, in kilobytes.
   * @return $this This instance.
   */
  function setSize(int $value): self {
    $this->size = $value;
    return $this;
  }

  /**
   * Sets the SSH-based URL for cloning this repository.
   * @param UriInterface|string|null $value The new URL for cloning this repository.
   * @return $this This instance.
   */
  function setSshUrl($value): self {
    $this->sshUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }

  /**
   * Sets the number of stars of this repository.
   * @param int $value The new number of stars.
   * @return $this This instance.
   */
  function setStarsCount(int $value): self {
    $this->starsCount = $value;
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
   * Sets the number of watchers of this repository.
   * @param int $value The new number of watchers.
   * @return $this This instance.
   */
  function setWatchersCount(int $value): self {
    $this->watchersCount = $value;
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
