<?php declare(strict_types=1);
namespace Gitea;

use Gitea\Models\{PayloadCommit, Repository, User};
use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/**
 * Represents a Gitea push event.
 */
class PushEvent implements \JsonSerializable {

  /**
   * @var string The hash of the new Git revision.
   */
  private $after = '';

  /**
   * @var string The hash of the previous Git revision.
   */
  private $before = '';

  /**
   * @var \ArrayObject The revision commits.
   */
  private $commits;

  /**
   * @var UriInterface|null The URL for comparing the revisions.
   */
  private $compareUrl;

  /**
   * @var User|null The user who pushed the commits.
   */
  private $pusher;

  /**
   * @var string The Git reference.
   */
  private $ref = '';

  /**
   * @var Repository|null The repository where the commits were pushed.
   */
  private $repository;

  /**
   * @var string The secret used to validate this event.
   */
  private $secret = '';

  /**
   * @var User|null The user who sent this event.
   */
  private $sender;

  /**
   * Creates a new event.
   */
  function __construct() {
    $this->commits = new \ArrayObject;
  }

  /**
   * Creates a new event from the specified JSON map.
   * @param object $map A JSON map representing an event.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return (new static)
      ->setAfter(isset($map->after) && is_string($map->after) ? $map->after : '')
      ->setBefore(isset($map->before) && is_string($map->before) ? $map->before : '')
      ->setCompareUrl(isset($map->compare_url) && is_string($map->compare_url) ? new Uri($map->compare_url) : null)
      ->setCommits(isset($map->commits) && is_array($map->commits) ? array_map([PayloadCommit::class, 'fromJson'], $map->commits) : [])
      ->setPusher(isset($map->pusher) && is_object($map->pusher) ? User::fromJson($map->pusher) : null)
      ->setRef(isset($map->ref) && is_string($map->ref) ? $map->ref : '')
      ->setRepository(isset($map->repository) && is_object($map->repository) ? Repository::fromJson($map->repository) : null)
      ->setSecret(isset($map->secret) && is_string($map->secret) ? $map->secret : '')
      ->setSender(isset($map->sender) && is_object($map->sender) ? User::fromJson($map->sender) : null);
  }

  /**
   * Gets the hash of the new Git revision.
   * @return string The hash of the new Git revision.
   */
  function getAfter(): string {
    return $this->after;
  }

  /**
   * Gets the hash of the new previous revision.
   * @return string The hash of the previous Git revision.
   */
  function getBefore(): string {
    return $this->before;
  }

  /**
   * Gets the revision commits.
   * @return \ArrayObject The revision commits.
   */
  function getCommits(): \ArrayObject {
    return $this->commits;
  }

  /**
   * Gets the URL for comparing the revisions.
   * @return UriInterface|null The URL for comparing the revisions.
   */
  function getCompareUrl(): ?UriInterface {
    return $this->compareUrl;
  }

  /**
   * Gets the user who pushed the commits.
   * @return User|null The user who pushed the commits.
   */
  function getPusher(): ?User {
    return $this->pusher;
  }

  /**
   * Gets the Git reference.
   * @return string The Git reference.
   */
  function getRef(): string {
    return $this->ref;
  }

  /**
   * Gets the repository where the commits were pushed.
   * @return Repository|null The repository where the commits were pushed.
   */
  function getRepository(): ?Repository {
    return $this->repository;
  }

  /**
   * Gets the secret used to validate this event.
   * @return string The secret used to validate this event.
   */
  function getSecret(): string {
    return $this->secret;
  }

  /**
   * Gets the user who sent this event.
   * @return User|null The user who sent this event.
   */
  function getSender(): ?User {
    return $this->sender;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'after' => $this->getAfter(),
      'before' => $this->getBefore(),
      'compare_url' => ($url = $this->getCompareUrl()) ? (string) $url : null,
      'commits' => array_map(function(PayloadCommit $commit) { return $commit->jsonSerialize(); }, $this->getCommits()->getArrayCopy()),
      'pusher' => ($user = $this->getPusher()) ? $user->jsonSerialize() : null,
      'ref' => $this->getRef(),
      'repository' => ($repository = $this->getRepository()) ? $repository->jsonSerialize() : null,
      'sender' => ($user = $this->getSender()) ? $user->jsonSerialize() : null
    ];
  }

  /**
   * Sets the hash of the new Git revision.
   * @param string $value The hash of the new Git revision.
   * @return $this This instance.
   */
  function setAfter(string $value): self {
    $this->after = $value;
    return $this;
  }

  /**
   * Sets the hash of the new previous revision.
   * @param string $value The hash of the new previous revision.
   * @return $this This instance.
   */
  function setBefore(string $value): self {
    $this->before = $value;
    return $this;
  }

  /**
   * Sets the revision commits.
   * @param PayloadCommit[] $values The revision commits.
   * @return $this This instance.
   */
  function setCommits(array $values): self {
    $this->getCommits()->exchangeArray($values);
    return $this;
  }

  /**
   * Sets the URL for comparing the revisions.
   * @param UriInterface|null $value The URL for comparing the revisions.
   * @return $this This instance.
   */
  function setCompareUrl(?UriInterface $value): self {
    $this->compareUrl = $value;
    return $this;
  }

  /**
   * Sets the user who pushed the commits.
   * @param User|null $value The new pusher.
   * @return $this This instance.
   */
  function setPusher(?User $value): self {
    $this->pusher = $value;
    return $this;
  }

  /**
   * Sets the Git reference.
   * @param string $value The new Git reference.
   * @return $this This instance.
   */
  function setRef(string $value): self {
    $this->ref = $value;
    return $this;
  }

  /**
   * Sets the repository where the commits were pushed.
   * @param Repository|null $value The new repository.
   * @return $this This instance.
   */
  function setRepository(?Repository $value): self {
    $this->repository = $value;
    return $this;
  }

  /**
   * Sets the secret used to validate this event.
   * @param string $value The new secret used to validate this event.
   * @return $this This instance.
   */
  function setSecret(string $value): self {
    $this->secret = $value;
    return $this;
  }

  /**
   * Sets the user who sent this event.
   * @param User|null $value The new sender.
   * @return $this This instance.
   */
  function setSender(?User $value): self {
    $this->sender = $value;
    return $this;
  }
}
