<?php

namespace Gitea\Api\Abstracts;

use Gitea\Client;
use GuzzleHttp\Exception\ServerException;
use Gitea\Collections\ApiItemCollection;
use Gitea\Api\Abstracts\AbstractApiRequester;
use Gitea\Api\Interfaces\AllRequesterInterface;

abstract class AbstractAllApiRequester extends AbstractApiRequester implements AllRequesterInterface
{
    /**
     * The maximum number of pages to process when
     * retrieving all repositories
     *
     * NOTE: Each page will contain the number of items
     * set in the $maxPageCount property (50 by default).
     * So you can get the number of records that this will equate to
     * by multiplying this number by the $maxPageCount
     *
     * @var integer
     */
    private $maxPageCount = 25;

    /**
     * The number of items per page
     *
     * @var integer
     */
    private $itemsPerPage = 50;

    /**
     * Get a page of items from the API route
     * that will provide all items
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @param integer $page The page of items to return
     * @param integer $limit Maximum number of items per page
     * @param array $extraOptions An array of extra options to pass the API reoute
     * @return ApiItemCollection
     */
    public function getPageOfAllItems(int $page = 1, int $limit = null, array $extraOptions = array())
    {
        trigger_error("The abstract 'requestAllItems()' method must be overwritten");
        return false;
    }

    /**
     * Return a collection of all items from an API route
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiItemCollection
     */
    public function all()
    {
        $allItems = array();
        $maxPageCount = $this->getMaxPageCount();
        $itemsPerPage = $this->getItemsPerPage();
        // Loop over pages until the $maxPageCount is reached
        for ($pageNum = 1; $pageNum < $maxPageCount; $pageNum++) {
            $searchItemsCollection = $this->getPageOfAllItems($pageNum, $itemsPerPage);
            if ($searchItemsCollection && $searchItemsCollection->count() > 0) {
                $searchItemsArray = $searchItemsCollection->toArray();
                $allItems = array_merge($allItems, $searchItemsArray);
            } else {
                break;
            }
        }
        return new ApiItemCollection($allItems);
    }

    public function getMaxPageCount()
    {
        return $this->maxPageCount;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
}
