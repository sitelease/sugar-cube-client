<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents a team in an organization.
 */
class Team {

  /**
   * @var string The team description.
   */
  public $description = '';

  /**
   * @var int The team identifier.
   */
  public $id = -1;

  /**
   * @var string The team name.
   */
  public $name = '';

  /**
   * @var string The team permission.
   */
  public $permission = TeamPermission::NONE;

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'description' => isset($map->description) && is_string($map->description) ? $map->description : '',
      'id' => isset($map->id) && is_int($map->id) ? $map->id : -1,
      'name' => isset($map->name) && is_string($map->name) ? $map->name : '',
      'permission' => isset($map->permission) && TeamPermission::isDefined($map->permission) ? $map->permission : TeamPermission::NONE
    ]);
  }
}
