<?php

namespace Gitea\Core\Interfaces;

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
}
