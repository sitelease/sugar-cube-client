<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents a set of permissions.
 */
class Permission {

  /**
   * @var bool Value indicating whether administrator access is allowed.
   */
  public $admin = false;

  /**
   * @var bool Value indicating whether pull is allowed.
   */
  public $pull = false;

  /**
   * @var bool Value indicating whether push is allowed.
   */
  public $push = false;

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'admin' => isset($map->admin) && is_bool($map->admin) ? $map->admin : false,
      'pull' => isset($map->pull) && is_bool($map->pull) ? $map->pull : false,
      'push' => isset($map->push) && is_bool($map->push) ? $map->push : false
    ]);
  }
}
