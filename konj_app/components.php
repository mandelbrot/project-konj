<?php
ob_start();

global $loggedin;
    if (isset($_SESSION['user']))
    {
    	$user = $_SESSION['user'];
    	$loggedin = TRUE;
    }
    else $loggedin = FALSE;

function get_sidebar($type, $id){
    if(get_parameter(null,"show_races_in_league") == 1)
    {
        echo '<li>
            <a href="#page-components">Trke</a>
            <ul class="nav" id="races-active">';
          
        $query = "SELECT rac_nam,rac_id FROM race where activity='D' or activity='Y'";
        $result = queryMysql($query);
        
        $num = mysqli_num_rows(queryMysql($query));
        
        for ($j = 0 ; $j < $num ; ++$j)
        {
            $row = mysqli_fetch_row($result);
            $raceid = $row[1];
            //$race='<li><a href="index?race=' . $raceid . '">' . $row[0] . '</a></li>';
            $race='<li><a class="race-link" href="#" onclick=\'ajaxGetComponent("race", ' . $raceid . ')\'>
                ' . $row[0] . '</a></li>';
            echo $race;  
        }
        
        echo '</ul>';
    }
                  
    get_league_leaguegroup($type, $id);
}

function get_league_leaguegroup($type, $id){
    if($_SESSION['active_tab'] == "race")
    {
        $show_leagues_in_races_tab = get_parameter(null,"show_leagues_in_races_tab");
        $show_league_groups_in_races_tab = get_parameter(null,"show_league_groups_in_races_tab");
    }
    else $show_league_groups_in_races_tab = $show_leagues_in_races_tab = 1;
    
    if($show_leagues_in_races_tab)
    {
        echo 
        '           <li>
          <a href="#page-components">Lige</a>
          <ul class="nav" id="leagues-active">';
          
        $query = "SELECT lea_nam, lea_id FROM league";
        $result = queryMysql($query);
    
        $num = mysqli_num_rows(queryMysql($query));
    
        if($num==0) echo '-';
        
        for ($j = 0 ; $j < $num ; ++$j)
        {
    	    $row = mysqli_fetch_row($result);
            
            $leagueid = $row[1];
            $league='<li><a class="race-link" href="#" onclick=\'ajaxGetComponent("league", ' . $leagueid . ')\'>' . $row[0] . '</a></li>';
        
            echo $league;
        }
    			
        echo
            '</ul>';
    }
    
    if($show_league_groups_in_races_tab)
    {
        echo '<li>
            <a href="#page-components">Lige-grupe</a>
            <ul class="nav" id="league-groups-active">';
          
        $query = "SELECT leagr_nam, leagr_id FROM league_group";
        $result = queryMysql($query);
    
        $num = mysqli_num_rows(queryMysql($query));
    
        if($num==0) echo '-';
        
        for ($j = 0 ; $j < $num ; ++$j)
        {
    	    $row = mysqli_fetch_row($result);
            
            $league_gr_id = $row[1];
            $league_gr='<li><a class="race-link" href="#" onclick=\'ajaxGetComponent("league_gr", ' . $league_gr_id . ')\'>' . $row[0] . '</a></li>';    

            echo $league_gr;
        }
    			
        echo
            '</ul>';
    }
}

