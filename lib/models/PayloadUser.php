<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents the author or committer of a commit.
 */
class PayloadUser implements \JsonSerializable {

  /**
   * @var string The mail address.
   */
  private $email = '';

  /**
   * @var string The full name.
   */
  private $name = '';

  /**
   * @var string The name of the Gitea account.
   */
  private $username = '';

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'email' => isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '',
      'name' => isset($map->name) && is_string($map->name) ? $map->name : '',
      'username' => isset($map->username) && is_string($map->username) ? $map->username : ''
    ]);
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
      'pusher',
      'ref' => $this->getRef(),
      'repository',
      'sender'
    ];
  }
}
