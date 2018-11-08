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
  private $isVerified = false;

  /**
   * @var string A custom message sent with the verification request.
   */
  private $payload = '';

  /**
   * @var string A message providing details about the verification.
   */
  private $reason = '';

  /**
   * @var string The signing key used for the verification.
   */
  private $signature = '';

  /**
   * Creates a new verification of a payload commit.
   */
  function __construct(bool $isVerified = false) {
    // TODO $this->setVerified($isVerified);
  }

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
   * Gets the custom message sent with the verification request.
   * @return string The custom message sent with the verification request.
   */
  function getPayload(): string {
    return $this->payload;
  }

  /**
   * Gets the message providing details about the verification.
   * @return string The message providing details about the verification.
   */
  function getReason(): string {
    return $this->reason;
  }

  /**
   * Gets the signing key used for the verification.
   * @return string The signing key used for the verification.
   */
  function getSignature(): string {
    return $this->signature;
  }

  /**
   * TODO
   * @return bool
   */
  function isVerified(): bool {
    return $this->isVerified;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'payload' => $this->getPayload(),
      'reason' => $this->getReason(),
      'signature' => $this->getSignature(),
      'verified' => $this->isVerified()
    ];
  }
}
