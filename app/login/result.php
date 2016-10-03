<?php
session_start();

if( $_REQUEST["username"] ) $username = $_REQUEST['username'];

$params =& $_GET;
if(!$params) $params =& $_POST;

// echo "<pre>"; print_r($params); echo "</pre>";
if(!authenticate($params))
{
    echo "<div class='help-block'>Invalid credentials</div>";
    echo "<br><a href=''>Please try again</a><br><br>";
}
else
{
    $_SESSION["freshdata_user_logged_in"] = true;
    $url = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php";
    echo "<br>Proceed to <a href='$url'>Fresh Data - Monitors maintenance</a><br><br> ";
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
        if(in_array($username, array("eliagbayani", "eli-agbayani", "jhammock", "jhpoelen"))) //TODO put this list of valid usernames in a hidden text file (e.g. .userlist.txt)
        {
            echo $html;
            return true;
        }
        else return false;
    }
}

?>