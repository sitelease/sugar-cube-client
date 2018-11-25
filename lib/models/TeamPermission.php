<?php
declare(strict_types=1);
namespace Gitea\Models;

use Enum\{EnumTrait};

/**
 * Defines the permission of a team.
 */
final class TeamPermission {
  use EnumTrait;

  /**
   * @var string The team has the administrator permission.
   */
  const ADMIN = 'admin';

  /**
   * @var string The team doesn't have any permission.
   */
  const NONE = 'none';

  /**
   * @var string The team has the owner permission.
   */
  const OWNER = 'owner';

  /**
   * @var string The team has the read permission.
   */
  const READ = 'read';

  /**
   * @var string The team has the write permission.
   */
  const WRITE = 'write';
}
