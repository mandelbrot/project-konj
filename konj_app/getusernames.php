<?php
function getusernames1(){
    //greška mi je bila jer ovaj require nije bil unutar funkcije!!!
    require "scripts/connect_to_mysql.php";
     //'<option value='. '"1"' . '>Select a person:</option>';
    
    $sql="SELECT id,ime,prezime FROM OSOBE;";
       
    $result = mysqli_query($myConnection, $sql) or die (mysqli_error()); 
  
    //    <option value="">Select a person:</option>
    //    <option value="1">Peter Griffin</option>
    //    <option value="2">Lois Griffin</option>
    //    <option value="3">Glenn Quagmire</option>
    //    <option value="4">Joseph Swanson</option>
    
    $user_names = '<option value="">Select a person:</option>';
    while($row = mysqli_fetch_array($result))
      {
          $user_names .= '<option value="' . $row['id'] . '">';
          $user_names .= $row['ime'] . " " . $row['prezime'] . "</option>";     
      }
      
    mysqli_free_result($result); 
    
    return $user_names;
}
?>