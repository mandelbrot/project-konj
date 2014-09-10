<?php
ob_start();

require_once "components.php";
include_once 'head.php';

if(isset($_GET['race']))
    $raceID=$_GET['race'];

if(isset($_POST['rac_reg_name']))
    $_SESSION['rac_reg_name'] = $_POST['rac_reg_name'];
if(isset($_POST['rac_reg_surname']))    
    $_SESSION['rac_reg_surname'] = $_POST['rac_reg_surname'];
if(isset($_POST['rac_reg_god_rodj']))
    $_SESSION['rac_reg_god_rodj'] = $_POST['rac_reg_god_rodj'];
if(isset($_POST['rac_reg_sex']))
    $_SESSION['rac_reg_sex'] = $_POST['rac_reg_sex'];
if(isset($_POST['rac_reg_shirt']))
    $_SESSION['rac_reg_shirt'] = $_POST['rac_reg_shirt'];
if(isset($_POST['rac_reg_meal']))
    $_SESSION['rac_reg_meal'] = $_POST['rac_reg_meal'];
    
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
                if (isset($raceID))
                {
                    //get_race_results2($raceID);
                    get_sidebar("race",$raceID);
                    }
                else
                {
                    //get_index_page2();
                    get_sidebar(null,null);
                    }
                ?>
            
            </ul>
        </div>

        <div class="bs-docs-container span9">
            <?php
            $name = trim($_POST['rac_reg_name']);
            $surname = trim($_POST['rac_reg_surname']);
            $god_rodj = trim($_POST['rac_reg_god_rodj']);
            
            $error = '';
            
            if ($name == '') $error = 'Name is required<br />';
            if ($surname == '') $error = 'Surname is required<br />';
            if ($god_rodj == '' || strlen($god_rodj) != 4 || $god_rodj<="1900" || $god_rodj>="2000") $error = 'Birth year not correct<br />';
            
            // Build the query string to be attached 
            // to the redirected URL
            $query_string = isset($_SESSION['raceid_prijava']) ? '?race=' . $_SESSION['raceid_prijava'] : '';
            
            // Redirection needs absolute domain and phisical dir
            $server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
            
            /* The header() function sends a HTTP message 
               The 303 code asks the server to use GET
               when redirecting to another page */
            header('HTTP/1.1 303 See Other');
            
            if ($error != '') {
                
               // Back to register page
               $next_page = 'registration';
               // Add error message to the query string
               $query_string .= '&error=' . $error;
               // This message asks the server to redirect to another page
               header('Location: ' . $next_page . $query_string);
               return;
            }
            // If Ok then go to confirmation
            else $next_page = 'index' . $query_string . '&con=';
            
            $query='insert into race_registration (rac_id,per_id,rac_clu_id,sta_id,tow_id,rac_reg_paid_fee,
                rac_reg_nam,rac_reg_sur,rac_reg_sex,rac_reg_year,rac_reg_clu,rac_reg_tow,rac_reg_shi,rac_reg_meal,
                activity,date) 
                values (' . $_SESSION['raceid_prijava'] . ',
                null,null,null,null,0,
                "' . $name . '","' . $surname . '",
                ' . $_SESSION['rac_reg_sex'] .',
                "' . $god_rodj . '",
                null,null,
                ' . (isset($_SESSION['rac_reg_shirt']) ? '"' . substr($_SESSION['rac_reg_shirt'], 0, 1) . '"' : 'null' ). ',
                ' . (isset($_SESSION['rac_reg_meal']) ? '"' . substr($_SESSION['rac_reg_meal'], 0, 1) . '"' : 'null' ). ',
                null,' . get_DB_time() . ');';
            $result = queryMysql($query);
         
            unset($_SESSION['rac_reg_name']);
            unset($_SESSION['rac_reg_surname']); 
            unset($_SESSION['rac_reg_god_rodj']);
            unset($_SESSION['rac_reg_sex']);
            unset($_SESSION['rac_reg_shirt']);
            unset($_SESSION['rac_reg_meal']);
    
            // Redirect to confirmation page
            //header('Location: http://' . $server_dir . $next_page . $query_string);    
            header("Location: " . $next_page); 
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
