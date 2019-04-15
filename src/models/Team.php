<?php declare(strict_types=1);
namespace Gitea\Models;

/** Represents a team in an organization. */
class Team implements \JsonSerializable {

  /** @var string The team description. */
  private $description = '';

  /** @var int The team identifier. */
  private $id;

  /** @var string The team name. */
  private $name;

  /** @var string The team permission. */
  private $permission = TeamPermission::NONE;

  /**
   * Creates a new team.
   * @param int $id The team identifier.
   * @param string $name The team name.
   */
  function __construct(int $id, string $name) {
    $this->id = $id;
    $this->setName($name);
  }

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return (new static(isset($map->id) && is_int($map->id) ? $map->id : -1, isset($map->name) && is_string($map->name) ? $map->name : ''))
      ->setDescription(isset($map->description) && is_string($map->description) ? $map->description : '')
      ->setPermission(isset($map->permission) && is_string($map->permission) ? $map->permission : TeamPermission::NONE);
  }

  /**
   * Gets the team description.
   * @return string The team description.
   */
  function getDescription(): string {
    return $this->description;
  }

  /**
   * Gets the team identifier.
   * @return int The team identifier.
   */
  function getId(): int {
    return $this->id;
  }

  /**
   * Gets the team name.
   * @return string The team name.
   */
  function getName(): string {
    return $this->name;
  }

  /**
   * Gets the team permission.
   * @return string The team permission.
   */
  function getPermission(): string {
    return $this->permission;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'description' => $this->getDescription(),
      'id' => $this->getId(),
      'name' => $this->getName(),
      'permission' => $this->getPermission()
    ];
  }

  /**
   * Sets the team description.
   * @param string $value The new description.
   * @return $this This instance.
   */
  function setDescription(string $value): self {
    $this->description = $value;
    return $this;
  }

  /**
   * Sets the team name.
   * @param string $value The new name.
   * @return $this This instance.
   */
  function setName(string $value): self {
    $this->name = $value;
    return $this;
  }

  /**
   * Sets the team permission.
   * @param string $value The new permission.
   * @return $this This instance.
   */
  function setPermission(string $value): self {
    $this->permission = TeamPermission::coerce($value, TeamPermission::NONE);
    return $this;
  }
}
