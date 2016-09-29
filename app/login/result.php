<?php
session_start();

if( $_REQUEST["username"] ) $username = $_REQUEST['username'];

$params =& $_GET;
if(!$params) $params =& $_POST;

// echo "<pre>"; print_r($params); echo "</pre>";
if(!authenticate($params))
{
    echo "\n\nInvalid credentials...\n\n";
}
else
{
    $_SESSION["freshdata_user_logged_in"] = true;
    $url = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php";
    echo "<br><a href='$url'>Go to FreshData</a><br>";
}

function authenticate($params)
{
    $username = $params['username'];
    $password = $params['password'];
    $url = "http://" . $_SERVER['SERVER_NAME'] . "/github-php-client/app/login/authenticate.php?username=$username&password=$password";
    $html = file_get_contents($url);
    if(stripos($html, 'Fatal error') !== false) return false; //string is found
    else
    {
        echo "<hr>$html<hr>";
        return true;
    }
}

?>