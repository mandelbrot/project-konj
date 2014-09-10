<?php
ob_start();

require_once "components.php";
include_once 'head.php';

if(isset($_GET['league']))
    $leagueID=$_GET['league'];
    
if(isset($_GET['league_gr']))
    $league_gr_ID=$_GET['league_gr'];
    
$_SESSION['active_tab']="league";

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
            if (isset($leagueID))
            {
                get_league_leaguegroup("league", $leagueID);
            }
            elseif (isset($league_gr_ID))
            {
                get_league_leaguegroup("league_group", $league_gr_ID);
            }
            else
            {
                get_league_leaguegroup(null,null);
            }
            ?>
            
            </ul>
        </div>

        <div class="bs-docs-container span9" id="welcome">

            <?php
                //prikaz podataka preko ajaxa
                echo '<div id="ajaxDiv"></div>';
                
                if (isset($leagueID))
                {
                    //get_league_group_results($league_gr_ID);
                }
                else if (isset($league_gr_ID))
                {
                    //get_league_group_results($league_gr_ID);
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