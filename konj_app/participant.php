<?php
ob_start();

require_once "components.php";
include_once 'head.php';

if(isset($_GET['participant']))
    $participantID=$_GET['participant'];
 
$_SESSION['active_tab']="participant";
  
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
	<?php include_once("navbar.php") ?>

    <div id="alerts-container"></div>

    <div id="doc-container" class="container">
      <div class="row">
         <div class="bs-docs-sidebar span3">
            <ul class="nav metro-nav-list bs-docs-sidenav">
        
            <?php 
            get_racers();
            ?>
        
            </ul>
        </div>

        <div class="bs-docs-container span9" id="welcome">

            <?php 
                //prikaz podataka preko ajaxa
                echo '<div id="ajaxDiv"></div>';
            
                if (isset($participantID))
                {
                    //get_racer($participantID);
                }
                else
                {
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