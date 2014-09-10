<?php
ob_start();

require_once "components.php";
include_once 'head.php';

if(isset($_GET['race']))
    $raceID=$_GET['race'];
    
if(isset($_POST['prijava']))
    $prijava=true;  
else $prijava=false;

if(isset($_GET['reg']))
    $prijava=true;  
else $prijava=false;  

if(isset($_GET['con']))
    $confirmation=true;  
else $confirmation=false;  

$_SESSION['active_tab']="race";

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
	<?php include_once("navbar.php") ?>

    <div id="alerts-container"></div>
    
    <div class="progress progress-indeterminate" id="loading_spinner">
		<div class="win-ring"></div>
	</div>
        
    <div id="doc-container" class="container">
      <div class="row">
         <div class="bs-docs-sidebar span3">
            <ul class="nav metro-nav-list bs-docs-sidenav">

            <?php 
            if (isset($raceID))
            {
                get_sidebar("race",$raceID);
            }
            else
            {
                get_sidebar(null,null);
            }
            ?>
        
            </ul>
        </div>

        <div class="bs-docs-container span9" id="welcome">

            <?php    
                //prikaz podataka preko ajaxa
                echo '<div id="ajaxDiv"></div>';
                
                if($confirmation){
                    echo "Uspje&#353;na prijava!";
                    unset($_SESSION['raceid_prijava']);
                    //header("refresh: 1; url=index?race=" . $raceID); 
                    header("refresh: 1; url=index"); 
                }
                else if (isset($raceID))
                {   
                    
                    //unset($_SESSION['prijava']);
                    //ponovo ispiši pomoću ajaxa o trci, sam kaj ovo ne radi
                    //get_race_info($raceID,$prijava);
                    
                    }
                else
                { 
                    //ako je ovo dole uključeno onda ne dela!
                    //vjerojatno registracija ne bu dobro radila na produkciji!!!
                    //header("url=index");
                    get_general(); 
                }
            ?>
    
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>

         </div>
      </div>
    </div>


    <?php 
    get_footer()        
    ?>

</body>
</html> 

<?php 
get_active_sidebar_link()        
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#loading_spinner').hide();
});

</script>