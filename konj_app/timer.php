<?php
ob_start();

require_once "components.php";
include_once 'head.php';

if(!isset($_SESSION['user']))
    header("Location: index");
    
if(isset($_POST['racer_id']))
    $racer_id=$_POST['racer_id'];

if(isset($_POST['processing'])){
    $log = process_results($_POST['processing_par']);
    if ($log == "2") echo "Nije odabran sustav bodovanja za ovu trku!";  
    }
      
$_SESSION['active_tab']="timer";

?>

<?php

class Timer {

   var $classname = "Timer";
   var $start     = 0;
   var $stop      = 0;
   var $elapsed   = 0;

   # Constructor
   function Timer( $start = true ) {
      if ( $start )
         $this->start();
   }

   # Start counting time
   function start() {
      $this->start = $this->_gettime();
   }

   # Stop counting time
   function stop() {
      $this->stop    = $this->_gettime();
      $this->elapsed = $this->_compute();
   }

   # Get Elapsed Time
   function elapsed() {
      if ( !$elapsed )
         $this->stop();

      return $this->elapsed;
   }

   # Get Elapsed Time
   function reset() {
      $this->start   = 0;
      $this->stop    = 0;
      $this->elapsed = 0;
   }

   #### PRIVATE METHODS ####

   # Get Current Time
   function _gettime() {
      $mtime = microtime();
      $mtime = explode( " ", $mtime );
      return $mtime[1] + $mtime[0];
   }

   # Compute elapsed time
   function _compute() {
      return $this->stop - $this->start;
   }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   
<body>
	<?php include_once("navbar.php") ?>

    <div id="alerts-container"></div>
    
    <div id="doc-container" class="container">
        <div class="row">
            <div class="bs-docs-container span3">
                <ul class="nav metro-nav-list bs-docs-sidenav">

                </ul>
            </div>
    
            <div class="bs-docs-container span9" id="welcome">
    
            <h2>Racer recording</h2>
            <br />
            <form action="timer" method="post">
                <fieldset>
                <label>Racer id:</label>
                <input type="text" class="input-mini" placeholder="Id..." name="racer_id" onsubmit="showResult(this.value)">
                <span class="help-block"></span>
                <button type="submit" class="btn" name="racer_start">Racer start</button>
                <button type="submit" class="btn" name="racer_finish">Racer finish</button>
                </fieldset>
            </form>
            
            <div id="livesearch"></div>
          
            <b>Log:</b></br>
            <?php
            
                if(isset($_GET['racer_id'])){
                    $q=$_GET["racer_id"];
                    $message = '<b>' . $q . '</b></br>';
                    echo $message;
                }
                
                //$t = new Timer();
                
