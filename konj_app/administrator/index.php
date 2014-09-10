<?php 
session_start();
/* Created by Adam Khoury @ www.developphp.com */
include_once "admin_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Magic Site Admin Center</title>
<script type="text/javascript">

function validate_form1 ( ) { 
    valid = true;
    if ( document.form1.pid.value == "" ) { 
	alert ( "Please enter the ID number for the page to be edited." ); 
	valid = false;
	} 
	return valid;
	}
	
function validate_form2 ( ) { 
    valid = true;
    if ( document.form2.pid.value == "" ) { 
	alert ( "Please enter the ID number for the page to be deleted." ); 
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
-->
</style></head>

<body>
<table width="100%" border="0" cellpadding="8">
  <tr>
    <td><h3>DevelopPHP's Basic PHP + MySQL Page Edit System&nbsp;&nbsp;&bull;&nbsp;&nbsp; <a href="index.php">Admin Home</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="../">View Live Website</a></h3></td>
  </tr>
  <tr>
    <td>Hello Admin, what would you like to do?<br /></td>
  </tr>
  <tr>
    <td bgcolor="#DAF2FE"><h3><a href="create_page.php">Create New Page</a></h3></td>
  </tr>
  <tr>
    <td bgcolor="#D5FFD5"><form id="form1" name="form1" method="post" action="edit_page.php" onsubmit="return validate_form1 ( );">
      <br />
      <input type="submit" name="button2" id="button2" value="Edit Existing Page" />
      <input name="pid" type="text" id="pid" size="8" maxlength="11" />
    &lt;&lt;&lt;&lt; place ID of the page to be edited here<br />
    <br />
    </form></td>
  </tr>
  <tr>
    <td bgcolor="#FFDDDD"><form id="form2" name="form2" method="post" action="page_delete_parse.php" onsubmit="return validate_form2 ( );">
      <br />
      <input type="submit" name="button" id="button" value="Delete Page" />
      <input name="pid" type="text" id="pid" size="8" maxlength="11" />
  &lt;&lt;&lt;&lt; place ID of the page to be deleted here<br />
      <br />
    </form></td>
  </tr>
</table>
</body>
</html>