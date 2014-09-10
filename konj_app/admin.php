<?php 
ob_start(); 
  
require_once "components.php"; 
include_once 'head.php'; 
  
 //echo isset($_GET['race']) ? $_GET['race'] : 'wtf'; 
if(!isset($_SESSION['user'])){ 
    header("Location: index"); 
    } 
            
//if(isset($_GET['race'])) 
//    $raceID=$_GET['race'];
      
$_SESSION['active_tab']="admin"; 
  
$page=''; 
  
if($page == '' && isset($_GET['participant'])){ 
    $page='participant';   
    $pageID=$_GET['participant'];   
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
	
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from person where per_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['participant']);
            session_participant_unset(); 
            header("Location: admin?participant=");
            }
    }
	 
    if(isset($_POST['participant_nam'])) 
        $_SESSION['participant_nam'] = $_POST['participant_nam']; 
    if(isset($_POST['participant_sur']))     
        $_SESSION['participant_sur'] = $_POST['participant_sur']; 
    if(isset($_POST['participant_god_rodj'])) 
        $_SESSION['participant_god_rodj'] = $_POST['participant_god_rodj']; 
    if(isset($_POST['participant_dat_rodj'])) 
        $_SESSION['participant_dat_rodj'] = $_POST['participant_dat_rodj']; 
    if(isset($_POST['participant_sex'])) 
        $_SESSION['participant_sex'] = $_POST['participant_sex']; 
    if(isset($_POST['participant_mob'])) 
        $_SESSION['participant_mob'] = $_POST['participant_mob']; 
    if(isset($_POST['participant_club'])) 
        $_SESSION['participant_club'] = $_POST['participant_club']; 
    if(isset($_POST['participant_email'])) 
        $_SESSION['participant_email'] = $_POST['participant_email']; 
    if(isset($_POST['participant_activity'])) 
        $_SESSION['participant_activity'] = strtoupper($_POST['participant_activity']) == "D" ? "D" : "N"; 
              
    if($pageID == "new" && isset($_POST['participant_nam']) && 
        isset($_POST['participant_sur']) && 
        isset($_POST['participant_god_rodj']) && 
        isset($_POST['participant_dat_rodj']) && 
        isset($_POST['participant_sex']) && 
        isset($_POST['participant_mob']) && 
        isset($_POST['participant_club']) && 
        isset($_POST['participant_email'])){ 
              
        $query='INSERT INTO person 
            (`clu_id`,`tow_id`,`sta_id`,`per_nam`,`per_sur`,`per_yea`,`per_dat_b`,`per_sex`,`per_adr`, 
            `per_tow`,`per_cou`,`per_sta`,`per_email`,`per_tel`,`per_mob`,`per_shi`,`per_meal`,`activity`,`date`) 
            VALUES 
            (' . $_SESSION['participant_club'] . ', 
            null, 
            null, 
            "' . $_SESSION['participant_nam'] . '", 
            "' . $_SESSION['participant_sur'] . '", 
            "' . $_SESSION['participant_god_rodj'] . '", 
            "' . $_SESSION['participant_dat_rodj'] . '", 
            "' . $_SESSION['participant_sex'] . '", 
            null,null,null,null,"' . $_SESSION['participant_email'] . '",null,
            "' . $_SESSION['participant_mob'] . '",null,null,
            "' . $_SESSION['participant_activity'] . '",
            ' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_participant_unset(); 
        header("Location: admin?participant="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from person where per_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?participant="); 
        } 
    else if ($pageID != '' && isset($_POST['participant_nam']) && 
        isset($_POST['participant_sur']) && 
        isset($_POST['participant_god_rodj']) && 
        isset($_POST['participant_dat_rodj']) && 
        isset($_POST['participant_sex']) && 
        isset($_POST['participant_mob']) && 
        isset($_POST['participant_club']) && 
        isset($_POST['participant_email'])){ 
              
        $query='update person 
            set per_nam = "' . $_SESSION['participant_nam'] . '",  
            per_sur = "' . $_SESSION['participant_sur'] . '",  
            per_yea = "' . $_SESSION['participant_god_rodj'] . '",  
            per_dat_b = "' . $_SESSION['participant_dat_rodj'] . '",  
            per_sex = "' . $_SESSION['participant_sex'] . '",  
            per_mob = "' . $_SESSION['participant_mob'] . '",  
            per_email = "' . $_SESSION['participant_email'] . '",  
            clu_id = ' . $_SESSION['participant_club'] . ',
            activity = "' . $_SESSION['participant_activity'] . '",
            date = ' . get_DB_time() . '
            where per_id='.$pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_participant_unset(); 
        header("Location: admin?participant="); 
        } 
} 
  
if($page == '' && isset($_GET['club']))
{ 
    $page='club';   
    $pageID=$_GET['club']; 
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
            
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from club where clu_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['club']);
            session_club_unset(); 
            header("Location: admin?club=");
            }
    }
	
    if(isset($_POST['club_nam'])) 
        $_SESSION['club_nam'] = $_POST['club_nam']; 
    if(isset($_POST['club_nams']))     
        $_SESSION['club_nams'] = $_POST['club_nams']; 
    if(isset($_POST['club_adr'])) 
        $_SESSION['club_adr'] = $_POST['club_adr']; 
    if(isset($_POST['club_tow'])) 
        $_SESSION['club_tow'] = $_POST['club_tow']; 
    if(isset($_POST['club_cou'])) 
        $_SESSION['club_cou'] = $_POST['club_cou']; 
    if(isset($_POST['club_sta'])) 
        $_SESSION['club_sta'] = $_POST['club_sta']; 
    if(isset($_POST['club_web'])) 
        $_SESSION['club_web'] = $_POST['club_web']; 
    if(isset($_POST['club_email'])) 
        $_SESSION['club_email'] = $_POST['club_email']; 
    if(isset($_POST['club_tel'])) 
        $_SESSION['club_tel'] = $_POST['club_tel']; 
    if(isset($_POST['club_tel2'])) 
        $_SESSION['club_tel2'] = $_POST['club_tel2']; 
    if(isset($_POST['club_fax'])) 
        $_SESSION['club_fax'] = $_POST['club_fax']; 
    if(isset($_POST['club_mob'])) 
        $_SESSION['club_mob'] = $_POST['club_mob']; 
    if(isset($_POST['club_mob2'])) 
        $_SESSION['club_mob2'] = $_POST['club_mob2']; 
    if(isset($_POST['club_acc'])) 
        $_SESSION['club_acc'] = $_POST['club_acc']; 
    if(isset($_POST['club_acc2'])) 
        $_SESSION['club_acc2'] = $_POST['club_acc2']; 
    if(isset($_POST['club_activity'])) 
        $_SESSION['club_activity'] = strtoupper($_POST['club_activity']) == "D" ? "D" : "N"; 
            
    if($pageID == "new" && isset($_POST['club_nam']) && 
        isset($_POST['club_nams']) && 
        isset($_POST['club_adr']) && 
        isset($_POST['club_tow']) && 
        isset($_POST['club_cou']) && 
        isset($_POST['club_sta']) && 
        isset($_POST['club_web']) && 
        isset($_POST['club_email']) && 
        isset($_POST['club_tel']) && 
        isset($_POST['club_tel2']) && 
        isset($_POST['club_fax']) && 
        isset($_POST['club_mob']) && 
        isset($_POST['club_mob2']) && 
        isset($_POST['club_acc']) && 
        isset($_POST['club_acc2'])){ 
  
        $query='INSERT INTO club 
            (`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
            `clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`) 
            VALUES 
            (null, 
            null, 
            null, 
            "' . $_SESSION['club_nam'] . '", 
            "' . $_SESSION['club_nams'] . '", 
            "' . $_SESSION['club_adr'] . '", 
            "' . $_SESSION['club_tow'] . '", 
            "' . $_SESSION['club_cou'] . '", 
            "' . $_SESSION['club_sta'] . '", 
            "' . $_SESSION['club_web'] . '", 
            "' . $_SESSION['club_email'] . '", 
            "' . $_SESSION['club_tel'] . '", 
            "' . $_SESSION['club_tel2'] . '", 
            "' . $_SESSION['club_fax'] . '", 
            "' . $_SESSION['club_mob'] . '", 
            "' . $_SESSION['club_mob2'] . '", 
            "' . $_SESSION['club_acc'] . '", 
            "' . $_SESSION['club_acc2'] . '", 
            "' . $_SESSION['club_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_club_unset(); 
        header("Location: admin?club="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from club where clu_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?club="); 
        } 
    else if ($pageID != '' && isset($_POST['club_nam']) && 
        isset($_POST['club_nams']) && 
        isset($_POST['club_adr']) && 
        isset($_POST['club_tow']) && 
        isset($_POST['club_cou']) && 
        isset($_POST['club_sta']) && 
        isset($_POST['club_web']) && 
        isset($_POST['club_email']) && 
        isset($_POST['club_tel']) && 
        isset($_POST['club_tel2']) && 
        isset($_POST['club_fax']) && 
        isset($_POST['club_mob']) && 
        isset($_POST['club_mob2']) && 
        isset($_POST['club_acc']) && 
        isset($_POST['club_acc2']))
	{        
        $query='update club 
            set clu_nam = "' . $_SESSION['club_nam'] . '",  
            clu_nams = "' . $_SESSION['club_nams'] . '",  
            clu_adr = "' . $_SESSION['club_adr'] . '",  
            clu_tow = "' . $_SESSION['club_tow'] . '",  
            clu_cou = "' . $_SESSION['club_cou'] . '",  
            clu_sta = "' . $_SESSION['club_sta'] . '", 
            clu_web = "' . $_SESSION['club_web'] . '",  
            clu_email = "' . $_SESSION['club_email'] . '",  
            clu_tel = "' . $_SESSION['club_tel'] . '",  
            clu_tel2 = "' . $_SESSION['club_tel2'] . '",  
            clu_fax = "' . $_SESSION['club_fax'] . '",  
            clu_mob = "' . $_SESSION['club_mob'] . '",  
            clu_mob2 = "' . $_SESSION['club_mob2'] . '",  
            clu_acc = "' . $_SESSION['club_acc'] . '",   
            clu_acc2 = "' . $_SESSION['club_acc2'] . '",
            activity = "' . $_SESSION['club_activity']. '",
            date = ' . get_DB_time() . '
            where clu_id='.$pageID . ';';  
        echo $query; 
        $result = queryMysql($query); 
        session_club_unset(); 
        header("Location: admin?club="); 
    } 
} 
  
if($page == '' && isset($_GET['race'])){ 
    $page='race';   
    $pageID=$_GET['race']; 
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
      
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from race where rac_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0]<1) {
            unset($_GET['race']);
            session_race_unset(); 
            header("Location: admin?race=");
            }
    }
	
    if(isset($_POST['race_nam'])) 
        $_SESSION['race_nam'] = $_POST['race_nam']; 
    if(isset($_POST['race_nams']))     
        $_SESSION['race_nams'] = $_POST['race_nams']; 
    if(isset($_POST['race_fr_dat'])) 
        $_SESSION['race_fr_dat'] = $_POST['race_fr_dat']; 
    if(isset($_POST['race_to_dat'])) 
        $_SESSION['race_to_dat'] = $_POST['race_to_dat']; 
    if(isset($_POST['race_start_dat'])) 
        $_SESSION['race_start_dat'] = $_POST['race_start_dat']; 
    if(isset($_POST['race_kmh'])) 
        $_SESSION['race_kmh'] = $_POST['race_kmh']; 
    if(isset($_POST['race_kmv'])) 
        $_SESSION['race_kmv'] = $_POST['race_kmv']; 
    if(isset($_POST['race_ent_fee'])) 
        $_SESSION['race_ent_fee'] = $_POST['race_ent_fee'];  
    $_SESSION['race_shirt'] = isset($_POST['race_shirt']) ? "D" : "N"; 
    $_SESSION['race_water'] = isset($_POST['race_water']) ? "D" : "N"; 
    $_SESSION['race_drink'] = isset($_POST['race_drink']) ? "D" : "N"; 
    $_SESSION['race_eat'] = isset($_POST['race_eat']) ? "D" : "N"; 
    $_SESSION['race_fraid'] = isset($_POST['race_fraid']) ? "D" : "N";
    $_SESSION['race_chk'] = isset($_POST['race_chk']) ? "D" : "N"; 
    $_SESSION['race_meal'] = isset($_POST['race_meal']) ? "D" : "N"; 
    $_SESSION['race_rs'] = isset($_POST['race_rs']) ? "D" : "N"; 
    $_SESSION['race_chrono'] = isset($_POST['race_chrono']) ? "D" : "N"; 
    if(isset($_POST['race_reg_fr_dat'])) 
        $_SESSION['race_reg_fr_dat'] = $_POST['race_reg_fr_dat']; 
    if(isset($_POST['race_reg_to_dat'])) 
        $_SESSION['race_reg_to_dat'] = $_POST['race_reg_to_dat']; 
    if(isset($_POST['race_desc'])) 
        $_SESSION['race_desc'] = $_POST['race_desc']; 
    if(isset($_POST['race_rul'])) 
        $_SESSION['race_rul'] = $_POST['race_rul']; 
    if(isset($_POST['race_ent_fee'])) 
        $_SESSION['race_ent_fee'] = $_POST['race_ent_fee']; 
    if(isset($_POST['race_lea_rou'])) 
        $_SESSION['race_lea_rou'] = $_POST['race_lea_rou'];
    if(isset($_POST['race_man_eq'])) 
        $_SESSION['race_man_eq'] = $_POST['race_man_eq']; 
    if(isset($_POST['race_club'])) 
        $_SESSION['race_club'] = $_POST['race_club']; 
    if(isset($_POST['race_league'])) 
        $_SESSION['race_league'] = $_POST['race_league']; 
    if(isset($_POST['race_league_group'])) 
        $_SESSION['race_league_group'] = $_POST['race_league_group']; 
    if(isset($_POST['race_st_num'])) 
        $_SESSION['race_st_num'] = $_POST['race_st_num']; 
    if(isset($_POST['race_activity'])) 
        $_SESSION['race_activity'] = strtoupper($_POST['race_activity']) == "D" ? "D" : "N"; 
  
    if($pageID == "new" && isset($_POST['race_nam']) && 
        isset($_POST['race_nams']) && 
        isset($_POST['race_fr_dat']) && 
        isset($_POST['race_to_dat'])){ 
        
        //ako je nova utrka i nema zadane st. brojeve, kreiraj nove st. brojeve
        if($pageID == "new" && $_SESSION['race_st_num'] == "null")
        {
            $query='INSERT INTO start (`st_typ`,`st_nam`,`activity`,`date`) 
            VALUES ("1", "' . $_SESSION['race_nam'] . '", "D",' . get_DB_time() . ');';  
            echo $query . '\r\n'; 
            $result = queryMysql($query);
            $query='select ifnull(max(st_id),1) from start;';  
            echo $query . '\r\n'; 
            $result = queryMysql($query);
            $row = mysqli_fetch_row($result);
            $_SESSION['race_st_num'] = $row[0];
        } 
        
        $query='INSERT INTO race(`rac_typ_id`,`lea_id`,`leagr_id`,`val_id`,`org_id`,`st_id`,`rac_lea_add`,`rac_typ_add`, 
            `rac_nam`,`rac_nams`,`rac_fr_dat`,`rac_to_dat`,`rac_start_dat`,`rac_limit_dat`,`rac_chrono`,`rac_kmH`,`rac_kmHD`,`rac_kmV`, 
            `rac_kmVD`,`rac_ent_fee`,`rac_ent_fee_val`,`rac_shirt`,`rac_water`,`rac_drink`,`rac_eat`,`rac_rs`,`rac_fraid`,`rac_reg_fr_dat`, 
            `rac_reg_to_dat`,`rac_desc`,`rac_rul`,`rac_man_eq`,`rac_chk`,`rac_lea_rou`,`rac_meal`, 
            `activity`,`date`) 
            VALUES 
            (1, 
            ' . $_SESSION['race_league'] . ', 
            ' . $_SESSION['race_league_group'] . ', 
            null, 
            ' . $_SESSION['race_club'] . ', 
            ' . $_SESSION['race_st_num'] . ',null,null, 
            "' . $_SESSION['race_nam'] . '", 
            "' . $_SESSION['race_nams'] . '", 
            "' . $_SESSION['race_fr_dat'] . '", 
            "' . $_SESSION['race_to_dat'] . '", 
            ' . ($_SESSION['race_start_dat'] == '' ? "null" : ('"' . $_SESSION['race_start_dat'] . '"')) . ', null, 
            "' . $_SESSION['race_chrono'] . '",
            ' . ($_SESSION['race_kmh'] == '' ? 0 : $_SESSION['race_kmh']) . ',null, 
            ' . ($_SESSION['race_kmv'] == '' ? 0 : $_SESSION['race_kmv']) . ',null, 
            ' . ($_SESSION['race_ent_fee'] == '' ? 0 : $_SESSION['race_ent_fee']) . ',null, 
            "' . $_SESSION['race_shirt'] . '", 
            "' . $_SESSION['race_water'] . '", 
            "' . $_SESSION['race_drink'] . '", 
            "' . $_SESSION['race_eat'] . '", 
            "' . $_SESSION['race_rs'] . '", 
            "' . $_SESSION['race_fraid'] . '", 
            ' . ($_SESSION['race_reg_fr_dat'] == '' ? "null" : ('"' . $_SESSION['race_reg_fr_dat'] . '"')) . ', 
            ' . ($_SESSION['race_reg_to_dat'] == '' ? "null" : ('"' . $_SESSION['race_reg_to_dat'] . '"')) . ', 
            "' . $_SESSION['race_desc'] . '", 
            "' . $_SESSION['race_rul'] . '", 
            "' . $_SESSION['race_man_eq'] . '", 
            "' . $_SESSION['race_chk'] . '",
            ' . ($_SESSION['race_lea_rou'] == '' ? "null" : $_SESSION['race_lea_rou']) . ', 
            "' . $_SESSION['race_meal'] . '", 
            "' . $_SESSION['race_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query);
        session_race_unset(); 
        
        header("Location: admin?race="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from race where rac_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?race="); 
        } 
    else if ($pageID != '' && isset($_POST['race_nam']) && 
        isset($_POST['race_nams']) && 
        isset($_POST['race_fr_dat']) && 
        isset($_POST['race_to_dat'])){ 
              
        $query='update race 
            set rac_nam = "' . $_SESSION['race_nam'] . '",  
            rac_nams = "' . $_SESSION['race_nams'] . '",  
            rac_fr_dat = "' . $_SESSION['race_fr_dat'] . '",  
            rac_to_dat = "' . $_SESSION['race_to_dat'] . '",  
            rac_start_dat = ' . ($_SESSION['race_start_dat'] == '' ? "null" : ('"' . $_SESSION['race_start_dat'] . '"')) . ',  
            rac_kmh = ' . ($_SESSION['race_kmh'] == '' ? 0 : $_SESSION['race_kmh']) . ',  
            rac_kmv = ' . ($_SESSION['race_kmv'] == '' ? 0 : $_SESSION['race_kmv']) . ', 
            rac_ent_fee = ' . ($_SESSION['race_ent_fee'] == '' ? 0 : $_SESSION['race_ent_fee']) . ', 
            rac_shirt = "' . $_SESSION['race_shirt'] . '",  
            rac_water = "' . $_SESSION['race_water'] . '",  
            rac_drink = "' . $_SESSION['race_drink'] . '",  
            rac_eat = "' . $_SESSION['race_eat'] . '",  
            rac_rs = "' . $_SESSION['race_rs'] . '",  
            rac_fraid = "' . $_SESSION['race_fraid'] . '",  
            rac_reg_fr_dat = ' . ($_SESSION['race_reg_fr_dat'] == '' ? "null" : ('"' . $_SESSION['race_reg_fr_dat'] . '"')) . ',  
            rac_reg_to_dat = ' . ($_SESSION['race_reg_to_dat'] == '' ? "null" : ('"' . $_SESSION['race_reg_to_dat'] . '"')) . ',  
            rac_desc = "' . $_SESSION['race_desc'] . '",  
            rac_rul = "' . $_SESSION['race_rul'] . '",  
            rac_man_eq = "' . $_SESSION['race_man_eq'] . '",  
            rac_chk = "' . $_SESSION['race_chk'] . '",  
            rac_meal = "' . $_SESSION['race_meal'] . '", 
            rac_chrono = "' . $_SESSION['race_chrono'] . '", 
            rac_lea_rou = ' . ($_SESSION['race_lea_rou'] == '' ? "null" : $_SESSION['race_lea_rou']) . ',
            org_id = ' . $_SESSION['race_club'] . ', 
            lea_id = ' . $_SESSION['race_league'] . ',
            leagr_id = ' . $_SESSION['race_league_group'] . ',
            st_id = ' . $_SESSION['race_st_num'] . ',
            activity = "' . $_SESSION['race_activity'] . '",
            date = ' . get_DB_time() . '
            where rac_id = '.$pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_race_unset(); 
        header("Location: admin?race="); 
        } 
}     

if($page == '' && isset($_GET['checkpoint'])){ 
    $page='checkpoint';   
    $pageID=$_GET['checkpoint'];
    $delID=isset($_GET['id']) ? $_GET['id'] : '';
    $chkID=isset($_GET['chk']) ? $_GET['chk'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
	$chkID = sanitizeString($chkID);
      
    if($pageID == -1){
        unset($_SESSION['checkpoint_race']);
        header("Location: admin?checkpoint=");
        } 
    
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from race where rac_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['checkpoint']);
            session_checkpoint_unset(); 
            header("Location: admin?checkpoint=");
            }
    }
	
    if(isset($_POST['checkpoint_race'])) 
        $_SESSION['checkpoint_race'] = $_POST['checkpoint_race'];
    if(isset($_POST['checkpoint_race'])) 
        $_SESSION['checkpoint_race'] = $_POST['checkpoint_race'];
    if(isset($_SESSION['checkpoint_race'])) $pageID = $_SESSION['checkpoint_race'];
    if(isset($_POST['checkpoint_naz']))     
        $_SESSION['checkpoint_naz'] = $_POST['checkpoint_naz'];
    if(isset($_POST['checkpoint_nazs']))     
        $_SESSION['checkpoint_nazs'] = $_POST['checkpoint_nazs'];
    if(isset($_POST['checkpoint_kmH']))     
        $_SESSION['checkpoint_kmH'] = $_POST['checkpoint_kmH'];   
    if(isset($_POST['checkpoint_kmV']))     
        $_SESSION['checkpoint_kmV'] = $_POST['checkpoint_kmV']; 
    if(isset($_POST['checkpoint_altV']))     
        $_SESSION['checkpoint_altV'] = $_POST['checkpoint_altV']; 
    if(isset($_POST['checkpoint_desc']))     
        $_SESSION['checkpoint_desc'] = $_POST['checkpoint_desc']; 
      
    $_SESSION['checkpoint_water'] = isset($_POST['checkpoint_water']) ? "D" : "N"; 
    $_SESSION['checkpoint_drink'] = isset($_POST['checkpoint_drink']) ? "D" : "N"; 
    $_SESSION['checkpoint_eat'] = isset($_POST['checkpoint_eat']) ? "D" : "N"; 
    $_SESSION['checkpoint_rs'] = isset($_POST['checkpoint_rs']) ? "D" : "N";     
    $_SESSION['checkpoint_fraid'] = isset($_POST['checkpoint_fraid']) ? "D" : "N";              
    
//    if($pageID == ""){
//        header("Location: admin?checkpoint="); 
//    }        
//    else 
    if($pageID == "new" && isset($_POST['checkpoint_naz']) && 
        isset($_POST['checkpoint_nazs'])){ 
              
        //$query='INSERT INTO race_checkpoint 
        //    (`st_typ`,`st_nam`,`activity`,`date`) 
        //    VALUES 
        //    (' . $_SESSION['st_num_type'] . ', 
        //    "' . $_SESSION['st_num_name'] . '",
        //    "D",' . get_DB_time() . ');'; 
        //echo $query; 
        //$result = queryMysql($query); 
        //session_checkpoint_unset(); 
        header("Location: admin?checkpoint="); 
        } 
    else if ($pageID == "del" && $delID != '' && $chkID == ''){ 
        //$query='delete from race_checkpoint where rac_id='. $delID . ';'; 
        //echo $query; 
        //$result = queryMysql($query); 
        
        header("Location: admin?checkpoint="); 
        } 
    else if ($pageID != '' && isset($_POST['st_num_name']) && 
        isset($_POST['st_num_type'])){
            
        //$query='update race_checkpoint 
        //    set st_nam = "' . $_SESSION['st_num_name'] . '",  
        //    st_typ = ' . $_SESSION['st_num_type'] . ',
        //    date = ' . get_DB_time() . '
        //    where st_id='.$pageID . ' a;'; 
        //echo $query; 
        //$result = queryMysql($query); 
        //session_checkpoint_unset(); 
        header("Location: admin?checkpoint="); 
        }   
    else if ($pageID == "-1"){
        header("Location: admin?checkpoint="); 
    }         
    else if($chkID == "new" && isset($_POST['checkpoint_naz']) && 
        isset($_POST['checkpoint_nazs'])){ 
              
        $query='INSERT INTO race_checkpoint 
            (`rac_id`,`chk_id`,`chk_naz`,`chk_nazs`,`chk_kmH`,`chk_kmV`,`chk_altV`,`chk_desc`,`chk_water`,
            `chk_drink`,`chk_eat`,`chk_rs`,`chk_fraid`,`activity`,`date`)
            VALUES 
            (' . $pageID . ',' . generirajNoviBrojCHK($pageID) . ',
            "' . $_SESSION['checkpoint_naz'] . '", 
            "' . $_SESSION['checkpoint_nazs'] . '",
            ' . ($_SESSION['checkpoint_kmH'] == '' ? 0 : $_SESSION['checkpoint_kmH']) . ',
            ' . ($_SESSION['checkpoint_kmV'] == '' ? 0 : $_SESSION['checkpoint_kmV']) . ',
            ' . ($_SESSION['checkpoint_altV'] == '' ? 0 : $_SESSION['checkpoint_altV']) . ',
            "' . $_SESSION['checkpoint_desc'] . '",
            "' . $_SESSION['checkpoint_water'] . '",
            "' . $_SESSION['checkpoint_drink'] . '",
            "' . $_SESSION['checkpoint_eat'] . '",
            "' . $_SESSION['checkpoint_rs'] . '",
            "' . $_SESSION['checkpoint_fraid'] . '",
            "D",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_checkpoint_unset(); 
        header("Location: admin?checkpoint=" . $pageID); 
        } 
    else if ($chkID == "del" && $delID != ''){ 
        $query='delete from race_checkpoint where chk_id='. $delID . ' and rac_id=' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?checkpoint=" . $pageID); 
        } 
    else if ($chkID != '' && isset($_POST['checkpoint_naz']) && 
        isset($_POST['checkpoint_nazs'])){ 
        $query='update race_checkpoint 
            set chk_naz = "' . $_SESSION['checkpoint_naz'] . '", 
            chk_nazs = "' . $_SESSION['checkpoint_nazs'] . '", 
            chk_kmH = ' . ($_SESSION['checkpoint_kmH'] == '' ? 0 : $_SESSION['checkpoint_kmH']) . ', 
            chk_kmV = ' . ($_SESSION['checkpoint_kmV'] == '' ? 0 : $_SESSION['checkpoint_kmV']) . ', 
            chk_altV = ' . ($_SESSION['checkpoint_altV'] == '' ? 0 : $_SESSION['checkpoint_altV']) . ', 
            chk_desc = "' . $_SESSION['checkpoint_desc'] . '", 
            chk_water = "' . $_SESSION['checkpoint_water'] . '", 
            chk_drink = "' . $_SESSION['checkpoint_drink'] . '", 
            chk_eat = "' . $_SESSION['checkpoint_eat'] . '", 
            chk_rs = "' . $_SESSION['checkpoint_rs'] . '", 
            chk_fraid = "' . $_SESSION['checkpoint_fraid'] . '", 
            activity = "D", date = ' . get_DB_time() . '
            where rac_id=' . $pageID . ' and chk_id=' . $chkID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_checkpoint_unset(); 
        header("Location: admin?checkpoint=" . $pageID); 
        }   
    } 

if($page == '' && isset($_GET['league'])){ 
    $page='league';  
    $pageID=$_GET['league']; 
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
                       
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from league where lea_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['league']);
            session_league_unset(); 
            header("Location: admin?league=");
            }
    }
	 
    if(isset($_POST['league_club'])) 
        $_SESSION['league_club'] = $_POST['league_club']; 
    if(isset($_POST['league_league_group']))     
        $_SESSION['league_league_group'] = $_POST['league_league_group']; 
    if(isset($_POST['league_nam'])) 
        $_SESSION['league_nam'] = $_POST['league_nam']; 
    if(isset($_POST['league_nams'])) 
        $_SESSION['league_nams'] = $_POST['league_nams']; 
    if(isset($_POST['league_fr_dat'])) 
        $_SESSION['league_fr_dat'] = $_POST['league_fr_dat']; 
    if(isset($_POST['league_to_dat'])) 
        $_SESSION['league_to_dat'] = $_POST['league_to_dat']; 
    if(isset($_POST['league_desc'])) 
        $_SESSION['league_desc'] = $_POST['league_desc']; 
    $_SESSION['league_day'] = isset($_POST['league_day']) ? $_POST['league_day'] : 0; 
    if(isset($_POST['league_day_sco']))  
        $_SESSION['league_day_sco'] = $_POST['league_day_sco']; 
    if(isset($_POST['league_rul'])) 
        $_SESSION['league_rul'] = $_POST['league_rul']; 
    if(isset($_POST['league_ent_fee'])) 
        $_SESSION['league_ent_fee'] = $_POST['league_ent_fee']; 
    if(isset($_POST['league_activity'])) 
        $_SESSION['league_activity'] = strtoupper($_POST['league_activity']) == "D" ? "D" : "N"; 
              
    if($pageID == "new" && isset($_POST['league_club']) && 
        isset($_POST['league_league_group']) && 
        isset($_POST['league_nam']) && 
        isset($_POST['league_nams'])){ 
              
        $query='INSERT INTO league 
            (`org_id`,`leagr_id`,sco_id,`lea_nam`,`lea_nams`,`lea_fr_dat`,`lea_to_dat`,`lea_desc`,`lea_day`, 
            `lea_day_sco`,`lea_rul`,`lea_ent_fee`,`activity`,`date`) 
            VALUES 
            (' . $_SESSION['league_club'] . ', 
            ' . $_SESSION['league_league_group'] . ', 
            1, 
            "' . $_SESSION['league_nam'] . '", 
            "' . $_SESSION['league_nams'] . '", 
            ' . ($_SESSION['league_fr_dat'] == '' ? "null" : $_SESSION['league_fr_dat']) . ', , 
            ' . ($_SESSION['league_fr_dat'] == '' ? "null" : $_SESSION['league_to_dat']) . ', , 
            "' . $_SESSION['league_desc'] . '", 
            ' . ($_SESSION['league_day'] == '' ? 0 : $_SESSION['league_day'])  . ', 
            ' . ($_SESSION['league_day_sco'] == '' ? 0 : $_SESSION['league_day_sco'])  . ', 
            "' . $_SESSION['league_rul'] . '", 
            ' . ($_SESSION['league_ent_fee'] == '' ? 0 : $_SESSION['league_ent_fee'])  . ',
            "' . $_SESSION['league_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_league_unset(); 
        header("Location: admin?league="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from league where lea_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?league="); 
        } 
    else if ($pageID != '' && isset($_POST['league_nam']) && 
        isset($_POST['league_nams'])){ 
              
        $query='update league 
            set lea_nam = "' . $_SESSION['league_nam'] . '",  
            lea_nams = "' . $_SESSION['league_nams'] . '",  
            lea_fr_dat = ' . ($_SESSION['league_fr_dat'] == '' ? "null" : $_SESSION['league_fr_dat']) . ', 
            lea_to_dat = ' . ($_SESSION['league_to_dat'] == '' ? "null" : $_SESSION['league_to_dat']) . ',
            lea_desc = "' . $_SESSION['league_desc'] . '",   
            lea_day = ' . ($_SESSION['league_day'] == '' ? 0 : $_SESSION['league_day']) . ',  
            lea_day_sco = ' . ($_SESSION['league_day_sco'] == '' ? 0 : $_SESSION['league_day_sco'])  . ',  
            lea_rul = "' . $_SESSION['league_rul'] . '",  
            lea_ent_fee = ' . ($_SESSION['league_ent_fee'] == '' ? 0 : $_SESSION['league_ent_fee']) . ',  
            org_id = ' . $_SESSION['league_club'] . ', 
            leagr_id = ' . $_SESSION['league_league_group'] . ',
            activity = "' . $_SESSION['league_activity'] . '",
            date = ' . get_DB_time() . '
            where lea_id = ' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_league_unset(); 
        header("Location: admin?league="); 
        } 
    } 

if($page == '' && isset($_GET['league_group'])){
    $page='league_group';  
    $pageID=$_GET['league_group']; 
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
                           
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from league_group where leagr_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['league_group']);
            session_league_group_unset(); 
            header("Location: admin?league_group=");
            }
    }
	   
    if(isset($_POST['league_group_nams'])) 
        $_SESSION['league_group_nams'] = $_POST['league_group_nams']; 
    if(isset($_POST['league_group_nam']))     
        $_SESSION['league_group_nam'] = $_POST['league_group_nam']; 
    if(isset($_POST['league_group_desc'])) 
        $_SESSION['league_group_desc'] = $_POST['league_group_desc']; 
    if(isset($_POST['league_group_rul'])) 
        $_SESSION['league_group_rul'] = $_POST['league_group_rul']; 
    if(isset($_POST['league_group_club'])) 
        $_SESSION['league_group_club'] = $_POST['league_group_club']; 
    if(isset($_POST['league_group_sco'])) 
        $_SESSION['league_group_sco'] = $_POST['league_group_sco'];
    if(isset($_POST['league_group_activity'])) 
        $_SESSION['league_group_activity'] = strtoupper($_POST['league_group_activity']) == "D" ? "D" : "N"; 
              
    if($pageID == "new" && isset($_POST['league_group_nams']) && 
        isset($_POST['league_group_nam'])){ 
              
        $query='INSERT INTO league_group 
            (`leagr_nam`,`leagr_nams`,`org_id`,sco_id,`leagr_desc`,`leagr_rul`,`activity`,`date`) 
            VALUES 
            ("' . $_SESSION['league_group_nam'] . '", 
            "' . $_SESSION['league_group_nams'] . '", 
            ' . $_SESSION['league_group_club'] . ', 
            ' . $_SESSION['league_group_sco'] . ',
            "' . $_SESSION['league_group_desc'] . '",
            "' . $_SESSION['league_group_rul'] . '",
			"' . $_SESSION['league_group_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_league_group_unset(); 
        header("Location: admin?league_group="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from league_group where leagr_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?league_group="); 
        } 
    else if ($pageID != '' && isset($_POST['league_group_nam']) && 
        isset($_POST['league_group_nams'])){ 
              
        $query='update league_group 
            set leagr_nam = "' . $_SESSION['league_group_nam'] . '",  
            leagr_nams = "' . $_SESSION['league_group_nams'] . '",   
            org_id = ' . $_SESSION['league_group_club'] . ', 
            sco_id = ' . $_SESSION['league_group_sco'] . ',
            leagr_desc = "' . $_SESSION['league_group_desc'] . '",    
            leagr_rul = "' . $_SESSION['league_group_rul'] . '", 
            date = ' . get_DB_time() . ',
			activity = "' . $_SESSION['league_group_activity'] . '"
            where leagr_id = ' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_league_group_unset(); 
        header("Location: admin?league_group="); 
        }
    } 

if($page == '' && isset($_GET['event'])){
    $page='event';  
    $pageID=$_GET['event']; 
	$delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
                               
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from event where eve_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['event']);
            session_event_unset(); 
            header("Location: admin?event=");
            }
    }
	    
    if(isset($_POST['event_nam'])) 
        $_SESSION['event_nam'] = $_POST['event_nam']; 
    if(isset($_POST['event_nams']))     
        $_SESSION['event_nams'] = $_POST['event_nams']; 
    if(isset($_POST['event_fr_dat'])) 
        $_SESSION['event_fr_dat'] = $_POST['event_fr_dat']; 
    if(isset($_POST['event_to_dat'])) 
        $_SESSION['event_to_dat'] = $_POST['event_to_dat']; 
    if(isset($_POST['event_start_dat'])) 
        $_SESSION['event_start_dat'] = $_POST['event_start_dat']; 
    if(isset($_POST['event_limit_dat'])) 
        $_SESSION['event_limit_dat'] = $_POST['event_limit_dat']; 
    if(isset($_POST['event_rac'])) 
        $_SESSION['event_rac'] = $_POST['event_rac']; 
    if(isset($_POST['event_rul']))  
        $_SESSION['event_rul'] = $_POST['event_rul']; 
    if(isset($_POST['event_desc'])) 
        $_SESSION['event_desc'] = $_POST['event_desc']; 
    if(isset($_POST['event_club'])) 
        $_SESSION['event_club'] = $_POST['event_club']; 
    if(isset($_POST['event_activity'])) 
        $_SESSION['event_activity'] = strtoupper($_POST['event_activity']) == "D" ? "D" : "N"; 
              
    if($pageID == "new" && isset($_POST['event_nam']) && 
        isset($_POST['event_nams'])){ 
              
        $query='INSERT INTO event 
            (`org_id`,`eve_nam`,`eve_nams`,`eve_fr_dat`,`eve_to_dat`,`eve_start_dat`, `eve_limit_dat`, 
            `eve_rac`,`eve_rul`,`eve_desc`,`activity`,`date`) 
            VALUES 
            (' . $_SESSION['event_club'] . ', 
            "' . $_SESSION['event_nam'] . '", 
            "' . $_SESSION['event_nams'] . '", 
            ' . ($_SESSION['event_fr_dat'] == '' ? "null" : '"' . $_SESSION['event_fr_dat'] . '"') . ', 
            ' . ($_SESSION['event_to_dat'] == '' ? "null" : '"' . $_SESSION['event_to_dat'] . '"') . ', 
            ' . ($_SESSION['event_start_dat'] == '' ? "null" : '"' . $_SESSION['event_start_dat'] . '"') . ', 
            ' . ($_SESSION['event_limit_dat'] == '' ? "null" : '"' . $_SESSION['event_limit_dat'] . '"') . ', 
            "' . $_SESSION['event_rac'] . '", 
            "' . $_SESSION['event_rul'] . '", 
            "' . $_SESSION['event_desc'] . '", 
            "' . $_SESSION['event_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_event_unset(); 
        header("Location: admin?event="); 
        } 
    else if ($pageID == "del" && $delID != ''){ 
        $query='delete from event where eve_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?event="); 
        } 
    else if ($pageID != '' && isset($_POST['event_nam']) && 
        isset($_POST['event_nams'])){ 
              
        $query='update event 
            set org_id = ' . $_SESSION['event_club'] . ',  
            eve_nam = "' . $_SESSION['event_nam'] . '",  
            eve_nams = "' . $_SESSION['event_nams'] . '",  
            eve_fr_dat = ' . ($_SESSION['event_fr_dat'] == '' ? "null" : '"' . $_SESSION['event_fr_dat'] . '"') . ',  
            eve_to_dat = ' . ($_SESSION['event_to_dat'] == '' ? "null" : '"' . $_SESSION['event_to_dat'] . '"') . ',   
            eve_start_dat = ' . ($_SESSION['event_start_dat'] == '' ? "null" : '"' . $_SESSION['event_start_dat'] . '"') . ',   
            eve_limit_dat = ' . ($_SESSION['event_limit_dat'] == '' ? "null" : '"' . $_SESSION['event_limit_dat'] . '"') . ',   
            eve_rac = "' . $_SESSION['event_rac'] . '",   
            eve_rul = "' . $_SESSION['event_rul'] . '",   
            eve_desc = "' . $_SESSION['event_desc'] . '",     
            date = ' . get_DB_time() . ',
			activity = "' . $_SESSION['event_activity'] . '"
            where eve_id = ' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_event_unset(); 
        header("Location: admin?event="); 
        } 
    } 

if($page == '' && isset($_GET['st_num'])){ 
    $page='st_num';   
    $pageID=$_GET['st_num'];   
    $delID=isset($_GET['id']) ? $_GET['id'] : '';
    $snID=isset($_GET['sn']) ? $_GET['sn'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
	$snID = sanitizeString($snID);
      
    if(isset($_POST['st_num_name'])) 
        $_SESSION['st_num_name'] = $_POST['st_num_name'];
    if(isset($_POST['st_num_type']))     
        $_SESSION['st_num_type'] = $_POST['st_num_type'];
    if(isset($_POST['st_num_sn_par']))     
        $_SESSION['st_num_sn_par'] = $_POST['st_num_sn_par'];
    if(isset($_POST['st_num_sn']))     
        $_SESSION['st_num_sn'] = $_POST['st_num_sn'];   
    if(isset($_POST['st_num_activity'])) 
        $_SESSION['st_num_activity'] = strtoupper($_POST['st_num_activity']) == "D" ? "D" : "N";        
                     
    if($pageID == "new" && isset($_POST['st_num_name']) && 
        isset($_POST['st_num_type'])){ 
              
        $query='INSERT INTO start 
            (`st_typ`,`st_nam`,`activity`,`date`) 
            VALUES 
            (' . $_SESSION['st_num_type'] . ', 
            "' . $_SESSION['st_num_name'] . '",
            "' . $_SESSION['st_num_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?st_num="); 
        } 
    else if ($pageID == "del" && $delID != '' && $snID == ''){  
        $query='delete from start where st_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?st_num="); 
        } 
    else if ($pageID != '' && isset($_POST['st_num_name']) && 
        isset($_POST['st_num_type'])){ 
            
        $query='update start 
            set st_nam = "' . $_SESSION['st_num_name'] . '",  
            st_typ = ' . $_SESSION['st_num_type'] . ',
            activity = "' . $_SESSION['st_num_activity'] . '",
            date = ' . get_DB_time() . '
            where st_id='.$pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?st_num="); 
        }               
    else if($snID == "new" && isset($_POST['st_num_sn']) && 
        isset($_POST['st_num_sn_par'])){ 
              
        $query='INSERT INTO st_num 
            (st_id,`sn_id`,`per_id`,`activity`,`date`) 
            VALUES 
            (' . $pageID . ',
            ' . $_SESSION['st_num_sn'] . ', 
            ' . $_SESSION['st_num_sn_par'] . ',
            "D",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?st_num=" . $pageID); 
        } 
    else if ($snID == "del" && $delID != ''){ 
        $query='delete from st_num where sn_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?st_num=" . $pageID); 
        } 
    else if ($snID != '' && isset($_POST['st_num_sn_par']) && 
        isset($_POST['st_num_sn_par'])){ 
        $query='update st_num 
            set per_id = "' . $_SESSION['st_num_sn_par'] . '",  
            date = ' . get_DB_time() . '
            where st_id=' . $pageID . ' and sn_id=' . $snID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?st_num=" . $pageID); 
        }   
    } 

if($page == '' && isset($_GET['results'])){ 
    $page='results';   
    $pageID=$_GET['results'];  
    $delID=isset($_GET['id']) ? $_GET['id'] : '';
    $resID=isset($_GET['res']) ? $_GET['res'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
	$resID = sanitizeString($resID);
      
    if(isset($_POST['results_sn_id'])) 
        $_SESSION['results_sn_id'] = $_POST['results_sn_id'];
    if(isset($_POST['results_per_sn_id'])) 
        $_SESSION['results_per_sn_id'] = $_POST['results_per_sn_id'];
    if(isset($_POST['results_res_fin_time']))     
        $_SESSION['results_res_fin_time'] = $_POST['results_res_fin_time'];
    if(isset($_POST['results_res_fin_time_sec']))     
        $_SESSION['results_res_fin_time_sec'] = $_POST['results_res_fin_time_sec'];
    if(isset($_POST['results_res_start']))     
        $_SESSION['results_res_start'] = $_POST['results_res_start'];   
    if(isset($_POST['results_res_time']))     
        $_SESSION['results_res_time'] = $_POST['results_res_time'];   
    if(isset($_POST['results_res_transfer_typ']))     
        $_SESSION['results_res_transfer_typ'] = $_POST['results_res_transfer_typ'];   
    if(isset($_POST['results_res_pen']))     
        $_SESSION['results_res_pen'] = $_POST['results_res_pen'];   	
    if(isset($_POST['results_activity'])) 
        $_SESSION['results_activity'] = strtoupper($_POST['results_activity']) == "D" ? "D" : "N";     
			
    if($pageID == "new" && isset($_POST['st_num_name']) && 
        isset($_POST['st_num_type'])){ 
        /*      
        $query='INSERT INTO race_result 
            (`st_typ`,`st_nam`,`activity`,`date`) 
            VALUES 
            (' . $_SESSION['st_num_type'] . ', 
            "' . $_SESSION['st_num_name'] . '",
            "' . $_SESSION['st_num_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?results="); */
        } 
    else if ($pageID == "del" && $delID != '' && $resID == ''){  
        /*$query='delete from race_result where st_id=' . $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?results="); */
        } 
    else if ($pageID != '' && isset($_POST['st_num_name']) && 
        isset($_POST['st_num_type'])){ 
            /*
        $query='update race_result 
            set st_nam = "' . $_SESSION['st_num_name'] . '",  
            st_typ = ' . $_SESSION['st_num_type'] . ',
            activity = "' . $_SESSION['st_num_activity'] . '",
            date = ' . get_DB_time() . '
            where res_id=' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_start_num_unset(); 
        header("Location: admin?results="); */
        }               
    else if($resID == "new" && isset($_POST['results_sn_id']) && 
        isset($_POST['results_sn_id'])){ 
              
        $query='INSERT INTO race_result 
            (rac_id,`sn_id`,`res_chk_id`,`res_fin_time`,`res_fin_time_sec`,`res_start`,`res_time`,
			`res_transfer_typ`,`res_pen`,`activity`,`date`) 
            VALUES 
            (' . $pageID . ',
            ' . $_SESSION['results_sn_id'] . ', null, 
            "' . $_SESSION['results_res_fin_time'] . '",
            ' . $_SESSION['results_res_fin_time_sec'] . ',
            "' . $_SESSION['results_res_start'] . '",
            "' . $_SESSION['results_res_time'] . '",
            "' . $_SESSION['results_res_transfer_typ'] . '",
            "' . $_SESSION['results_res_pen'] . '",
            "D",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_results_unset(); 
        header("Location: admin?results=" . $pageID); 
        } 
    else if ($resID == "del" && $delID != ''){ 
        $query='delete from race_result where res_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?results=" . $pageID); 
        } 
    else if ($resID != '' && isset($_POST['results_sn_id']) && 
        isset($_POST['results_sn_id'])){ 
        $query='update race_result 
            set sn_id = ' . $_SESSION['results_sn_id'] . ', 
			res_pen = "' . $_SESSION['results_res_pen'] . '", 	
			res_fin_time = "' . $_SESSION['results_res_fin_time'] . '", 	
			res_fin_time_sec = ' . $_SESSION['results_res_fin_time_sec'] . ', 	
			res_start = "' . $_SESSION['results_res_start'] . '", 	
			res_time = "' . $_SESSION['results_res_time'] . '", 	
			res_transfer_typ = "' . $_SESSION['results_res_transfer_typ'] . '", 	
			activity = "' . $_SESSION['results_activity'] . '", 	
            date = ' . get_DB_time() . '
            where res_id=' . $resID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_results_unset(); 
        header("Location: admin?results=" . $pageID); 
        }   
    }
 
if($page == '' && isset($_GET['control'])){ 
    $page='control';   
    $pageID=$_GET['control']; 
    $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
            
    if($pageID != "new" && $pageID != "" && $pageID != "del"){
        $query='select ifnull(count(*),0) from control where clu_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) {
            unset($_GET['control']);
            session_control_unset(); 
            header("Location: admin?control=");
            }
    }
	
    if(isset($_POST['club_nam'])) 
        $_SESSION['club_nam'] = $_POST['club_nam']; 
            
    if($pageID == "new" && isset($_POST['club_nam']))
	{ 
        $query='INSERT INTO control 
            (`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
            `clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`) 
            VALUES 
            (null, 
            null, 
            null, 
            "' . $_SESSION['club_nam'] . '", 
            "' . $_SESSION['club_nams'] . '", 
            "' . $_SESSION['club_adr'] . '", 
            "' . $_SESSION['club_tow'] . '", 
            "' . $_SESSION['club_cou'] . '", 
            "' . $_SESSION['club_sta'] . '", 
            "' . $_SESSION['club_web'] . '", 
            "' . $_SESSION['club_email'] . '", 
            "' . $_SESSION['club_tel'] . '", 
            "' . $_SESSION['club_tel2'] . '", 
            "' . $_SESSION['club_fax'] . '", 
            "' . $_SESSION['club_mob'] . '", 
            "' . $_SESSION['club_mob2'] . '", 
            "' . $_SESSION['club_acc'] . '", 
            "' . $_SESSION['club_acc2'] . '", 
            "' . $_SESSION['club_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_club_unset(); 
        header("Location: admin?control="); 
	} 
    else if ($pageID == "del" && $delID != '')
	{ 
        $query='delete from control where clu_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?control="); 
    } 
    else if ($pageID != '' && isset($_POST['club_nam']))
	{     
        $query='update control 
            set clu_nam = "' . $_SESSION['club_nam'] . '",  
            clu_nams = "' . $_SESSION['club_nams'] . '",  
            clu_adr = "' . $_SESSION['club_adr'] . '",  
            clu_tow = "' . $_SESSION['club_tow'] . '",  
            clu_cou = "' . $_SESSION['club_cou'] . '",  
            clu_sta = "' . $_SESSION['club_sta'] . '", 
            clu_web = "' . $_SESSION['club_web'] . '",  
            clu_email = "' . $_SESSION['club_email'] . '",  
            clu_tel = "' . $_SESSION['club_tel'] . '",  
            clu_tel2 = "' . $_SESSION['club_tel2'] . '",  
            clu_fax = "' . $_SESSION['club_fax'] . '",  
            clu_mob = "' . $_SESSION['club_mob'] . '",  
            clu_mob2 = "' . $_SESSION['club_mob2'] . '",  
            clu_acc = "' . $_SESSION['club_acc'] . '",   
            clu_acc2 = "' . $_SESSION['club_acc2'] . '",
            activity = "' . $_SESSION['club_activity']. '",
            date = ' . get_DB_time() . '
            where clu_id='.$pageID . ';';  
        echo $query; 
        $result = queryMysql($query); 
        session_control_unset(); 
        header("Location: admin?control="); 
	} 
} 
  
