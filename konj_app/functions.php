<?php // rnfunctions.php
/**
 * $dbhost  = 'localhost';    // Unlikely to require changing
 * $dbname  = 'zadatak'; // Modify these...
 * $dbuser  = 'root';     // ...variables according
 * $dbpass  = 'mysql';     // ...to your installation
 * $appname = "CMS Demo"; // ...and preference
 */
 

include "connect_to_mysql.php";
$appname = "KONJ"; 

function createTable($name, $query)
{
	if (tableExists($name))
	{
		echo "Table '$name' already exists<br />";
	}
	else
	{
		queryMysql("CREATE TABLE $name($query)");
		echo "Table '$name' created<br />";
	}
}

function tableExists($name)
{
    $result = mysqli_query(returnConnection(), "SHOW TABLES LIKE '$name'") or die (mysqli_error()); 
	return mysqli_num_rows($result);
}

function queryMysql($query)
{
	$result = mysqli_query(returnConnection(), $query) or die(mysqli_error(returnConnection()));
	return $result;
}


function destroySession()
{
	$_SESSION=array();
	
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', time()-2592000, '/');
		
	session_destroy();
}

function sanitizeString($var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);

    return mysqli_real_escape_string(returnConnection(), $var);
}

function showProfile($user)
{
	if (file_exists("$user.jpg"))
		echo "<img src='$user.jpg' border='1' align='left' />";
		
	$result = queryMysql("SELECT * FROM rnprofiles WHERE user='$user'");
	
	if (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br />";
	}
}

function get_DB_time(){
    list($microSec, $RACER_RECORDING_TIME) = explode(" ", microtime());
    return "'" . date('Y-m-d H:i:s', $RACER_RECORDING_TIME) . "'";
}
?>
