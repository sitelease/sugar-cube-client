<?php

namespace Gitea\Core\Traits;

use Gitea\Client;
use Gitea\Model\Repository;

use Gitea\Core\Interfaces\RequestChainableInterface;

/**
 * Abstract class that implements the RequestChainable interface
 *
 * @author Benjamin Blake (sitelease.ca)
 */
trait RequestChainable
{
    /**
     * The object that called this object
     *
     * @var string
     */
    private $caller;

    /**
     * Get the object that called this method
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return object|null
     */
    public function getCaller(): ?object
    {
        return $this->caller;
    }

    /**
     * Set the object that called this method
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return self
     */
    public function setCaller($object): self
    {
        $this->caller = $object;
        return $this;
    }

    /**
     * Return the request chain heirarchy
     * as an array of objects
     *
     * This is useful if you need to know
     * what objects where called in order to
     * get the current object
     *
     * @author Benjamin Blake (sitelease.ca)
     * @return array
     */
    public function getRequestChain(): array
    {
        $requestChain = array();

        // While the caller implements the RequestChainableInterface
        // loop over it and add it to the request chain array
        $caller = $this->getCaller();
        while ($caller instanceof RequestChainableInterface) {
            $requestChain[] = $caller;

            if ($caller && !$caller instanceof Client) {
                $caller = $caller->getCaller();
            } else {
                break;
            }
        }
        return $requestChain;
    }

    /**
     * Climb up the request chain searching for
     * an object of a certain class
     *
     * If the object is found it will be returned,
     * otherwise the method returns null
     *
     * @author Benjamin Blake (sitelease.ca)
     * @param string $class The class of the object you are searching for
     * @return object|null
     */
    public function searchRequestChain(string $class): ?object
    {
        $requestChain = $this->getRequestChain();

        $foundObj = null;
        foreach ($requestChain as $callerObj) {
            if ($class == get_class($callerObj)) {
                $foundObj = $callerObj;
                break;
            }
        }

        return $foundObj;
    }

    /**
     * Return the request chain heirarchy
     * as a string of class names
     *
     * This is useful if you need to quickly print out
     * a breadcrumb like heirarchy of callers
     *
     * @author Benjamin Blake (sitelease.ca)
     * @return array
     */
    public function debugRequestChain(): string
    {
        $requestChainDebug = "";
        $requestChain = $this->getRequestChain();

        while (count($requestChain) > 0) {
            $callerObj = array_shift($requestChain);
            if (count($requestChain) != 0) {
                $requestChainDebug .= get_class($callerObj)." -> ";
            } else {
                $requestChainDebug .= get_class($callerObj);
            }
        }

        return $requestChainDebug;
    }

    /**
     * Climb up the request chain searching for
     * a repository object. If a repository is found
     * it will be returned otherwise the method will
     * make an API request to retrieve it
     *
     * @author Benjamin Blake (sitelease.ca)
     * @param string $owner The owner of the repository
     * @param string $name The name of the repository
     * @return Repository|null
     */
    public function findOrRequestRepository(string $owner, string $name): ?Repository
    {
        $repository = $this->searchRequestChain(Repository::class);

        if (!$repository) {
            $client = $this->getClient();
            $repository = $client->repositories()->getByName($owner, $name);
        }

        return $repository;
    }

}
