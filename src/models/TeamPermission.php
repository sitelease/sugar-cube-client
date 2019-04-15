<?php declare(strict_types=1);
namespace Gitea\Models;

use Enum\{EnumTrait};

/** Defines the permission of a team. */
final class TeamPermission {
  use EnumTrait;

  /** @var string The team has the administrator permission. */
  const admin = 'admin';

  /** @var string The team doesn't have any permission. */
  const none = 'none';

  /** @var string The team has the owner permission. */
  const owner = 'owner';

  /** @var string The team has the read permission. */
  const read = 'read';

  /** @var string The team has the write permission. */
  const write = 'write';
}
