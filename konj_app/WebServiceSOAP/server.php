<?php
require_once '../functions.php';
//require_once '../components.php';
$p = isset($_GET['p']) ? $_GET['p'] : "";
$upload = isset($_POST['upload']) ? $_POST['upload'] : "";

//download
if($p == "clubs")
{
	$query='select clu_id, clu_nam as clu_nam, clu_transfer from club;'; 
	//echo $query; 
	$result = queryMysql($query); 
    $num = mysqli_num_rows(queryMysql($query));
	$b = array();
    for ($i = 0 ; $i < $num ; ++$i)
    {
	    $row = mysqli_fetch_row($result);
		$c = array();
		$c['id']=$row[0];
		$c['clu_nam']=$row[1];
		$c['clu_transfer']='S';
		array_push($b, $c);
    }
	$a = array();
	$a['clubs']=$b;
	echo(json_encode($a));
}
else if($p == "participants")
{
	$query='select per_id,per_nam,per_sur,per_shi,per_yea,per_sex,per_mob,per_email,per_clu,per_transfer from person;'; 
	//echo $query; 
	$result = queryMysql($query); 
    $num = mysqli_num_rows(queryMysql($query));
	$b = array();
    for ($i = 0 ; $i < $num ; ++$i)
    {
	    $row = mysqli_fetch_row($result);
		$c = array();
		$c['id']=$row[0];
		$c['per_nam']=$row[1];
		$c['per_sur']=$row[2];
		$c['per_shi']=$row[3];
		$c['per_yea']=$row[4];
		$c['per_sex']=$row[5];
		$c['per_mob']=$row[6];
		$c['per_email']=$row[7];
		$c['per_clu']=$row[8];
		$c['per_transfer']='S';
		array_push($b, $c);
    }
	$a = array();
	$a['participants']=$b;
	echo(json_encode($a));
}
else if($p == "races")
{
	$query='select rac_id,rac_nam,rac_chrono from race;'; 
	//echo $query; 
	$result = queryMysql($query); 
    $num = mysqli_num_rows(queryMysql($query));
	$b = array();
    for ($i = 0 ; $i < $num ; ++$i)
    {
	    $row = mysqli_fetch_row($result);
		$c = array();
		$c['id']=$row[0];
		$c['rac_nam']=$row[1];
		$c['rac_chrono']=$row[2];
		array_push($b, $c);
    }
	$a = array();
	$a['races']=$b;
	echo(json_encode($a));
}
else if($p == "registrations")
{
	$query='select r.rac_id, st.per_id, st.sn_id,st_transfer
		from race r
		inner join st_num st on r.st_id=st.st_id;'; 
	//echo $query; 
	$result = queryMysql($query); 
    $num = mysqli_num_rows(queryMysql($query));
	$b = array();
    for ($i = 0 ; $i < $num ; ++$i)
    {
	    $row = mysqli_fetch_row($result);
		$c = array();
		$c['rac_id']=$row[0];
		$c['per_id']=$row[1];
		$c['st_num']=$row[2];
		$c['st_transfer']=$row[3];
		array_push($b, $c);
    }
	$a = array();
	$a['registrations']=$b;
	echo(json_encode($a));
}
else if($p == "results")
{
	$query='select rac_id, sn_id as st_num, res_fin_time, res_fin_time_sec, res_typ_id, res_time, res_start from race_result;'; 
	//echo $query; 
	$result = queryMysql($query); 
    $num = mysqli_num_rows(queryMysql($query));
	$b = array();
    for ($i = 0 ; $i < $num ; ++$i)
    {
	    $row = mysqli_fetch_row($result);
		$c = array();
		$c['rac_id']=$row[0];
		$c['st_num']=$row[1];
		$c['res_fin_time']=$row[2];
		$c['res_fin_time_sec']=$row[3];
		$c['res_typ']=$row[4];
		$c['res_time']=$row[5];
		$c['res_start']=$row[6];
		array_push($b, $c);
    }
	$a = array();
	$a['results']=$b;
	echo(json_encode($a));
}
//upload
else if($_SERVER['REQUEST_METHOD'] == "POST")
{
	echo file_get_contents('php://input');
	$data = json_decode(file_get_contents('php://input'), true);
	$type = isset($data['type']) ? $data['type'] : "nema";//umjesto isset array_key_exists("child2", $response)+
	switch($type)
	{
		case 'clubs':
			$result = upload_clubs($data);
			break;
		case 'participants':
			$result = upload_participants($data);
			break;
		case 'participants_backup':
			$result = upload_participants_backup($data);
			break;
		case 'results':
			$result = upload_results($data);
			break;
		case 'results_backup':
			$result = upload_results_backup($data);
			break;
		case 'races':
			$result = upload_races($data);
			break;
		case 'registrations':
			$result = upload_registrations($data);
			break;
		case 'process':
			echo "process results: " . $data['race'] . "!";
			$result = process_results($data['race']) == "1" ? "success" : "";
			break;
		default:
			$result = "Empty request!";
			break;
	}
	echo $result;
}
else
{
	echo $p;
}