function get_general()
{
/**
 *     $r=1;
 *     while($r>0)
 *     {
 *         echo '<div class="progress progress-indeterminate">
 * 		<div class="win-ring"></div>
 * 		</div>';
 *             ob_flush(); flush();
 *             sleep(3);
 * 			$r=0;
 *     }
 */
   
	echo'
    <div class="bs-docs-section" id="news">
       <div class="page-header">
          <h3>Novosti:</h3>
       </div>';

    $query = "select rr.sn_id, concat(p.per_nam, ' ', p.per_sur) as trkac,p.per_id , 
    	   rr.res_fin_time vrijeme, round(r.rac_kmh/get_time_decimal(rr.res_fin_time),2) as 'kmH/h',
			round(r.rac_kmv/get_time_decimal(rr.res_fin_time),2) as 'kmV/h',r.rac_nam,r.rac_id
        from race_result rr
        inner join race r on rr.rac_id=r.rac_id
        inner join start s on r.st_id=s.st_id
        inner join st_num st on s.st_id=st.st_id
        inner join person p on st.per_id=p.per_id
        where rr.sn_id=st.sn_id
        order by res_time desc limit 20";
    $result = queryMysql($query);

    $num = mysqli_num_rows(queryMysql($query));

    for ($i = 0 ; $i < $num ; ++$i)
    {
	$row = mysqli_fetch_row($result);
         
        $racer='<p>
			<a class="race-link" href="#" onclick=\'ajaxGetComponent("race", ' . $row[7] . ')\'>' . $row[6] . '</a>  -  
			<a class="race-link" href="#"                 onclick=\'ajaxGetComponent("racer", ' . $row[2] . ')\'>' . $row[1] . ' (' . $row[0] . ')</a>
			 u cilju: <font size="3"><b class="accent-color">' . $row[3] . '</b></font>, <b>' . $row[4] . ' kmH/h</b>, ' . $row[5] . ' kmV/h</p>';  
        
        echo $racer;
    }

	echo'</br>
          <h3>Utrke: </h3>';

    $query = "select r.rac_nam,r.rac_id,r.rac_start_dat
        from race r
        where rac_fr_dat > ADDDATE(DATE(NOW()), -30) and rac_to_dat < ADDDATE(DATE(NOW()), 30) 
		order by rac_start_dat limit 20";
    $result = queryMysql($query);

    $num = mysqli_num_rows(queryMysql($query));

    for ($i = 0 ; $i < $num ; ++$i)
    {
		$row = mysqli_fetch_row($result);
        
		$racer='<p><a class="race-link" href="#" onclick=\'ajaxGetComponent("race", ' . $row[1] . ')\'>' . $row[0] . '</a>  ' . $row[2] . '</p>';
			
		if(date("Y-m-d H:i:s") > $row[2])  $racer = '<strike>' . $racer . '</strike>';
			
		echo $racer;
    }

    echo '</div>';
}

function round_res_last_round($result_first,$result_second){
    return ($result_second == null ? true : ($result_first<$result_second ? true : false));
}

function get_racers(){        
    echo '<li>
        <a href="#page-components">Trka&#269;i</a>
        <ul class="nav" id="particpants-active">';
      
    $query = "SELECT per_nam, per_sur, per_id FROM person order by per_sur, per_nam";
    $result = queryMysql($query);

    $num = mysqli_num_rows(queryMysql($query));

    if($num==0) echo '-';
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
	    $row = mysqli_fetch_row($result);
         
        $id = $row[2];
        $racer='<li><a class="race-link" href="#" onclick=\'ajaxGetComponent("racer", ' . $id . ')\'>' . $row[0] . ' ' . $row[1] . '</a></li>';  
        
        echo $racer;
    }
			
    echo
        '</ul>';
}

function get_footer(){
    echo'
    <a class="bs-docs-top affix" href="#welcome">Back to top</a>

    <footer class="bs-docs-footer ">
      <div class="container">
         <p>Developed by Marko Leljak.</p>
         <!--<p>Design by <a target="_blank" href="https://twitter.com/aozoralabs">@aozoralabs</a>.</p>
         <p>Code licensed under <a target="_blank" href="http://www.apache.org/licenses/LICENSE-2.0">Apache License v2.0</a> or <a target="_blank" href="http://www.gnu.org/licenses/gpl-2.0.html">GPL2</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>-->
      </div>
    </footer>
    ';
}
function get_active_tab($tab){
    if(isset($_SESSION['active_tab']))
        $active_tab=$_SESSION['active_tab'];
    else
        $active_tab='race'; 
    
    if($active_tab==$tab){
        return "active";
    }
}

function get_active_sidebar_link(){
    echo '
<script type="text/javascript">
    $( "#info" ).fadeOut( 5000, function() {
        // Animation complete.
    });
    
/**
 *     //this was before (when not using ajax)
 *     $(document).ready(function(){
 *       $(\'#races-active li a\').each(function(index) {
 *     	var $href = $(this).attr(\'href\');
 *           if(this.href.trim() == window.location + \'#\'){
 *               $(this).parent().addClass("active");
 *               }
 *       });
 *     });
 */
   
    //race link actve/unactive
    var $thumbs = $(\'.race-link\').click(function(e) {
        e.preventDefault();
        //run removeClass on every element
        //if the elements are not static, you might want to rerun $(\'.thumbnail\')
        //instead of the saved $thumbs
        $thumbs.parent().removeClass("active");
        //add the class to the currently clicked element (this)
        $(this).parent().addClass("active");
     });
     //alert();
     //var r;
     //r = <?php //echo (isset($_GET[\'race\']) ? ajaxGetComponent($_GET[\'race\']) : null); ?>;
     //window.location.href = window.location.pathname.substring( 0, window.location.pathname.lastIndexOf( \'?\' ) + 1 );

