<?php

namespace Gitea\Api;

use GuzzleHttp\Exception\ServerException;

use Gitea\Client;
use Gitea\Collections\ApiItemCollection;
use Gitea\Model\Branch;

use Gitea\Api\Abstracts\AbstractApiRequester;

class Branches extends AbstractApiRequester
{
    /**
     * Get all tags from a particular repository
     * using the repository's name and owner
     *
     * Example:
     * ```
     * // Get all tags from a repository owned by a user
     * $giteaClient->tags()->fromRepository("username", "test-repository");
     *
     * // Get all tags from a repository owned by an organization
     * $giteaClient->tags()->fromRepository("organizationName", "test-repository");
     * ```
     *
     * @param string $owner The name of the user or organization that owns the repository
     * @param string $repository The name of the repository
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return ApiItemCollection
     */
    public function fromRepository(string $owner, string $repository)
    {
        $client = $this->getClient();

        $repositoryCollection = new ApiItemCollection();
        try {
            $response = $this->get("repos/$owner/$repository/branches");
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode == 200) {
                $jsonItemList = json_decode($body, true);
                if (count($jsonItemList) > 0) {
                    foreach ($jsonItemList as $jsonItem) {
                        $encodedItem = json_encode($jsonItem);
                        $itemObject = Branch::fromJson(
                            $this->getClient(),
                            $this,
                            json_decode($encodedItem)
                        );
                        $repositoryCollection->addItem($itemObject, $itemObject->getName());
                    }
                }
            }
            return $repositoryCollection;
        } catch (ServerException $serverError) {
            return $repositoryCollection;
        }
    }

}
