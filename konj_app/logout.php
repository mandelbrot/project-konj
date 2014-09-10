<?php 
ob_start();
include_once 'head.php';
echo "<h3>Log out</h3>";

if (isset($_SESSION['user']))
{
	destroySession();
    echo "You have been logged out.";
    header("refresh: 1; url=index");
    //header("Location: index.php"); 
    exit();
	//echo "You have been logged out. Please
	//<a href='index.php'>click here</a> to refresh the screen.";
}
else {
    echo "You are not logged in";
    header("refresh: 1; url=index");
    exit();
}
?>
