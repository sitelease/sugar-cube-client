<?php declare(strict_types=1);
namespace Gitea\Models;

use Enum\{EnumTrait};

/** Defines the state of a Gitea status. */
final class StatusState {
  use EnumTrait;

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