function upload_clubs($data)
{
	$clubs = $data['clubs'];
	$i=0;

	foreach ($clubs as $club)
	{
		if (is_array($club) && strtoupper($club['clu_transfer']) == 'U')
		{
			$query='UPDATE club 
			set clu_nam = "' . $club['clu_nam'] . '", 
			activity = "D",
			date= ' . get_DB_time() . ',
			clu_transfer = "' . strtoupper($club['clu_transfer']) . '"
			where clu_id = ' . $club['id'] . ';'; 
		}
		else if (is_array($club) && strtoupper($club['clu_transfer']) == 'M')
		{
			$query='INSERT INTO club 
			(`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
			`clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`,`clu_transfer`) 
			VALUES 
			(null, 
			null, 
			null, 
			"' . $club['clu_nam'] . '", 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			"D",' . get_DB_time() . ',
			"' . strtoupper($club['clu_transfer']) . '");'; 
		}
		else 
		{
			$query = "";
		}
		//echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function upload_participants($data)
{
	$participants = $data["participants"];//ak ne dela onda $item = $data[0];
	
	$i=0;
	
	foreach ($participants as $participant)
	{
		if (strtoupper($participant['per_transfer']) == 'U')
		{
			$query='UPDATE person 
			set per_nam = "' . $participant['per_nam'] . '", 
			per_sur = "' . $participant['per_sur'] . '", 
			per_email = "' . $participant['per_email'] . '", 
			per_mob = "' . $participant['per_mob'] . '", 
			per_sex = "' . $participant['per_sex'] . '", 
			per_shi = "' . $participant['per_shi'] . '", 
			per_yea = "' . $participant['per_yea'] . '", 
			per_clu = "' . $participant['per_clu'] . '", 
			activity = "D",
			date= ' . get_DB_time() . ',
			per_transfer = "' . strtoupper($participant['per_transfer']) . '" 
			where per_id = ' . $participant['id'] . ';'; 
		}
		else if (strtoupper($participant['per_transfer']) == 'M')
		{
			$query='INSERT INTO person 
			(`per_id`,`per_nam`,`per_sur`,`per_yea`,`per_dat_b`,`per_sex`,`per_adr`, 
			`per_tow`,`per_cou`,`per_sta`,`per_email`,`per_tel`,`per_mob`,`per_shi`,`per_meal`,`per_clu`,`activity`,`date`,`per_transfer`) 
			VALUES 
			(' . $participant['id'] . ', 
			"' . $participant['per_nam'] . '", 
			"' . $participant['per_sur'] . '", 
			"' . $participant['per_yea'] . '", 
			null, 
			"' . $participant['per_sex'] . '", 
			null, null, null, null, 
			"' . $participant['per_email'] . '",
			null, 
			"' . $participant['per_mob'] . '",
			"' . $participant['per_shi'] . '",
			null, 
			"' . $participant['per_clu'] . '",
			"D",' . get_DB_time() . ',
			"' . strtoupper($participant['per_transfer']) . '");'; 
		}
		else 
		{
			$query = "";
		}
		echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function upload_participants_backup($data)
{
	$participants = $data["participants"];//ak ne dela onda $item = $data[0];
	
	$i=0;
	
	if ($participants != '')
		foreach ($participants as $participant)
		{
			if ($participant['id'] == '') break;
			
			$query='INSERT INTO person_mob 
			(`per_id`,`per_nam`,`per_sur`,`per_yea`,`per_dat_b`,`per_sex`,`per_adr`, 
			`per_tow`,`per_cou`,`per_sta`,`per_email`,`per_tel`,`per_mob`,`per_shi`,`per_meal`,`per_clu`,`activity`,`date`,`per_transfer`) 
			VALUES 
			(' . $participant['id'] . ', 
			"' . $participant['per_nam'] . '", 
			"' . $participant['per_sur'] . '", 
			"' . $participant['per_yea'] . '", 
			null, 
			"' . $participant['per_sex'] . '", 
			null, null, null, null, 
			"' . $participant['per_email'] . '",
			null, 
			"' . $participant['per_mob'] . '",
			"' . $participant['per_shi'] . '",
			null, 
			"' . $participant['per_clu'] . '",
			"D",' . get_DB_time() . ',
			"' . strtoupper($participant['per_transfer']) . '");'; 

			echo $i . " " . $query . "\n"; 
			if ($query != "") 
			{	
				$result = queryMysql($query);
			}
			
			$i++;
		}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function upload_races($data)
{
	//utrke se ne bi smjele uploadati zasad, tek dok se dobro testira aplikacija
	$races = $data["races"];
	
	$i=0;
	
	foreach ($races as $race)
	{
		if (strtoupper($race['rac_transfer']) == 'U')
		{
			$query='INSERT INTO race 
			(`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
			`clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`,`rac_transfer`) 
			VALUES 
			(null, 
			null, 
			null, 
			"' . $race['clu_nam'] . '", 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			"D",' . get_DB_time() . ',
			"' . strtoupper($race['rac_transfer']) . '");'; 
		}
		else if (strtoupper($race['rac_transfer']) == 'M')
		{
			$query='INSERT INTO race 
			(`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
			`clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`,`rac_transfer`) 
			VALUES 
			(null, 
			null, 
			null, 
			"' . $race['clu_nam'] . '", 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			null, 
			"D",' . get_DB_time() . ',
			"' . strtoupper($race['rac_transfer']) . '");'; 
		}
		else 
		{
			$query = "";
		}
		//echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function upload_registrations($data)
{
	$registrations = $data["registrations"];
	
	//$query="select st_id from race where rac_id='1'";
	$st_id = 1;
	
	$i=0;
	
	foreach ($registrations as $registration)
	{
		if ($registration['id'] == '') break;
		
		$query="select st_id from race where rac_id=" . $registration['id'] . ";";
		$result = queryMysql($query);
		$row = mysqli_fetch_row($result);
		$st_id = $row[0];

		if (strtoupper($registration['st_transfer']) == 'U')
		{
			$query='UPDATE st_num 
			set per_id = ' . $registration['per_id'] . ',
			activity = "D",
			date = ' . get_DB_time() . ', 
			st_transfer = "' . $registration['st_transfer'] . '" 
			where st_id=' . $st_id . ' and st_num_id = ' . $registration['st_num'] . ''; 
		}
		else if (strtoupper($registration['st_transfer']) == 'M')
		{/*
			$query='INSERT INTO st_num 
			(`st_id`,`sn_id`,`per_id`,`per_id_add`,`activity`,`date`,`st_transfer`) 
			VALUES 
			(' . $st_id . ', 
			' . $registration['st_num'] . ',
			' . $registration['per_id'] . ',null,"D",' . get_DB_time() . ', 
			"' . $registration['st_transfer'] . '");'; */
			
			$query = 'INSERT INTO st_num (`st_id`,`sn_id`,`per_id`,`per_id_add`,`activity`,`date`,`st_transfer`)
					VALUES (' . $st_id . ', ' . $registration['st_num'] . ',
					' . $registration['per_id'] . ',null,"D",' . get_DB_time() . ', 
					"' . $registration['st_transfer'] . '")
				ON DUPLICATE KEY UPDATE
					per_id = ' . $registration['per_id'] . ',
					activity = "D",
					date = ' . get_DB_time() . ', 
					st_transfer = "' . $registration['st_transfer'] . '"';
		}
		else 
		{
			$query = "";
		}
		if ($i > 10) echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function result_exists($rac_id, $st_num)
{
	$query='select res_transfer_typ from race_result where 
        rac_id = ' . $rac_id . ' and sn_id = ' . $st_num . ';';
         
	$result = queryMysql($query);
	
    $num = mysqli_num_rows(queryMysql($query));
    
    //ne postoji rezultat, insertaj
	if($num<1) return 0;
    
    $r = 2;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
	    $row = mysqli_fetch_row($result);
        $res_typ = $row[0];
        
        //postoji rezultat uploadan s mobitela a?uriraj (1),
        //postoji rezultat ali s mobitela nije moguce a?uriranje (2)
        $r = ($res_typ == 3 ? 1 : 2);
    }
    
    return $r;
}

function upload_results($data)
{
	$results = $data["results"];
	$i=0;
	
	foreach ($results as $result)
	{
		if ($result['rac_id'] == '' && $result['st_num'] == '' ) break;
		
		$r = isset($result['rac_id']) && isset ($result['st_num']) ? result_exists($result['rac_id'], $result['st_num']) : 2;
		switch($r)
        { 
            case 0: //insert
    			$query='INSERT INTO race_result 
        			(`rac_id`,`res_chk_id`,`sn_id`,`res_typ_id`,`res_fin_time`,`res_fin_time_sec`,`res_start`,`res_time`,`res_pen`,`res_transfer_typ`, 
        			`res_mob_id`,`activity`,`date`) 
        			VALUES 
        			(' . $result['rac_id'] . ', null, 
        			' . $result['st_num'] . ', null, 
        			"' . $result['res_fin_time'] . '",
        			"' . $result['res_fin_time_sec'] . '",
        			' . ($result['res_start'] != "" ? ('"' . $result['res_start'] . '"'): "null") . ',
        			' . ($result['res_time'] != "" ? ('"' . $result['res_time'] . '"'): "null") . ',
        			null, 3, 
        			' . $result['res_mob_id'] . ',"D",' . get_DB_time() . ');'; 
                break; 
            case 1: //update
    			$query='UPDATE race_result 
        			set res_fin_time = "' . $result['res_fin_time'] . '",
						res_fin_time_sec = ' . $result['res_fin_time_sec'] . ',
						res_time = ' . ($result['res_time'] != "" ? ('"' . $result['res_time'] . '"'): "null") . ',
						res_start = ' . ($result['res_start'] != "" ? ('"' . $result['res_start'] . '"'): "null") . ',
						res_mob_id = ' . $result['res_mob_id'] . ',
						activity = "D",
						date = ' . get_DB_time() . '
        			where rac_id=' . $result['rac_id'] . ' and sn_id = ' . $result['st_num'] . ';'; 
                break; 
            default: //nothing
                $query='';
                break;    
        } 
        
		echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}

function upload_results_backup($data)
{
	$results = $data["results"];
	$i=0;
	
	foreach ($results as $result)
	{
		if ($result['rac_id'] == '' && $result['st_num'] == '' ) break;
		
		$query='INSERT INTO race_result_mob 
			(`rac_id`,`res_chk_id`,`sn_id`,`res_typ_id`,`res_fin_time`,`res_fin_time_sec`,`res_start`,`res_time`,`res_pen`,`res_transfer_typ`, 
			`res_mob_id`,`activity`,`date`) 
			VALUES 
			(' . $result['rac_id'] . ', null, 
			' . $result['st_num'] . ', null, 
			"' . $result['res_fin_time'] . '",
			"' . $result['res_fin_time_sec'] . '",
			' . ($result['res_start'] != "" ? ('"' . $result['res_start'] . '"'): "null") . ',
			' . ($result['res_time'] != "" ? ('"' . $result['res_time'] . '"'): "null") . ',
			null, 3, 
			' . $result['res_mob_id'] . ',"D",' . get_DB_time() . ');'; 

		echo $i . " " . $query . "\n"; 
		if ($query != "") 
		{	
			$result = queryMysql($query);
		}
		
		$i++;
	}

	$result = "upload success!";
	//$result = $data;
	return $result;
}
?>  