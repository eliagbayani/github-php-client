<?php
define('DEVELOPER_EMAIL', 'eagbayani@eol.org');
define('VALID_USERNAMES', "eliagbayani,jhammock,jhpoelen,eli-agbayani"); //TODO put this list of valid usernames in a hidden text file (e.g. .userlist.txt) and gitignore it.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');
// error_reporting(0); // Turn off all error reporting -> Turned off because wrong login credentials gives a fatal error in github api that isn't captured cleanly

// define('HTTP_PROTOCOL', 'http://'); //for MacMini
define('HTTP_PROTOCOL', 'https://'); //for eol-archive
?>
