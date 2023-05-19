<?php declare(strict_types=1);
namespace Gitea\Model;

use MyCLabs\Enum\Enum;

/** Defines the permission of a team. */
final class TeamPermission extends Enum {

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
