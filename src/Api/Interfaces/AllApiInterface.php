<?php

namespace Gitea\Api\Interfaces;

use Gitea\Client;

/**
 * Interface for API classes that support the all() method
 *
 * @author Benjamin Blake (sitelease.ca)
 */
interface AllApiInterface
{
    /**
     * The maximum number of pages to process when
     * retrieving all items
     *
     * @author Benjamin Blake (sitelease.ca)
     * @return int
     */
    public function getMaxPageCount();

    /**
     * Get the number of items that will be retrieved per
     * page when retrieving all items
     *
     * @author Benjamin Blake (sitelease.ca)
     * @return int
     */
    public function getItemsPerPage();

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
    public function getPageOfAllItems(int $page = 1, int $limit = null, array $extraOptions = array());

    /**
     * Return a collection of all items
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiItemCollection
     */
    public function all();
}
