<?php
/* Created by Adam Khoury @ www.developphp.com */

$error_msg = "";
if (isset ($_POST['username'])){
if ($_POST['username']) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	// Simple hard coded values for the correct username and password
	$admin = "theterminator";
    $adminpass = "goobernuts";
    // connect to mysql here if you store admin username and password in your database
    // This would be the prefered method of storing the values instead of hard coding them here into the script
    if (($username != $admin) || ($password != $adminpass)) {
		$error_msg = ': <font color="#FF0000">Your login information is incorrect</font>';
	} else {
		//session_register('admin');//ovo je zastarjelo pa se koristi samo ovo dole
        $_SESSION['admin'] = $username;
//        if (!isset($_SESSION['admin']))
//            $_SESSION['admin'] = $$username;
		require_once "index.php";
        session_start();
		exit();
	}

}// close if post username
    
}
?>


<?php
if (isset($_SESSION['admin']))
{
    echo '<h3>Only the administrator can view this directory</h3><br />
	
	<table width="340" border="0">
<form action="admin_check.php" method="post" target="_self">
  <tr>
    <td colspan="2">Please Log In Here' . $error_msg . '</td>
  </tr>
  <tr>
    <td width="96">Username:</td>
    <td width="234"><input type="text" name="username" id="username" style="width:98%" /></td>
  </tr>
  <tr>
    <td>Password:</td>
    <td><input type="password" name="password" id="password" style="width:98%" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Log In Now" /></td>
  </tr>
</form> 
</table>
	<br />
<br />
<br />

<a href="../">Or click here to head back to the homepage</a>';
exit();
}
?>
