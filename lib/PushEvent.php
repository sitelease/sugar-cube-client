<?php
declare(strict_types=1);
namespace Gitea;

use Gitea\Models\{PayloadCommit, Repository, User};
use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/**
 * Represents a Gitea push event.
 * @property \ArrayObject $commits The revision commits.
 * @property UriInterface|null $compareUrl The URL for comparing the revisions.
 */
class PushEvent {

  /**
   * @var string The hash of the new Git revision.
   */
  public $after = '';

  /**
   * @var string The hash of the previous Git revision.
   */
  public $before = '';

  /**
   * @var User|null The user who pushed the commits.
   */
  public $pusher;

  /**
   * @var string The Git reference.
   */
  public $ref = '';

  /**
   * @var Repository|null The repository where the commits were pushed.
   */
  public $repository;

  /**
   * @var string The secret used to validate this event.
   */
  public $secret = '';

  /**
   * @var User|null The user who sent this event.
   */
  public $sender;

  /**
   * @var \ArrayObject The revision commits.
   */
  private $commits;

  /**
   * @var UriInterface|null The URL for comparing the revisions.
   */
  private $compareUrl;

  /**
   * Creates a new event.
   * @param array $config Name-value pairs that will be used to initialize the object properties.
   */
  function __construct(array $config = []) {
    $this->commits = new \ArrayObject;
  }

  /**
   * Creates a new event from the specified JSON map.
   * @param object $map A JSON map representing an event.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'after' => isset($map->after) && is_string($map->after) ? $map->after : '',
      'before' => isset($map->before) && is_string($map->before) ? $map->before : '',
      'compareUrl' => isset($map->compare_url) && is_string($map->compare_url) ? new Uri($map->compare_url) : null,
      'commits' => isset($map->commits) && is_array($map->commits) ? array_map([PayloadCommit::class, 'fromJson'], $map->commits) : [],
      'pusher' => isset($map->pusher) && is_object($map->pusher) ? User::fromJson($map->pusher) : null,
      'ref' => isset($map->ref) && is_string($map->ref) ? $map->ref : '',
      'repository' => isset($map->repository) && is_object($map->repository) ? Repository::fromJson($map->repository) : null,
      'secret' => isset($map->secret) && is_string($map->secret) ? $map->secret : '',
      'sender' => isset($map->sender) && is_object($map->sender) ? User::fromJson($map->sender) : null
    ]);
  }

  /**
   * Returns the list of fields that should be returned by default.
   * @return array The list of field names or field definitions.
   */
  function fields(): array {
    return [
      'after',
      'before',
      'compare_url' => function(self $model) { return ($url = $model->getCompareUrl()) ? (string) $url : null; },
      'commits',
      'pusher',
      'ref',
      'repository',
      'sender'
    ];
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
   * @param UriInterface|string|null $value The URL for comparing the revisions.
   * @return $this This instance.
   */
  function setCompareUrl($value): self {
    $this->compareUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }
}
