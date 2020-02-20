<?php

namespace Gitea\Collections;

use Gitea\Collections\Interfaces\ApiCollectionInterface;

use \Countable;
use \IteratorAggregate;
use \ArrayIterator;

class ApiItemCollection implements ApiCollectionInterface, IteratorAggregate, Countable
{
    private $items = array();

    public function __construct($internalArray = array()) {
        if ($internalArray && is_array($internalArray)) {
            $this->items = $internalArray;
        }
    }

    public function addItem($apiObject, $key = null) {
        if ($key == null) {
            $this->items[] = $apiObject;
        }
        else {
            if (isset($this->items[$key])) {
                return false;
            } else {
                $this->items[$key] = $apiObject;
            }
        }
    }

    public function deleteItem($key) {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            return false;
        }
    }

    public function getItem($key) {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
          return false;
        }
    }

    public function keys() {
        return array_keys($this->items);
    }

    public function count() {
        return count($this->items);
    }

    public function keyExists($key) {
        return isset($this->items[$key]);
    }

    public function toArray() {
        return $this->items;
    }

    public function getIterator() {
        return new ArrayIterator($this->items);
    }
}