/**
 * $(document).ready(function(){
 *     $(\'#leagues-active li a\').each(function(index) {
 * 		var $href = $(this).attr(\'href\');
 *         if(this.href.trim() == window.location){
 *             $(this).parent().addClass("active");
 *             }
 *     });
 *     $(\'#league-groups-active li a\').each(function(index) {
 * 		var $href = $(this).attr(\'href\');
 *         if(this.href.trim() == window.location){
 *             $(this).parent().addClass("active");
 *             }
 *     });
 * });
 */
</script> 

<!-- Grab Google CDN\'s jQuery. fall back to local if necessary -->
<!-- <script src="//code.jquery.com/jquery-1.10.0.min.js"></script>
<script>window.jQuery || document.write("<script src=\'../assets/js/jquery-1.10.0.min.js\'>\x3C/script>")</script>-->

<!--[if IE 7]>
<script type="text/javascript" src="scripts/bootmetro-icons-ie7.js">
<![endif]-->
<!-- 
<script type="text/javascript" src="assets/js/google-code-prettify/prettify.js"></script>
<script type="text/javascript" src="assets/js/min/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/bootmetro-panorama.js"></script>
<script type="text/javascript" src="assets/js/bootmetro-pivot.js"></script>
<script type="text/javascript" src="assets/js/bootmetro-charms.js"></script>
<script type="text/javascript" src="assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/js/holder.js"></script>
<script type="text/javascript" src="assets/js/min/Chart.min.js"></script>

<script type="text/javascript" src="assets/js/docs.js"></script>
-->
';
}

function get_sex($sex){
    return $sex == 1 ? 'M': '&#381;';
}

function getValue($table, $column, $columnId, $id)
{
    $query = "select " . $column . " from " . $table . " where " . $columnId . " = " . $id . " limit 1";
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));
    if($num > 0)
    {
	   $row = mysqli_fetch_row($result);
       $error = $row[0];
    }
    else
	   $error = "";
       
	return $error;
}

function get_parameter($par_id, $par_nam){
    
    if($par_id == null && $par_nam == null){
        return null;
    }
    
    if($par_id!=null){
        $query = "SELECT par_val FROM xparameters where par_id=" . $par_id;
        $result = queryMysql($query);
    
        $row = mysqli_fetch_row($result);
        
        return $row[0];
    }
    
    if($par_nam!=null){
        $query = "SELECT par_val FROM xparameters where par_nam='" . $par_nam . "'";
        $result = queryMysql($query);
        
        $row = mysqli_fetch_row($result);
        
        return $row[0];
    }
}

//    $query = "update scoring set sco_system='100,95,92,90,";
//    
//    for($i=89;$i>1;$i--){
//        $query.=$i.",";
//    }
//    $query.="' where sco_id=1";
//    $result = queryMysql($query);