if($page == '' && isset($_GET['town'])){ 
    $page='town';  
    $pageID=$_GET['town']; 
	$pageID = sanitizeString($pageID);
    } 
if($page == '' && isset($_GET['county'])){ 
    $page='county';  
    $pageID=$_GET['county']; 
	$pageID = sanitizeString($pageID);
    } 
if($page == '' && isset($_GET['country'])){ 
    $page='country';  
    $pageID=$_GET['country']; 
	$pageID = sanitizeString($pageID);
    } 
if($page == '' && isset($_GET['currency']))
{ 
    $page='currency';  
    $pageID=$_GET['currency']; 
	$pageID = sanitizeString($pageID);
} 
if($page == '' && isset($_GET['scoring']))
{
    $page='scoring'; 
    $pageID=$_GET['scoring'];  
	$delID=isset($_GET['id']) ? $_GET['id'] : ''; 
	$pageID = sanitizeString($pageID);
	$delID = sanitizeString($delID);
                                   
    if($pageID != "new" && $pageID != "" && $pageID != "del")
	{
        $query='select ifnull(count(*),0) from scoring where sco_id='. $pageID . ';'; 
        //echo $query; 
        $result = queryMysql($query); 
		$row = mysqli_fetch_row($result); 
        if($row[0] < 1) 
		{
            unset($_GET['scoring']);
            session_scoring_unset(); 
            header("Location: admin?scoring=");
        }
    }
	   
    if(isset($_POST['scoring_nam'])) 
        $_SESSION['scoring_nam'] = $_POST['scoring_nam']; 
    if(isset($_POST['scoring_sys']))     
        $_SESSION['scoring_sys'] = $_POST['scoring_sys']; 
    if(isset($_POST['scoring_desc'])) 
        $_SESSION['scoring_desc'] = $_POST['scoring_desc'];
    if(isset($_POST['scoring_activity'])) 
        $_SESSION['scoring_activity'] = strtoupper($_POST['scoring_activity']) == "D" ? "D" : "N";    
              
    if($pageID == "new" && isset($_POST['scoring_nam']) && 
        isset($_POST['scoring_sys']))
	{ 
              
        $query='INSERT INTO scoring 
            (`sco_nam`,`sco_sys`,sco_desc,`activity`,`date`) 
            VALUES 
            ("' . $_SESSION['scoring_nam'] . '", 
            "' . $_SESSION['scoring_sys'] . '", 
            "' . $_SESSION['scoring_desc'] . '",
			"' . $_SESSION['scoring_activity'] . '",' . get_DB_time() . ');'; 
        echo $query; 
        $result = queryMysql($query); 
        session_scoring_unset(); 
        header("Location: admin?scoring="); 
    } 
    else if ($pageID == "del" && $delID != '')
	{ 
        $query='delete from scoring where sco_id='. $delID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        header("Location: admin?scoring="); 
    } 
    else if ($pageID != '' && isset($_POST['scoring_nam']) && 
        isset($_POST['scoring_sys']))
	{     
        $query='update scoring 
            set sco_nam = "' . $_SESSION['scoring_nam'] . '",  
            sco_sys = "' . $_SESSION['scoring_sys'] . '",   
            sco_desc = "' . $_SESSION['scoring_desc'] . '", 
            date = ' . get_DB_time() . ',
			activity = "' . $_SESSION['scoring_activity'] . '"
            where sco_id = ' . $pageID . ';'; 
        echo $query; 
        $result = queryMysql($query); 
        session_scoring_unset(); 
        header("Location: admin?scoring="); 
    }
} 

