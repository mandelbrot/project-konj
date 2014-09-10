<?php
include '../functions.php';
$p = isset($_GET['p']) ? $_GET['p'] : "";
$upload = isset($_POST['upload']) ? $_POST['upload'] : "";

//download
if($p == "clubs")
{
	$query='select clu_id,clu_nam as clu_nam,clu_transfer from club;'; 
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
		$c['clu_transfer']=$row[2];
		array_push($b, $c);
    }
	$a = array();
	$a['clubs']=$b;
	echo(json_encode($a));
}
else if($p == "participants")
{
	$query='select per_id,per_nam,per_sur,per_yea,per_sex,per_mob,per_email,per_clu,per_transfer from PERSON;'; 
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
		$c['per_year']=$row[3];
		$c['per_sex']=$row[4];
		$c['per_mob']=$row[5];
		$c['per_email']=$row[6];
		$c['per_clu']=$row[7];
		$c['per_transfer']=$row[8];
		array_push($b, $c);
    }
	$a = array();
	$a['participants']=$b;
	echo(json_encode($a));
}
else if($p == "races")
{
	$query='select rac_id,rac_nam from race;'; 
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
		array_push($b, $c);
    }
	$a = array();
	$a['races']=$b;
	echo(json_encode($a));
}
else if($p == "registrations")
{
	$query='select r.rac_id, st.per_id, st.sn_id
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
		$c['id']=$row[0];
		$c['per_id']=$row[1];
		$c['st_num']=$row[2];
		array_push($b, $c);
    }
	$a = array();
	$a['registrations']=$b;
	echo(json_encode($a));
}
else if($p == "results")
{
	$query='select rac_id, sn_id as st_num, res_fin_time, res_fin_time_sec, res_transfer_typ from race_result;'; 
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
		case 'results':
			$result = upload_results($data);
			break;
		case 'races':
			$result = upload_races($data);
			break;
		case 'registrations':
			$result = upload_registrations($data);
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
		if (strtoupper($participant['clu_transfer']) == 'U')
		{
			$query='UPDATE person 
			set per_nam = "' . $participant['per_nam'] . '", 
			per_sur = "' . $participant['per_sur'] . '", 
			per_email = "' . $participant['per_email'] . '", 
			per_mob = "' . $participant['per_mob'] . '", 
			per_sex = "' . $participant['per_sex'] . '", 
			per_shi = "' . $participant['per_shi'] . '", 
			per_year = "' . $participant['per_year'] . '", 
			per_clu = "' . $participant['per_clu'] . '", 
			activity = "D",
			date= ' . get_DB_time() . ',
			per_transfer = "' . strtoupper($club['per_transfer']) . '" 
			where par_id = ' . $participant['id'] . ';'; 
		}
		else if (strtoupper($participant['per_transfer']) == 'M')
		{
			$query='INSERT INTO person 
			(`per_id`,`klu_id`,`mje_id`,`drz_id`,`per_nam`,`per_sur`,`per_year`,`per_dat_b`,`per_sex`,`per_adr`, 
			`per_tow`,`per_cou`,`per_sta`,`per_email`,`per_tel`,`per_mob`,`per_shi`,`per_meal`,`per_clu`,`activity`,`date`,`per_transfer`) 
			VALUES 
			(null, null, null, null,
			"' . $participant['per_nam'] . '", 
			"' . $participant['per_sur'] . '", 
			"' . $participant['per_year'] . '", 
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

function upload_races($data)
{
	$races = $data["races"];
	
	$i=0;
	
	foreach ($races as $race)
	{
		if (strtoupper($race['clu_transfer']) == 'U')
		{
			$query='INSERT INTO race 
			(`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
			`clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`,`clu_transfer`) 
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
			"' . strtoupper($race['clu_transfer']) . '");'; 
		}
		else if (strtoupper($race['clu_transfer']) == 'M')
		{
			$query='INSERT INTO race 
			(`tow_id`,`cou_id`,`sta_id`,`clu_nam`,`clu_nams`,`clu_adr`,`clu_tow`,`clu_cou`,`clu_sta`,`clu_web`, 
			`clu_email`,`clu_tel`,`clu_tel2`,`clu_fax`,`clu_mob`,`clu_mob2`,`clu_acc`,`clu_acc2`,`activity`,`date`,`clu_transfer`) 
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
			"' . strtoupper($race['clu_transfer']) . '");'; 
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
		if ($i == 0)
		{
			$query="select st_id from race where rac_id=" . $registration['id'] . ";";
			$st_id = queryMysql($query);
		}
		if (strtoupper($registration['st_transfer']) == 'U')
		{
			$query='UPDATE st_num 
			set per_id = ' . $registration['per_id'] . ',
			activity = "D",
			date = ' . get_DB_time() . ', 
			st_transfer = ' . $registration['st_transfer'] . ' 
			where st_id=' . $st_id . ' and st_num_id = ' . $registration['st_num'] . ''; 
		}
		else if (strtoupper($registration['st_transfer']) == 'M')
		{
			$query='INSERT INTO st_num 
			(`st_id`,`st_num_id`,`st_num_typ`,`per_id`,`per_id_add`,`st_num_nam`,`st_num_nams`,`activity`,`date`,`st_transfer`) 
			VALUES 
			($st_id, 
			' . $registration['st_num'] . ', null, 
			' . $registration['per_id'] . ', null,null,null,"D",' . get_DB_time() . ', 
			' . $registration['st_transfer'] . ');'; 
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

function upload_results($data)
{
	$results = $data["results"];
	
	$i=0;
	
	foreach ($results as $result)
	{
		/*if (strtoupper($result['clu_transfer']) == 'M')
		{
			//srediti!!!
			$query='UPDATE race_result 
			(`rac_id`,`res_check_id`,`rac_start_num_id`,`lea_per_start_num`,`res_fin_time`,`res_fin_time_sec`,`res_time`,`res_fin`,`res_pen`,`res_typ`, 
			`res_mob_id`) 
			VALUES 
			set ($st_id, null, st_num, st_num, res_fin_time,res_fin_time(ili se to automatski napuni na serveru), D, null, 3, res_mob_id)));'; 
		}
		else if (strtoupper($result['clu_transfer']) == 'U')
		{*/
			$query='INSERT INTO race_result 
			(`rac_id`,`res_check_id`,`rac_start_num_id`,`lea_per_start_num`,`res_fin_time`,`res_fin_time_sec`,`res_time`,`res_fin`,`res_pen`,`res_typ`, 
			`res_mob_id`) 
			VALUES 
			(' . $registration['rac_id'] . ', null, 
			' . $registration['st_num'] . ', null, 
			"' . $registration['res_fin_time'] . '",null,
			"' . $registration['res_time'] . '",
			D, null, 3, 
			' . $registration['res_mob_id'] . ')));'; 
		/*}
		else 
		{
			$query = "";
		}*/
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
?>  