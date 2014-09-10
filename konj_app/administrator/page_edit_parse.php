<?php
/* Created by Adam Khoury @ www.developphp.com */

// You may want to obtain refering site name that this post came from for security purposes here
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pid = $_POST['pid'];
$pagetitle = $_POST['pagetitle'];
$linklabel = $_POST['linklabel'];
$pagebody = $_POST['pagebody'];
if(!isset($_POST['showing']))
{
    $show="0";
}
else
{
    $show="1";
}
// Filter Function -------------------------------------------------------------------
function filterFunction ($var) { 
    $var = nl2br(htmlspecialchars($var));
    $var = preg_replace("/'/i", "&#39;", $var);
    $var = preg_replace("/`/i", "&#39;", $var);		
    return $var; 
} 
$pagetitle = addslashes($pagetitle);
$linklabel = addslashes($linklabel);
$pagebody = addslashes($pagebody);
// End Filter Function --------------------------------------------------------------
include_once "../scripts/connect_to_mysql.php";
// Add the updated info into the database table
$query = mysqli_query($myConnection, "UPDATE pages SET pagetitle='$pagetitle', linklabel='$linklabel', 
    pagebody='$pagebody', lastmodified=now(), showing='$show' WHERE id='$pid'") or die (mysqli_error($myConnection));

echo 'Operation Completed Successfully! <br /><br /><a href="index.php">Click Here</a>';
exit();
?>