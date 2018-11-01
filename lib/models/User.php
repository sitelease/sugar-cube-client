<?php
declare(strict_types=1);
namespace Gitea\Models;

use GuzzleHttp\Psr7\{Uri};
use Psr\Http\Message\{UriInterface};

/**
 * Represents a Gitea user.
 * @property UriInterface|null $avatarUrl The URL of the avatar image.
 */
class User {

  /**
   * @var string The mail address.
   */
  public $email = '';

  /**
   * @var string The full name.
   */
  public $fullName = '';

  /**
   * @var int The user identifier.
   */
  public $id = -1;

  /**
   * @var string The user locale.
   */
  public $language = '';

  /**
   * @var string The name of the Gitea account.
   */
  public $login = '';

  /**
   * @var UriInterface|null The URL to the user's avatar.
   */
  private $avatarUrl;

  /**
   * Creates a new user from the specified JSON map.
   * @param object $map A JSON map representing a user.
   * @return static The instance corresponding to the specified JSON map.
   */
  static function fromJson(object $map): self {
    return new static([
      'avatarUrl' => isset($map->avatar_url) && is_string($map->avatar_url) ? $map->avatar_url : null,
      'email' => isset($map->email) && is_string($map->email) ? mb_strtolower($map->email) : '',
      'fullName' => isset($map->full_name) && is_string($map->full_name) ? $map->full_name : '',
      'id' => isset($map->id) && is_int($map->id) ? $map->id : -1,
      'language' => isset($map->language) && is_string($map->language) ? $map->language : '',
      'login' => isset($map->login) && is_string($map->login) ? $map->login : ''
    ]);
  }

  /**
   * Returns the list of fields that should be returned by default.
   * @return array The list of field names or field definitions.
   */
  function fields(): array {
    return [
      'avatar_url' => function(self $model) { return ($url = $model->getAvatarUrl()) ? (string) $url : null; },
      'email',
      'full_name' => 'fullName',
      'id',
      'language',
      'login'
    ];
  }

  /**
   * Gets the URL of the avatar image.
   * @return UriInterface|null The URL of the avatar image.
   */
  function getAvatarUrl(): ?UriInterface {
    return $this->avatarUrl;
  }

  /**
   * Sets the URL of the avatar image.
   * @param UriInterface|string|null $value The new avatar URL.
   * @return $this This instance.
   */
  function setAvatarUrl($value): self {
    $this->avatarUrl = is_string($value) ? new Uri($value) : $value;
    return $this;
  }
}
