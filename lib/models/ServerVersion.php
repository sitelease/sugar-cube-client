<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Warps the version of the Gitea server.
 */
class ServerVersion {

  /**
   * @var string The version number.
   */
  public $version = '';

  /**
   * Creates a new server version from the specified JSON map.
   * @param object $map A JSON map representing a server version.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'version' => isset($map->version) && is_string($map->version) ? $map->version : ''
    ]);
  }
}
