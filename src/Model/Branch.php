<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use Gitea\Client;
use Gitea\Model\PayloadCommit;

use \InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a Gitea branch. */
class Branch extends AbstractApiModel {

    /** @var string The branch's name */
    private $name = '';

    /** @var PayloadCommit|null The commit connected to this branch */
    private $commit;

    /** @var string True if the branch is protected  */
    private $protected = true;

    /** @var string True if the user can push to this branch */
    private $userCanPush = false;

    /** @var string True if the user can merge this branch */
    private $userCanMerge = false;


    /**
     * Creates a new branch
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param string $name The branch name
     */
    public function __construct(Client &$client , ?object $caller, ...$args) {
        parent::__construct($client, $caller, $args);
        if (count($args) >= 1) {
            $name = $args[0];
            if (!is_string($name)) {
                $argumentType = gettype($name);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            $this->setName($name);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new branch from the specified JSON map.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON map representing an branch.
     * @return static The instance corresponding to the specified JSON map.
     */
    static function fromJson(object &$client , ?object $caller, object $map): self {
        return (
            new static(
                $client,
                $caller,
                isset($map->name) && is_string($map->name) ? $map->name : ''
            )
        )
        ->setCommit(isset($map->commit) && is_object($map->commit) ? PayloadCommit::fromJson($client, null, $map->commit) : null)
        ->setProtected(isset($map->protected) && is_bool($map->protected) ? $map->protected : true)
        ->setCanUserPush(isset($map->user_can_push) && is_bool($map->user_can_push) ? $map->user_can_push : false)
        ->setUserCanMerge(isset($map->user_can_merge) && is_bool($map->user_can_merge) ? $map->user_can_merge : false);
    }

    /**
     * Converts this object to a map in JSON format.
     * @return \stdClass The map in JSON format corresponding to this object.
     */
    function jsonSerialize(): \stdClass {
        return (object) [
            'name' => $this->getName(),
            'commit' => ($commit = $this->getCommit()) ? $commit->jsonSerialize() : null,
            'protected' => $this->getProtected(),
            'user_can_push' => $this->getCanUserPush(),
            'user_can_merge' => $this->getUserCanMerge()
        ];
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getCommit(): ?PayloadCommit {
        return $this->commit;
    }

    public function setCommit(?PayloadCommit $object): self {
        $this->commit = $object;
        return $this;
    }

    public function getProtected() {
        return $this->protected;
    }

    public function setProtected(bool $boolean): self {
        $this->protected = $boolean;
        return $this;
    }

    public function getCanUserPush() {
        return $this->canUserPush;
    }

    public function setCanUserPush(bool $boolean): self {
        $this->canUserPush = $boolean;
        return $this;
    }

    public function getUserCanMerge() {
        return $this->userCanMerge;
    }

    public function setUserCanMerge(bool $boolean): self {
        $this->userCanMerge = $boolean;
        return $this;
    }

}
