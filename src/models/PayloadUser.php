<?php declare(strict_types=1);
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
  private $username;

  /**
   * Creates a new payload user.
   * @param string $username The name of the Gitea account.
   */
  function __construct(string $username) {
    $this->username = $username;
  }

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return (new static(isset($map->username) && is_string($map->username) ? $map->username : ''))
      ->setEmail(isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '')
      ->setName(isset($map->name) && is_string($map->name) ? $map->name : '');
  }

  /**
   * Gets the mail address.
   * @return string The mail address.
   */
  function getEmail(): string {
    return $this->email;
  }

  /**
   * Gets the full name.
   * @return string The full name.
   */
  function getName(): string {
    return $this->name;
  }

  /**
   * Gets the name of the Gitea account.
   * @return string The name of the Gitea account.
   */
  function getUsername(): string {
    return $this->username;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'email' => $this->getEmail(),
      'name' => $this->getName(),
      'username' => $this->getUsername()
    ];
  }

  /**
   * Sets the mail address.
   * @param string $value The new mail address.
   * @return $this This instance.
   */
  function setEmail(string $value): self {
    $this->email = $value;
    return $this;
  }

  /**
   * Sets the full name.
   * @param string $value The new full name.
   * @return $this This instance.
   */
  function setName(string $value): self {
    $this->name = $value;
    return $this;
  }
}
