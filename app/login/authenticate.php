<?php
require_once("../config/settings.php");

$params =& $_GET;
if(!$params) $params =& $_POST;

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
