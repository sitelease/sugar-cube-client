<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents a set of permissions.
 */
class Permission implements \JsonSerializable {

  /**
   * @var bool Value indicating whether administrator access is allowed.
   */
  private $admin;

  /**
   * @var bool Value indicating whether pull is allowed.
   */
  private $pull;

  /**
   * @var bool Value indicating whether push is allowed.
   */
  private $push;

  /**
   * Creates a new permission.
   * @param bool $admin Value indicating whether administrator access is allowed.
   * @param bool $pull Value indicating whether pull is allowed.
   * @param bool $push Value indicating whether push is allowed.
   */
  function __construct(bool $admin = false, bool $pull = false, bool $push = false) {
    $this->setAdmin($admin)->setPull($pull)->setPush($push);
  }

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  function __toString(): string {
    $json = json_encode($this, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    return static::class." $json";
  }

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static(
      isset($map->admin) && is_bool($map->admin) ? $map->admin : false,
      isset($map->pull) && is_bool($map->pull) ? $map->pull : false,
      isset($map->push) && is_bool($map->push) ? $map->push : false
    );
  }

  /**
   * Gets a value indicating whether administrator access is allowed.
   * @return bool `true` if administrator access is allowed, otherwise `false`.
   */
  function getAdmin(): bool {
    return $this->admin;
  }

  /**
   * Gets a value indicating whether pull is allowed.
   * @return bool `true` if pull is allowed, otherwise `false`.
   */
  function getPull(): bool {
    return $this->pull;
  }

  /**
   * Gets a value indicating whether push is allowed.
   * @return bool `true` if push is allowed, otherwise `false`.
   */
  function getPush(): bool {
    return $this->push;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'admin' => $this->getAdmin(),
      'pull' => $this->getPull(),
      'push' => $this->getPush()
    ];
  }

  /**
   * Sets a value indicating whether administrator access is allowed.
   * @param bool $value `true` to allow administrator access, otherwise `false`.
   * @return $this This instance.
   */
  function setAdmin(bool $value): self {
    $this->admin = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether pull is allowed.
   * @param bool $value `true` to allow pull, otherwise `false`.
   * @return $this This instance.
   */
  function setPull(bool $value): self {
    $this->pull = $value;
    return $this;
  }

  /**
   * Sets a value indicating whether push is allowed.
   * @param bool $value `true` to allow push, otherwise `false`.
   * @return $this This instance.
   */
  function setPush(bool $value): self {
    $this->push = $value;
    return $this;
  }
}
