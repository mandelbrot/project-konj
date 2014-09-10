<?php  
/* Created by Adam Khoury @ www.developphp.com */
// Place db host name. Sometimes "localhost" but  
// sometimes looks like this: >>      ???mysql??.someserver.net 
$db_host = "localhost"; 
// Place the username for the MySQL database here 
$db_username = "pkvertik_user";  
// Place the password for the MySQL database here 
$db_pass = "srM8024iYh";  
// Place the name for the MySQL database here 
$db_name = "pkvertik_konj"; 

// Run the connection here   
$myConnection = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die ("could not connect to mysql");  
// Now you can use the variable $myConnection to connect in your queries  


function returnConnection()
{

$db_host = "localhost"; 
// Place the username for the MySQL database here 
$db_username = "pkvertik_user";  
// Place the password for the MySQL database here 
$db_pass = "srM8024iYh";  
// Place the name for the MySQL database here 
$db_name = "pkvertik_konj"; 

// Run the connection here   
$myConnection = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die ("could not connect to mysql");

return $myConnection;
    
}
    
?> 