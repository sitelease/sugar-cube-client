<?php
declare(strict_types=1);
use Gitea\{PushEvent};

/**
 * Handles the payload of a Gitea push event.
 * @return PushEvent The parsed payload.
 * @throws UnexpectedValueException The request headers or the request body are invalid.
 */
function main(): PushEvent {
  if (!isset($_SERVER['HTTP_X_GITEA_DELIVERY']) || !isset($_SERVER['HTTP_X_GITEA_EVENT']))
    throw new UnexpectedValueException('Invalid payload data.');

  $data = json_decode((string) file_get_contents('php://input'));
  if (!is_object($data)) throw new UnexpectedValueException('Invalid payload data.');

  return PushEvent::fromJson($data);
}
