<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Warps the version of the Gitea server.
 */
class ServerVersion implements \JsonSerializable {

  /**
   * @var string The version number.
   */
  private $version;

  /**
   * Creates a new server version.
   * @param string $version The version number.
   */
  function __construct(string $version) {
    $this->version = $version;
  }

  /**
   * Creates a new server version from the specified JSON map.
   * @param object $map A JSON map representing a server version.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static(isset($map->version) && is_string($map->version) ? $map->version : '');
  }

  /**
   * Gets the version number.
   * @return string The version number.
   */
  function getVersion(): string {
    return $this->version;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) ['version' => $this->getVersion()];
  }
}