function process_results($par){
    //sanitize string!!!
    $par = sanitizeString($par);
    
    fix_results(true);
    
    switch ($par){   
        case "all":
            $result = queryMysql("delete from table_results;");
            $query = "Insert into table_results(rac_id,lea_id,r_leagr_id,l_leagr_id,rac_lea_add,per_id,
        		st_id,sn_id,sco_id,sco,res_fin_time,res_fin_time_sec,
        		activity,date) 
        		SELECT distinct 
        		r.rac_id, r.lea_id, 
        		r.leagr_id, l.leagr_id,
        		r.rac_lea_add, 
        		per.per_id as per_id, 
        		r.st_id, rr.sn_id,
        		l.sco_id, 0, 
        		res_fin_time, res_fin_time_sec, 
        		'D', DATE_FORMAT(now(),'%Y%m%d')
        		from
        		race_result rr 
        		inner join race r on rr.rac_id=r.rac_id
        		inner join start st on r.st_id=st.st_id
        		inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
        		inner join person per on sn.per_id=per.per_id
        		left join league l on r.lea_id=l.lea_id
        		left join league_group lg on l.leagr_id=lg.leagr_id
        		left join league_group lg1 on r.leagr_id=lg1.leagr_id;";
            break;
        case "":
            $query=";";
            break;
        default:
            $result = queryMysql("delete from table_results where rac_id='$par';");
            $query = "Insert into table_results(rac_id,lea_id,r_leagr_id,l_leagr_id,rac_lea_add,per_id,
        		st_id,sn_id,sco_id,sco,res_fin_time,res_fin_time_sec,
        		activity,date) 
        		SELECT distinct 
        		r.rac_id, r.lea_id, 
        		r.leagr_id, l.leagr_id,
        		r.rac_lea_add, 
        		per.per_id as per_id, 
        		r.st_id, rr.sn_id,
        		l.sco_id, 0, 
        		res_fin_time, res_fin_time_sec, 
        		'D', DATE_FORMAT(now(),'%Y%m%d')
        		from
        		race_result rr 
        		inner join race r on rr.rac_id=r.rac_id
        		inner join start st on r.st_id=st.st_id
        		inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
        		inner join person per on sn.per_id=per.per_id
        		left join league l on r.lea_id=l.lea_id
        		left join league_group lg on l.leagr_id=lg.leagr_id
        		left join league_group lg1 on r.leagr_id=lg1.leagr_id
                where rr.rac_id='$par'";  
            break;
    }
    
    $result = queryMysql($query);

    if($par == "all") return "1";
    
    //$row = mysqli_fetch_row($result);   
    
    $query = "select sco_id,tab_id,per_sex,res_fin_time  from table_results tr
        inner join person per on tr.per_id=per.per_id
        where rac_id=$par
        order by per_sex desc,res_fin_time";
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));    
    
    if($num<1) return "0";
    
    $query2 = "select sco_id from table_results
        where rac_id=$par";
    $result2 = queryMysql($query2);
    $row2 = mysqli_fetch_row($result2);
    if($row2[0] == null) return "2";
    $sco_sys = get_scores($row2[0]);
    
    $sex=null;
    $t=true;
    $br=0;
    
    for($i=0;$i<$num;$i++){
        $row = mysqli_fetch_row($result);
        if($sex != null && $sex != $row[2] && $t){
            $t=false;
            $br=$i;
        }
        $red=$i-$br;
        $query2 = "update table_results set sco='$sco_sys[$red]' 
            where tab_id=$row[1];";
        //echo $query2 . "<br/>";
        $result2 = queryMysql($query2);
    
        $sex=$row[2];
    }            
    
    return "1";
}

function resultString2Long($result, $miliseconds)
{
    $milis = $miliseconds ? 1000 : 1;
    $parts = explode(":", $result);
    if(count($parts) == 2)
        $noviResLong = $milis * ($parts[0]*60 + $parts[1]);
    else if(count($parts)  == 3)
        $noviResLong = $milis * ($parts[0]*60*60 + $parts[1]*60 + $parts[2]);
    else if(count($parts)  == 4)
        $noviResLong = $milis * ($parts[0]*60*60*24 + $parts[1]*60*60 + $parts[2]*60 + $parts[3]);
    else
        $noviResLong = $milis * ($parts[0]*60*60 + $parts[1]*60 + $parts[2]);
    
    return $noviResLong;
}

function resultLong2String($result, $miliseconds)
{
    $milis = $miliseconds ? 1000 : 1;
    $days = floor($result >= $milis*60*60*24 ? $result / $milis*60*60*24 : 0); 
    $hours = floor($result >= $milis*60*60 ? ($result - $milis*60*60*24*$days) / $milis*60*60 : 0); 
    $min = floor($result >= $milis*60 ? ($result - $milis*60*60*$hours) / ($milis*60) : 0);
    $sec = floor($result - $milis*60*60*$hours - $milis*60*$min) / $milis;
           
	$vrijemeRucno = $days > 0 ? substr("00" . $days, strlen("00" . $days) - 2, 
			 strlen("00" . $days)) . ":" : "";
            
	$vrijemeRucno .= 
	            substr("00" . $hours, strlen("00" . $hours) - 2, strlen("00" . $hours)) 
                    . ":" .
	            substr("00" . $min, strlen("00" . $min) - 2, strlen("00" . $min)) 
                    . ":" .
	            substr("00" . $sec, strlen("00" . $sec) - 2, strlen("00" . $sec));
	return $vrijemeRucno;
}
        
