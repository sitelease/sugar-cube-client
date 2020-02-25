<?php

namespace Gitea\Collections\Interfaces;

use Gitea\Api\AbstractApiRequester;

interface ApiCollectionInterface
{
    /**
     * Construct the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param array $internalArray
     */
    public function __construct($internalArray = array());

    /**
     * Add an item to the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param AbstractApiRequester $apiObject
     * @param string $key
     */
    public function addItem($apiObject, $key = null);

    /**
     * Remove an existing item from the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param string $key
     */
    public function deleteItem($key);

    /**
     * Get an existing item from the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param string $key
     */
    public function getItem($key);

    /**
     * Get a list of the keys in the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param string $key
     */
    public function keys();

    /**
     * Return the number of items in the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     */
    public function count();

    /**
     * Return true if a key existing in the collection
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param string $key
     */
    public function keyExists($key);

    /**
     * Convert the collection to an array
     *
     * @author Benjamin Blake (sitelease.ca)
     */
    public function toArray();

    /**
     * Required definition of interface IteratorAggregate
     *
     * This method makes the collection work with loops
     *
     * @author Benjamin Blake (sitelease.ca)
     */
    public function getIterator();
}
