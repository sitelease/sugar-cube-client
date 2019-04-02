<?php declare(strict_types=1);
namespace Gitea\Models;

/**
 * Represents the worked time for an issue or pull request.
 */
class TrackedTime implements \JsonSerializable {

  /**
   * @var \DateTime|null The date the entry was created.
   */
  private $createdAt;

  /**
   * @var int The entry identifier.
   */
  private $id;

  /**
   * @var int The identifier of the associated issue or pull request.
   */
  private $issueId = -1;

  /**
   * @var int The elapsed time, in seconds.
   */
  private $time;

  /**
   * @var int The identifier of the initiating user.
   */
  private $userId = -1;

  /**
   * Creates a new entry.
   * @param int $id The entry identifier.
   * @param int $time The elapsed time, in seconds.
   */
  function __construct(int $id, int $time) {
    $this->id = $id;
    $this->setTime($time);
  }

  /**
   * Creates a new entry from the specified JSON map.
   * @param object $map A JSON map representing an entry.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return (new static(isset($map->id) && is_int($map->id) ? $map->id : -1, isset($map->time) && is_int($map->time) ? $map->time : 0))
      ->setCreatedAt(isset($map->created) && is_string($map->created) ? new \DateTime($map->created) : null)
      ->setIssueId(isset($map->issue_id) && is_int($map->issue_id) ? $map->issue_id : -1)
      ->setUserId(isset($map->user_id) && is_int($map->user_id) ? $map->user_id : -1);
  }

  /**
   * Gets the date the entry was created.
   * @return \DateTime|null The date the entry was created.
   */
  function getCreatedAt(): ?\DateTime {
    return $this->createdAt;
  }

  /**
   * Gets the entry identifier.
   * @return int The entry identifier.
   */
  function getId(): int {
    return $this->id;
  }

  /**
   * Gets the identifier of the associated issue or pull request.
   * @return int The identifier of the associated issue or pull request.
   */
  function getIssueId(): int {
    return $this->issueId;
  }

  /**
   * Gets the elapsed time, in seconds.
   * @return int The elapsed time, in seconds.
   */
  function getTime(): int {
    return $this->time;
  }

  /**
   * Gets the identifier of the initiating user.
   * @return int The identifier of the initiating user.
   */
  function getUserId(): int {
    return $this->userId;
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  function jsonSerialize(): \stdClass {
    return (object) [
      'created' => ($date = $this->getCreatedAt()) ? $date->format('c') : null,
      'id' => $this->getId(),
      'issue_id' => $this->getIssueId(),
      'time' => $this->getTime(),
      'user_id' => $this->getUserId()
    ];
  }

  /**
   * Sets the date the entry was created.
   * @param \DateTime|null $value The new date of creation.
   * @return $this This instance.
   */
  function setCreatedAt(?\DateTime $value): self {
    $this->createdAt = $value;
    return $this;
  }

  /**
   * Sets the identifier of the associated issue or pull request.
   * @param int $value The new issue identifier.
   * @return $this This instance.
   */
  function setIssueId(int $value): self {
    $this->issueId = $value;
    return $this;
  }

  /**
   * Sets the elapsed time, in seconds.
   * @param int $value The new elapsed time, in seconds.
   * @return $this This instance.
   */
  function setTime(int $value): self {
    $this->time = $value;
    return $this;
  }

  /**
   * Sets the identifier of the initiating user.
   * @param int $value The new user identifier.
   * @return $this This instance.
   */
  function setUserId(int $value): self {
    $this->userId = $value;
    return $this;
  }
}
