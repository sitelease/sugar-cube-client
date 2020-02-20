<?php

namespace Gitea;

require 'vendor/autoload.php';

use Gitea\Client;

print("Starting Script... \n");
print("Creating Guzzle client \n");
$giteaClient = new Client("https://gitea.devserver.localdomain:3000/api/v1/");
$giteaClient->setAuthToken('32e609ad39539c1d0e8544800bd49b1025ac6b49');
// print("Getting Organization via API \n");
// $organization = $giteaClient->organizations()->getByUsername("Sitelease");
// if ($organization) {
//     print("Username: ".$organization->getUsername()."\n");
//     print("Full Name: ".$organization->getFullName()."\n");
//     print("Description: ".$organization->getDescription()."\n");
//     print("Website: ".$organization->getWebsite()."\n");
//     print("Location: ".$organization->getLocation()."\n");
//     var_dump(json_encode($organization));
// } else {
//     print("No Data could be retrieved"."\n");
// }
print("Getting all repos via API \n");
$repositories = $giteaClient->repositories()->all();
if ($repositories && count($repositories) > 0) {
    foreach ($repositories as $item) {
        print("Name: ".$item->getName()."\n");
        print("Full Name: ".$item->getFullName()."\n");
        print("Description: ".$item->getDescription()."\n");
        print("\n\n");
    }
    print("Total Items: ".count($repositories)."\n");
} else {
    print("No repos could be retrieved"."\n");
}

print("Exiting script"."\n");
