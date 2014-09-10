<?php
ob_start();

require_once "components.php";
include_once 'head.php';
include_once 'get_race_info.php';

/**
 * if (!isset($_GET['name']))
 *    $name = "";
 * else
 *    $name = $_GET['name'];

 * if (!isset($_GET['surname']))
 *    $surname = "";
 * else
 *    $surname = $_GET['surname'];
 */

if (!isset($_GET['error']))
   $error = '';
else
   $error = $_GET['error'];
   
$_SESSION['active_tab']="race";
   
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
            <!-- Metro Components -->
            
                <?php
                //!!!ipak sam maknul sidebar kod registracije
                if (isset($raceID))
                {
                    //get_sidebar("race",$raceID);
                }
                else
                {
                    //get_sidebar(null,null);
                }
                ?>
            
            </ul>
        </div>

        <div class="bs-docs-container span9">

            <?php
                if (isset($_SESSION['raceid_prijava']))
                {
                    get_race_info($_SESSION['raceid_prijava'],true);  
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

<script type="text/javascript">
   $( "#info" ).fadeOut( 5000, function() {
// Animation complete.
});
</script>