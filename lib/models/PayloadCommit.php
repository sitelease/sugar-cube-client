<?php
declare(strict_types=1);
namespace Gitea\Models;

use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/**
 * Represents a commit.
 */
class PayloadCommit implements \JsonSerializable {

  /**
   * @var PayloadUser|null The person who authored the commit.
   */
  public $author;

  /**
   * @var PayloadUser|null The person who committed the code.
   */
  public $committer;

  /**
   * @var string The commit hash.
   */
  public $id = '';

  /**
   * @var string The commit message.
   */
  public $message = '';

  /**
   * @var PayloadCommitVerification|null The GPG verification of this commit.
   */
  public $verification;

  /**
   * @var \DateTime|null The commit date.
   */
  private $timestamp;

  /**
   * @var UriInterface|null The URL to the commit's history.
   */
  private $url;

  /**
   * Creates a new commit from the specified JSON map.
   * @param object $map A JSON map representing a commit.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'author' => isset($map->author) && is_object($map->author) ? PayloadUser::fromJson($map->author) : null,
      'committer' => isset($map->committer) && is_object($map->committer) ? PayloadUser::fromJson($map->committer) : null,
      'id' => isset($map->id) && is_string($map->id) ? $map->id : '',
      'message' => isset($map->message) && is_string($map->message) ? $map->message : '',
      'timestamp' => isset($map->timestamp) && is_string($map->timestamp) ? $map->timestamp : null,
      'url' => isset($map->url) && is_string($map->url) ? $map->url : null,
      'verification' => isset($map->verification) && is_object($map->verification) ? PayloadCommitVerification::fromJson($map->verification) : null
    ]);
  }

  /**
   * Gets the commit date.
   * @return \DateTime|null The commit date.
   */
  function getTimestamp(): ?\DateTime {
    return $this->timestamp;
  }

  /**
   * Gets the URL to the commit's history.
   * @return UriInterface|null The URL to the commit's history.
   */
  function getUrl(): ?UriInterface {
    return $this->url;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'author',
      'committer',
      'id',
      'message',
      'timestamp' => ($date = $this->getTimestamp()) ? $date->format('c') : null,
      'url' => ($url = $this->getUrl()) ? (string) $url : null,
      'verification'
    ];
  }

  /**
   * Sets the commit date.
   * @param \DateTime|string|null $value The new commit date.
   * @return $this This instance.
   */
  function setTimestamp($value): self {
    $this->timestamp = is_string($value) ? new \DateTime($value) : $value;
    return $this;
  }

  /**
   * Sets the URL to the commit's history.
   * @param UriInterface|string|null $value The new commit URL.
   * @return $this This instance.
   */
  function setUrl($value): self {
    $this->url = is_string($value) ? new Uri($value) : $value;
    return $this;
  }
}
