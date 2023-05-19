<?php

namespace Gitea;

use Gitea\Model\PayloadCommit;
use Gitea\Model\Repository;
use Gitea\Model\User;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use stdClass;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a Gitea push event. */
class PushEvent extends AbstractApiModel
{
    /** @var string The hash of the new Git revision. */
    private $after = '';

    /** @var string The hash of the previous Git revision. */
    private $before = '';

    /** @var \ArrayObject The revision commits. */
    private $commits;

    /** @var UriInterface|null The URL for comparing the revisions. */
    private $compareUrl;

    /** @var User|null The user who pushed the commits. */
    private $pusher;

    /** @var string The Git reference. */
    private $ref = '';

    /** @var Repository|null The repository where the commits were pushed. */
    private $repository;

    /** @var string The secret used to validate this event. */
    private $secret = '';

    /** @var User|null The user who sent this event. */
    private $sender;

    /** Creates a new event. */
    public function __construct(Client &$client, ?object $caller, ...$args)
    {
        $this->commits = new \ArrayObject();
        parent::__construct($client, $caller, ...$args);
    }

    /**
     * Checks an event's HTTP SERVER array to unsure
     * that the request is valid
     *
     * NOTE: This will compare the events secret to
     * passed in secret key to ensure they match
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param array $server The HTTP SERVER array for the push event
     * @param string $body The raw data from the request body
     * @param string $secretKey The secret key to from your server
     * @param bool $skipSecretValidation If set to true, secret key validation will be skipped (used for newer versions of Gitea)
     * @return bool
     */
    public static function validateRequest(array $server, string $body, string $secretKey, bool $skipSecretValidation = false)
    {
        // Validate request protocol
        if ($server['REQUEST_METHOD'] != 'POST') {
            throw new \RuntimeException("FAILED: Not POST - The request was not sent using the POST protocol");
        }

        // Validate content type
        $contentType = isset($server['CONTENT_TYPE']) ? strtolower(trim($server['CONTENT_TYPE'])) : '';
        if ($contentType != 'application/json') {
            throw new \RuntimeException("FAILED: Wrong Type - The request's content type is not set to 'application/json'");
        }

        // Validate request body/content
        $rawContent = trim($body);
        if (empty($rawContent)) {
            throw new \RuntimeException("FAILED: Empty Body - The request has an empty body");
        }

        if (!$skipSecretValidation) {
            // Validate header signature
            $headerSignature = isset($server['HTTP_X_GITEA_SIGNATURE']) ? $server['HTTP_X_GITEA_SIGNATURE'] : '';
            if (empty($headerSignature)) {
                throw new \RuntimeException("FAILED: Signature Missing - The request is missing the Gitea signature");
            }

            // calculate payload signature
            $payload_signature = hash_hmac('sha256', $rawContent, $secretKey, false);

            // check payload signature against header signature
            if ($headerSignature != $payload_signature) {
                throw new \RuntimeException(
                    "FAILED: Access Denied - The push event's secret does not match the expected secret"
                );
            }
        }

        return true;
    }

    /**
     * Creates a new event from the specified JSON map.
     * @param object $map A JSON map representing an event.
     * @return static The instance corresponding to the specified JSON map.
     */
    public static function fromJson(object &$client, ?object $caller, object $map): self
    {
        $newEvent = new static(
            $client,
            $caller
        );
        $newEvent->setAfter(isset($map->after) && is_string($map->after) ? $map->after : '')
        ->setBefore(isset($map->before) && is_string($map->before) ? $map->before : '')
        ->setCompareUrl(isset($map->compare_url) && is_string($map->compare_url) ? new Uri($map->compare_url) : null)
        ->setPusher(isset($map->pusher) && is_object($map->pusher) ? User::fromJson($client, null, $map->pusher) : null)
        ->setRef(isset($map->ref) && is_string($map->ref) ? $map->ref : '')
        ->setRepository(isset($map->repository) && is_object($map->repository) ? Repository::fromJson($client, null, $map->repository) : null)
        ->setSecret(isset($map->secret) && is_string($map->secret) ? $map->secret : '')
        ->setSender(isset($map->sender) && is_object($map->sender) ? User::fromJson($client, null, $map->sender) : null);

        if (isset($map->commits) && is_array($map->commits)) {
            $commitsArray = [];
            foreach ($map->commits as $commit) {
                $commitsArray[] = PayloadCommit::fromJson($client, null, $commit);
            }
            $newEvent->setCommits($commitsArray);
        }

        return $newEvent;
    }

