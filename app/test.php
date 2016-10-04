<?php
include_once(dirname(__FILE__) . "/../client/GitHubClient.php");

$repos = array(
    'maps_test',
);

$client = new GitHubClient();
foreach($repos as $repo)
{
    $client->setPage();
    $client->setPageSize(2);
    $commits = $client->repos->commits->listCommitsOnRepository('eliagbayani', $repo);
    
    echo "Count: " . count($commits) . "\n";
    foreach($commits as $commit)
    {
        /* @var $commit GitHubCommit */
        echo "\n" . get_class($commit) . " - Sha: " . $commit->getSha() . "\n";
    }
    
    $commits = $client->getNextPage();

    echo "Count: " . count($commits) . "\n";
    foreach($commits as $commit)
    {
        /* @var $commit GitHubCommit */
        echo "\n" . get_class($commit) . " - Sha: " . $commit->getSha() . "\n";
    }
}
?>

