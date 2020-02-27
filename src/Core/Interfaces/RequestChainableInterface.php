<?php

namespace Gitea\Core\Interfaces;

use Gitea\Client;
use Gitea\Model\Repository;

/**
 * Interface that allows the tracking of request heirarchies
 *
 * @author Benjamin Blake (sitelease.ca)
 */
interface RequestChainableInterface
{
    /**
     * Get the object that called this method
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return object|null
     */
    public function getCaller(): ?object;

    /**
     * Set the object that called this method
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return self
     */
    public function setCaller($object): self;

    /**
     * Return the request chain heirarchy
     * as an array of objects
     *
     * This is useful if you need to know
     * what objects where called in order to
     * get the current object
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return array
     */
    public function getRequestChain(): array;

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
    public function searchRequestChain(string $class): ?object;

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
    public function debugRequestChain(): string;

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
    public function findOrRequestRepository(string $owner, string $name): ?Repository;
}
