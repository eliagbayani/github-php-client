<?php
session_start();
require_once("../config/settings.php");

//if( $_REQUEST["username"] ) $username = $_REQUEST['username']; //another option to pass params

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
    $url = "http://" . $_SERVER['SERVER_NAME'] . "/FreshData/index.php?view_type=".$params['view_type'];
    
    if($params['view_type'] == 'admin') echo "<br>Proceed to <a href='$url'>Fresh Data: Monitors - Admin</a><br><br> ";
    elseif($params['view_type'] == 'scistarter') echo "<br>Proceed to <a href='$url'>Fresh Data: SciStarter - Admin</a><br><br> ";
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
        // if(in_array($username, array("eliagbayani", "xxx", "jhammock", "jhpoelen"))) //TODO put this list of valid usernames in a hidden text file (e.g. .userlist.txt)

        $valid_usernames = explode(",", VALID_USERNAMES);
        if(in_array($username, $valid_usernames))
        {
            echo $html;
            return true;
        }
        else
        {
            echo "<br>Please contact " . DEVELOPER_EMAIL . " to be given access to Fresh Data: Admin pages.<br><br>";
            return false;
        }
    }
}
?>