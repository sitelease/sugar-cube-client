<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use Gitea\Client;
use Gitea\Model\PayloadUser;
use Gitea\Model\PayloadCommitVerification;

use \InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a commit. */
class PayloadCommit extends AbstractApiModel {

    /** @var PayloadUser|null The person who authored the commit. */
    private $author;

    /** @var PayloadUser|null The person who committed the code. */
    private $committer;

    /** @var string The commit hash. */
    private $id;

    /** @var string The commit message. */
    private $message;

    /** @var \DateTime|null The commit date. */
    private $timestamp;

    /** @var UriInterface|null The URL to the commit's history. */
    private $url;

    /** @var PayloadCommitVerification|null The GPG verification of this commit. */
    private $verification;

    /**
     * Creates a new payload commit.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param string $id The commit hash.
     * @param string $message The commit message.
     */
    public function __construct(Client &$client , ?object $caller, ...$args) {
        parent::__construct($client, $caller, $args);
        if (count($args) >= 2) {
            $id = $args[0];
            $message = $args[1];
            if (!is_string($id)) {
                $argumentType = gettype($id);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 3rd parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            if (!is_string($message)) {
                $argumentType = gettype($message);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            $this->id = $id;
            $this->setMessage($message);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new commit from the specified JSON map.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON map representing a commit.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object &$client , ?object $caller, object $map): self {
        return (
            new static(
                $client,
                $caller,
                isset($map->id) && is_string($map->id) ? $map->id : '',
                isset($map->message) && is_string($map->message) ? $map->message : ''
            )
        )
        ->setAuthor(isset($map->author) && is_object($map->author) ? PayloadUser::fromJson($client, null, $map->author) : null)
        ->setCommitter(isset($map->committer) && is_object($map->committer) ? PayloadUser::fromJson($client, null, $map->committer) : null)
        ->setTimestamp(isset($map->timestamp) && is_string($map->timestamp) ? new \DateTime($map->timestamp) : null)
        ->setUrl(isset($map->url) && is_string($map->url) ? new Uri($map->url) : null)
        ->setVerification(isset($map->verification) && is_object($map->verification) ? PayloadCommitVerification::fromJson($client, null, $map->verification) : null);
    }

    /**
     * Gets the person who authored the commit.
     * @return PayloadUser|null The person who authored the commit.
     */
    function getAuthor(): ?PayloadUser {
        return $this->author;
    }

    /**
     * Gets the person who committed the code.
     * @return PayloadUser|null The person who committed the code.
     */
    function getCommitter(): ?PayloadUser {
        return $this->committer;
    }

    /**
     * Gets the commit hash.
     * @return string The commit hash.
     */
    function getId(): string {
        return $this->id;
    }

    /**
     * Gets the commit message.
     * @return string The commit message.
     */
    function getMessage(): string {
        return $this->message;
    }

    /**
     * Gets the commit date.
     * @return \DateTime|null The commit date.
     */
    function getTimestamp(): ?\DateTime {
        return $this->timestamp;
    }

    /**
     * Gets the URL to the commit's history.
     * @return UriInterface|null The URL to the commit's history.
     */
    function getUrl(): ?UriInterface {
        return $this->url;
    }

    /**
     * Gets the GPG verification of this commit.
     * @return PayloadCommitVerification|null The GPG verification of this commit.
     */
    function getVerification(): ?PayloadCommitVerification {
        return $this->verification;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'author' => ($author = $this->getAuthor()) ? $author->jsonSerialize() : null,
            'committer' => ($committer = $this->getCommitter()) ? $committer->jsonSerialize() : null,
            'id' => $this->getId(),
            'message' => $this->getMessage(),
            'timestamp' => ($date = $this->getTimestamp()) ? $date->format('c') : null,
            'url' => ($url = $this->getUrl()) ? (string) $url : null,
            'verification' => ($verification = $this->getVerification()) ? $verification->jsonSerialize() : null
        ];
    }

    /**
     * Sets the person who authored the commit.
     * @param PayloadUser|null $value The new author.
     * @return $this This instance.
     */
    function setAuthor(?PayloadUser $value): self {
        $this->author = $value;
        return $this;
    }

    /**
     * Sets the person who committed the code.
     * @param PayloadUser|null $value The new committer.
     * @return $this This instance.
     */
    function setCommitter(?PayloadUser $value): self {
        $this->committer = $value;
        return $this;
    }

    /**
     * Sets the commit message.
     * @param string $value The new message.
     * @return $this This instance.
     */
    function setMessage(string $value): self {
        $this->message = $value;
        return $this;
    }

    /**
     * Sets the commit date.
     * @param \DateTime|null $value The new commit date.
     * @return $this This instance.
     */
    function setTimestamp(?\DateTime $value): self {
        $this->timestamp = $value;
        return $this;
    }

    /**
     * Sets the URL to the commit's history.
     * @param UriInterface|null $value The new commit URL.
     * @return $this This instance.
     */
    function setUrl(?UriInterface $value): self {
        $this->url = $value;
        return $this;
    }

    /**
     * Sets the commit message.
     * @param PayloadCommitVerification|null $value The new message.
     * @return $this This instance.
     */
    function setVerification(?PayloadCommitVerification $value): self {
        $this->verification = $value;
        return $this;
    }
}
