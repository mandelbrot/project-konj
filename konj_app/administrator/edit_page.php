<?php 
session_start();
/* Created by Adam Khoury @ www.developphp.com */
include_once "admin_check.php";
?>
<?php 
$error_message="";
// You should put an if condition here to check that the posted $pid variable is present first thing, I did not do that

if(isset($_POST['pid'])) $pid = preg_replace("/[^0-9]/i", "", $_POST['pid']); // filter everything but numbers for security
else $pid = preg_replace("/[^0-9]/i", "", $_GET['pid']); // filter everything but numbers for security
// Query the body section for the proper page
include_once "../scripts/connect_to_mysql.php";

$sqlCommand = "SELECT id FROM pages WHERE id='$pid' LIMIT 1"; 
$query = mysqli_query($myConnection, $sqlCommand) or die (mysqli_error()); 
$row = mysqli_fetch_array($query);
if($row == null) exit(0);

$showing = "";
$sqlCommand = "SELECT pagetitle, linklabel, pagebody, showing FROM pages WHERE id='$pid' LIMIT 1"; 
$query = mysqli_query($myConnection, $sqlCommand) or die (mysqli_error()); 
while ($row = mysqli_fetch_array($query)) { 
    $pagetitle = $row["pagetitle"];
	$linklabel = $row["linklabel"];
	$pagebody = StripSlashes($row["pagebody"]);
	$pagebody = str_replace("<br />", "", $pagebody);
	
    if($row["showing"] == "1") $showing = "checked";
} 
$table='';
$sqlCommand = "SELECT * FROM pages"; 
$query = mysqli_query($myConnection, $sqlCommand) or die (mysqli_error()); 
while ($row = mysqli_fetch_array($query)) { 
    $id1 = $row["id"];
    $pagetitle1 = $row["pagetitle"];
	$linklabel1 = $row["linklabel"];
    //$pagebody1 = $row["pagebody"];
	$pagebody1 = StripSlashes($row["pagebody"]);
	$pagebody1 = str_replace("<br />", "", $pagebody1);
	
    if($row["showing"] == "1") $showing1 = "true";
    else $showing1 = "false";
    
    $table .= '
        <tr>
            <td><a href="edit_page.php?pid='. $id1 .'">'. $pagetitle1 .'</td>
            <td>'. $linklabel1 .'</td>
            <td>'. $pagebody1 .'</a></td>
            <td>'. $showing1 .'</td>
            <td>'. $id1 .'</td>
            <td><a href="page_delete_parse.php?pid='. $id1 .'">Delete</td>
        </tr>
    ';
} 

mysqli_free_result($query); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editing Page</title>
<script type="text/javascript">

function validate_form ( ) { 
    valid = true;
    if ( document.form.pagetitle.value == "" ) { 
	alert ( "Please enter the page title." ); 
	valid = false;
	} else if ( document.form.linklabel.value == "" ) { 
	alert ( "Please enter info for the link label." ); 
	valid = false;
	} else if ( document.form.pagebody.value == "" ) { 
	alert ( "Please enter some info into the page body." ); 
	valid = false;
	}
	return valid;
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
}
.page_edit{
    width:70%;
    margin:0 auto;
}
.table{
    width:90%;
    margin:0 auto;
    border-bottom: 1px dotted black;
}
.table th{
    border-bottom: 1px solid black;
    text-align:left;
}

.header{
    margin:15px;padding-right:10px;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellpadding="8">
  <tr>
    <td><h3>Editing Existing Page&nbsp;&nbsp;&bull;&nbsp;&nbsp; <a href="index.php">Admin Home</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="../" target="_blank">View Live Website</a></h3></td>
  </tr>
  <tr>
    <td><?php echo $error_message; ?><br /></td>
  </tr>
  <tr>
    <td>
<table class="page_edit" width="100%" border="0" cellpadding="5">
    <form id="form" name="form" method="post" action="page_edit_parse.php"  onsubmit="return validate_form ( );">
  <tr>
    <td width="12%" align="right" bgcolor="#F5E4A9">Page Full Title</td>
    <td width="88%" bgcolor="#F5E4A9"><input name="pagetitle" type="text" id="pagetitle" size="80" maxlength="64" value="<?php echo $pagetitle; ?>" /></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#D7EECC">Link Label</td>
    <td bgcolor="#D7EECC"><input name="linklabel" type="text" id="linklabel" maxlength="24"  value="<?php echo $linklabel; ?>" /> 
      (What the link to this page will display as)</td>
  </tr>
  <tr>
    <td align="right" valign="top" bgcolor="#DAEAFA">Page Body</td>
    <td bgcolor="#DAEAFA"><textarea name="pagebody" id="pagebody" cols="88" rows="16"><?php echo $pagebody; ?></textarea></td>
  </tr>
  
  <tr>
    <td align="right" valign="top" bgcolor="#DFEFFF">Published?</td>
    <td bgcolor="#DAEAFA"><input type="checkbox" id="showing" name="showing" value="showing" <?php echo $showing; ?>></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input name="pid" type="hidden" value="<?php echo $pid; ?>" />
    <input type="submit" name="button" id="button" value="Submit Page Edit" /></td>
  </tr>
  </form>
</table>

    
    </td>
  </tr>
</table>
<br />
<table class="table"  cellpadding="5">
        <tr class="header">
            <th class="header"><b>Page title</b></th>
            <th class="header"><b>Link label</b></th>
            <th class="header"><b>Page body</b></th>
            <th class="header"><b>Showing</b></th>
            <th class="header"><b>Id</b></th>
            <th class="header"><b>Action</b></th>
        </tr>
      <?php echo $table; ?>
      
</table>
</body>
</html>