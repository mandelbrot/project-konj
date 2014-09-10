<?php 
ob_start();
//sleep(1);
include_once 'head.php';
//echo "<h3>Member Log in</h3>";
$error = $user = $pass = "";

if (isset($_POST['user']))
{
	$user = sanitizeString($_POST['user']);
	$pass = sanitizeString($_POST['pass']);

	if ($user == "" || $pass == "")
	{
		$error = "Not all fields were entered<br />";
	}
	else
	{
		$query = "SELECT user_id,user,pass FROM user
				  WHERE user='$user' AND pass='$pass'";

		if (mysqli_num_rows(queryMysql($query)) == 0)
		{
			$error = "Username/Password invalid<br />";
		}
		else
		{
            $result = queryMysql($query); 
            $row = mysqli_fetch_row($result);
			$_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			$_SESSION['user_id'] = $row[0];
            
            //header("Location: index?view=" . $user); 
            //exit();
//			die("You are now logged in. Please
//			   <a href='dashboard.php?view=$user'>click here</a>.");
		}
	}
}
/*
echo <<<_END
<form method='post' action='login'>$error
Username <input type='text' maxlength='16' name='user'
	value='$user' /><br />
Password <input type='password' maxlength='30' name='pass'
	value='$pass' /><br />
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input type='submit' value='Login' />
</form>
_END;*/
?>
