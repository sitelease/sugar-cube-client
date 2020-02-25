<?php

namespace Gitea\Api;

use GuzzleHttp\Psr7\Response;

use Gitea\Client;
use Gitea\Model\Organization;

use Gitea\Api\Abstracts\AbstractApiRequester;

class Organizations extends AbstractApiRequester
{

    /**
     * Get an organization using its username and parse
     * it's information into an organization object
     *
     * Example:
     * ```
     * $giteaClient->organizations()->getByUsername($orgUsername);
     * ```
     *
     * @param string $username
     * @author Benjamin Blake (sitelease.ca)
     *
     * @return Organization|Response
     */
    public function getByUsername(string $username)
    {
        $client = $this->getClient();
        try {
            $response = $this->get("orgs/$username");
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            if ($statusCode == 200) {
                return Organization::fromJson(json_decode($body));
            } else {
                return $response;
            }
        } catch (ServerException $serverError) {
            return $response;
        }
    }

}
