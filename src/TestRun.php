<?php

namespace Gitea;

require 'vendor/autoload.php';

use Gitea\Client;
use Gitea\Model\Repository;

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

// print("Getting all repos via API \n");
// $repositories = $giteaClient->repositories()->all();
// if ($repositories && count($repositories) > 0) {
//     foreach ($repositories as $item) {
//         print("Name: ".$item->getName()."\n");
//         print("Full Name: ".$item->getFullName()."\n");
//         print("Description: ".$item->getDescription()."\n");
//         print("\n\n");
//     }
//     print("Total Items: ".count($repositories)."\n");
// } else {
//     print("No repos could be retrieved"."\n");
// }

// print("Getting all tags for the 'sl-product-catalog' repository \n\n");
// $repository = $giteaClient->repositories()->getByName("Sitelease", "sl-product-catalog");
// if ($repository) {
//     $tags = $repository->tags();
//     if ($tags && count($tags) > 0) {
//         foreach ($tags as $tag) {
//             print("Processing ".$tag->getName()."\n");
//             // var_dump(json_encode($tag));
//             print("\n\n");
//         }
//         print("Total Tags: ".count($tags)."\n");
//     }
// } else {
//     print("The repository could not be retrieved"."\n");
// }

print("Getting all branches for the 'sl-product-catalog' repository \n\n");
$repository = $giteaClient->repositories()->getByName("Sitelease", "sl-theme-recipe");
if ($repository) {
    $branches = $repository->branches();
    if ($branches && count($branches) > 0) {
        foreach ($branches as $branch) {
            // var_dump(json_encode($branch));
            print("Processing ".$branch->getName()."\n");
            $debugChain = $branch->debugRequestChain();
            if ($debugChain) {
                print("Chain ".$debugChain."\n");
            }
            $foundObj = $branch->searchRequestChain(Repository::class);
            if ($foundObj) {
                print("Repository class found \n");
                print("Type: ".get_class($foundObj)." \n");
            } else{
                print("Repository class NOT found \n");
            }
            print("\n\n");
        }
        print("Total Branches: ".count($branches)."\n");
    }
} else {
    print("The repository could not be retrieved"."\n");
}

// print("Getting contents of \"composer.json\" file \n\n");
// $rawFile = $giteaClient->repositories()->getRawFile("Sitelease", "sl-theme-recipe", "composer.json");
// if ($rawFile) {
//     var_dump(json_encode($rawFile));
//     print("\n\n");
// } else {
//     print("The raw file could not be retrieved"."\n");
// }

// print("Getting contents of \"composer.json\" file \n\n");
// $rawFile = $giteaClient->repositories()->getRawFile("Sitelease", "sl-theme-recipe", "composer.json");
// if ($rawFile) {
//     var_dump($rawFile);
//     print("\n\n");
// } else {
//     print("The raw file could not be retrieved"."\n");
// }

// print("Getting a repository \n\n");
// $repository = $giteaClient->repositories()->getByName("Sitelease", "sl-theme-recipe");
// if ($repository) {
//     var_dump($repository);
//     print("\n\n");
// } else {
//     print("The repository could not be retrieved"."\n");
// }

// print("Getting archive for the 'sl-product-catalog' repository \n\n");
// $repository = $giteaClient->repositories()->getByName("Sitelease", "sl-theme-recipe");
// if ($repository) {
//     $archive = $repository->archive("master");
//     if ($archive) {
//         print("Downloading Archive...\n");
//         file_put_contents("master.tar.gz", $archive);
//         print("Success!\n");
//     }
// } else {
//     print("The archive could not be retrieved"."\n");
// }

print("Exiting script"."\n");
