<?php
$params =& $_GET;
if(!$params) $params =& $_POST;

error_reporting(E_ALL);
// error_reporting(0); // Turn off all error reporting -> Turned off because wrong login credentials gives a fatal error in github api that isn't captured cleanly
include_once(dirname(__FILE__) . "/../../client/GitHubClient.php");

$username = $params['username'];
$password = $params['password'];

$client = new GitHubClient();
$client->setCredentials($username, $password);
if($user = $client->users->getSingleUser($username))
{
    if($realname = getProtectedValue($user, "name")) {}
    else $realname = $username;

    echo "<br>Logged in OK<br> ";
    echo "<br>Welcome $realname<br> ";
    if($src = getProtectedValue($user, "avatar_url")) echo "<br><img src='$src'><br> ";
}

function getProtectedValue($obj, $name)
{
  $array = (array) $obj;
  $prefix = chr(0).'*'.chr(0);
  return $array[$prefix.$name];
}

?>