                if(isset($_POST['timer_reset'])){
                    //$t->Reset();
                    //$t->start();
                    $_SESSION['history'] = '';
                    $_SESSION['start'] = '';
                    
                    if(isset($_SESSION['current_race_recording'])){
                        list($microSec, $RACE_START_TIME) = explode(" ", microtime());
                        $query='insert into race_rec (rac_id,user_id,start,start_sec,stop,stop_sec) 
                            values(' . $_SESSION['current_race_recording'] . ',' . $_SESSION['user_id'] . ',
                            \'' . date('Y-m-d H:i:s', $RACE_START_TIME) . '\',' . $RACE_START_TIME . ',null,null);'; 
                        //echo $query; 
                        $result = queryMysql($query);
                    }
                    else
                        echo 'ODABERI UTRKU!';
                }
                
                if(isset($_POST['timer_stop'])){
                    //$t->Reset();
                    //$t->start();
                    $_SESSION['history'] = '';
                    $_SESSION['start'] = '';
                    
                    if(isset($_SESSION['current_race_recording'])){
                        list($microSec, $RACE_STOP_TIME) = explode(" ", microtime());
                        $query='insert into race_rec (rac_id,user_id,start,start_sec,stop,stop_sec) 
                            values(' . $_SESSION['current_race_recording'] . ',' . $_SESSION['user_id'] . ',
                            null,null,\'' . date('Y-m-d H:i:s', $RACE_STOP_TIME) . '\',' . $RACE_STOP_TIME . ');'; 
                        //echo $query; 
                        $result = queryMysql($query);
                    }
                    else
                        echo 'PRVO ODABERI UTRKU!';
                }
                
                if(isset($_POST['timer_start'])){
                    if (!isset($_POST['current_race_recording'])){
                        echo 'PRVO ODABERI UTRKU!';
                    }
                    else if ($_POST['current_race_recording'] == -1){
                        echo 'PRVO ODABERI UTRKU!!!';
                    }
                    else{
        //                $t->Reset();
        //                $t->start();
        //                $_SESSION['start'] = $t->start;
        //                echo $_SESSION['start'];
                        
                        if($_POST['race_start'] != ''){ 
                            $RACE_START_TIME = strtotime($_POST['race_start']);
                        }
                        else {
                            list($microSec, $RACE_START_TIME) = explode(" ", microtime());
                        }
                        //$_SESSION['start'] = date('d-n-Y, H:i:s', $RACE_START_TIME);
                        $message = '<b>Timer started at '. date('d-n-Y, H:i:s', $RACE_START_TIME) . '</b></br>';
                        //$message .= '<b>Timer started at '. $_SESSION['start'] . '</b></br>';
                        if(!isset($_SESSION['history']))
                            $_SESSION['history'] = $message;
                        else $_SESSION['history'] .= $message;
                        echo $_SESSION['history'];
                    
                        $_SESSION['current_race_recording'] = $_POST['current_race_recording'];
                        $query='insert into race_rec (rac_id,user_id,start,start_sec,stop,stop_sec) 
                            values(' . $_SESSION['current_race_recording'] . ',' . $_SESSION['user_id'] . ',
                            \'' . date('Y-m-d H:i:s', $RACE_START_TIME) . '\',' . $RACE_START_TIME . ',null,null);'; 
                        //echo $query; 
                        $result = queryMysql($query); 
                    }
                }
                
				//dupli submit: http://stackoverflow.com/questions/15626868/prevent-double-form-submit-using-tokens
				
                if(isset($_POST['racer_id'])){
                    if(isset($_SESSION['current_race_recording']) && isset($_POST['racer_finish'])){
                        //if(isset($_SESSION['racer_id']))
                        //if($_SESSION['racer_id']==$racer_id and $racer_id!='') return;
                    
                        $racer_id = $_POST['racer_id'];   
                        $race_id = $_SESSION['current_race_recording'];           
                        
                        list($microSec, $RACER_RECORDING_TIME) = explode(" ", microtime());
                        
						$racer_ids = explode(",", $racer_id);
						
						for($i = 0; $i < count($racer_ids); $i++)
						{               
							$racer_ids[$i] = trim($racer_ids[$i]);
							
							$RACER_ELAPSED_TIME_SEC = $RACER_RECORDING_TIME - 
								(get_race_chrono($race_id) ? strtotime(get_race_racer_start_time($race_id, $racer_ids[$i])) : 
									get_race_start_time_sec($race_id));
							$RACER_ELAPSED_TIME = gmdate('H:i:s', $RACER_ELAPSED_TIME_SEC);
										   
							$RACER_RECORDING_TIME_DAT = date('Y-m-d H:i:s', $RACER_RECORDING_TIME);
										   
							//treba riješiti tipove res_typ_id!!!
							//treba riješiti update za race_result ako se promijeni pocetak utrke u race_rec
							if(result_exists($race_id, $racer_ids[$i]))
								$query='update race_result
									set res_time = \'' . $RACER_RECORDING_TIME_DAT . '\',
									res_fin_time = \'' . $RACER_ELAPSED_TIME . '\',
									res_fin_time_sec = \'' . $RACER_ELAPSED_TIME_SEC . '\',
									activity = "D",
									date = \'' . $RACER_RECORDING_TIME_DAT . '\'
									where rac_id = ' . $race_id .' and sn_id = ' . $racer_ids[$i] . ';';
							else
								$query='insert into race_result (rac_id,res_chk_id,sn_id,res_typ_id,res_fin_time,res_fin_time_sec,
									res_start, res_time, res_pen, activity, date) 
									values(' . $race_id . ',
									null,
									' . $racer_ids[$i] . ',
									null,
									\'' . $RACER_ELAPSED_TIME . '\',
									' . $RACER_ELAPSED_TIME_SEC . ',
									\'' . (get_race_chrono($race_id) ? $RACER_RECORDING_TIME_DAT : get_race_start_time($race_id)) . '\',
									\'' . $RACER_RECORDING_TIME_DAT . '\',
									null,"D",
									\'' . $RACER_RECORDING_TIME_DAT . '\');';
								
							echo $query; 
							$result = queryMysql($query); 
						   
							$message = 'Racer ' . $racer_ids[$i] . ' finished @ '. 
							date('d-n-Y, H:i:s', $RACER_RECORDING_TIME) . '. Elapsed time: '.
							$RACER_ELAPSED_TIME . '</br>';
							
							if(!isset($_SESSION['history'])) $_SESSION['history'] = $message;
							else $_SESSION['history'] .= $message;
                        }
						
                        echo $_SESSION['history'];                    
                    }
                    else if(isset($_SESSION['current_race_recording']) && isset($_POST['racer_start']))
                    {
                        $racer_ids = $_POST['racer_id'];   
                        $race_id = $_SESSION['current_race_recording'];            
                        
                        list($microSec, $RACER_RECORDING_TIME) = explode(" ", microtime());
                        
						$racer_ids = explode(",", $racer_id);
						
						for($i = 0; $i < count($racer_ids); $i++)
						{
							$racer_ids[$i] = trim($racer_ids[$i]);
							
							$RACER_ELAPSED_TIME_SEC = $RACER_RECORDING_TIME - 
								(get_race_chrono($race_id) ? strtotime(get_race_racer_start_time($race_id, $racer_ids[$i])) : 
									get_race_start_time_sec($race_id));
							$RACER_ELAPSED_TIME = gmdate('H:i:s', $RACER_ELAPSED_TIME_SEC);
										   
							$RACER_RECORDING_TIME_DAT = date('Y-m-d H:i:s', $RACER_RECORDING_TIME);
							
							//treba riješiti tipove res_typ_id!!!
							//treba riješiti update za race_result ako se promijeni pocetak utrke u race_rec
							if(result_exists($race_id, $racer_ids[$i]))
								$query='update race_result
									set res_start = \'' . $RACER_RECORDING_TIME_DAT . '\',
									activity = "D",
									date = \'' . $RACER_RECORDING_TIME_DAT . '\'
									where rac_id = ' . $race_id .' and sn_id = ' . $racer_ids[$i] . ';';
							else
								$query='insert into race_result (rac_id,res_chk_id,sn_id,res_typ_id,res_fin_time,res_fin_time_sec,
									res_start, res_time, res_pen, activity, date) 
									values(' . $race_id . ',
									null,
									' . $racer_ids[$i] . ',
									null,
									\'' . $RACER_ELAPSED_TIME . '\',
									' . $RACER_ELAPSED_TIME_SEC . ',
									\'' . (get_race_chrono($race_id) ? $RACER_RECORDING_TIME_DAT : get_race_start_time($race_id)). '\',
									\'' . $RACER_RECORDING_TIME_DAT . '\',
									null,"D",
									\'' . $RACER_RECORDING_TIME_DAT . '\');';
								
							echo $query; 
							$result = queryMysql($query); 
						}
                    }
                    else
                        echo 'PRVO ODABERI UTRKU!';            
                }
            ?>
            
            <br />
            <br />
            <h2>Race selection</h2>
            <br />
            <form action="timer" method="post">
                <fieldset>
                    <?php
                        $query2 = "SELECT rac_id, rac_nam   
                            FROM race"; 
                            //where '" . date('Ymd') . "'  between rac_fr_dat and rac_to_dat"; 
                        $result2 = queryMysql($query2); 
                        $num2 = mysqli_num_rows(queryMysql($query2)); 
                        
                        echo '<label>Race:</label> 
                            <select class="input-xlarge" name="current_race_recording" id="current_race_recording" 
                                onChange="set_current_race_recording();"> 
                            <option value="-1">Select race...</option>'; 
                        for($i=0;$i<$num2;$i++){   
                            $row2 = mysqli_fetch_row($result2); 
                            echo '<option value="' . $row2[0] . '" ' . 
                            ($row2[0] == (isset($_POST['current_race_recording']) ? $_POST['current_race_recording'] : $_SESSION['current_race_recording']) ? "selected=\"selected\"" : "") . 
                            '>' . $row2[1] . '</option>';        
                        } 
                        echo ' 
                        </select>'; 
                    ?>
                    <br />
                    <input type="text" class="input-xxlarge" placeholder="Race Start Time (yyyy-mm-dd HH:MM:SS)..." name="race_start">
                    <br />
                    <button type="submit" class="btn" name="timer_start">Start timer</button>
                </fieldset>
            </form>
            
            <form action="timer" method="post">
                <fieldset>
                    <button type="submit" class="btn" name="timer_reset">Reset timer</button>
                </fieldset>
            </form>
           
            <form action="timer" method="post">
                <fieldset>
                    <button type="submit" class="btn" name="timer_stop">Stop timer</button>
                </fieldset>
            </form>
                
            <br/>
            <br/>
            <h2>Process race results</h2>
            <br/>
            <form action="timer" method="post">
                <fieldset>
                    <label>Race id:</label>
                    <input type="text" placeholder="Type race id..." name="processing_par">
                    <span class="help-block"></span>
                    <button type="submit" class="btn" name="processing">Process results</button>
                </fieldset>
            </form>
            
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
    function get_race_start_time($raceid){
        $query = "SELECT start FROM race_rec 
            where rac_id = '$raceid' 
            order by rac_rec_id desc limit 1;"; 
            //order by start desc limit 1;"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return -1;
        }
        else {
            return $row[0];
        }
    }
    function get_race_start_time_sec($raceid){
        $query = "SELECT start_sec FROM race_rec 
            where rac_id = '$raceid' 
            order by rac_rec_id desc limit 1;"; 
            //order by start_sec desc limit 1;"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return -1;
        }
        else {
            return $row[0];
        }
    }
    function get_race_stop_time($raceid){
        $query = "SELECT stop FROM race_rec 
            where rac_id = '$raceid' 
            order by rac_rec_id desc limit 1;"; 
            //order by stop asc limit 1;"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return -1;
        }
        else {
            return $row[0];
        }
    }
    function get_race_stop_time_sec($raceid){
        $query = "SELECT stop_sec FROM race_rec 
            where rac_id = '$raceid' 
            order by rac_rec_id desc limit 1;"; 
            //order by stop_sec asc limit 1;"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return -1;
        }
        else {
            return $row[0];
        }
    }
    function get_race_chrono($raceid){
        $query = "SELECT rac_chrono FROM race 
            where rac_id = '$raceid'"; 
            //order by stop_sec asc limit 1;"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return false;
        }
        else {
            return ($row[0] == "D" || $row == "Y" ? true : false);
        }
    }
    function get_race_racer_start_time($raceid, $racer_id){
        $query = "SELECT res_start FROM race_result
            where rac_id = '$raceid' and sn_id = '$racer_id';"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return get_race_start_time($raceid);
        }
        else {
            return ($row[0] == '' || $row[0] == null ? get_race_start_time($raceid): $row[0]);
        }
    }
    function result_exists($raceid, $racer_id){
        $query = "SELECT count(*) FROM race_result
            where rac_id = '$raceid' and sn_id = '$racer_id';"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
        $row = mysqli_fetch_row($result); 
        if($num == 0){
            return false;
        }
        else {
            return ($row[0] > 0 ? true : false);
        }
    }
?>

<script>
    function set_current_race_recording(){
    var id = $('#current_race_recording').val(val);
    }
</script>

<script>
    function showResult(str)
    {
    if (str.length==0)
      {
      document.getElementById("livesearch").innerHTML="";
      document.getElementById("livesearch").style.border="0px";
      return;
      }
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
      }
    xmlhttp.open("GET","timer?racer_id="+str,true);
    xmlhttp.send();
    }
</script>
