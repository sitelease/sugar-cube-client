<?php

namespace Gitea\Model;

use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use Gitea\Client;

use stdClass;
use InvalidArgumentException;

use Gitea\Model\Abstracts\AbstractApiModel;

/** Represents a Gitea tag. */
class Tag extends AbstractApiModel
{
    /** @var int The tag identifier. */
    private $id = -1;

    /** @var string The tag's name. */
    private $name = '';

    /** @var UriInterface The tarball URL for the tag */
    private $tarballURL;

    /** @var UriInterface The zipball URL for the tag */
    private $zipballURL;

    /** @var int The commit information for the tag */
    private $commit = [
        "sha" => "",
        "url" => null,
    ];

    /**
     * Creates a new tag
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param int|string $id The tag identifier
     * @param string $name The tag name
     */
    public function __construct(Client &$client, ?object $caller, ...$args)
    {
        parent::__construct($client, $caller, $args);
        if (count($args) >= 2) {
            $id = $args[0];
            $name = $args[1];
            if (!is_string($id)) {
                $argumentType = gettype($id);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 3rd parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            if (!is_string($name)) {
                $argumentType = gettype($name);
                throw new InvalidArgumentException("The \"__construct()\" function requires the 4th parameter to be of the string type, but a \"$argumentType\" was passed in");
            }
            $this->id = $id;
            $this->setName($name);
        } else {
            $numArgs = func_num_args();
            throw new InvalidArgumentException("The \"__construct()\" function requires 4 parameters but only $numArgs were passed in");
        }
    }

    /**
     * Creates a new tag from the specified JSON map.
     * @param object $client The Gitea client that originally made the request for this object's data
     * @param object|null $caller The object that called this method
     * @param object $map A JSON map representing an tag.
     * @return static The instance corresponding to the specified JSON map.
     */
    public static function fromJson(object &$client, ?object $caller, object $map): self
    {
        $newTag = new static(
            $client,
            $caller,
            isset($map->id) && is_string($map->id) ? $map->id : -1,
            isset($map->name) && is_string($map->name) ? $map->name : ''
        );
        $newTag->setTarballURL(isset($map->tarball_url) && is_string($map->tarball_url) ? new Uri($map->tarball_url) : null);
        $newTag->setZipballURL(isset($map->zipball_url) && is_string($map->zipball_url) ? new Uri($map->zipball_url) : null);
        if (isset($map->commit)) {
            $newTag->setCommitSha(isset($map->commit->sha) && is_string($map->commit->sha) ? $map->commit->sha : "");
            $newTag->setCommitUrl(isset($map->commit->url) && is_string($map->commit->url) ? new Uri($map->commit->url) : null);
        }
        return $newTag;
    }

    /**
     * Converts this object to a map in JSON format.
     * @return stdClass The map in JSON format corresponding to this object.
     */
    public function jsonSerialize(): stdClass
    {
        return (object) [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'tarball_url' => ($url = $this->getTarballURL()) ? (string) $url : null,
            'zipball_url' => ($url = $this->getZipballURL()) ? (string) $url : null,
            'commit' => [
                "sha" => $this->getCommitSha(),
                "url" => ($url = $this->getCommitUrl()) ? (string) $url : null
            ],
        ];
    }

    /**
     * Gets the tag identifier.
     * @return int The tag identifier.
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTarballURL(): ?UriInterface
    {
        return $this->tarballURL;
    }

    public function setTarballURL(?UriInterface $url): self
    {
        $this->tarballURL = $url;
        return $this;
    }

    public function getZipballURL(): ?UriInterface
    {
        return $this->zipballURL;
    }

    public function setZipballURL(?UriInterface $url): self
    {
        $this->zipballURL = $url;
        return $this;
    }

    public function getCommitSha(): string
    {
        $commit = $this->commit;
        return $commit["sha"];
    }

    public function setCommitSha(string $string): self
    {
        $this->commit["sha"] = $string;
        return $this;
    }

    public function getCommitUrl(): ?uri
    {
        $commit = $this->commit;
        return $commit["url"];
    }

    public function setCommitUrl(?uri $url): self
    {
        $this->commit["url"] = $url;
        return $this;
    }
}
