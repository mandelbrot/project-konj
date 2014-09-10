<?php
ob_start();
    
require_once "components.php";
include_once 'head.php';

if(!isset($_SESSION['user']))
    header("Location: index");
    
if(isset($_GET['race']))
    $raceID=$_GET['race'];
    
$_SESSION['active_tab']="preferences";
   
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
	<?php include_once("navbar.php") ?>

    <div id="alerts-container"></div>

    <div id="doc-container" class="container">
      <div class="row">
        <div class="bs-docs-container span9" id="welcome">
            <?php
        
            $Chb = array(3,3,3);
                
            if($_POST)
            {
              
                //$Chb_post = $_POST['Chb'];
                //var_dump($Chb_post);
                //echo count($pet);
                //echo $_POST['Chb'][Chb1];
                //echo $_POST['Chb'][Chb2];
                //if(isset($pet[1]['Chb2']))
                //    echo $pet[1]['Chb2'];
                //echo count($_POST['Chb']);
        //        for( $i=0 ; $i < count($_POST['Chb']) ; $i++ )
        //        {
        //            $c="'" . 'Chb'.($i+1) . "'";
        //            echo $pet[0][Chb1];
        //            echo $pet[$i][$c];
        //            $Chb[$i]       = isset($_POST[$i][$c]) ? "checked" : "";
        //            echo $Chb[$i];   
        //        }
                
                $Chb[0] = isset($_POST['Chb']['Chb1']) ? "checked" : "";
                $Chb_b[0] = isset($_POST['Chb']['Chb1']) ? 1 : 0;
                $Chb[1] = isset($_POST['Chb']['Chb2']) ? "checked" : "";
                $Chb_b[1] = isset($_POST['Chb']['Chb2']) ? 1 : 0;
                $Chb[2] = isset($_POST['Chb']['Chb3']) ? "checked" : "";
                $Chb_b[2] = isset($_POST['Chb']['Chb3']) ? 1 : 0;
                
                $query = "update xparameters set
                    par_val='$Chb_b[0]' where par_nam = 'show_races_in_league'";
                $result = queryMysql($query); 
                $query = "update xparameters set
                    par_val='$Chb_b[1]' where par_nam = 'show_leagues_in_races_tab'";
                $result = queryMysql($query); 
                $query = "update xparameters set
                    par_val='$Chb_b[2]' where par_nam = 'show_league_groups_in_races_tab'";
                $result = queryMysql($query); 
                
            }
            else
            {
                $query = "SELECT par_val FROM xparameters
                where par_nam in ('show_races_in_league','show_leagues_in_races_tab',
                'show_league_groups_in_races_tab')";
           
                $result = queryMysql($query); 
                $num_rounds = mysqli_num_rows(queryMysql($query));
                if($num_rounds==0)
                {
                    for( $i=0 ; $i < 3 ; $i++ )
                    {
                        $Chb[$i] = "";
                    }
                } 
                else 
                {
                    for($i=0;$i<$num_rounds;$i++)
                    {
                        $row = mysqli_fetch_row($result);
                        $Chb[$i] = $row[0] == 1 ? "checked" : "";      
                    }
                }
            }
            
            echo '<div class="bs-docs-section">
                <form action="preferences" method="post">
                    <fieldset>
                        <legend>Tab preferences</legend>
                            <label class="checkbox">
                                <input type="checkbox" name="Chb[Chb1]" id="Chb1"'. $Chb[0] .'>
                                <span class="metro-checkbox">show_races_in_league</span>
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="Chb[Chb2]" id="Chb2"'. $Chb[1] .'>
                                <span class="metro-checkbox">show_leagues_in_races_tab</span>
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="Chb[Chb3]" id="Chb3"'. $Chb[2] .'>
                                <span class="metro-checkbox">show_league_groups_in_races_tab</span>
                            </label>
                            <br/>
                            <span class="help-block"></span>
                        <legend>Other preferences</legend>
                        <button type="submit" class="btn">Submit</button>
                    </fieldset>
                </form>
            </div>';
        
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
