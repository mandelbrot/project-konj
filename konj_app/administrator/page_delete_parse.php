<?php
/* Created by Adam Khoury @ www.developphp.com */

// You may want to obtain refering site name that this post came from for security purposes here
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['pid'])) $pid = $_POST['pid'];
else $pid = $_GET['pid'];
// End Filter Function --------------------------------------------------------------
include_once "../scripts/connect_to_mysql.php";
// Add the updated info into the database table
$query = mysqli_query($myConnection, "DELETE FROM pages WHERE id='$pid'") or die (mysqli_error($myConnection));
if(mysqli_affected_rows($myConnection) >= 1) echo 'Page has been deleted successfully. <br /><br /><a href="index.php">Click Here</a>';
else echo 'No pages were deleted. <br /><br /><a href="index.php">Click Here</a>';
exit();
?>