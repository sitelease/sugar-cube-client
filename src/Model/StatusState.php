<?php

declare(strict_types=1);

namespace Gitea\Model;

use MyCLabs\Enum\Enum;

/** Defines the state of a Gitea status. */
final class StatusState extends Enum
{
    /** @var string The status is an error. */
    const error = 'error';

    /** @var string The status is a failure. */
    const failure = 'failure';

    /** @var string The status is pending. */
    const pending = 'pending';

    /** @var string The status is a success. */
    const success = 'success';

    /** @var string The status is a warning. */
    const warning = 'warning';
}