function fix_results($all)
{
    if($all)
        $query = "select res_id, res_fin_time, res_fin_time_sec from race_result";
    else
        $query = "select res_id, res_fin_time, res_fin_time_sec from race_result
            where res_fin_time_sec = '' or res_fin_time_sec is null";
        
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));    
    
    for($i=0;$i<$num;$i++){
        $row = mysqli_fetch_row($result);    
        $noviResLong = resultString2Long($row[1], false);         
        if($all)
        {
            if($noviResLong != $row[2])
            {
                $query2 = "update race_result set res_fin_time_sec=$noviResLong
                    where res_id=$row[0];";
                //echo $query2;
                $result2 = queryMysql($query2);
            }         
        }
        else
        {
            $query2 = "update race_result set res_fin_time_sec=$noviResLong
                where res_id=$row[0];";
            //echo $query2;
            $result2 = queryMysql($query2);  
        }
    }   

    if($all)
        $query = "select res_id, res_fin_time, res_fin_time_sec from race_result";
    else
        $query = "select res_id, res_fin_time, res_fin_time_sec from race_result
            where res_fin_time = '' or res_fin_time is null";
        
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));    
    
    for($i=0;$i<$num;$i++){
        $row = mysqli_fetch_row($result);       
  		$noviResString = resultLong2String($row[2], false);       
        if($all)
        {    
            if($noviResString != $row[1])
            {
                $query2 = "update race_result set res_fin_time='$noviResString'
                    where res_id=$row[0];";
                //echo $query2;
                $result2 = queryMysql($query2);
            }     
        }
        else
        {
            $query2 = "update race_result set res_fin_time='$noviResString'
                where res_id=$row[0];";
            //echo $query2;
            $result2 = queryMysql($query2);  
        }
    }  
}

function get_scores($sco_id){
    
    $query = "select sco_sys from scoring where sco_id='$sco_id'";
    $result = queryMysql($query);
    $row = mysqli_fetch_row($result);
    
    $sys=$row[0];
    //print_r(explode(',', $sys));
    $arr=explode(',', $sys);
    $sco_system=array();
    $prev=$arr[0];
    for($i=0;$i<count($arr);$i++){
        $curr=$arr[$i];
        if(strpos($curr, "x") != FALSE){
            $diff = str_replace("x", $curr, "");
            $sco_system[$i] = $prev < $diff ? 1 : $prev - $diff;
        }
        elseif($curr == "..."){
            $sco_system[$i] = $prev == 1 ? 1 : $prev - 1;
        }
        else{
            $sco_system[$i] = $curr;
        }
        
        $prev=$sco_system[$i];
    }
    
    if($curr == "..."){
        $i -= 1;
        $tmp = $sco_system[$i];
        while($tmp>1){
            $i += 1;
            $sco_system[$i] = $tmp - 1;
            $tmp = $sco_system[$i];
        }
    }
    
//    foreach($sco_system as $key => $value)
//    {
//      echo $key.". = ". $value. ", ";
//    }
    return $sco_system;
    
    }
?>

<script language="javascript" type="text/javascript">

function ajaxGetComponent(type, id)
{
    var ajaxRequest; 
	
    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer Browsers
        try
        {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) 
        {
            try
            {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('ajaxDiv');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }

    //$('#doc-container').hide();
    //$('#loading_spinner').show();
    switch(type)
    {
        case "race":
            ajaxRequest.open("GET", "get_race_info.php?race=" + id, false);
            break;
        case "league":
            ajaxRequest.open("GET", "get_league_info.php?league=" + id, false);
            break;
        case "league_gr":
            ajaxRequest.open("GET", "get_league_info.php?league_gr=" + id, false);
            break;
        case "racer":
            ajaxRequest.open("GET", "get_racer_info.php?racer=" + id, false);
            break;
        default:
            ajaxRequest.open("GET", "get_race_info.php?race=" + id, false);
            break;
    }
    ajaxRequest.send(null);
    //$('#loading_spinner').hide();
    //$('#doc-container').show();
    $('#news').remove();
}

</script>