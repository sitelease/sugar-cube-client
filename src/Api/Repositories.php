<?php

namespace Gitea\Api;

use GuzzleHttp\Exception\ServerException;

use Gitea\Client;
use Gitea\Collections\ApiItemCollection;
use Gitea\Model\Repository;

use Gitea\Api\Abstracts\AbstractAllApiRequester;

class Repositories extends AbstractAllApiRequester
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
     * $client->repositories()->search($keyword, $page);
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
                        $itemObject = Repository::fromJson(
                            $client,
                            $this,
                            json_decode($encodedItem)
                        );
                        $repositoryCollection->addItem($itemObject, $itemObject->getId());
                    }
                }
            }
            return $repositoryCollection;

        } catch (ServerException $serverError) {
            return $repositoryCollection;
        }
    }

    /**
     * Get a repository using its name and owner
     *
     * Example:
     * ```
     * $client->repositories()->getByName($owner, $repoName);
     * ```
     *
     * @param string $owner The owner of the repository
     * @param string $repoName The name of the repository
     * @return Repository
     */
    public function getByName(string $owner, string $repoName)
    {
        $client = $this->getClient();
        try {
            $response = $this->get("repos/$owner/$repoName");
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            if ($statusCode == 200) {
                return Repository::fromJson(
                    $client,
                    $this,
                    json_decode($body)
                );
            }
            return false;

        } catch (ServerException $serverError) {
            return false;
        }
    }

    /**
     * Get a repository using its ID
     *
     * Example:
     * ```
     * $client->repositories()->getByID($repoId);
     * ```
     *
     * @param string repoId The ID of the repository
     * @return Repository
     */
    public function getById(int $repoId)
    {
        $client = $this->getClient();
        try {
            $response = $this->get("repositories/$repoId");
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            if ($statusCode == 200) {
                return Repository::fromJson(
                    $client,
                    $this,
                    json_decode($body)
                );
            }
            return false;

        } catch (ServerException $serverError) {
            return false;
        }
    }

    /**
     * Get the contents of a file in a certain in repository commit/branch/tag
     * using the repository's name and owner
     *
     * Example:
     * ```
     * $client->repositories()->getFileContents($owner, $repoName, "README.md", "v2.0.0");
     * ```
     *
     * @param string $owner The owner of the repository
     * @param string $repoName The name of the repository
     * @param string $filepath The path to the file (relative to the repository root)
     * @param string $ref The name of the commit/branch/tag. Default the repository’s default branch (usually master)
     * @return string
     */
    public function getFileContents(string $owner, string $repoName, string $filepath, string $ref="")
    {
        $client = $this->getClient();
        try {
            if ($ref !== "") {
                $response = $this->get("repos/$owner/$repoName/contents/$filepath",[
                    "ref" => $ref
                ]);
            } else {
                $response = $this->get("repos/$owner/$repoName/contents/$filepath");
            }

            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $body = (string) $response->getBody();
                $jsonObj = json_decode($body, true);
                if (array_key_exists("content", $jsonObj)) {
                    $base64FileContents = $jsonObj["content"];
                    $fileContents = base64_decode($base64FileContents);
                    return $fileContents;
                }
            }
            return false;

        } catch (ServerException $serverError) {
            return false;
        }
    }

    /**
     * Download an archive for a branch, tag, or commit SHA
     *
     * Example:
     * ```
     * $client->repositories()->downloadArchive($owner, $repoName, "master", ".zip");
     * ```
     *
     * @param string $owner The owner of the repository
     * @param string $repoName The name of the repository
     * @param string $gitRef The branch, tag, or commit SHA for the archive
     * @param string $format The format of the downloaded archive (".zip", or ".tar.gz")
     * @return string A string that can be written to a file
     */
    public function downloadArchive(string $owner, string $repoName, string $gitRef, string $format = ".tar.gz")
    {
        $client = $this->getClient();
        $filepath = $gitRef.$format;
        try {
            $response = $this->get("repos/$owner/$repoName/archive/$filepath");
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            if ($statusCode == 200) {
                return $body;
            }
            return false;

        } catch (ServerException $serverError) {
            return false;
        }
    }

}
