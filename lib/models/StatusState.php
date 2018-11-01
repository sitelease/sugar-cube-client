<?php
declare(strict_types=1);
namespace Gitea\Models;

use Enum\{EnumTrait};

/**
 * Defines the state of a Gitea status.
 */
final class StatusState {
  use EnumTrait;

  /**
   * @var string The status is an error.
   */
  const ERROR = 'error';

  /**
   * @var string The status is a failure.
   */
  const FAILURE = 'failure';

  /**
   * @var string The status is a pending.
   */
  const PENDING = 'pending';

  /**
   * @var string The status is a success.
   */
  const SUCCESS = 'success';

  /**
   * @var string The status is a warning.
   */
  const WARNING = 'warning';
}