    /**
     * Gets the hash of the new Git revision.
     * @return string The hash of the new Git revision.
     */
    public function getAfter(): string
    {
        return $this->after;
    }

    /**
     * Gets the hash of the new previous revision.
     * @return string The hash of the previous Git revision.
     */
    public function getBefore(): string
    {
        return $this->before;
    }

    /**
     * Gets the revision commits.
     * @return \ArrayObject The revision commits.
     */
    public function getCommits(): \ArrayObject
    {
        return $this->commits;
    }

    /**
     * Gets the URL for comparing the revisions.
     * @return UriInterface|null The URL for comparing the revisions.
     */
    public function getCompareUrl(): ?UriInterface
    {
        return $this->compareUrl;
    }

    /**
     * Gets the user who pushed the commits.
     * @return User|null The user who pushed the commits.
     */
    public function getPusher(): ?User
    {
        return $this->pusher;
    }

    /**
     * Gets the Git reference.
     * @return string The Git reference.
     */
    public function getRef(): string
    {
        return $this->ref;
    }

    /**
     * Gets the repository where the commits were pushed.
     * @return Repository|null The repository where the commits were pushed.
     */
    public function getRepository(): ?Repository
    {
        return $this->repository;
    }

    /**
     * Gets the secret used to validate this event.
     * @return string The secret used to validate this event.
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * Gets the user who sent this event.
     * @return User|null The user who sent this event.
     */
    public function getSender(): ?User
    {
        return $this->sender;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return stdClass The map in JSON format corresponding to this object.
     */
    public function jsonSerialize(): stdClass
    {
        return (object) [
            'after' => $this->getAfter(),
            'before' => $this->getBefore(),
            'compare_url' => ($url = $this->getCompareUrl()) ? (string) $url : null,
            'commits' => array_map(
                function (PayloadCommit $commit) {
                    return $commit->jsonSerialize();
                },
                $this->getCommits()->getArrayCopy()
            ),
            'pusher' => ($user = $this->getPusher()) ? $user->jsonSerialize() : null,
            'ref' => $this->getRef(),
            'repository' => ($repository = $this->getRepository()) ? $repository->jsonSerialize() : null,
            'sender' => ($user = $this->getSender()) ? $user->jsonSerialize() : null
        ];
    }

    /**
     * Sets the hash of the new Git revision.
     * @param string $value The hash of the new Git revision.
     * @return $this This instance.
     */
    public function setAfter(string $value): self
    {
        $this->after = $value;
        return $this;
    }

    /**
     * Sets the hash of the new previous revision.
     * @param string $value The hash of the new previous revision.
     * @return $this This instance.
     */
    public function setBefore(string $value): self
    {
        $this->before = $value;
        return $this;
    }

    /**
     * Sets the revision commits.
     * @param PayloadCommit[] $values The revision commits.
     * @return $this This instance.
     */
    public function setCommits(array $values): self
    {
        $this->getCommits()->exchangeArray($values);
        return $this;
    }

    /**
     * Sets the URL for comparing the revisions.
     * @param UriInterface|null $value The URL for comparing the revisions.
     * @return $this This instance.
     */
    public function setCompareUrl(?UriInterface $value): self
    {
        $this->compareUrl = $value;
        return $this;
    }

    /**
     * Sets the user who pushed the commits.
     * @param User|null $value The new pusher.
     * @return $this This instance.
     */
    public function setPusher(?User $value): self
    {
        $this->pusher = $value;
        return $this;
    }

    /**
     * Sets the Git reference.
     * @param string $value The new Git reference.
     * @return $this This instance.
     */
    public function setRef(string $value): self
    {
        $this->ref = $value;
        return $this;
    }

    /**
     * Sets the repository where the commits were pushed.
     * @param Repository|null $value The new repository.
     * @return $this This instance.
     */
    public function setRepository(?Repository $value): self
    {
        $this->repository = $value;
        return $this;
    }

    /**
     * Sets the secret used to validate this event.
     * @param string $value The new secret used to validate this event.
     * @return $this This instance.
     */
    public function setSecret(string $value): self
    {
        $this->secret = $value;
        return $this;
    }

    /**
     * Sets the user who sent this event.
     * @param User|null $value The new sender.
     * @return $this This instance.
     */
    public function setSender(?User $value): self
    {
        $this->sender = $value;
        return $this;
    }
}