if($page == '' && isset($_GET['user']))
{ 
    $page='user';  
    $pageID=$_GET['user']; 
	$pageID = sanitizeString($pageID);
} 

if($page == '' && isset($_GET['role']))
{ 
    $page='role';  
    $pageID=$_GET['role']; 
	$pageID = sanitizeString($pageID);
}  
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
                <li> 
                  <a href="#page-components">Trke...</a> 
                  <ul class="nav" id="races-active"> 
                    <li><a href="admin?race=">Trke</a></li> 
                      <ul class="nav"> 
                        <li><a href="admin?registered=">Registrirani</a></li> 
                        <li><a href="admin?checkpoint=">Checkpoint</a></li> 
                      </ul> 
                    <li><a href="admin?league=">Lige</a></li> 
                    <li><a href="admin?league_group=">Lige-grupe</a></li> 
                    <li><a href="admin?event=">Doga&#273;aji</a></li> 
                    <li><a href="admin?st_num=">Startni brojevi</a></li> 
                  </ul> 
                  <a href="admin?results=">Rezultati</a> 
                  <ul class="nav" id="osnovno-active"> 
                    <li><a href="admin?control=">Kontrola</a></li> 
                  </ul> 
                  <a href="admin?other=">Osnovno</a> 
                  <ul class="nav" id="osnovno-active"> 
                    <li><a href="admin?participant=">Osobe</a></li> 
                    <li><a href="admin?club=">Klubovi</a></li> 
                    <li><a href="admin?town=">Gradovi</a></li> 
                    <li><a href="admin?county=">&#381;upanije</a></li> 
                    <li><a href="admin?country=">Dr&#382;ave</a></li> 
                    <li><a href="admin?currency=">Valute</a></li> 
                    <li><a href="admin?scoring=">Bodovanja</a></li> 
                    <li><a href="admin?user=">Korisnici</a></li> 
                    <li><a href="admin?role=">Role</a></li> 
                  </ul> 
            </ul> 
        </div> 
  
        <div class="bs-docs-container span9" id="welcome"> 
            <div class="bs-docs-section"> 
  
                <?php 
                    switch($page){ 
                        case "checkpoint": 
                            $chkID=isset($_GET['chk']) ? $_GET['chk'] : ''; 
							$chkID = sanitizeString($chkID);
                            get_page_checkpoint($pageID, $chkID);            
                            break; 
                        case "club": 
                            get_page_club($pageID);            
                            break; 
                        case "control": 
                            get_page_control($pageID);            
                            break; 
                        case "county": 
                            get_page_county($pageID);            
                            break; 
                        case "country": 
                            get_page_country($pageID);            
                            break; 
                        case "currency": 
                            get_page_currency($pageID);            
                            break; 
                        case "event": 
                            get_page_event($pageID);            
                            break;  
                        case "league": 
                            get_page_league($pageID);            
                            break; 
                        case "league_group": 
                            get_page_league_group($pageID);            
                            break; 
                        case "participant": 
                            get_page_participant($pageID);            
                            break; 
                        case "race": 
                            get_page_race($pageID);            
                            break; 
                        case "role": 
                            get_page_role($pageID);            
                            break; 
                        case "scoring": 
                            get_page_scoring($pageID);            
                            break; 
                        case "st_num":  
                            $snID=isset($_GET['sn']) ? $_GET['sn'] : ''; 
                            get_page_start_num($pageID, $snID);  
							$snID = sanitizeString($snID);          
                            break; 
                        case "results":  
                            $resID=isset($_GET['res']) ? $_GET['res'] : ''; 
                            get_page_results($pageID, $resID);  
							$resID = sanitizeString($resID);          
                            break;
                        case "town": 
                            get_page_town($pageID);            
                            break; 
                        case "user": 
                            get_page_user($pageID);            
                            break; 
                        default: 
                            get_page_general(); 
                            break; 
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
    </div> 
  
    <?php  
        get_footer()         
    ?> 
</body> 
</html> 
  
<?php  
    function get_page_participant($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_participant_all(); 
                break; 
            case 'new': 
                get_page_participant_edit('new'); 
                break; 
            default: 
                get_page_participant_edit($pageID); 
                break;    
        } 
    }        
    function get_page_participant_all(){ 
        echo
        '<table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT per.per_id, concat(per.per_nam, ' ', per.per_sur) as participant, per_yea,  
            per_dat_b,per_sex,per_mob, clu_nam, c.clu_id, per.activity 
            FROM person per 
            left join club c on per.clu_id=c.clu_id 
            order by per.per_sur"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?participant=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?participant=new"><span aria-hidden="true" class="icon-user-add"></span></a> 
            <br/><br/> 
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span1">R.br.</th> 
                <th class="span1">Osoba</th> 
                <th class="span1">God.</th> 
                <th class="span1">Dat. r.</th> 
                <th class="span1">Spol</th> 
                <th class="span1">Mob.</th> 
                <th class="span2">Klub</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                 
                echo ' 
                <tr> 
                    <td><a href="admin?participant=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td>' . ($i+1) . '.</td> 
                    <td><a href="admin?participant=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '.</td> 
                    <td>' . $row[3] . '</td> 
                    <td>' . ($row[4] == 1 ? "M" : "&#381;") . '</td> 
                    <td>' . $row[5] . '</td> 
                    <td><a href="admin?club=' . $row[7] . '">' . $row[6] . '</a></td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_participant_edit($pageID){
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
            
			$participant_nam = (isset($_SESSION['participant_nam']) ? $_SESSION['participant_nam'] : '');
			$participant_sur = (isset($_SESSION['participant_sur']) ? $_SESSION['participant_sur'] : '');
			$participant_god_rodj = (isset($_SESSION['participant_god_rodj']) ? $_SESSION['participant_god_rodj'] : '');
			$participant_dat_rodj = (isset($_SESSION['participant_dat_rodj']) ? $_SESSION['participant_dat_rodj'] : '');
			$participant_mob = (isset($_SESSION['participant_mob']) ? $_SESSION['participant_mob'] : '');
			$participant_email = (isset($_SESSION['participant_email']) ? $_SESSION['participant_email'] : '');
			$participant_sexM = 'value="1" ' . 
                (isset($_SESSION['participant_sex']) ? ($_SESSION['participant_sex'] == 1 ? 'checked' : '') : 'checked');
			$participant_sexF = 'value="0" ' . 
                (isset($_SESSION['participant_sex']) ? ($_SESSION['participant_sex'] == 0 ? 'checked' : '') : '');
			$participant_activity = (isset($_SESSION["participant_activity"]) ? $_SESSION["participant_activity"] : '');
        }
		else{
			$query = "SELECT per.per_nam, per.per_sur, per_yea, per_dat_b, per_sex, per_mob, clu_id, per_email, activity
				FROM person per 
				where per.per_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$participant_nam = $row[0];
			$participant_sur = $row[1];
			$participant_god_rodj = $row[2];
			$participant_dat_rodj = $row[3];
			$participant_mob = $row[5];
			$participant_email = $row[7];
			$participant_activity = $row[8];
			$participant_sexM = 'value="1" ' . ($row[4] == 1 ? "checked" : '');
			$participant_sexF = 'value="0" ' . ($row[4] == 0 ? "checked" : '');
		}
		
        echo' 
        <form action="admin?participant=' . $pageID . '" method="post"> 
            <fieldset> 
				<div class="control-group">
					<label>Ime:</label> 
					<input type="text" class="input-xxlarge" placeholder="Type participant\'s name..." maxlength="80" name="participant_nam"
						value="' . $participant_nam . '"> 
				</div>
				<div class="control-group">
					<label>Prezime:</label> 
					<input type="text" class="input-xxlarge" placeholder="Type participant\'s surname..." maxlength="80" name="participant_sur" 
						value="' . $participant_sur . '"> 
				</div>
                <span class="help-block"></span> 
                <label>Spol:</label> 
                <label class="radio"> 
                <input type="radio" name="participant_sex" id="spolM" ' . $participant_sexM . ' > 
                <span class="metro-radio">M</span> 
                </label> 
                <label class="radio"> 
                <input type="radio" name="participant_sex" id="spolF" ' . $participant_sexF . ' > 
                <span class="metro-radio">&#381;</span> 
                </label>     
                <span class="help-block"></span> 
                <br/> 
				<div class="control-group">
					<label>Godina ro&#273;enja:</label> 
					<input type="text" placeholder="Type participant\'s birth year..." maxlength="4" minlength="4" name="participant_god_rodj" 
						value="' . $participant_god_rodj . '"> 
				</div>
                <span class="help-block"></span> 
                <label>Datum ro&#273;enja (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="Type participant\'s birth date..." maxlength="19" minlength="19" name="participant_dat_rodj" 
                    value="' . $participant_dat_rodj . '"> 
                <span class="help-block"></span> 
				<div class="control-group">
					<label>Mob.:</label> 
					<input type="text" placeholder="Type participant\'s mobile..."  maxlength="20" name="participant_mob" 
						value="' . $participant_mob . '"> 
				</div>
                <span class="help-block"></span> 
				<div class="control-group">
					<label>E-mail:</label> 
					<input type="text" placeholder="Type participant\'s e-mail..."  maxlength="50" name="participant_email" 
						value="' . $participant_email . '"> 
				</div>
                <span class="help-block"></span>
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="participant_activity"
                    value="' . $participant_activity . '">
                </div>'; 
  
        $query2 = "SELECT clu_id, clu_nam   
            FROM club"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
			
        echo ' 
        <div class="control-group">
        <label>Klub:</label> 
        <select name="participant_club"> 
        <option value="null">Select a club...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            $selectedClub = $pageID == 'new' ? ($row2[0] == $_SESSION['participant_club'] ? "selected=\"selected\"" : "") : 
                ($row2[0] == $row[6] ? "selected=\"selected\"" : "");
            echo '<option value="' . $row2[0] . '" ' . $selectedClub . '>' . $row2[1] . '</option>';        
        } 
        echo'</div>';
        echo' 
        </select> 
        <a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    } 

    function session_participant_unset(){ 
        unset($_SESSION['participant_nam']); 
        unset($_SESSION['participant_sur']); 
        unset($_SESSION['participant_god_rodj']); 
        unset($_SESSION['participant_dat_rodj']); 
        unset($_SESSION['participant_sex']); 
        unset($_SESSION['participant_mob']); 
        unset($_SESSION['participant_club']); 
        unset($_SESSION['participant_email']); 
        unset($_SESSION['participant_activity']); 
        }  
      
    function get_page_club($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_club_all(); 
                break; 
            case 'new': 
                get_page_club_edit($pageID); 
                break; 
            default: 
                get_page_club_edit($pageID); 
                break; 
        } 
    }  
    function get_page_club_all(){ 
        echo'
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT clu_id, clu_nam, clu_nams, clu_tow, clu_adr, clu_web, clu_email, activity 
            FROM club c"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                    <th class="span1"></th> 
                    <th class="span3">Naziv</th> 
                    <th class="span1">K. naziv</th> 
                    <th class="span1">Grad</th> 
                    <th class="span1">Adresa</th> 
                    <th class="span1">Web</th> 
                    <th class="span1">E-mail</th> 
                    <th class="span1">Aktivnost</th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?club=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?club=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '</td> 
                    <td>' . $row[3] . '</td> 
                    <td>' . $row[4] . '</td> 
                    <td><a href="' . $row[5] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '</td> 
                    <td>' . $row[7] . '</td> 
                </tr>';        
            } 
            echo ' 
            </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }   
    function get_page_club_edit($pageID){ 
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$club_nam = (isset($_SESSION['club_nam']) ? $_SESSION['club_nam'] : '');
			$club_nams = (isset($_SESSION['club_nams']) ? $_SESSION['club_nams'] : '');
			$club_adr = (isset($_SESSION['club_adr']) ? $_SESSION['club_adr'] : '');
			$club_tow = (isset($_SESSION['club_tow']) ? $_SESSION['club_tow'] : '');
			$club_cou = (isset($_SESSION['club_cou']) ? $_SESSION['club_cou'] : '');
			$club_sta = (isset($_SESSION['club_sta']) ? $_SESSION['club_sta'] : '');
			$club_web = (isset($_SESSION['club_web']) ? $_SESSION['club_web'] : '');
			$club_email = (isset($_SESSION['club_email']) ? $_SESSION['club_email'] : '');
			$club_tel = (isset($_SESSION['club_tel']) ? $_SESSION['club_tel'] : '');
			$club_tel2 = (isset($_SESSION['club_tel2']) ? $_SESSION['club_tel2'] : '');
			$club_fax = (isset($_SESSION['club_fax']) ? $_SESSION['club_fax'] : '');
			$club_mob = (isset($_SESSION['club_mob']) ? $_SESSION['club_mob'] : '');
			$club_mob2 = (isset($_SESSION['club_mob2']) ? $_SESSION['club_mob2'] : '');
			$club_acc = (isset($_SESSION['club_acc']) ? $_SESSION['club_acc'] : '');
			$club_acc2 = (isset($_SESSION['club_acc2']) ? $_SESSION['club_acc2'] : '');
			$club_activity = (isset($_SESSION['club_activity']) ? $_SESSION['club_activity'] : '');
        }
		else{
			$query =  "SELECT clu_nam, clu_nams, clu_adr, clu_tow, clu_cou, clu_sta, clu_web, clu_email, clu_tel, 
				clu_tel2,clu_fax,clu_mob,clu_mob2,clu_acc,clu_acc2,activity 
				FROM club c 
				where c.clu_id = " . $pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$club_nam = $row[0];
			$club_nams = $row[1];
			$club_adr = $row[2];
			$club_tow = $row[3];
			$club_cou = $row[4];
			$club_sta = $row[5];
			$club_web = $row[6];
			$club_email = $row[7];
			$club_tel = $row[8];
			$club_tel2 = $row[9];
			$club_fax = $row[10];
			$club_mob = $row[11];
			$club_mob2 = $row[12];
			$club_acc = $row[13];
			$club_acc2 = $row[14];
            $club_activity = $row[15];
		}
          
        echo' 
        <form action="admin?club=' . $pageID . '" method="post"> 
            <fieldset> 
                <div class="control-group">
                    <label>Naziv:</label> 
                    <input type="text"  class="input-xxlarge" placeholder="Type club\'s name..." name="club_nam" 
                        value="' . $club_nam . '"> 
                </div>
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type club\'s shorter name..." name="club_nams" 
                    value="' . $club_nams . '"> 
                <label>Adresa:</label> 
                <input type="text" placeholder="Type club\'s adress..." name="club_adr" 
                    value="' . $club_adr . '"> 
                <label>Grad:</label> 
                <input type="text" placeholder="Type club\'s town..." name="club_tow" 
                    value="' . $club_tow . '"> 
                <label>&#381;upanija:</label> 
                <input type="text" placeholder="Type club\'s county..." name="club_cou"
                    value="' . $club_cou . '"> 
                <label>Dr&#382;ava:</label> 
                <input type="text" placeholder="Type club\'s state..." name="club_sta" 
                    value="' . $club_sta . '"> 
                <label>Web:</label> 
                <input type="text" placeholder="Type club\'s web adress..." name="club_web"  
                    value="' . $club_web . '"> 
                <label>E-mail:</label> 
                <input type="text" placeholder="Type club\'s email..." name="club_email" 
                    value="' . $club_email . '"> 
                <label>Telefon:</label> 
                <input type="text" placeholder="Type club\'s telephone..." name="club_tel" 
                    value="' . $club_tel . '"> 
                <label>Telefon2:</label> 
                <input type="text" placeholder="Type club\'s telephone..." name="club_tel2"
                    value="' . $club_tel2 . '"> 
                <label>Fax:</label> 
                <input type="text" placeholder="Type club\'s fax..." name="club_fax"
                    value="' . $club_fax . '"> 
                <label>Mob:</label> 
                <input type="text" placeholder="Type club\'s mobile..." name="club_mob" 
                    value="' . $club_mob . '"> 
                <label>Mob2:</label> 
                <input type="text" placeholder="Type club\'s mobile..." name="club_mob2"
                    value="' . $club_mob2 . '"> 
                <label>Ra&#269;un:</label> 
                <input type="text" placeholder="Type club\'s account number..." name="club_acc" 
                    value="' . $club_acc . '"> 
                <label>Ra&#269;un2:</label> 
                <input type="text" placeholder="Type club\'s account number..." name="club_acc2" 
                    value="' . $club_acc2 . '"> 
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="club_activity"
                    value="' . $club_activity . '">
                </div>
                <span class="help-block"></span> 
                <br/><br/> 
                <button type="submit" id="spremi" class="btn">Spremi</button> 
            </fieldset> 
        </form>'; 
    }   
    
    function session_club_unset(){ 
        unset($_SESSION['club_nam']); 
        unset($_SESSION['club_nams']); 
        unset($_SESSION['club_adr']); 
        unset($_SESSION['club_tow']); 
        unset($_SESSION['club_cou']); 
        unset($_SESSION['club_sta']); 
        unset($_SESSION['club_web']); 
        unset($_SESSION['club_email']); 
        unset($_SESSION['club_tel']); 
        unset($_SESSION['club_tel2']); 
        unset($_SESSION['club_fax']); 
        unset($_SESSION['club_mob']); 
        unset($_SESSION['club_mob2']); 
        unset($_SESSION['club_acc']); 
        unset($_SESSION['club_acc2']); 
        unset($_SESSION['club_activity']); 
    } 
  
    function get_page_control($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_control_all(); 
                break; 
            case 'new': 
                get_page_control_edit($pageID); 
                break; 
            default: 
                get_page_control_edit($pageID); 
                break; 
        } 
    }  
    function get_page_control_all(){ 
        echo'
        <table class="table table-condensed table-hover table-striped">'; 
	    
		//kontrola za duple rezultate          
        $query = "SELECT rr.res_id,rr.rac_id,r.rac_nam,rr.sn_id,p.per_id,concat(p.per_nam, ' ', p.per_sur),rr.res_fin_time,rr.res_fin_time_sec,
			rr.res_start,rr.res_time,rr.res_pen,rr.res_transfer_typ,rr.res_mob_id FROM `race_result` rr
			inner join (SELECT rac_id,sn_id FROM `race_result` group by rac_id,sn_id having count(res_id)>1) as dupli on
			rr.rac_id = dupli.rac_id and rr.sn_id=dupli.sn_id
			inner join race r on rr.rac_id=r.rac_id
			inner join start s on r.st_id=s.st_id
			inner join st_num st on s.st_id=st.st_id
			left join person p on st.per_id=p.per_id
			where rr.sn_id=st.sn_id
			order by rr.rac_id,rr.sn_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Nema duplih rezultata! :)'; 
            //echo'<br/><br/><a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            //<a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            echo'    
            <br/><br/> Dupli rezultati!
                <thead> 
                <tr> 
                    <th class="span1"></th> 
                    <th class="span3">Utrka</th> 
                    <th class="span1">St. broj</th> 
                    <th class="span1">Natjecatelj</th> 
					<th class="span1">Rez.</th> 
					<th class="span1">Rez.(sec)</th> 
					<th class="span1">Start</th> 
					<th class="span1">Cilj</th> 
					<th class="span1">Kazna</th> 
					<th class="span1">Tip</th>  
					<th class="span1">Mob id</th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?control=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?race=' . $row[1] . '">' . $row[2] . '</a></td> 
                    <td><a href="admin?results=' . $row[1] . '&res=' . $row[0] .'">' . $row[3] . '</a></td> 
                    <td><a href="admin?participant=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '</td> 
                    <td>' . $row[7] . '</td> 
                    <td>' . $row[8] . '</td> 
                    <td>' . $row[9] . '</td> 
                    <td>' . $row[10] . '</td> 
                    <td>' . $row[11] . '</td> 
                    <td>' . $row[12] . '</td> 
                </tr>';        
            } 
            echo ' 
            </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
        
        echo'
        <table class="table table-condensed table-hover table-striped">'; 
	    
		//kontrola za krivo upisane rezultate          
        $query = "SELECT rr.res_id,rr.rac_id,r.rac_nam,rr.sn_id,p.per_id,concat(p.per_nam, ' ', p.per_sur),rr.res_fin_time,rr.res_fin_time_sec,
			rr.res_start,rr.res_time,rr.res_pen,rr.res_transfer_typ,rr.res_mob_id FROM `race_result` rr
			inner join race r on rr.rac_id=r.rac_id
			inner join start s on r.st_id=s.st_id
			inner join st_num st on s.st_id=st.st_id
			left join person p on st.per_id=p.per_id
			where rr.sn_id=st.sn_id
			order by rr.rac_id,rr.sn_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        $prvi = true; 
        for($i=0;$i<$num;$i++){ 
            $row = mysqli_fetch_row($result); 
            
            $res_fin_time = $row[6];
            $parts = explode(":", $res_fin_time);
            $error = false;
            if(count($parts) == 2)
            {
                if($parts[1] > 59 || $parts[0] > 59) $error = true;
            }
            else if(count($parts) == 3)
            {
                if($parts[2] > 59 || $parts[1] > 59 || $parts[0] > 23) $error = true;
            }
            else if(count($parts) == 4)
            {
                if($parts[3] > 59 || $parts[2] > 59 || $parts[1] > 23) $error = true;
            }
            else
            {
                if($parts[2] > 59 || $parts[1] > 59 || $parts[0] > 23) $error = true;
            }
            
            if($error)
            {
                if($prvi)
                {
                    echo'    
                    <br/><br/> Krivo upisani rezultati!
                        <thead> 
                        <tr> 
                            <th class="span1"></th> 
                            <th class="span3">Utrka</th> 
                            <th class="span1">St. broj</th> 
                            <th class="span1">Natjecatelj</th> 
        					<th class="span1">Rez.</th> 
        					<th class="span1">Rez.(sec)</th> 
        					<th class="span1">Start</th> 
        					<th class="span1">Cilj</th> 
        					<th class="span1">Kazna</th> 
        					<th class="span1">Tip</th>  
        					<th class="span1">Mob id</th> 
                        </tr> 
                        </thead> 
                    <tbody>';
                    $prvi = false;
                }
                
                echo ' 
                <tr> 
                    <td><a href="admin?control=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?race=' . $row[1] . '">' . $row[2] . '</a></td> 
                    <td><a href="admin?results=' . $row[1] . '&res=' . $row[0] .'">' . $row[3] . '</a></td> 
                    <td><a href="admin?participant=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '</td> 
                    <td>' . $row[7] . '</td> 
                    <td>' . $row[8] . '</td> 
                    <td>' . $row[9] . '</td> 
                    <td>' . $row[10] . '</td> 
                    <td>' . $row[11] . '</td> 
                    <td>' . $row[12] . '</td> 
                </tr>';  
            }      
        } 
        
        if($prvi) echo 'Nema krivih rezultata! :)'; 
        echo ' 
        </tbody></table>'; 
    }   
    function get_page_control_edit($pageID){ 
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$club_nam = (isset($_SESSION['club_nam']) ? $_SESSION['club_nam'] : '');
        }
		else{
			$query =  "SELECT clu_nam, clu_nams, clu_adr, clu_tow, clu_cou, clu_sta, clu_web, clu_email, clu_tel, 
				clu_tel2,clu_fax,clu_mob,clu_mob2,clu_acc,clu_acc2,activity 
				FROM control c 
				where c.clu_id = " . $pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$club_nam = $row[0];
		}
          
        echo' 
        <form action="admin?control=' . $pageID . '" method="post"> 
            <fieldset> 
                <div class="control-group">
                    <label>Naziv:</label> 
                    <input type="text"  class="input-xxlarge" placeholder="Type club\'s name..." name="club_nam" 
                        value="' . $club_nam . '"> 
                </div>
                <span class="help-block"></span> 
                <br/><br/> 
                <button type="submit" id="spremi" class="btn">Spremi</button> 
            </fieldset> 
        </form>'; 
    }   
    
    function session_control_unset(){ 
        unset($_SESSION['club_nam']);  
    } 
	
    function get_page_race($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_race_all(); 
                break; 
            case 'new': 
                get_page_race_edit($pageID); 
                break; 
            default: 
                get_page_race_edit($pageID); 
                break;           
        } 
    }        
    function get_page_race_all(){ 
        echo' 
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT r.rac_id,case when trim(r.rac_nams)='' or r.rac_nams is null then r.rac_nam else r.rac_nams end,
            r.org_id,ifnull(c.clu_nams,c.clu_nam),r.lea_id,ifnull(l.lea_nams,l.lea_nam), 
            r.rac_start_dat,r.rac_kmh,r.rac_kmv,r.rac_ent_fee,r.activity
            from race r 
            left join league l on r.lea_id=l.lea_id 
            left join club c on r.org_id=c.clu_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?race=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?race=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                     <th class="span1"></th> 
                     <th class="span1">Utrka</th> 
                     <th class="span3">Organizator</th> 
                     <th class="span1">Liga</th> 
                     <th class="span1">Datum</th> 
                     <th class="span1">KmH</th> 
                     <th class="span1">KmV</th> 
                     <th class="span1">Startnina</th> 
                     <th class="span1">Aktivnost</th> 
                     <th class="span1"></th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?race=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?race=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td><a href="admin?club=' . $row[2] . '">' . $row[3] . '</a></td> 
                    <td><a href="admin?league=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '</td> 
                    <td>' . $row[7] . '</td> 
                    <td>' . $row[8] . '</td> 
                    <td>' . $row[9] . '</td> 
                    <td>' . $row[10] . '</td> 
					<td><a href="admin?results=' . $row[0] . '">rezultati</a></td>
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_race_edit($pageID){ 
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$race_nam = (isset($_SESSION["race_nam"]) ? $_SESSION["race_nam"] : '');
			$race_nams = (isset($_SESSION["race_nams"]) ? $_SESSION["race_nams"] : '');
			$race_fr_dat = (isset($_SESSION["race_fr_dat"]) ? $_SESSION["race_fr_dat"] : '');
			$race_to_dat = (isset($_SESSION["race_to_dat"]) ? $_SESSION["race_to_dat"] : '');
			$race_start_dat = (isset($_SESSION["race_start_dat"]) ? $_SESSION["race_start_dat"] : '');
			$race_kmh = (isset($_SESSION["race_kmh"]) ? $_SESSION["race_kmh"] : '');
			$race_kmv = (isset($_SESSION["race_kmv"]) ? $_SESSION["race_kmv"] : '');
			$race_ent_fee = (isset($_SESSION["race_ent_fee"]) ? $_SESSION["race_ent_fee"] : '');
			
			$race_shirt = ($_SESSION["race_shirt"] == 1 || $_SESSION["race_shirt"] == "D" || $_SESSION["race_shirt"] == "Y" ? " checked " : "");
			$race_water = ($_SESSION["race_water"] == 1 || $_SESSION["race_water"] == "D" || $_SESSION["race_water"] == "Y" ? " checked " : "");
			$race_drink = ($_SESSION["race_drink"] == 1 || $_SESSION["race_drink"] == "D" || $_SESSION["race_drink"] == "Y" ? " checked " : "");
			$race_eat = ($_SESSION["race_eat"] == 1 || $_SESSION["race_eat"] == "D" || $_SESSION["race_eat"] == "Y" ? " checked " : "");
			$race_rs = ($_SESSION["race_rs"] == 1 || $_SESSION["race_rs"] == "D" || $_SESSION["race_rs"] == "Y" ? " checked " : "");
			$race_fraid = ($_SESSION["race_fraid"] == 1 || $_SESSION["race_fraid"] == "D" || $_SESSION["race_fraid"] == "Y" ? " checked " : "");
			$race_chk = ($_SESSION["race_chk"] == 1 || $_SESSION["race_chk"] == "D" || $_SESSION["race_chk"] == "Y" ? " checked " : "");
			$race_meal = ($_SESSION["race_meal"] == 1 || $_SESSION["race_meal"] == "D" || $_SESSION["race_meal"] == "Y" ? " checked " : "");
			$race_chrono = ($_SESSION["race_chrono"] == 1 || $_SESSION["race_chrono"] == "D" || $_SESSION["race_chrono"] == "Y" ? " checked " : "");
				
			$race_reg_fr_dat = (isset($_SESSION["race_reg_fr_dat"]) ? $_SESSION["race_reg_fr_dat"] : '');
			$race_reg_to_dat = (isset($_SESSION["race_reg_to_dat"]) ? $_SESSION["race_reg_to_dat"] : '');
			$race_desc = (isset($_SESSION["race_desc"]) ? $_SESSION["race_desc"] : '');
			$race_rul = (isset($_SESSION["race_rul"]) ? $_SESSION["race_rul"] : '');
			$race_man_eq = (isset($_SESSION["race_man_eq"]) ? $_SESSION["race_man_eq"] : '');
			$race_lea_rou = (isset($_SESSION["race_lea_rou"]) ? $_SESSION["race_lea_rou"] : '');
			$race_activity = (isset($_SESSION["race_activity"]) ? $_SESSION["race_activity"] : '');
			$race_club = (isset($_SESSION["race_club"]) ? $_SESSION["race_club"] : '');
			$race_league = (isset($_SESSION["race_league"]) ? $_SESSION["race_league"] : '');
			$race_league_group = (isset($_SESSION["race_league_group"]) ? $_SESSION["race_league_group"] : '');
			$race_st_num = (isset($_SESSION["race_st_num"]) ? $_SESSION["race_st_num"] : '');
        }
		else{
			$query = "SELECT r.rac_nam,r.rac_nams,rac_fr_dat,rac_to_dat,rac_start_dat,rac_kmH,rac_kmV,rac_ent_fee,rac_shirt,rac_water, 
				rac_drink,rac_eat,rac_rs,rac_fraid,rac_chk,rac_meal,rac_reg_fr_dat,rac_reg_to_dat,rac_desc,rac_rul, 
				rac_man_eq, 
				r.org_id,r.lea_id,r.leagr_id, rac_lea_rou,r.activity, r.rac_chrono, r.st_id
				from race r 
				left join league l on r.lea_id=l.lea_id 
				left join league_group lg on r.lea_id=lg.leagr_id 
				left join club c on r.org_id=c.clu_id 
				where r.rac_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$race_nam = $row[0];
			$race_nams = $row[1];
			$race_fr_dat = $row[2];
			$race_to_dat = $row[3];
			$race_start_dat = $row[4];
			$race_kmh = $row[5];
			$race_kmv = $row[6];
			$race_ent_fee = $row[7];
			
			$race_shirt = ($row[8] == 1 || $row[8] == "D" || $row[8] == "Y" ? " checked " : "");
			$race_water = ($row[9] == 1 || $row[9] == "D" || $row[9] == "Y" ? " checked " : "");
			$race_drink = ($row[10] == 1 || $row[10] == "D" || $row[10] == "Y" ? " checked " : "");
			$race_eat = ($row[11] == 1 || $row[11] == "D" || $row[11] == "Y" ? " checked " : "");
			$race_rs = ($row[12] == 1 || $row[12] == "D" || $row[12] == "Y" ? " checked " : "");
			$race_fraid = ($row[13] == 1 || $row[13] == "D" || $row[13] == "Y" ? " checked " : "");
			$race_chk = ($row[14] == 1 || $row[14] == "D" || $row[14] == "Y" ? " checked " : "");
			$race_meal = ($row[15] == 1 || $row[15] == "D" || $row[15] == "Y" ? " checked " : "");
			$race_chrono = ($row[26] == 1 || $row[26] == "D" || $row[26] == "Y" ? " checked " : "");
					
			$race_reg_fr_dat = $row[16];
			$race_reg_to_dat = $row[17];
			$race_desc = $row[18];
			$race_rul = $row[19];
			$race_man_eq = $row[20];
			$race_club = $row[21];
			$race_league = $row[22];
			$race_league_group = $row[23];
			$race_lea_rou = $row[24];
			$race_activity = $row[25];
            $race_st_num = $row[27];
		}
      
        echo' 
        <form action="admin?race=' . $pageID . '" method="post"> 
            <fieldset> 
                <div class="control-group">
                    <label>Naziv:</label> 
                    <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="race_nam" 
                        value="' . $race_nam . '">
                </div> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter race name..." maxlength="20" name="race_nams" 
                    value="' . $race_nams . '"> 
                <div class="control-group">
                    <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                    <input type="text" placeholder="..." maxlength="19" name="race_fr_dat"
                        value="' . $race_fr_dat . '"> 
                    <input type="text" placeholder="..." maxlength="19" name="race_to_dat"
                        value="' . $race_to_dat . '">
                    </div>
                <label>Start:</label> 
                <input type="text" placeholder="..." name="race_start_dat"
                    value="' . $race_start_dat . '"> 
                <span class="help-block"></span> 
                <div class="control-group">
                    <label>Duljina kmH kmV:</label> 
                    <input type="text" placeholder="..." name="race_kmh"
                        value="' . $race_kmh . '"> 
                    <input type="text" placeholder="..." name="race_kmv"
                        value="' . $race_kmv . '"> 
                </div>
                <span class="help-block"></span> 
                <label>Startnina:</label> 
                <input type="text" placeholder="..." name="race_ent_fee"
                    value="' . $race_ent_fee . '"><br/><br/>'; 
                                                 
        $query2 = "SELECT st_id, st_nam   
            FROM start where activity = 'D' or activity = 'Y'"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
        
        
        echo '<div class="control-group"><label>Startni brojevi:</label> 
            <select name="race_st_num"> 
            <option value="null">Select start numbers...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            $selectedStNum = $pageID == 'new' ? ($row2[0] == $race_st_num ? "selected=\"selected\"" : "") : 
                ($row2[0] == $row[27] ? "selected=\"selected\"" : "");
            echo '<option value="' . $row2[0] . '" ' . $selectedStNum . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select></div>'; 
        
        echo'<br/>             
                <label class="checkbox"> 
                    <input type="checkbox" name="race_chrono" 
                    '. $race_chrono .'
                    ><span class="metro-checkbox">Utrka na kronometar?</span> 
                </label>   
                <br/> 
                  
                <label class="checkbox"> 
                    <input type="checkbox" name="race_shirt" 
                    '. $race_shirt .'
                    ><span class="metro-checkbox">Majica</span> 
                </label> 
                      
                <label class="checkbox"> 
                    <input type="checkbox" name="race_water" 
                    '. $race_water .'
                    ><span class="metro-checkbox">Voda</span> 
                </label>  
                                      
                <label class="checkbox"> 
                    <input type="checkbox" name="race_drink" 
                    '. $race_drink .'
                    ><span class="metro-checkbox">Pi&#263;e</span> 
                </label>  
                                                
                <label class="checkbox"> 
                    <input type="checkbox" name="race_eat" 
                    '. $race_eat .'
                    ><span class="metro-checkbox">Hrana</span> 
                </label>  
                                                                 
                <label class="checkbox"> 
                    <input type="checkbox" name="race_rs" 
                    '. $race_rs .'
                    ><span class="metro-checkbox">GSS</span> 
                </label>  
                                                
                <label class="checkbox"> 
                    <input type="checkbox" name="race_fraid" 
                    '. $race_fraid .'
                    ><span class="metro-checkbox">Prva pomo&#263;</span> 
                </label>       
                                                                                 
                <label class="checkbox"> 
                    <input type="checkbox" name="race_chk" 
                    '. $race_chk .'
                    ><span class="metro-checkbox">Checkpoints</span> 
                </label>  
                                                
                <label class="checkbox"> 
                    <input type="checkbox" name="race_meal" 
                    '. $race_meal .'
                    ><span class="metro-checkbox">Jelo nakon utrke</span> 
                </label>                
                        
                <br/> 
                  
                <label>Registracije od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="race_reg_fr_dat"
                    value="' . $race_reg_fr_dat . '"> 
                <input type="text" placeholder="..." maxlength="19" name="race_reg_to_dat"
                    value="' . $race_reg_to_dat . '">           
                  
                <label>Opis:</label> 
                <textarea rows="3" placeholder="Type race description..."  maxlength="1000" name="race_desc"
                    value="' . $race_desc . '">' . $race_desc . '</textarea> 
                <span class="help-block"></span> 
                  
                <label>Pravila:</label> 
                <textarea rows="5" type="text" placeholder="Type race rules..."  maxlength="500" name="race_rul" 
                    value="' . $race_rul . '">' . $race_rul . '</textarea> 
                <span class="help-block"></span> 
                  
                <label>Obavezna oprema:</label> 
                <textarea rows="2" type="text" placeholder="Type mandatory equipment..."  maxlength="200" name="race_man_eq"  
                    value="' . $race_man_eq . '">' . $race_man_eq . '</textarea> 
                <span class="help-block"></span> 
                '; 
  
        $query2 = "SELECT clu_id, clu_nam   
        FROM club"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
  
        echo '<div class="control-group"><label>Organizator:</label> 
            <select name="race_club"> 
            <option value="null">Select club...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            $selectedClub = $pageID == 'new' ? ($row2[0] == $race_club ? "selected=\"selected\"" : "") : 
                ($row2[0] == $row[21] ? "selected=\"selected\"" : "");
            echo '<option value="' . $row2[0] . '" ' . $selectedClub . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select></div>'; 
    
        $query2 = "SELECT lea_id, lea_nam   
        FROM league"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
  
        echo '<label>Liga:</label> 
            <select name="race_league"> 
            <option value="null">Select league...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            $selectedLeague = $pageID == 'new' ? ($row2[0] == $race_league ? "selected=\"selected\"" : "") : 
                ($row2[0] == $row[22] ? "selected=\"selected\"" : "");
            echo '<option value="' . $row2[0] . '" ' . $selectedLeague . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select>'; 
                  
        $query2 = "SELECT leagr_id, leagr_nam   
            FROM league_group"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
                
        echo '<div class="control-group">
              <label>Rbr. kola u ligi (obavezno ako je odabrana liga!)</label> <input type="text" placeholder="Rbr kola" name="race_lea_rou"
              value="' . $race_lea_rou . '">
			  </div>'; 
                    
        echo '<div class="control-group">
              <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="race_activity"
              value="' . $race_activity . '">
              </div>'; 
        
        echo '<label>Liga-grupa:</label> 
            <select name="race_league_group"> 
            <option value="null">Select league group...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            $selectedLeagueGroup = $pageID == 'new' ? ($row2[0] == $race_league_group ? "selected=\"selected\"" : "") : 
                ($row2[0] == $row[23] ? "selected=\"selected\"" : "");
            echo '<option value="' . $row2[0] . '" ' . $selectedLeagueGroup . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select>'; 

        echo' 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }     
    
    function session_race_unset(){ 
        unset($_SESSION['race_nam']); 
        unset($_SESSION['race_nams']); 
        unset($_SESSION['race_fr_dat']); 
        unset($_SESSION['race_to_dat']); 
        unset($_SESSION['race_start_dat']); 
        unset($_SESSION['race_kmh']); 
        unset($_SESSION['race_kmv']); 
        unset($_SESSION['race_ent_fee']); 
        unset($_SESSION['race_shirt']); 
        unset($_SESSION['race_water']); 
        unset($_SESSION['race_drink']); 
        unset($_SESSION['race_eat']); 
        unset($_SESSION['race_rs']); 
        unset($_SESSION['race_fraid']); 
        unset($_SESSION['race_reg_fr_dat']); 
        unset($_SESSION['race_reg_to_dat']); 
        unset($_SESSION['race_desc']); 
        unset($_SESSION['race_rul']); 
        unset($_SESSION['race_man_eq']); 
        unset($_SESSION['race_chk']); 
        unset($_SESSION['race_meal']); 
        unset($_SESSION['race_club']); 
        unset($_SESSION['race_league']); 
        unset($_SESSION['race_league_group']); 
        unset($_SESSION['race_st_num']); 
        unset($_SESSION['race_activity']); 
        unset($_SESSION['race_lea_rou']); 
        unset($_SESSION['race_chrono']); 
        } 
      
    function get_page_checkpoint($pageID,$chkID){
        switch($pageID){ 
            case '': 
                get_page_checkpoint_all(); 
                break; 
            case 'new': 
                get_page_checkpoint_edit($pageID,''); 
                break; 
            default: 
                get_page_checkpoint_edit($pageID,$chkID); 
                break; 
        } 
    }
    function get_page_checkpoint_all(){ 
        
        echo
        '<table class="table table-condensed table-hover table-striped">'; 
        
		$query = "SELECT c.rac_id,r.rac_nam, count(*)
            FROM race_checkpoint c
			inner join race r on c.rac_id=r.rac_id
			group by c.rac_id,r.rac_nam"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database';
			echo '<br/><br/><a href="admin?checkpoint=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'
            <h2>Kontrolne to&#269;ke<h2/>
            <a href="admin?checkpoint=new"><span aria-hidden="true" class="icon-plus-5"></span></a>
            <br/><br/> 
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span1">Utrka</th> 
                <th class="span1">Broj KT-ova</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?checkpoint=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?checkpoint=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_checkpoint_edit($pageID, $chkID){ 
        
		if($pageID == 'new'){
            echo '
            <h2>Kontrolne to&#269;ke<h2/>
            <a href="admin?checkpoint="><span aria-hidden="true" class="icon-arrow-left-13"></span></a>
            <br/><br/> ';
            
			$pageID = 'new';
			
			$query2 = "SELECT rac_id, rac_nam  
				FROM race"; 
			$result2 = queryMysql($query2); 
			$num2 = mysqli_num_rows(queryMysql($query2)); 
			  
			echo'
			<form action="admin?checkpoint=new" method="post"> 
            <fieldset> 			
			<label>Utrka:</label> 
			<select name="checkpoint_race"> 
			<option value="null">Select race...</option>'; 
			for($i=0;$i<$num2;$i++){   
				$row2 = mysqli_fetch_row($result2); 
				echo'  
				<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION['checkpoint_race'] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
			} 
			echo'
            </select>
			<span class="help-block"></span> 
			<button type="submit" class="btn">Click</button> 
			</fieldset> 
			</form>'; 
		}
		else{
//			$query = "SELECT c.rac_id,chk_naz,chk_nazs,chk_kmH,chk_kmV,chk_altV,chk_desc,chk_water,chk_drink,chk_eat,chk_rs,chk_fraid 
//				FROM race_checkpoint c
//				where c.chk_id=" . $pageID . " and r.rac_id=" . $racID; 
//			$result = queryMysql($query); 
//			$num = mysqli_num_rows(queryMysql($query)); 
//			$row = mysqli_fetch_row($result); 
			 
//			$st_num_name = $row[1];
//			$st_num_type = $row[2];
		}
		
//        echo' 
//        <form action="admin?checkpoint=' . $pageID . '" method="post"> 
//            <fieldset> 
//                <label>Naziv:</label> 
//                <input type="text" class="input-xxlarge" placeholder="Type checkpoint name..." maxlength="80" name="chk_naz"
//                    value="' . $chk_naz . '">  
//                <label>Tip:</label> 
//                <input type="text" class="input-mini" placeholder="Type shorter checkpoint name..." maxlength="20" name="chk_nazs" 
//                    value="' . $chk_nazs . '"> 
//                <span class="help-block"></span> 
//            <button type="submit" id="spremi" class="btn">Spremi</button> 
//            </fieldset> 
//        </form>'; 
      
		if($pageID != 'new'){
			get_page_checkpoint_id($pageID); 
			
			if($chkID == "new"){
				echo '
				<br/>'; 
				
				//$checkpoint_race = (isset($_SESSION["checkpoint_race"]) ? $_SESSION["checkpoint_race"] : '');
				$checkpoint_naz = (isset($_SESSION["checkpoint_naz"]) ? $_SESSION['checkpoint_naz'] : '');
				$checkpoint_nazs = (isset($_SESSION["checkpoint_nazs"]) ? $_SESSION['checkpoint_nazs'] : '');
				$checkpoint_kmH = (isset($_SESSION["checkpoint_kmH"]) ? $_SESSION['checkpoint_kmH'] : '');
				$checkpoint_kmV = (isset($_SESSION["checkpoint_kmV"]) ? $_SESSION['checkpoint_kmV'] : '');
				$checkpoint_altV = (isset($_SESSION["checkpoint_altV"]) ? $_SESSION['checkpoint_altV'] : '');
				$checkpoint_desc = (isset($_SESSION["checkpoint_desc"]) ? $_SESSION['checkpoint_desc'] : '');
				$checkpoint_water = (isset($_SESSION["checkpoint_water"]) ? ($_SESSION["checkpoint_water"] == 1 || $_SESSION["checkpoint_water"] == "D" || $_SESSION["checkpoint_water"] == "Y" ? " checked " : "") : ""); 
				$checkpoint_drink = (isset($_SESSION["checkpoint_drink"]) ? ($_SESSION["checkpoint_drink"] == 1 || $_SESSION["checkpoint_drink"] == "D" || $_SESSION["checkpoint_drink"] == "Y" ? " checked " : "") : "");
				$checkpoint_eat = (isset($_SESSION["checkpoint_eat"]) ? ($_SESSION["checkpoint_eat"] == 1 || $_SESSION["checkpoint_eat"] == "D" || $_SESSION["checkpoint_eat"] == "Y" ? " checked " : "") : "");
				$checkpoint_rs = (isset($_SESSION["checkpoint_rs"]) ? ($_SESSION["checkpoint_rs"] == 1 || $_SESSION["checkpoint_rs"] == "D" || $_SESSION["checkpoint_rs"] == "Y" ? " checked " : "") : "");
				$checkpoint_fraid = (isset($_SESSION["checkpoint_fraid"]) ? ($_SESSION["checkpoint_fraid"] == 1 || $_SESSION["checkpoint_fraid"] == "D" || $_SESSION["checkpoint_fraid"] == "Y" ? " checked " : "") : "");
			}
			else if($chkID != ''){ 
				echo '
				<br/>'; 
                
				$query = "SELECT chk_naz,chk_nazs,chk_kmH,chk_kmV,chk_altV,chk_desc,chk_water,chk_drink,chk_eat,chk_rs,chk_fraid   
					FROM race_checkpoint c 
					where c.rac_id=" . $pageID . " and c.chk_id=" . $chkID;
				$result = queryMysql($query); 
				$num = mysqli_num_rows(queryMysql($query)); 
				$row = mysqli_fetch_row($result); 
			
				//$checkpoint_race = $row[0];
				$checkpoint_naz = $row[0];
				$checkpoint_nazs = $row[1];
				$checkpoint_kmH = $row[2];
				$checkpoint_kmV = $row[3];
				$checkpoint_altV = $row[4];
				$checkpoint_desc = $row[5];
				$checkpoint_water = ($row[6] == 1 || $row[6] == "D" || $row[6] == "Y" ? " checked " : "");
				$checkpoint_drink = ($row[7] == 1 || $row[7] == "D" || $row[7] == "Y" ? " checked " : "");
				$checkpoint_eat = ($row[8] == 1 || $row[8] == "D" || $row[8] == "Y" ? " checked " : "");
				$checkpoint_rs = ($row[9] == 1 || $row[9] == "D" || $row[9] == "Y" ? " checked " : "");
				$checkpoint_fraid = ($row[10] == 1 || $row[10] == "D" || $row[10] == "Y" ? " checked " : "");

			}
			else{
				echo '
				<br/>
				<a href="admin?checkpoint=' . $pageID . '&chk=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
			}
			 
            if($chkID == "new" || $chkID != ''){
                if($chkID == "new")
                    echo'<h3>Unesi podatke za novi KT:<h3/>';
                else echo'<h3>Promjena podataka za KT:<h3/>';
                
    			echo'  
    			<form action="admin?checkpoint=' . $pageID . '&chk=' . $chkID . '" method="post"> 
    				<fieldset> 
    					<label>Naziv:</label> 
    					<input type="text" class="input-xlarge" placeholder="Type checkpoint name..." maxlength="80" name="checkpoint_naz"
    						value="' . $checkpoint_naz . '">
    					<span class="help-block"></span>  
    					<label>Kratki naziv:</label> 
    					<input type="text" class="input-large" placeholder="Type checkpoint name..." maxlength="20" name="checkpoint_nazs"
    						value="' . $checkpoint_nazs . '">
    					<span class="help-block"></span>   
    					<label>KmH   kmV   n.m.v:</label> 
    					<input type="text" class="input-mini" name="checkpoint_kmH"
    						value="' . $checkpoint_kmH . '">
    					<input type="text" class="input-mini" name="checkpoint_kmV"
    						value="' . $checkpoint_kmV . '">
    					<input type="text" class="input-mini" name="checkpoint_altV"
    						value="' . $checkpoint_altV . '">
    					<span class="help-block"></span>  
    					<label>Opis:</label> 
    					<textarea rows="3" type="text" placeholder="Checkpoint description..." maxlength="200" name="checkpoint_desc"  
    						value="' . $checkpoint_desc . '">' . $checkpoint_desc . '</textarea> 
    					<span class="help-block"></span> 
    					
                        <label class="checkbox"> 	
                            <input type="checkbox" name="checkpoint_water" 
    						'. $checkpoint_water .'
    						><span class="metro-checkbox">Voda</span> 
    					</label>  
    										  
    					<label class="checkbox"> 
    						<input type="checkbox" name="checkpoint_drink" 
    						'. $checkpoint_drink .'
    						><span class="metro-checkbox">Pi&#263;e</span> 
    					</label>  
    													
    					<label class="checkbox"> 
    						<input type="checkbox" name="checkpoint_eat" 
    						'. $checkpoint_eat .'
    						><span class="metro-checkbox">Hrana</span> 
    					</label>  
    																	 
    					<label class="checkbox"> 
    						<input type="checkbox" name="checkpoint_rs" 
    						'. $checkpoint_rs .'
    						><span class="metro-checkbox">GSS</span> 
    					</label>  
    													
    					<label class="checkbox"> 
    						<input type="checkbox" name="checkpoint_fraid" 
    						'. $checkpoint_fraid .'
    						><span class="metro-checkbox">Prva pomo&#263;</span> 
    					</label> 
    			';
    			 
    			echo' 
    			</select> 
    			<span class="help-block"></span> 
                <br/>
    			<button type="submit" id="spremi" class="btn">Spremi</button> 
    			</fieldset> 
    			</form>'; 
            }	
		}
    } 

    function get_page_checkpoint_id($pageID){
        echo '
        <h2>Kontrolne to&#269;ke za ' . getValue("race", "rac_nam", "rac_id", $pageID) . '<h2/>
        <a href="admin?checkpoint=-1"><span aria-hidden="true" class="icon-arrow-left-13"></span></a>
        <br/><br/> 
        <table class="table table-condensed table-hover table-striped">'; 
        
        $query2 = "SELECT chk_id,chk_naz,chk_kmH,chk_kmV,chk_altV,chk_water,chk_drink,chk_eat,chk_rs,chk_fraid
        	FROM race_checkpoint c
        	inner join race r on c.rac_id=r.rac_id
        	where c.rac_id=" . $pageID; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2));   
      
        if($num2==0){ 
            echo 'Empty database'; 
        } 
        else{           
            echo'
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span4">Naziv KT</th> 
                <th class="span1">KT-#kmH</th> 
                <th class="span1">KT-#kmV</th> 
                <th class="span1">KT-n.m.v.</th> 
				<th class="span1">Voda</th> 
				<th class="span1">Pi&#263;e</th> 
				<th class="span1">Jelo</th> 
				<th class="span1">GSS</th> 
				<th class="span1">PP</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num2;$i++){ 
                $row = mysqli_fetch_row($result2); 
                echo ' 
                <tr> 
                    <td><a href="admin?checkpoint=' . $pageID . '&chk=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?checkpoint=' . $pageID . '&chk=' . $row[0] . '">' . $row[1] . '.</td> 
                    <td>' . $row[2] . '</td> 
                    <td>' . $row[3] . '</td> 
					<td>' . $row[4] . '</td> 
					<td>' . ($row[5] == 1 || $row[5] == "D" || $row[5] == "Y" ? " <span aria-hidden=\"true\" class=\"icon-checkmark-2\"></span> " : " <span aria-hidden=\"true\" class=\"icon-cross-2\"></span> ") . ' </td> 	
					<td>' . ($row[6] == 1 || $row[6] == "D" || $row[6] == "Y" ? " <span aria-hidden=\"true\" class=\"icon-checkmark-2\"></span> " : " <span aria-hidden=\"true\" class=\"icon-cross-2\"></span> ") . ' </td> 	
					<td>' . ($row[7] == 1 || $row[7] == "D" || $row[7] == "Y" ? " <span aria-hidden=\"true\" class=\"icon-checkmark-2\"></span> " : " <span aria-hidden=\"true\" class=\"icon-cross-2\"></span> ") . ' </td> 
					<td>' . ($row[8] == 1 || $row[8] == "D" || $row[8] == "Y" ? " <span aria-hidden=\"true\" class=\"icon-checkmark-2\"></span> " : " <span aria-hidden=\"true\" class=\"icon-cross-2\"></span> ") . ' </td> 
					<td>' . ($row[9] == 1 || $row[9] == "D" || $row[9] == "Y" ? " <span aria-hidden=\"true\" class=\"icon-checkmark-2\"></span> " : " <span aria-hidden=\"true\" class=\"icon-cross-2\"></span> ") . ' </td> 		
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }
    function session_checkpoint_unset(){
        unset($_SESSION['checkpoint_race']); 
        unset($_SESSION['checkpoint_naz']); 
        unset($_SESSION['checkpoint_nazs']); 
        unset($_SESSION['checkpoint_kmH']); 
        unset($_SESSION['checkpoint_kmV']); 
        unset($_SESSION['checkpoint_altV']); 
        unset($_SESSION['checkpoint_desc']); 
        unset($_SESSION['checkpoint_water']); 
        unset($_SESSION['checkpoint_drink']); 
        unset($_SESSION['checkpoint_eat']); 
        unset($_SESSION['checkpoint_rs']); 
        unset($_SESSION['checkpoint_fraid']);
        } 
	function generirajNoviBrojCHK($racID){
        $query = "SELECT ifnull(max(chk_id)+1,1)
            FROM race_checkpoint c
			inner join race r on c.rac_id=r.rac_id
            where c.rac_id='$racID'"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            return 1; 
        } 
        else{
            $row = mysqli_fetch_row($result); 
            return $row[0];
        }
	}
    
    function get_page_league($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_league_all(); 
                break; 
            case 'new': 
                get_page_league_edit($pageID); 
                break; 
            default: 
                get_page_league_edit($pageID); 
                break;           
        } 
    }        
    function get_page_league_all(){ 
        echo' 
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT l.lea_id,ifnull(l.lea_nams,l.lea_nam),l.org_id,ifnull(c.clu_nams,c.clu_nam),l.leagr_id,ifnull(lg.leagr_nams,lg.leagr_nam), 
            l.lea_to_dat,l.lea_fr_dat,l.lea_day,l.lea_day_sco,l.lea_ent_fee,l.lea_desc,l.activity 
            from league l 
            left join league_group lg on l.leagr_id=lg.leagr_id 
            left join club c on l.org_id=c.clu_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?league=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?league=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                     <th class="span1"></th> 
                     <th class="span1">Liga</th> 
                     <th class="span1">Organizator</th> 
                     <th class="span1">Liga-grupa</th> 
                     <th class="span1">Datum od-do</th> 
                     <th class="span2">Kolo</th> 
                     <th class="span2">Startnina</th> 
                     <th class="span1">Aktivnost</th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?league=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?league=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td><a href="admin?club=' . $row[2] . '">' . $row[3] . '</a></td> 
                    <td><a href="admin?league_group=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '-' . $row[7] . '</td> 
                    <td>' . $row[8] . '/' . $row[9] . '</td> 
                    <td>' . $row[10] . '</td> 
                    <td>' . $row[12] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_league_edit($pageID){ 
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$league_nam = (isset($_SESSION["race_nam"]) ? $_SESSION["race_nam"] : '');
			$league_nams = (isset($_SESSION["league_nams"]) ? $_SESSION["league_nams"] : '');
			$league_fr_dat = (isset($_SESSION["league_fr_dat"]) ? $_SESSION["league_fr_dat"] : '');
			$league_to_dat = (isset($_SESSION["league_to_dat"]) ? $_SESSION["league_to_dat"] : '');
			$league_day = (isset($_SESSION["league_day"]) ? $_SESSION["league_day"] : '');
			$league_day_sco = (isset($_SESSION["league_day_sco"]) ? $_SESSION["league_day_sco"] : '');
			$league_ent_fee = (isset($_SESSION["league_ent_fee"]) ? $_SESSION["league_ent_fee"] : '');
			$league_desc = (isset($_SESSION["league_desc"]) ? $_SESSION["league_desc"] : '');
			$league_rul = (isset($_SESSION["league_rul"]) ? $_SESSION["league_rul"] : '');
			$league_activity = (isset($_SESSION["league_activity"]) ? $_SESSION["league_activity"] : '');
		}
		else{
			$query = "SELECT l.lea_nam,l.lea_nams, 
				l.lea_fr_dat,l.lea_to_dat,l.lea_day,l.lea_day_sco,l.lea_ent_fee,l.lea_desc,l.lea_rul, 
				l.org_id,l.leagr_id ,l.activity
				from league l 
				where l.lea_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$league_nam = $row[0];
			$league_nams = $row[1];
			$league_fr_dat = $row[2];
			$league_to_dat = $row[3];
			$league_day = $row[4];
			$league_day_sco = $row[5];
			$league_ent_fee = $row[6];
			$league_desc = $row[7];
			$league_rul = $row[8];
			$league_activity = $row[11];
		}

        
        echo' 
        <form action="admin?league=' . $pageID . '" method="post"> 
            <fieldset> 
                <div class="control-group">
                    <label>Naziv:</label> 
                    <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="league_nam" 
                        value="' . $league_nam . '">
                </div> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter league name..." maxlength="20" name="league_nams" 
                    value="' . $league_nams . '"> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="league_fr_dat"
                    value="' . $league_fr_dat . '"> 
                <input type="text" placeholder="..." maxlength="19" name="league_to_dat"
                    value="' . $league_to_dat . '"> 
                <span class="help-block"></span> 
                <label>Broj kola   -   broj kola koji se boduje:</label> 
                <input class="input-mini" type="text" placeholder="..." name="league_day"
                    value="' . $league_day . '"> 
                <input class="input-mini" type="text" placeholder="..." name="league_day_sco"
                    value="' . $league_day_sco. '"> 
                <span class="help-block"></span> 
                <label>Startnina:</label> 
                <input type="text" placeholder="..." name="league_ent_fee"
                    value="' . $league_ent_fee . '"> 
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_desc"  
                    value="' . $league_desc . '">' . $league_desc . '</textarea> 
                <span class="help-block"></span>  
                <label>Pravila:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_rul"  
                    value="' . $league_rul . '">' . $league_rul . '</textarea> 
                <span class="help-block"></span>                
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="league_activity"
                    value="' . $league_activity . '">
                </div>';  
  
                $query2 = "SELECT clu_id, clu_nam   
                FROM club per"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <div class="control-group">
                <label>Organizator:</label> 
                <select name="league_club"> 
                <option value="null">Select organizer...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
					$selectedClub = $pageID == 'new' ? ($row2[0] == $_SESSION['league_club'] ? "selected=\"selected\"" : "") : 
						($row2[0] == $row[9] ? "selected=\"selected\"" : "");
                    echo '<option value="' . $row2[0] . '" ' . $selectedClub . '>' . $row2[1] . '</option>';        
                } 
                echo ' 
                </select></div>'; 
                  
                $query2 = "SELECT leagr_id, leagr_nam   
                FROM league_group lg"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Liga-grupa:</label> 
                <select name="league_league_group"> 
                <option value="null">Select league group...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
					$selectedStNum = $pageID == 'new' ? ($row2[0] == $_SESSION['league_league_group'] ? "selected=\"selected\"" : "") : 
						($row2[0] == $row[10] ? "selected=\"selected\"" : "");
                    echo '<option value="' . $row2[0] . '" ' . $selectedStNum . '>' . $row2[1] . '</option>';        
                } 
                echo ' 
                </select>'; 
  
        echo' 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }  
    function session_league_unset(){ 
        unset($_SESSION['league_nam']); 
        unset($_SESSION['league_nams']); 
        unset($_SESSION['league_fr_dat']); 
        unset($_SESSION['league_to_dat']); 
        unset($_SESSION['league_desc']); 
        unset($_SESSION['league_day']); 
        unset($_SESSION['league_day_sco']); 
        unset($_SESSION['league_rul']); 
        unset($_SESSION['league_ent_fee']); 
        unset($_SESSION['league_club']); 
        unset($_SESSION['league_league_group']);  
        unset($_SESSION['league_nam']); 
        unset($_SESSION['league_nams']); 
        unset($_SESSION['league_fr_dat']); 
        unset($_SESSION['league_to_dat']); 
        unset($_SESSION['league_desc']); 
        unset($_SESSION['league_day']); 
        unset($_SESSION['league_day_sco']); 
        unset($_SESSION['league_rul']); 
        unset($_SESSION['league_ent_fee']); 
        unset($_SESSION['league_club']); 
        unset($_SESSION['league_league_group']); 
        unset($_SESSION['league_activity']); 
        } 
                          
    function get_page_league_group($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_league_group_all(); 
                break; 
            case 'new': 
                get_page_league_group_edit($pageID); 
                break; 
            default: 
                get_page_league_group_edit($pageID); 
                break;           
        } 
    }        
    function get_page_league_group_all(){ 
        echo' 
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT lg.leagr_id,ifnull(leagr_nams,leagr_nam),lg.org_id,ifnull(c.clu_nams,c.clu_nam),
            lg.sco_id,s.sco_nam,lg.activity
            from league_group lg 
            left join scoring s on lg.sco_id=s.sco_id
            left join club c on lg.org_id=c.clu_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?league_group=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?league_group=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                     <th class="span1"></th> 
                     <th class="span2">Liga-grupa</th> 
                     <th class="span2">Organizator</th> 
                     <th class="span1">Bodovanje</th> 
                     <th class="span2">Datum od-do</th> 
                     <th class="span1"># kola</th> 
                     <th class="span1"># liga</th> 
                     <th class="span1">Aktivnost</th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?league_group=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?league_group=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td><a href="admin?club=' . $row[2] . '">' . $row[3] . '</a></td> 
                    <td><a href="admin?scoring=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>-</td> 
                    <td>0</td> 
                    <td>0</td> 
                    <td>' . $row[6] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_league_group_edit($pageID){ 
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$league_group_nam = (isset($_SESSION["league_group_nam"]) ? $_SESSION["league_group_nam"] : '');
			$league_group_nams = (isset($_SESSION["league_group_nams"]) ? $_SESSION["league_group_nams"] : '');
			$league_group_desc = (isset($_SESSION["league_group_desc"]) ? $_SESSION["league_group_desc"] : '');
			$league_group_rul = (isset($_SESSION["league_group_rul"]) ? $_SESSION["league_group_rul"] : '');
			$league_group_activity = (isset($_SESSION["league_group_activity"]) ? $_SESSION["league_group_activity"] : '');
		}
		else{                      
			$query = "SELECT leagr_nam,leagr_nams,leagr_desc,leagr_rul,org_id,lg.sco_id,lg.activity
				from league_group lg 
				left join scoring s on lg.sco_id=s.sco_id
				left join club c on lg.org_id=c.clu_id
				where lg.leagr_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$league_group_nam = $row[0];
			$league_group_nams = $row[1];
			$league_group_desc = $row[2];
			$league_group_rul = $row[3];
            $league_group_activity = $row[6];
		}
        
        echo' 
        <form action="admin?league_group=' . $pageID . '" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="league_group_nam" 
                    value="' . $league_group_nam . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter league name..." maxlength="20" name="league_group_nams" 
                    value="' . $league_group_nams . '">
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_group_desc"  
                    value="' . $league_group_desc . '">' . $league_group_desc . '</textarea> 
                <span class="help-block"></span>  
                <label>Pravila:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_group_rul"  
                    value="' . $league_group_rul . '">' . $league_group_rul . '</textarea> 
                <span class="help-block"></span>               
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="league_group_activity"
                    value="' . $league_group_activity . '">
                </div>';                  
  
                $query2 = "SELECT clu_id, clu_nam   
                FROM club"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Organizator:</label> 
                <select name="league_group_club"> 
                <option value="null">Select organizer...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
					$selectedClub = $pageID == 'new' ? ($row2[0] == $_SESSION['league_group_club'] ? "selected=\"selected\"" : "") : 
						($row2[0] == $row[4] ? "selected=\"selected\"" : "");
                    echo '<option value="' . $row2[0] . '" ' . $selectedClub . '>' . $row2[1] . '</option>';        
                } 
                echo ' 
                </select>'; 
                  
                $query2 = "SELECT sco_id, sco_nam   
                FROM scoring"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Bodovanje:</label> 
                <select name="league_group_sco"> 
                <option value="null">Select scoring system...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2);  
					$selectedScoring = $pageID == 'new' ? ($row2[0] == $_SESSION['league_group_sco'] ? "selected=\"selected\"" : "") : 
						($row2[0] == $row[5] ? "selected=\"selected\"" : "");
                    echo '<option value="' . $row2[0] . '" ' . $selectedScoring . '>' . $row2[1] . '</option>';        
                } 
                echo ' 
                </select>'; 
  
        echo' 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }     

    function session_league_group_unset(){ 
        unset($_SESSION['league_group_nam']); 
        unset($_SESSION['league_group_nams']); 
        unset($_SESSION['league_group_desc']); 
        unset($_SESSION['league_group_rul']);
        unset($_SESSION['league_group_club']); 
        unset($_SESSION['league_group_rul']); 
        unset($_SESSION['league_group_activity']); 
        }
		                
    function get_page_event($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_event_all(); 
                break; 
            case 'new': 
                get_page_event_edit($pageID); 
                break; 
            default: 
                get_page_event_edit($pageID); 
                break;           
        } 
    }        
    function get_page_event_all(){ 
        echo' 
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT e.eve_id,ifnull(e.eve_nams,e.eve_nam),e.org_id,ifnull(c.clu_nams,c.clu_nam),
            ifnull(e.eve_fr_dat,''),ifnull(e.eve_to_dat,''), 6 as broj, e.eve_rac, e.activity 
            from event e 
            left join club c on e.org_id=c.clu_id"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?event=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?event=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                     <th class="span1"></th> 
                     <th class="span2">Dogadaj</th> 
                     <th class="span2">Organizator</th> 
                     <th class="span2">Datum od-do</th> 
                     <th class="span1"># utrka</th> 
                     <th class="span1">Utrke</th> 
                     <th class="span1">Aktivnost</th> 
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?event=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?event=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td><a href="admin?club=' . $row[2] . '">' . $row[3] . '</a></td> 
                    <td>' . $row[4] . ' - ' . $row[5] . '</td> 
                    <td>' . $row[6] . '</td> 
                    <td>' . $row[7] . '</td> 
                    <td>' . $row[8] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_event_edit($pageID){  
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$event_nam = (isset($_SESSION["event_nam"]) ? $_SESSION["event_nam"] : '');
			$event_nams = (isset($_SESSION["event_nams"]) ? $_SESSION["event_nams"] : '');
			$event_fr_dat = (isset($_SESSION["event_fr_dat"]) ? $_SESSION["event_fr_dat"] : '');
			$event_to_dat = (isset($_SESSION["event_to_dat"]) ? $_SESSION["event_to_dat"] : '');
			$event_start_dat = (isset($_SESSION["event_start_dat"]) ? $_SESSION["event_start_dat"] : '');
			$event_limit_dat = (isset($_SESSION["event_limit_dat"]) ? $_SESSION["event_limit_dat"] : '');
			$event_rac = (isset($_SESSION["event_rac"]) ? $_SESSION["event_rac"] : '');
			$event_desc = (isset($_SESSION["event_desc"]) ? $_SESSION["event_desc"] : '');
			$event_rul = (isset($_SESSION["event_rul"]) ? $_SESSION["event_rul"] : '');
			$event_activity = (isset($_SESSION["event_activity"]) ? $_SESSION["event_activity"] : '');
		}
		else{    
			$query = "SELECT e.eve_nam,e.eve_nams,e.eve_fr_dat,e.eve_to_dat, eve_start_dat,eve_limit_dat,
				eve_rac,eve_desc,eve_rul,e.org_id,e.activity
				from event e 
				left join club c on e.org_id=c.clu_id
				where e.eve_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$event_nam = $row[0];
			$event_nams = $row[1];
			$event_fr_dat = $row[2];
			$event_to_dat = $row[3];
			$event_start_dat = $row[4];
			$event_limit_dat = $row[5];
			$event_rac = $row[6];
			$event_desc = $row[7];
			$event_rul = $row[8];
            $event_activity = $row[10];
		}
        
        echo' 
        <form action="admin?event=' . $pageID . '" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type event name..." maxlength="80" name="event_nam" 
                    value="' . $event_nam . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter event name..." maxlength="20" name="event_nams" 
                    value="' . $event_nams . '"> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="event_fr_dat"
                    value="' . $event_fr_dat . '"> 
                <input type="text" placeholder="..." maxlength="19" name="event_to_dat"
                    value="' . $event_to_dat . '"> 
                <span class="help-block"></span> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="event_start_dat"
                    value="' . $event_start_dat . '"> 
                <input type="text" placeholder="..." maxlength="19" name="event_limit_dat"
                    value="' . $event_limit_dat . '"> 
                <span class="help-block"></span> 
                <label>Utrke (id):</label> 
                <textarea rows="2" type="text" placeholder="Type event race id\'s..." maxlength="200" name="event_rac"  
                    value="' . $event_rac . '">' . $event_rac . '</textarea> 
                <span class="help-block"></span> 
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="event_desc"  
                    value="' . $event_desc . '">' . $event_desc . '</textarea> 
                <span class="help-block"></span>  
                <label>Pravila:</label> 
                <textarea rows="3" type="text" placeholder="Type rules..." maxlength="200" name="event_rul"  
                    value="' . $event_rul . '">' . $event_rul . '</textarea> 
                <span class="help-block"></span>        
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="event_activity"
                    value="' . $event_activity . '">
                </div>';  
  
                $query2 = "SELECT clu_id, clu_nam   
                FROM club"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Organizator:</label> 
                <select name="event_club"> 
                <option value="null">Select organizer...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
					$selectedClub = $pageID == 'new' ? ($row2[0] == $_SESSION['event_club'] ? "selected=\"selected\"" : "") : 
						($row2[0] == $row[9] ? "selected=\"selected\"" : "");
                    echo '<option value="' . $row2[0] . '" ' . $selectedClub  . '>' . $row2[1] . '</option>';        
                } 
                echo ' 
                </select>';  
        echo' 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }     

    function session_event_unset(){ 
        unset($_SESSION['event_nam']); 
        unset($_SESSION['event_nams']); 
        unset($_SESSION['event_fr_dat']); 
        unset($_SESSION['event_to_dat']); 
        unset($_SESSION['event_start_dat']); 
        unset($_SESSION['event_limit_dat']); 
        unset($_SESSION['event_rac']); 
        unset($_SESSION['event_rul']); 
        unset($_SESSION['event_desc']);
        unset($_SESSION['event_club']);
        unset($_SESSION['event_activity']); 
        } 
        
    function get_page_town(){ 
          
    }   
    function get_page_county(){ 
          
    }      
    function get_page_country(){ 
          
    }      
    function get_page_currency(){ 
          
    }    
	function get_page_scoring($pageID){ 
        switch($pageID){ 
            case '': 
                get_page_scoring_all(); 
                break; 
            case 'new': 
                get_page_scoring_edit($pageID); 
                break; 
            default: 
                get_page_scoring_edit($pageID); 
                break;           
        } 
    }        
    function get_page_scoring_all(){ 
        echo' 
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT sco_id,sco_nam,sco_sys,activity
            from scoring"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num==0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?scoring=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?scoring=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
                <thead> 
                <tr> 
                     <th class="span1"></th> 
                     <th class="span2">Naziv</th> 
                     <th class="span4">Sustav</th>
                     <th class="span1">Aktivnost</th>
                </tr> 
                </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?scoring=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?scoring=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '</td>
                    <td>' . $row[3] . '</td>
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }    
    function get_page_scoring_edit($pageID){		
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$scoring_nam = (isset($_SESSION["scoring_nam"]) ? $_SESSION["scoring_nam"] : '');
			$scoring_sys = (isset($_SESSION["scoring_sys"]) ? $_SESSION["scoring_sys"] : '');
			$scoring_desc = (isset($_SESSION["scoring_desc"]) ? $_SESSION["scoring_desc"] : '');
			$scoring_activity = (isset($_SESSION["scoring_activity"]) ? $_SESSION["scoring_activity"] : '');
		}
		else{     
			$query = "SELECT sco_nam,sco_sys,sco_desc,activity
				from scoring 
				where sco_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			
			$scoring_nam = $row[0];
			$scoring_sys = $row[1];
			$scoring_desc = $row[2];
            $scoring_activity = $row[3];
		}
        
        echo' 
        <form action="admin?scoring=' . $pageID . '" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="scoring_nam" 
                    value="' . $scoring_nam . '"> 
                <label>Sustav:</label> 
                <textarea rows="3" type="text" placeholder="Type system..." maxlength="200" name="scoring_sys"  
                    value="' . $scoring_sys . '">' . $scoring_sys . '</textarea> 
                <span class="help-block"></span>  
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="scoring_desc"  
                    value="' . $scoring_desc . '">' . $scoring_desc . '</textarea> 
                <span class="help-block"></span>   
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="scoring_activity"
                    value="' . $scoring_activity . '">
                </div>               
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }     
     
	function session_scoring_unset(){ 
        unset($_SESSION['scoring_nam']); 
        unset($_SESSION['scoring_sys']); 
        unset($_SESSION['scoring_desc']); 
        unset($_SESSION['scoring_activity']); 
        }    
    
	function get_page_user(){ 
          
    }    
    function get_page_role(){ 
          
    } 
	
    function get_page_start_num($pageID, $snID){ 
        switch($pageID){ 
            case '': 
                get_page_start_num_all(); 
                break; 
            case 'new': 
                get_page_start_num_edit($pageID, ''); 
                break; 
            default: 
                get_page_start_num_edit($pageID, $snID); 
                break;    
        } 
    }        
    function get_page_start_num_all(){ 
        echo
        '<table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT s.st_id, st_nam, st_typ, activity
            FROM start s"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num == 0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?st_num=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?st_num=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span1">R.br.</th> 
                <th class="span3">Naziv</th> 
                <th class="span2">Tip</th> 
                <th class="span1">Aktivnost</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td><a href="admin?st_num=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td>' . ($i+1) . '.</td> 
                    <td><a href="admin?st_num=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '</td> 
                    <td>' . $row[3] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }  
    function get_next_sn($st_id){
        $query = "SELECT max(sn_id)+1
            FROM st_num
            where st_id='$st_id';"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 

        if($num<1) return 1;
        else {   
            $row = mysqli_fetch_row($result);
            return $row[0];
        }
    }  
    function get_page_start_num_edit($pageID, $snID){ 
        echo '<h2>Startni brojevi</h2>';
        
		if($pageID == null || $pageID == '' || $pageID == 'new'){
			$pageID = 'new';
			
			$st_num_name = (isset($_SESSION['st_num_name']) ? $_SESSION['st_num_name'] : '');
			$st_num_type = (isset($_SESSION['st_num_type']) ? $_SESSION['st_num_type'] : '');
			$st_num_activity = (isset($_SESSION['st_num_activity']) ? $_SESSION['st_num_activity'] : '');
		}
		else{
			$query = "SELECT s.st_id, st_nam, st_typ, activity
				FROM start s
				where s.st_id=" .$pageID; 
			$result = queryMysql($query); 
			$num = mysqli_num_rows(queryMysql($query)); 
			$row = mysqli_fetch_row($result); 
			 
			$st_num_name = $row[1];
			$st_num_type = $row[2];
			$st_num_activity = $row[3];
		}
		
        echo' 
        <form action="admin?st_num=' . $pageID . '" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input type="text" class="input-xxlarge" placeholder="Type st. number name..." maxlength="80" name="st_num_name"
                    value="' . $st_num_name . '">  
                <label>Tip:</label> 
                <input type="text" class="input-mini" placeholder="Type st. number type..." maxlength="80" name="st_num_type" 
                    value="' . $st_num_type . '"> 
                <span class="help-block"></span> 
                <div class="control-group">
                    <label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> <input type="text" placeholder="D/N" name="st_num_activity"
                    value="' . $st_num_activity . '">
                </div>  
            <button type="submit" id="spremi" class="btn">Spremi</button> 
            </fieldset> 
        </form>'; 
      
		if($pageID != 'new'){
			get_page_start_num_id($pageID); 
			
			if($snID == "new"){
				
				//$sn = (isset($_SESSION['st_num_sn']) ? ($_SESSION['st_num_sn'] != '' ? $_SESSION['st_num_sn'] : get_next_sn($pageID)) : get_next_sn($pageID));
				
				echo '
				<br/><br/>
				<form action="admin?st_num=' . $pageID . '&sn=new" method="post"> 
					<fieldset> 
						<label>Startni broj:</label> 
						<input type="text" class="input-mini" placeholder="Type st. number..." maxlength="11" name="st_num_sn"
							value="' . get_next_sn($pageID) . '">';
							
				$query = "SELECT per_id, concat(per_nam, ' ', per_sur)   
					FROM person"; 
				$result = queryMysql($query); 
				$num = mysqli_num_rows(queryMysql($query)); 
				  
				echo' 
				<label>Osoba:</label> 
				<select name="st_num_sn_par"> 
				<option value="null">Select participant...</option>'; 
				for($i=0;$i<$num;$i++){   
					$row = mysqli_fetch_row($result); 
					echo'  
					<option value="' . $row[0] . '" ' . ($row[0] == $_SESSION['st_num_sn_per'] ? "selected=\"selected\"" : "") . '>' . $row[1] . '</option>';   
				}
				echo'
					</select> 
					<span class="help-block"></span> 
					<button type="submit" id="spremi" class="btn">Spremi</button> 
					</fieldset> 
				</form>'; 
			}
			else if($snID != ''){ 
				$query = "SELECT sn_id, st.per_id, concat(per.per_nam, ' ', per.per_sur)
					FROM start s
					inner join st_num st on s.st_id=st.st_id
					inner join person per on st.per_id=per.per_id
					where s.st_id=" . $pageID . " and st.sn_id=" . $snID;
				$result = queryMysql($query); 
				$num = mysqli_num_rows(queryMysql($query)); 
				$row = mysqli_fetch_row($result); 
			
				echo'  
				<form action="admin?st_num=' . $pageID . '&sn=' . $snID . '" method="post"> 
					<fieldset> 
						<label>Startni broj:</label> 
						<input type="text" class="input-mini" placeholder="Type st. number..." maxlength="11" name="st_num_sn"
							value="' . $row[0] . '" disabled>';
							
				$query2 = "SELECT per_id, concat(per_nam, ' ', per_sur)   
					FROM person"; 
				$result2 = queryMysql($query2); 
				$num2 = mysqli_num_rows(queryMysql($query2)); 
				  
				echo' 
				<label>Osoba:</label> 
				<select name="st_num_sn_par"> 
				<option value="null">Select participant...</option>'; 
				for($i=0;$i<$num2;$i++){   
					$row2 = mysqli_fetch_row($result2); 
					echo'  
					<option value="' . $row2[0] . '" ' . ($row2[0] == $row[1] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
				} 
				echo' 
				</select> 
				<span class="help-block"></span> 
				<button type="submit" id="spremi" class="btn">Spremi</button> 
				</fieldset> 
				</form>'; 
			}
			else{
				echo '
				<br/>
				<a href="admin?st_num=' . $pageID . '&sn=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
			}
		}
    } 
    function get_page_start_num_id($pageID){
        echo
        '<br/><br/>
        <legend>Startni brojevi <-> osobe</legend>
        <table class="table table-condensed table-hover table-striped">'; 
                    
        $query2 = "SELECT sn_id, st.per_id, concat(per.per_nam, ' ', per.per_sur), per.clu_id, c.clu_nam
        	FROM start s
        	inner join st_num st on s.st_id=st.st_id
        	inner join person per on st.per_id=per.per_id
            left join club c on per.clu_id=c.clu_id
        	where s.st_id=" . $pageID; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2));   
      
        if($num2==0){ 
            echo 'Empty database'; 
        } 
        else{           
            echo'
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span1">Startni broj</th> 
                <th class="span1">Natjecatelj</th> 
                <th class="span4">Klub</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num2;$i++){ 
                $row = mysqli_fetch_row($result2); 
                echo ' 
                <tr> 
                    <td><a href="admin?st_num=' . $pageID . '&sn=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?st_num=' . $pageID . '&sn=' . $row[0] . '">' . $row[0] . '.</td> 
                    <td><a href="admin?participant=' . $row[1] . '">' . $row[2] . '</a></td> 
                    <td><a href="admin?club=' . $row[3] . '">' . $row[4] . '</a></td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }
    function session_start_num_unset(){
        unset($_SESSION['st_num_name']); 
        unset($_SESSION['st_num_type']); 
        unset($_SESSION['st_num_sn_par']); 
        unset($_SESSION['st_num_sn']);
        unset($_SESSION['st_num_activity']); 
        }  
    
	
    function get_page_results($pageID, $resID){ 
        switch($pageID){ 
            case '': 
                get_page_results_all(); 
                break; 
            case 'new': 
                get_page_results_edit($pageID, ''); 
                break; 
            default: 
                get_page_results_edit($pageID, $resID); 
                break;    
        } 
    }        
    function get_page_results_all(){ 
        echo
        '<table class="table table-condensed table-hover table-striped">'; 
                    
        $query = "SELECT rr.rac_id, r.rac_nam, count(rr.res_Id) 
            FROM race_result rr
			inner join race r on rr.rac_id=r.rac_id
			group by rr.rac_id, r.rac_nam"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
      
        if($num == 0){ 
            echo 'Empty database'; 
            echo'<br/><br/><a href="admin?results=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
        } 
        else{           
            echo'    
            <a href="admin?results=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
            <br/><br/> 
            <thead> 
            <tr> 
                <th class="span1">R.br.</th> 
                <th class="span3">Utrka</th> 
                <th class="span1">Broj rezultata</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num;$i++){ 
                $row = mysqli_fetch_row($result); 
                echo ' 
                <tr> 
                    <td>' . ($i+1) . '.</td> 
                    <td><a href="admin?results=' . $row[0] . '">' . $row[1] . '</a></td> 
                    <td>' . $row[2] . '</td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }  
	
    function get_page_results_edit($pageID, $resID){ 
        echo '<h2>Rezultati</h2>';
		
		
		//moA3da srediti da �?ita umjesto   admin?results=1&res=13   admin?results=1&sn=5
		
		
        echo' 
        <form action="admin?results=' . $pageID . '" method="get"> 
            <fieldset> 
                <div class="control-group">
					<label>Utrka:</label> 
					<select name="results" ' . ($pageID == "" || $pageID == "new" || $pageID == "null" ? "" : "disabled") . '  class="span4"> 
					<option value="null">Select race...</option>'; 
					$query2 = "SELECT rac_id, rac_nam FROM race"; 
					$result2 = queryMysql($query2); 
					$num2 = mysqli_num_rows(queryMysql($query2)); 
					for($i=0;$i<$num2;$i++){   
						$row2 = mysqli_fetch_row($result2); 
						echo'  
						<option value="' . $row2[0] . '" ' . ($row2[0] == $pageID ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
					} 
					echo' 
					</select> 
                </div>';  
            echo ($pageID == "" || $pageID == "new" || $pageID == "null" ? "<button type=\"submit\" id=\"spremi\" class=\"btn\">Odaberi</button>" : "");
            echo '</fieldset> 
        </form>'; 
      
		if($pageID != 'new'){
			get_page_results_id($pageID); 
			
			if($resID == "new")
			{
				$results_sn_id = (isset($_SESSION["results_sn_id"]) ? $_SESSION["results_sn_id"] : '');
				$results_per_sn_id = (isset($_SESSION["results_per_sn_id"]) ? $_SESSION["results_per_sn_id"] : '');
				$results_res_fin_time = (isset($_SESSION["results_res_fin_time"]) ? $_SESSION["results_res_fin_time"] : '');
				$results_res_fin_time_sec = (isset($_SESSION["results_res_fin_time_sec"]) ? $_SESSION["results_res_fin_time_sec"] : '');
				$results_res_start = (isset($_SESSION["results_res_start"]) ? $_SESSION["results_res_start"] : '');
				$results_res_time = (isset($_SESSION["results_res_time"]) ? $_SESSION["results_res_time"] : '');
				$results_res_transfer_typ = (isset($_SESSION["results_res_transfer_typ"]) ? $_SESSION["results_res_transfer_typ"] : '');
				$results_res_pen = (isset($_SESSION["results_res_pen"]) ? $_SESSION["results_res_pen"] : '');
				$results_activity = (isset($_SESSION["results_activity"]) ? $_SESSION["results_activity"] : '');
			}
			else if($resID != "")
			{
				$query = "SELECT rr.sn_id, st.per_id, concat(per.per_nam, ' ', per.per_sur), rr.res_fin_time, rr.res_fin_time_sec, rr.res_start, rr.res_time, rr.res_transfer_typ, rr.res_pen, 
					rr.activity, rr.date, rr.res_mob_id 
					FROM race_result rr
					inner join race r on rr.rac_id=r.rac_id
					inner join start s on r.st_id=s.st_id
					inner join st_num st on st.st_id=s.st_id and rr.sn_id=st.sn_id
					inner join person per on st.per_id=per.per_id
					where rr.res_id=" . $resID;
				$result = queryMysql($query); 
				$num = mysqli_num_rows(queryMysql($query)); 
				$row = mysqli_fetch_row($result); 
				
				$results_sn_id = $row[0];
				$results_per_sn_id = $row[1];
				$results_res_fin_time = $row[3];
				$results_res_fin_time_sec = $row[4];
				$results_res_start = $row[5];
				$results_res_time = $row[6];
				$results_res_transfer_typ = $row[7];
				$results_res_pen = $row[8];
				$results_activity = $row[9];
			}
			
			if($resID != "")
			{
				echo'<br />  
				<form action="admin?results=' . $pageID . '&res=' . $resID . '" method="post"> 
					<fieldset> 
						<div class="control-group"><label>Startni broj:</label> 
						<input type="text" placeholder="Type st. number..." maxlength="11" name="results_sn_id"
							value="' . $row[0] . '">
						</div>';
														
						//ispiU� samo registrirane osobe
						$query2 = "SELECT st.sn_id, concat(per_nam, ' ', per_sur) participant  
							FROM person p
							inner join st_num st on p.per_id=st.per_id
							inner join start s on st.st_id=s.st_id
							inner join race r on r.st_id=s.st_id
							where r.rac_id = " . $pageID . " order by participant"; 
						$result2 = queryMysql($query2); 
						$num2 = mysqli_num_rows(queryMysql($query2)); 
						  
						echo' 
						<div class="control-group">
							<label>Osoba:</label> 
							<select name="results_per_sn_id"> 
							<option value="null">Select participant...</option>'; 
							for($i=0;$i<$num2;$i++){   
								$row2 = mysqli_fetch_row($result2); 
								echo'  
								<option value="' . $row2[0] . '" ' . ($row2[0] == $row[0] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';      
							} 
							echo' 
							</select>
						</div> 
						<div class="control-group">
							<label>Rezultat:</label> 
							<input type="text" placeholder="Type result..." maxlength="11" name="results_res_fin_time"
								value="' . $results_res_fin_time . '">
						</div>
						<div class="control-group">
							<label>Rezultat (sec):</label> 
							<input type="text" placeholder="Type result in sec..." maxlength="11" name="results_res_fin_time_sec"
								value="' . $results_res_fin_time_sec . '">
						</div>
						<label>Start (YYYY-MM-DD HH:MM:SS):</label> 
						<input type="text" placeholder="..." maxlength="19" name="results_res_start"
							value="' . $results_res_start . '">
						<label>Cilj (YYYY-MM-DD HH:MM:SS):</label> 
						<input type="text" placeholder="..." maxlength="19" name="results_res_time"
							value="' . $results_res_time . '">
						<label>Tip:</label> 
						<input type="text" placeholder="Result type..." maxlength="11" name="results_res_transfer_typ"
							value="' . $results_res_transfer_typ . '">
						<label>Kazna:</label> 
						<input type="text" placeholder="Penalty" maxlength="11" name="results_res_pen"
							value="' . $results_res_pen . '">
						<label>Aktivnost (ako nije aktivna ne&#263;e se prikazivati!)</label> 
						<input type="text" placeholder="D/N" name="results_activity"
							value="' . $results_activity .'" disabled>
					<span class="help-block"></span> 
					<button type="submit" id="spremi" class="btn">Spremi</button> 
					</fieldset> 
				</form>'; 
			}
			else{
				echo '
				<br/>
				<a href="admin?results=' . $pageID . '&res=new"><span aria-hidden="true" class="icon-plus-5"></span></a>';
			}
		}
    } 
	
    function get_page_results_id($pageID){
        echo
        '<table class="table table-condensed table-hover table-striped">'; 
                    
        $query2 = "SELECT rr.res_id, rr.sn_id, st.per_id, concat(per.per_nam, ' ', per.per_sur), per.clu_id, c.clu_nam, 
			rr.res_fin_time, rr.res_fin_time_sec, rr.res_start, rr.res_time, rr.res_transfer_typ 
        	FROM race_result rr
        	inner join race r on rr.rac_id=r.rac_id
            inner join start s on r.st_id=s.st_id
        	inner join st_num st on st.st_id=s.st_id and rr.sn_id=st.sn_id
        	inner join person per on st.per_id=per.per_id
            left join club c on per.clu_id=c.clu_id
        	where rr.rac_id = " . $pageID . " 
			order by rr.res_fin_time_sec, rr.res_fin_time"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2));   
      
        if($num2==0){ 
            echo 'Empty database'; 
        } 
        else{           
            echo'
            <thead> 
            <tr> 
                <th class="span1"></th> 
                <th class="span1">St. broj</th> 
                <th class="span1">Natjecatelj</th> 
                <th class="span4">Klub</th> 
                <th class="span1">Rez.</th> 
                <th class="span1">Rez.(sec)</th> 
                <th class="span1">Start</th> 
                <th class="span1">Cilj</th> 
                <th class="span1">Tip</th> 
            </tr> 
            </thead> 
            <tbody>'; 
            for($i=0;$i<$num2;$i++){ 
                $row = mysqli_fetch_row($result2); 
                echo ' 
                <tr> 
                    <td><a href="admin?results=' . $pageID . '&res=del&id=' . $row[0] . '" class="delete"><span aria-hidden="true" class="icon-erase"></span></a></td> 
                    <td><a href="admin?results=' . $pageID . '&res=' . $row[0] . '">' . $row[1] . '.</td> 
                    <td><a href="admin?participant=' . $row[2] . '">' . $row[3] . '</a></td> 
                    <td><a href="admin?club=' . $row[4] . '">' . $row[5] . '</a></td> 
                    <td>' . $row[6] . '</a></td> 
                    <td>' . $row[7] . '</a></td> 
                    <td>' . $row[8] . '</a></td> 
                    <td>' . $row[9] . '</a></td> 
                    <td>' . $row[10] . '</a></td> 
                </tr>';        
            } 
        echo ' 
        </tbody>'; 
        } 
          
        echo ' 
        </table>'; 
    }
    function session_results_unset(){
        unset($_SESSION['results_sn_id']); 
        unset($_SESSION['results_per_sn_id']); 
        unset($_SESSION['results_res_fin_time']); 
        unset($_SESSION['results_res_fin_time_sec']); 
        unset($_SESSION['results_res_start']); 
        unset($_SESSION['results_res_time']); 
        unset($_SESSION['results_res_transfer_typ']); 
        unset($_SESSION['results_res_pen']);
        unset($_SESSION['results_activity']); 
        }  
		
    function get_page_general(){ 
          
    }    
?> 
  
<script type="text/javascript"> 
    /**
 * $page='race';   
 *     $pageID=$_GET['race']; 
 *     $delID=isset($_GET['id']) ? $_GET['id'] : ''; 
 *       
 *     if($pageID != "new" && $pageID != "" && $pageID != "del"){
 *         $query='select ifnull(count(*),0) from race where rac_id='. $pageID . ';'; 
 *         //echo $query; 
 *         $result = queryMysql($query); 
 * 		$row = mysqli_fetch_row($result); 
 *         if($row[0]<1) {
 *             unset($_GET['race']);
 *             session_race_unset(); 
 *             header("Location: admin?race=");
 *             }
 *     }
 */
$(document).ready(function(){ 
    //ako je get sloveani onda ga ne ku?, ne izbacuje ni?
    var page = "1";
    race = "<?php echo (isset($_GET['race']) ? ($_GET['race'] == "new" ? "new race" : $_GET['race']) : ''); ?>";
    participant = "<?php echo (isset($_GET['participant']) ? ($_GET['participant'] == "new" ? "new participant" : $_GET['participant']) : ''); ?>";
    club = "<?php echo (isset($_GET['club']) ? ($_GET['club'] == "new" ? "new club" : $_GET['club']) : ''); ?>";
    league = "<?php echo (isset($_GET['league']) ? ($_GET['league'] == "new" ? "new league" : $_GET['league']) : ''); ?>";
    results = "<?php echo (isset($_GET['results']) ? ($_GET['results'] == "new" ? "new results" : $_GET['results']) : ''); ?>";
    //alert(results);
    //alert(race);            
	
    if(race !== "")
    {
        $('select[name="race_st_num"]').closest("div").addClass("info");
        $('input[name="race_nam"]').closest("div").addClass("info");
        $('input[name="race_fr_dat"]').closest("div").addClass("info");
        $('select[name="race_club"]').closest("div").addClass("info");
        $('input[name="race_kmh"]').closest("div").addClass("info");
        $('input[name="race_kmv"]').closest("div").addClass("info");
        $('input[name="race_activity"]').closest("div").addClass("info");
    } 
	else if(participant !== "")
	{
        $('input[name="participant_nam"]').closest("div").addClass("info");
        $('input[name="participant_sur"]').closest("div").addClass("info");
        $('select[name="participant_club"]').closest("div").addClass("info");
        $('input[name="participant_god_rodj"]').closest("div").addClass("info");
        $('input[name="participant_email"]').closest("div").addClass("info");
        $('input[name="participant_mob"]').closest("div").addClass("info");
        $('input[name="participant_activity"]').closest("div").addClass("info");
	} 
	else if(club !== "")
	{
        $('input[name="club_nam"]').closest("div").addClass("info");
        $('input[name="club_activity"]').closest("div").addClass("info");
	}
	else if(league !== "")
	{
        $('input[name="league_nam"]').closest("div").addClass("info");
        $('select[name="league_club"]').closest("div").addClass("info");
        $('input[name="league_activity"]').closest("div").addClass("info");
	}
	else if(results !== "")
    {
		$('input[name="results_sn_id"]').closest("div").addClass("info");
        $('select[name="results_per_sn_id"]').closest("div").addClass("info");
        $('input[name="results_res_fin_time"]').closest("div").addClass("info");
        //$('input[name="results_res_fin_time_sec"]').closest("div").addClass("info");
	}
	
    //document.body.style.cursor = <?php //echo '<span aria-hidden="true" class="icon-hourglass"></span>';?>;
    $('#osnovno-active li a').each(function(index) { 
        var $href = $(this).attr('href'); 
        var w = window.location.toString(); 
        //var n1 = w.indexOf("konj"); 
        var n2 = w.indexOf("="); 
        var $page = w.substring(0, n2+1); 
        if(this.href.trim() == $page){ 
            $(this).parent().addClass("active"); 
            } 
    }); 
      
    $('#races-active li a').each(function(index) { 
        var $href = $(this).attr('href'); 
        var w = window.location.toString(); 
        //var n1 = w.indexOf("konj"); 
        var n2 = w.indexOf("="); 
        var $page = w.substring(0, n2+1); 
        if(this.href.trim() == $page){ 
            $(this).parent().addClass("active"); 
            } 
    }); 
        
    $('.delete').click(function(e){
        var answer = confirm ("Obrisati?");
        if (!answer)
    		e.preventDefault();
    });

	//results
	$('select[name="results_per_sn_id"]')
	  .change(function() {
		var a = $('select[name="results_per_sn_id"] option:selected').val();
        $('input[name="results_sn_id"]').val(a);        
	  });
	$('input[name="results_sn_id"]')
	  .change(function() {
		var a = $('input[name="results_sn_id"]').val();
        $('select[name="results_per_sn_id"]').val(a);        
	  });
      
	$('input[name="results_res_fin_time"]')
	  .change(function() {
		var a = $('input[name="results_res_fin_time"]').val();
        
        var parts = a.split(":");
        var milis = 1;
 	    var noviResLong = 0;
 	    if(parts.length == 2)
 		    noviResLong = milis * (parts[0]*60 + +parts[1]);
 	    else if(parts.length == 3)
 		    noviResLong = milis * (parts[0]*60*60 + parts[1]*60 + +parts[2]);
 	    else if(parts.length == 4)
                    noviResLong = milis * (parts[0]*60*60*24 + parts[1]*60*60 + parts[2]*60 + +parts[3]);
 	    else
 		    noviResLong = milis * (parts[0]*60*60 + parts[1]*60 + +parts[2]);
           
        $('input[name="results_res_fin_time_sec"]').val(noviResLong);        
	  });
	//results
	
    $('#spremi').click(function(e){
		error=false;
        //alert("<?php echo $pageID; ?>");
		$(".control-group").removeClass("error");
		$(".control-group").removeClass("info");
		if(typeof($('select[name="race_st_num"] option:selected').val()) !== 'undefined')
        {
            var a = $('select[name="race_st_num"] option:selected').val();
                $.ajax({
                   url: 'getDBValue.php',
                   type: 'POST',
                   async: false,
                   data: {race_st_num: a, type: "check_race_st_id", race: "<?php echo (isset($pageID) ? $pageID : ""); ?>"},
                   success: function (data) 
                    {
                        data = data.trim();
                        //alert(data);
                        if(data == "null")
                        {
        	              error=true;
             			  $('select[name="race_st_num"]').closest("div").addClass("error");
                		  $('span.help-inline').remove();
                		  $('select[name="race_st_num"]').closest("div").append("<span class=\"help-inline\">St. brojevi se ne smiju mijenjati!</span>");
                          alert("Za utrku nije dozvoljeno mijenjati st. brojeve ako ve\u0107 postoje upisani rezultati s tim st. brojevima!");
                        }
                        else if(data == "1" || data == "")
                        {
        	              error=true;
                		  $('select[name="race_st_num"]').closest("div").addClass("error");
                		  $('span.help-inline').remove();
                		  $('select[name="race_st_num"]').closest("div").append("<span class=\"help-inline\">St. brojevi se ne smiju mijenjati!</span>");
                          alert("Za utrku nije dozvoljeno mijenjati st. brojeve ako ve\u0107 postoje upisani rezultati s tim st. brojevima!");
                        }
                        else
                        {
        	              error=false;
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("error" + status);
                    // executed if something went wrong during call
                    if (xhr.status > 0) alert('Error: ' + status); // status 0 - when load is interrupted
                    
                }
            });
			
			if($.trim($('select[name="race_st_num"]').val()) == '') $('select[name="race_st_num"]').closest("div").addClass("error");
			if($.trim($('input[name="race_nam"]').val()) == '') $('input[name="race_nam"]').closest("div").addClass("error");
			if($.trim($('input[name="race_fr_dat"]').val()) == '') $('input[name="race_fr_dat"]').closest("div").addClass("error");
			if($.trim($('select[name="race_club"]').val()) == '' || $('select[name="race_club"]').val() == "null") $('select[name="race_club"]').closest("div").addClass("error");
			if($.trim($('input[name="race_kmh"]').val()) == '') $('input[name="race_kmh"]').closest("div").addClass("error");
			if($.trim($('input[name="race_kmv"]').val()) == '') $('input[name="race_kmv"]').closest("div").addClass("error");
			if($.trim($('input[name="race_activity"]').val()) == '') $('input[name="race_activity"]').closest("div").addClass("error");
    	}
		else if(typeof($('select[name="participant_club"] option:selected').val()) !== 'undefined')
		{
			if($.trim($('input[name="participant_nam"]').val()) == '') {$('input[name="participant_nam"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="participant_sur"]').val()) == '') {$('input[name="participant_sur"]').closest("div").addClass("error");error=true;}
			if($.trim($('select[name="participant_club"]').val()) == '' || $('select[name="participant_club"]').val() == "null" ) {$('select[name="participant_club"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="participant_god_rodj"]').val()) == '') {$('input[name="participant_god_rodj"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="participant_email"]').val()) == '') {$('input[name="participant_email"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="participant_mob"]').val()) == '') {$('input[name="participant_mob"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="participant_activity"]').val()) == '') {$('input[name="participant_activity"]').closest("div").addClass("error");error=true;}
		}
		else if(typeof($('input[name="club_nam"]').val()) !== 'undefined')
		{
			if($.trim($('input[name="club_nam"]').val()) == '') {$('input[name="club_nam"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="club_activity"]').val()) == '') {$('input[name="club_activity"]').closest("div").addClass("error");error=true;}
		}
		else if(typeof($('input[name="league_nam"]').val()) !== 'undefined')
		{
			if($.trim($('input[name="league_nam"]').val()) == '') {$('input[name="league_nam"]').closest("div").addClass("error");error=true;}
			if($.trim($('select[name="league_club"]').val()) == '' || $('select[name="league_club"]').val() == "null" ) {$('select[name="league_club"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="league_activity"]').val()) == '') {$('input[name="league_activity"]').closest("div").addClass("error");error=true;}
		}
		else if(typeof($('input[name="results_sn_id"]').val()) !== 'undefined')
		{
			if($.trim($('input[name="results_sn_id"]').val()) == '') {$('input[name="results_sn_id"]').closest("div").addClass("error");error=true;}
			if($.trim($('select[name="results_per_sn_id"]').val()) == '' || $('select[name="results_per_sn_id"]').val() == "null" ) {$('select[name="results_per_sn_id"]').closest("div").addClass("error");error=true;}
			if($.trim($('input[name="results_res_fin_time"]').val()) == '') {$('input[name="results_res_fin_time"]').closest("div").addClass("error");error=true;}
			//if($.trim($('input[name="results_res_fin_time_sec"]').val()) == '') {$('input[name="results_res_fin_time_sec"]').closest("div").addClass("error");error=true;}
		}

    	if(error)
        {
            //alert(error);
    		e.preventDefault();
		}
		else
		{
			//POST
		}
	});
}); 
	
//treba doraditi da za natjecatelje ima jedan check, za trke drugi,...
function checkForm(type) {
    if(document.getElementById('name').value.trim() == ''){
        $("#errorDiv").html("<font color=red>Upi? ime!</font>");   
        return false;
    }
    else if(document.getElementById('surname').value.trim() == ''){
        $("#errorDiv").html("<font color=red>Upi? prezime!</font>");   
        return false;
    }
    else if(document.getElementById('god_rodj').value.trim() == '' || 
            document.getElementById('god_rodj').value.trim().length != 4 || 
            document.getElementById('god_rodj').value.trim() <="1900" || 
            document.getElementById('god_rodj').value.trim() >="2000"){
        $("#errorDiv").html("<font color=red>Upi? ispravnu godinu rodenja!</font>");   
        return false;
    }
    else if(document.getElementById('god_rodj').value.trim() == '' && 
            document.getElementById('god_rodj').value.trim().length != 4 || 
            document.getElementById('god_rodj').value.trim() <="1900" || 
            document.getElementById('god_rodj').value.trim() >="2000"){
        $("#errorDiv").html("<font color=red>Ako je odabrana liga onda trka mora imati redni broj kola!</font>");   
        return false;
    }
    else{
    }
}
</script>