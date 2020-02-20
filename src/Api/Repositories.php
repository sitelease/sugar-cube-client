<?php

namespace Gitea\Api;

use Gitea\Client;
use Gitea\Collections\ApiItemCollection;
use Gitea\Models\Repository;

use Gitea\Api\AbstractApi;

class Repositories extends AbstractApi
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
     * Return a collection of all the repositories
     *
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiItemCollection
     */
    public function all()
    {
        $allItems = array();
        $maxPageCount = $this->getMaxPageCount();
        // Loop over pages until the $maxPageCount is reached
        for ($pageNum=1; $pageNum < $maxPageCount; $pageNum++) {
            $searchItemsCollection = $this->search("", $pageNum);
            if ($searchItemsCollection && $searchItemsCollection->count() > 0) {
                $searchItemsArray = $searchItemsCollection->toArray();
                $allItems = array_merge($allItems, $searchItemsArray);
            } else {
                break;
            }
        }
        return new ApiItemCollection($allItems);
    }

    /**
     * Search all repositories and return a list of them
     *
     * Example:
     * ```
     * $giteaClient->repositories()->search($keyword, $page);
     * ```
     *
     * @param string $keyword Keyword to search by
     * @param integer $page The page of items to return
     * @param integer $limit Maximum number of items per page
     * @param array $extraOptions An array of extra options to pass the API reoute
     * @return void
     *
     * @return ApiItemCollection
     */
    public function search(string $keyword = "", int $page = 1, int $limit = null, array $extraOptions = array())
    {
        $client = $this->getClient();
        $limit = $limit ?? $this->getItemsPerPage();

        $repositoryCollection = new ApiItemCollection();
        try {
            $response = $this->get("repos/search",[
                "page" => $page,
                "limit" => $limit
            ]);
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            if ($statusCode == 200) {
                $jsonObj = json_decode($body, true);
                $jsonOk = $jsonObj["ok"];
                $jsonItemList = $jsonObj["data"];

                if ($jsonOk && count($jsonItemList) > 0) {
                    foreach ($jsonItemList as $jsonItem) {
                        $encodedItem = json_encode($jsonItem);
                        $itemObject = Repository::fromJson(json_decode($encodedItem));
                        $repositoryCollection->addItem($itemObject, $itemObject->getId());
                    }
                }
            }
            return $repositoryCollection;

        } catch (ServerException $serverError) {
            return $repositoryCollection;
        }
    }

    public function getMaxPageCount() {
        return $this->maxPageCount;
    }

    public function getItemsPerPage() {
        return $this->itemsPerPage;
    }

}
