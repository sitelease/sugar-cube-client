<?php
declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents the GPG verification of a commit.
 */
class PayloadCommitVerification implements \JsonSerializable {

  /**
   * @var bool Value indicating whether the verification has succeeded.
   */
  public $isVerified = false;

  /**
   * @var string A custom message sent with the verification request.
   */
  public $payload = '';

  /**
   * @var string A message providing details about the verification.
   */
  public $reason = '';

  /**
   * @var string The signing key used for the verification.
   */
  public $signature = '';

  /**
   * Creates a new commit from the specified JSON map.
   * @param object $map A JSON map representing a commit.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'isVerified' => isset($map->verified) && is_bool($map->verified) ? $map->verified : false,
      'payload' => isset($map->payload) && is_string($map->payload) ? $map->payload : '',
      'reason' => isset($map->reason) && is_string($map->reason) ? $map->reason : '',
      'signature' => isset($map->signature) && is_string($map->signature) ? $map->signature : ''
    ]);
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'payload',
      'reason',
      'signature',
      'verified' => 'isVerified'
    ];
  }
}
