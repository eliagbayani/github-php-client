<?php
/* a place to test things:

https://developer.github.com/libraries/
https://github.com/tan-tan-kanarek/github-php-client

works from the browser OK: good source: https://developer.github.com/v3/
https://api.github.com/users/eliagbayani
*/

error_reporting(E_ALL);
// error_reporting(0); // Turn off all error reporting -> Turned off because wrong login credentials gives a fatal error in github api that isn't captured cleanly

include_once(dirname(__FILE__) . "/../client/GitHubClient.php");

// echo "<pre>"; print_r($_COOKIE); echo "</pre>";

// exit;

// /*
// $username = "eliagbayanix";
// $password = "erja1325x";

// $username = "eli-agbayani";
// $password = "erja173";
// 
$username = "jhammock";
$password = "kkk";

$username = "jhpoelen";
$password = "k";

$username = "a";
$password = "";


$client = new GitHubClient();
$client->setCredentials($username, $password);

// echo "<pre>"; print_r($client->users); echo "</pre>";

// exit;
// if($user = $client->users->getTheAuthenticatedUser())
if($user = $client->users->getSingleUser($username))
{
    echo "<pre>"; print_r($user); echo "</pre>";

    if($realname = getProtectedValue($user, "name")) {}
    else $realname = $username;
    
    echo "<br>Welcome $realname<br>";
    
    if($src = getProtectedValue($user, "avatar_url")) echo "<br><img src='$src'><br>";
    return true;
}
else
{
    echo "\nInvalid credentials...\n";
}
return false;
exit;

// if($client) print_r($client);
// else echo "\nClient not found...\n";
$repo = "maps_test";
// $repo = "gimmefreshdata.github.io";
// $repo = "eol_php_code";

$user = $client->users->getTheAuthenticatedUser();
// $user = $client->usersEmails->listEmailAddressesForUser('eliagbayani', $repo);
// $user = $client->users->getSingleUser('jhammock'); //works OK e.g. 'eliagbayani' or 'jhammock'

echo "<pre>";
print_r($user);
echo "</pre>";

// */

/*
[url:protected] => https://api.github.com
[uploadUrl:protected] => https://uploads.github.com
[debug:protected] => 
[username:protected] => eliagbayani
[password:protected] => erja1325
[timeout:protected] => 240
[rateLimit:protected] => 0
[rateLimitRemaining:protected] => 0
[rateLimitReset:protected] => 0
[authType:protected] => basic
[oauthKey:protected] => 
[page:protected] => 
[pageSize:protected] => 100
[lastPage:protected] => 
[lastUrl:protected] => 
[lastMethod:protected] => 
[lastData:protected] => 
[lastReturnType:protected] => 
[lastReturnIsArray:protected] => 
[lastExpectedHttpCode:protected] => 
[pageData:protected] => Array

[url:protected] => https://api.github.com
[uploadUrl:protected] => https://uploads.github.com
[debug:protected] => 
[username:protected] => eliagbayani
[password:protected] => erja1325
[timeout:protected] => 240
[rateLimit:protected] => 0
[rateLimitRemaining:protected] => 0
[rateLimitReset:protected] => 0
[authType:protected] => basic
[oauthKey:protected] => 
[page:protected] => 
[pageSize:protected] => 100
[lastPage:protected] => 
[lastUrl:protected] => 
[lastMethod:protected] => 
[lastData:protected] => 
[lastReturnType:protected] => 
[lastReturnIsArray:protected] => 
[lastExpectedHttpCode:protected] => 
[pageData:protected] => Array

*/

/* works OK 
$commits = $client->repos->commits->listCommitsOnRepository('eliagbayani', $repo); //OK
print_r($commits);
*/

/*
$owner = 'eliagbayani';
$repo = 'maps_test';
//https://github.com/gimmefreshdata/source-reeflifesurvey
$owner = 'gimmefreshdata';
$repo = 'source-reeflifesurvey';
$collabs = $client->repos->collaborators->listReposCollaborators($owner, $repo);
print_r($collabs);
*/


/* works OK - list all Contributors
$owner = 'eliagbayani';
$repo = 'maps_test';

$owner = 'gimmefreshdata';
$repo = "gimmefreshdata.github.io";

$owner = 'gimmefreshdata';
$repo = 'source-reeflifesurvey';

$contribs = $client->repos->listContributors($owner, $repo);
print_r($contribs);
*/

function getProtectedValue($obj,$name) {
  $array = (array)$obj;
  $prefix = chr(0).'*'.chr(0);
  return $array[$prefix.$name];
}

function user_is_logged_in_wiki()
{
    $url = "https://api.github.com/users/eli-agbayani";
    $url = "https://api.github.com/user?access_token=342e31fbf3317fac972c6b231dbcf6a64b8e0939";
    $json = get_api_result($url);
    
    echo "\n" . $json . "\n";
    print_r($json);
    
    /* string possible values:
    Array ( [wiki_literatureeditor_session] => qm1skkoagkoke0pejoke12uti2 ) {"query":{"userinfo":{"id":0,"name":"127.0.0.1","anon":""}}}
    Array ( [wiki_literatureeditor_session] => q1hjhuk9108ufr6l1c6jfmli06 ) {"query":{"userinfo":{"id":1,"name":"EAgbayani"}}}
    */
    if(stripos($json, "\"anon\"") !== false || !$json) //string is found
    {
        // self::display_message(array('type' => "error", 'msg' => "Cannot proceed. <a href='" . "http://" . $_SERVER['SERVER_NAME'] . "/LiteratureEditor/wiki/Special:UserLogin'>You must login from the wiki first</a>."));
        return false;
    }
    else
    {
        // $obj = json_decode($json);
        // $username = $obj->query->userinfo->name;
        // $realname = self::get_realname($username);
        // $url = "http://" . $_SERVER['SERVER_NAME'] . "/" . MEDIAWIKI_MAIN_FOLDER . "/wiki/User:" . str_replace(" ", "_", $username) . "";
        // $this->compiler = "[$url {$realname}]";

        return true;
    }
}

function get_api_result($url)
{
    $session_cookie = 'eli_session';
    // if(!isset($_COOKIE[$session_cookie])) return false;
    $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_COOKIE, $session_cookie . '=' . @$_COOKIE[$session_cookie]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $string = curl_exec($ch);
    curl_close($ch);
    return $string;
}



?>