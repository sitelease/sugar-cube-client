<?php

namespace Gitea\Api;

use GuzzleHttp\Exception\ServerException;

use Gitea\Client;
use Gitea\Collections\ApiItemCollection;
use Gitea\Model\Repository;

use Gitea\Api\Abstracts\AbstractAllApi;

class Repositories extends AbstractAllApi
{
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
    public function getPageOfAllItems(int $page = 1, int $limit = null, array $extraOptions = array()) {
        return $this->search("", $page, $limit, $extraOptions);
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

}
