<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use \InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents the GPG verification of a commit. */
class PayloadCommitVerification extends AbstractApiModel {

    /** @var bool Value indicating whether the verification has succeeded. */
    private $isVerified;

    /** @var string A custom message sent with the verification request. */
    private $payload = '';

    /** @var string A message providing details about the verification. */
    private $reason = '';

    /** @var string The signing key used for the verification. */
    private $signature = '';

    /**
     * Creates a new verification of a payload commit.
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param bool $isVerified Value indicating whether the verification has succeeded.
     */
    function __construct(object $giteaClient, object $apiRequester, ...$args) {

        $this->setGiteaClient($giteaClient);
        $this->setApiRequester($apiRequester);
        if (count($args) >= 1) {
            $isVerified = $args[0];
            if (!is_bool($isVerified)) {
                $argumentType = gettype($isVerified);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 3rd parameter to be of the boolean type, but a \"$argumentType\" was passed in");
            }
            $this->setVerified($isVerified);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new commit from the specified JSON map.
     * @param object $giteaClient The Gitea client that originally made the request for this object's data
     * @param object $apiRequester The Api requester that created this object
     * @param object $map A JSON map representing a commit.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object $giteaClient, object $apiRequester, object $map): self {
        return (
            new static(
                $giteaClient,
                $apiRequester,
                isset($map->verified) && is_bool($map->verified) ? $map->verified : false
            )
        )
        ->setPayload(isset($map->payload) && is_string($map->payload) ? $map->payload : '')
        ->setReason(isset($map->reason) && is_string($map->reason) ? $map->reason : '')
        ->setSignature(isset($map->signature) && is_string($map->signature) ? $map->signature : '');
    }

    /**
     * Gets the custom message sent with the verification request.
     * @return string The custom message sent with the verification request.
     */
    function getPayload(): string {
        return $this->payload;
    }

    /**
     * Gets the message providing details about the verification.
     * @return string The message providing details about the verification.
     */
    function getReason(): string {
        return $this->reason;
    }

    /**
     * Gets the signing key used for the verification.
     * @return string The signing key used for the verification.
     */
    function getSignature(): string {
        return $this->signature;
    }

    /**
     * Gets a value indicating whether the verification has succeeded.
     * @return bool `true` if the verification has succeeded, otherwise `false`.
     */
    function isVerified(): bool {
        return $this->isVerified;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'payload' => $this->getPayload(),
            'reason' => $this->getReason(),
            'signature' => $this->getSignature(),
            'verified' => $this->isVerified()
        ];
    }

    /**
     * Sets the custom message sent with the verification request.
     * @param string $value A new custom message.
     * @return $this This instance.
     */
    function setPayload(string $value): self {
        $this->payload = $value;
        return $this;
    }

    /**
     * Sets the message providing details about the verification.
     * @param string $value A new message providing details about the verification.
     * @return $this This instance.
     */
    function setReason(string $value): self {
        $this->reason = $value;
        return $this;
    }

    /**
     * Sets the signing key used for the verification.
     * @param string $value The new signing key.
     * @return $this This instance.
     */
    function setSignature(string $value): self {
        $this->signature = $value;
        return $this;
    }

    /**
     * Sets a value indicating whether the verification has succeeded.
     * @param bool $value `true` if the verification has succeeded, otherwise `false`.
     * @return $this This instance.
     */
    function setVerified(bool $value): self {
        $this->isVerified = $value;
        return $this;
    }
}
