<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents the author or committer of a commit.
 */
class PayloadUser {

  /**
   * @var string The mail address.
   */
  public $email = '';

  /**
   * @var string The full name.
   */
  public $name = '';

  /**
   * @var string The name of the Gitea account.
   */
  public $username = '';

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
}
