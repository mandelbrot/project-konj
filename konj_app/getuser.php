<?php
require_once "connect_to_mysql.php";

if (isset($_GET['q'])) {
    $q=$_GET['q'];
    }
else{
    //echo '<div id="txtHint"><b>Person info will be listed here.</b></div>';
    return;
}

$sql="SELECT * FROM OSOBE WHERE id = '".$q."'";

$result = mysqli_query($myConnection, $sql) or die (mysqli_error()); 

echo "<table border='1'>
<tr>
<th>Ime</th>
<th>Prezime</th>
<th>Adresa</th>
<th>Grad</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['Ime'] . "</td>";
  echo "<td>" . $row['Prezime'] . "</td>";
  echo "<td>" . $row['Adresa'] . "</td>";
  echo "<td>" . $row['Grad'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_free_result($result); 
?> 