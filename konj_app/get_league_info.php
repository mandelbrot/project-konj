<?php

require_once "components.php";
include_once 'head.php';

if(isset($_GET['league']))
    $league=sanitizeString($_GET['league']);

if(isset($_GET['league_gr']))
    $league_gr=sanitizeString($_GET['league_gr']);
	
function get_league_results($leagueid){
    $query = "select * from league l 
        left join club c on l.org_id=c.clu_id
        left join league_group lg on l.leagr_id=lg.leagr_id
        where lea_id='$leagueid'";  
    $result = queryMysql($query);
    $leagueInfo = mysqli_fetch_row($result);
    
    $query = "SELECT rac_id, rac_nam, rac_lea_rou
        FROM race r
        where r.lea_id='$leagueid'
        order by rac_lea_rou";

    $races_in_league = queryMysql($query);    
    $num_rounds = mysqli_num_rows(queryMysql($query));
    if($num_rounds==0){
        echo 'Ova liga nema odr&#382;anih kola!';
        return;
    } 

    echo '
<div class="bs-docs-section">
   <div class="page-header">
      <h1 id="metro-pivot1">' . $leagueInfo[4] . '<small></small></h1>
   </div>
   <div class="bs-docs-example bs-docs-example-pivot">
      <div id="pivot" class="pivot slide">
         <div class="pivot-headers">
            <a href="#pivot" data-pivot-index="0" class="active">Tablica</a>';
         
    $races_ids = array();
    $rounds_numbers = array();
           
    for($i=0;$i<$num_rounds;$i++){
        $row = mysqli_fetch_row($races_in_league);
        $races_ids[$i] = $row[0];
        $rounds_numbers[$i] = $row[2];
        
        //echo '<a href="#pivot" data-pivot-index="' . ($i+1) . '">' . $row[1] . '</a>';
        echo '<a href="#pivot" data-pivot-index="' . ($i+1) . '">' . $row[2] . '. kolo</a>';  
    }
    
    echo '
        <a href="#pivot" data-pivot-index="' . ($num_rounds+1) . '">Uvod</a>
        <a href="#pivot" data-pivot-index="' . ($num_rounds+2) . '">Info</a>
        <a href="#pivot" data-pivot-index="' . ($num_rounds+3) . '">Natjecatelji</a>
        ';         
   
    echo'</div>
         <div class="pivot-items">';
               
    //table
    echo'
         <div id="pivot-item-0" class="pivot-item active">
           <table class="table table-condensed table-hover table-striped">
              <thead>
              <tr>
                 <th class="span1">R.br.</th>
                 <th class="span2">Trka&#269;</th>
                 <th class="span1">Bod.</th>
                 <th class="span1">PB sezona</th>
                 <th class="span1">PB</th>
              </tr>
              </thead>
              <tbody>'; 
    $query = "select concat(per.per_nam, ' ', per.per_sur) as trkac, tr.per_id,sum(sco) as sco, per_sex, 
        PB_league($leagueid, tr.per_id), PB_league_gr(tr.l_leagr_id, tr.per_id)
        from table_results tr
        inner join person per on tr.per_id=per.per_id
        where lea_id=$leagueid
        group by per_sex, tr.per_id
        order by per_sex desc, sum(sco) desc";
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));
    
    $sex=null;
    $t=true;
    $br=0;
    
    for($i=0;$i<$num;$i++){
        if($i == 0){
            echo '
              <tr>
                 <td colspan=6><b>Mu&#353;ki</b></td>
              </tr>';  
        }
        $row = mysqli_fetch_row($result);
        if($sex != null && $sex != $row[3] && $t){
            if($t){
                echo '
                  <tr>
                     <td colspan=6><b>&#381;ene</b></td>
                  </tr>';  
            }
            $t=false;
            $br=$i;
            }
        echo '
          <tr>
             <td>' . ($i-$br+1) . '.</td>
             <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[1] . ')\'>' . $row[0] . '</a></td>
             <td>' . $row[2] . '</td>
             <td>' . $row[4] . '</td>
             <td>' . $row[5] . '</td>
          </tr>';
        $sex = $row[3];
    }
    
    echo '
                  </tbody>
               </table>
            </div>';
        
    
    //rounds
    get_league_round_results($leagueid, $races_ids, $rounds_numbers);

    echo'
        <div id="pivot-item-' . ($num_rounds+1) .'" class="pivot-item">
          <p>Tu ide uvod</p>
        </div>
        ';
    
    echo '
        <div id="pivot-item-' . ($num_rounds+2) .'" class="pivot-item">
          <p>Tu ide info</p>
        </div>
        ';
               
    echo '
        <div id="pivot-item-' . ($num_rounds+3) .'" class="pivot-item">
          <p>Tu ide natjecatelji</p>
        </div>';          

    echo'
         </div>
      </div>
   </div>

   <br/>

<hr class="bs-docs-separator">

</div>
    ';
}

function get_league_round_results($leagueid, $races_ids, $rounds_numbers){
    
    $query = "select sco_id, lea_leagr_sn from league where lea_id='$leagueid'";
    $result = queryMysql($query);
    $row = mysqli_fetch_row($result);
    $sco_sys = get_scores($row[0]);

    for($i=0;$i<count($races_ids);$i++){
        echo'
            <div id="pivot-item-' . ($i+1) .'" class="pivot-item">
               <table class="table table-condensed table-hover table-striped">
                  <thead>
                  <tr>
                     <th class="span1">R.br.</th>
                     <th class="span1">St.br.</th>
                     <th class="span2">Trka&#269;</th>
                     <th class="span1">Bod.</th>
                     <th class="span2">Rezultat</th>
                     <th class="span1">Pro&#353;lo k.</th>
                     <th class="span1">PB</th>
                  </tr>
                  </thead>
                  <tbody>';      

        $query2 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
        	   rr.res_fin_time vrijeme, rr2.res_fin_time vrijeme_prosl_kola, lea_id, per.per_id,
               PB(lea_id, rr.rac_id, per.per_id) as PB,
               PB_league(lea_id, per.per_id) as PB_league,
               case when (res_fin_time_sec = best_res_league(lea_id, per.per_sex, true)) then 1 else 0 end as BR
            FROM race_result rr 
        	inner join race r on rr.rac_id=r.rac_id
        	inner join start st on r.st_id=st.st_id
        	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
        	inner join person per on sn.per_id=per.per_id
            left outer join (
            select rr.sn_id, res_fin_time from race_result rr
			inner join race r on rr.rac_id=r.rac_id
			inner join start st on r.st_id=st.st_id
			inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
			inner join person per on sn.per_id=per.per_id
            where rr.rac_id =(
            select r.rac_id from race r
            inner join (
            select lea_id from race r
            where r.rac_id='$races_ids[$i]') as league
             on r.lea_id=league.lea_id
            and '$rounds_numbers[$i]'>rac_lea_rou
            limit 1)
            ) as rr2
            on rr.sn_id=rr2.sn_id
            where rr.rac_id='$races_ids[$i]' and r.lea_id='$leagueid' and per.per_sex=1
            order by rr.res_fin_time";

        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2));
        
        $query3 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
        	   rr.res_fin_time vrijeme, rr2.res_fin_time vrijeme_prosl_kola, lea_id, per.per_id,
               PB(lea_id, rr.rac_id, per.per_id) as PB,
               PB_league(lea_id, per.per_id) as PB_league,
               case when (res_fin_time_sec = best_res_league(lea_id, per.per_sex, true)) then 1 else 0 end as BR
            FROM race_result rr 
        	inner join race r on rr.rac_id=r.rac_id
        	inner join start st on r.st_id=st.st_id
        	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
        	inner join person per on sn.per_id=per.per_id
            left outer join (
            select rr.sn_id, res_fin_time from race_result rr
			inner join race r on rr.rac_id=r.rac_id
			inner join start st on r.st_id=st.st_id
			inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
			inner join person per on sn.per_id=per.per_id
            where rr.rac_id =(
            select r.rac_id from race r
            inner join (
            select lea_id from race r
            where r.rac_id='$races_ids[$i]') as league
             on r.lea_id=league.lea_id
            and '$rounds_numbers[$i]'>rac_lea_rou
            limit 1)
            ) as rr2
            on rr.sn_id=rr2.sn_id
            where rr.rac_id='$races_ids[$i]' and r.lea_id='$leagueid' and per.per_sex=0
            order by rr.res_fin_time";

        $result3 = queryMysql($query3); 
        $num3 = mysqli_num_rows(queryMysql($query3));
            
        for($j=0;$j<$num2;$j++){
            if($j == 0){
                echo '
                  <tr>
                     <td colspan=7><b>Mu&#353;ki</b></td>
                  </tr>';  
            }
            $row = mysqli_fetch_row($result2);
            echo '
              <tr>
                 <td>' . ($j+1) . '.</td>
                 <td>' . $row[0] . '.</td>
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
                 <td>' . $sco_sys[$j] . '</td>
                 <td>' . $row[2] . ' ' . ($row[8] == 1 ? "<b><u>BR</u> </b>" : "") . ($row[6] == 1 ? "<b>PB</b>" : "") . '
                 ' . (round_res_last_round($row[2], $row[3]) ? 
                    '<span aria-hidden="true" class="icon-thumbs-up-2"></span>' : 
                    '<span aria-hidden="true" class="icon-thumbs-down-2"></span>') . '
                 </td>
                 <td>' . $row[3] . '</td>
                 <td><b>' . $row[7] . '</b></td>
              </tr>';
            
        }
        for($j=0;$j<$num3;$j++){
            if($j == 0){
                echo '
                  <tr>
                     <td colspan=7><b>&#381;ene</b></td>
                  </tr>';  
            }
            $row = mysqli_fetch_row($result3);
            echo '
              <tr>
                 <td>' . ($j+1) . '.</td>
                 <td>' . $row[0] . '.</td>
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
                 <td>' . $sco_sys[$j] . '</td>
                 <td>' . $row[2] . ' ' . ($row[8] == 1 ? "<b><u>BR</u> </b>" : "") . ($row[6] == 1 ? "<b>PB</b>" : "") . '
                 ' . (round_res_last_round($row[2], $row[3]) ? 
                    '<span aria-hidden="true" class="icon-thumbs-up-2"></span>' : 
                    '<span aria-hidden="true" class="icon-thumbs-down-2"></span>') . '
                 </td>
                 <td>' . $row[3] . '</td>
                 <td><b>' . $row[7] . '</b></td>
              </tr>';
            
        }
        
        echo '
                      </tbody>
                   </table>
                </div>';
    }
}

function get_league_group_results($leagroid){
    $query = "select * from league l 
        left join club c on l.org_id=c.clu_id
        left join league_group lg on l.leagr_id=lg.leagr_id
        where lg.leagr_id='$leagroid'";  
    $result = queryMysql($query);
    $leagues_in_league_group = mysqli_num_rows(queryMysql($query));
    
    $query1 = "select * from race r 
        left join league_group lg on r.leagr_id=lg.leagr_id
        where lg.leagr_id='$leagroid'";  
    $result1 = queryMysql($query1);
    $races_in_league_group = mysqli_num_rows(queryMysql($query1));

    if($leagues_in_league_group > 0){
        for($i=0;$i<$leagues_in_league_group;$i++){
            $row = mysqli_fetch_row($result);
            $leagueGrInfo=$row[38];
            $leagueIds[$i]=$row[0];
            $leagueNames[$i]=$row[5];
            }
    }
    else if ($races_in_league_group > 0){
        for($i=0;$i<$races_in_league_group;$i++){
            $row = mysqli_fetch_row($result1);
            $leagueGrInfo=$row[35];
            $raceIds[$i]=$row[0];
            $raceNames[$i]=$row[9];
            }
        }
    else{
        echo 'Ova liga-grupa nema odr&#382;anih trka!';
        return;
    }
    
    echo '
<div class="bs-docs-section">
   <div class="page-header">
      <h1 id="metro-pivot-title">' . $leagueGrInfo . '<small></small></h1>
   </div>
   <div class="bs-docs-example bs-docs-example-pivot">
      <div id="pivot" class="pivot slide">
         <div class="pivot-headers">
            <a href="#pivot" data-pivot-index="0" class="active">Odr&#382;ane trke</a>';
         
//    echo '
//        <a href="#pivot" data-pivot-index="' . ($num_rounds+1) . '">Uvod</a>
//        <a href="#pivot" data-pivot-index="' . ($num_rounds+2) . '">Info</a>
//        <a href="#pivot" data-pivot-index="' . ($num_rounds+3) . '">Natjecatelji</a>
//        ';         
   
    echo'</div>
         <div class="pivot-items">
        <div id="pivot-item-0" class="pivot-item active">
            <div id="pivot-item-0" class="pivot-item">
               <table class="table table-condensed table-hover table-striped">
                  <thead>
                  <tr>';
        echo $leagues_in_league_group > 0 ? 
                      '<th class="span1">Liga</th>
                     <th class="span1">Kolo</th>'
                     : 
                     '<th class="span1">Trka</th>';
                     echo'<th class="span1">Uk.</th>
                     <th class="span1">&#381;</th>
                     <th class="span1">M</th>
                     <th class="span3">&#381; naj</th>
                     <th class="span3">M naj</th>
                     <th class="span3">&#381; prosj.</th>
                     <th class="span3">M prosj.</th>
                  </tr>
                  </thead>
                  <tbody>';     
                   
    if($leagues_in_league_group > 0){            
        get_league_group_results1($leagueIds,$leagueNames);
    }
    else{ //($races_in_league_group > 0){
        get_league_group_results2($raceIds,$raceNames);
        }
    
    echo '
                  </tbody>
               </table>
            </div>
         </div>
         </div>
      </div>
   </div>
   <br/>
<hr class="bs-docs-separator">
</div>
    ';
}

function get_league_group_results1($leagueIds,$leagueNames){
    
    for($i=0;$i<count($leagueIds);$i++){
        $query = "
        select r.rac_id, r.rac_lea_rou, count(*) as T,
        	SUM(CASE WHEN per.per_sex=0 THEN 1 ELSE 0 END) AS F,
        	SUM(CASE WHEN per.per_sex=1 THEN 1 ELSE 0 END) AS M,
        	min(CASE WHEN per.per_sex=0 THEN rr.res_fin_time ELSE 'N/A' end) as F_best,
        	min(CASE WHEN per.per_sex=1 THEN rr.res_fin_time ELSE 'N/A' end) as M_best,
        	get_best_result_per_id(r.rac_id,0) as F_best_id, 
        	get_best_result_per_id(r.rac_id,1) as M_best_id,
        	concat(per0.per_nam, ' ', per0.per_sur) as NameSurnameF,
        	concat(per1.per_nam, ' ', per1.per_sur) as NameSurnameM,
            get_rac_avg_res(r.rac_id,0) as AvgResF,
            get_rac_avg_res(r.rac_id,1) as AvgResM
        from race_result rr
        inner join race r on rr.rac_id=r.rac_id and r.lea_id='$leagueIds[$i]'
    	inner join start st on r.st_id=st.st_id
    	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
    	inner join person per on sn.per_id=per.per_id
        left join person per0 on get_best_result_per_id(r.rac_id,0)=per0.per_id
        left join person per1 on get_best_result_per_id(r.rac_id,1)=per1.per_id
        group by r.rac_id
        order by r.lea_id, r.rac_lea_rou
        ";
    
    $results_league_group = queryMysql($query);    
    $rounds_in_league_group = mysqli_num_rows(queryMysql($query));
    
        for($j=0;$j<$rounds_in_league_group;$j++){
            $row = mysqli_fetch_row($results_league_group);
          echo '
              <tr>
                 <td><a href="#" onclick=\'ajaxGetComponent("league", ' . $leagueIds[$i] . ')\'>' . $leagueNames[$i] . '.</a></td>
                 <td><a href="#" onclick=\'ajaxGetComponent("race", ' . $row[0] . ')\'>' . $row[1] . '.</a></td>
                 <td>' . $row[2] . '</td>
                 <td>' . $row[3] . '</td>
                 <td>' . $row[4] . '</td>';
                 $female = $row[5]=="N/A" ? $row[5] : ' - ' . $row[5];
                 $male = $row[6]=="N/A" ? $row[6] : ' - ' . $row[6];
          echo'
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[7] . ')\'>' . $row[9] . '</a>' . $female . '</td>
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[8] . ')\'>' . $row[10] . '</a>' . $male . '</td>
                 <td>' . $row[11] . '</td>
                 <td>' . $row[12] . '</td>
              </tr>';
            
        }
    }
}

function get_league_group_results2($raceIds,$raceNames){

    $query = "
    select r.rac_id, count(*) as T,
    	SUM(CASE WHEN per.per_sex=0 THEN 1 ELSE 0 END) AS F,
    	SUM(CASE WHEN per.per_sex=1 THEN 1 ELSE 0 END) AS M,
    	min(CASE WHEN per.per_sex=0 THEN rr.res_fin_time ELSE 'N/A' end) as F_best,
    	min(CASE WHEN per.per_sex=1 THEN rr.res_fin_time ELSE 'N/A' end) as M_best,
    	get_best_result_per_id(r.rac_id,0) as F_best_id, 
    	get_best_result_per_id(r.rac_id,1) as M_best_id,
    	concat(per0.per_nam, ' ', per0.per_sur) as NameSurnameF,
    	concat(per1.per_nam, ' ', per1.per_sur) as NameSurnameM,
        get_rac_avg_res(r.rac_id,0) as AvgResF,
        get_rac_avg_res(r.rac_id,1) as AvgResM
    from race_result rr
    inner join race r on rr.rac_id=r.rac_id
    inner join league_group lg on r.leagr_id=lg.leagr_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
    left join person per0 on get_best_result_per_id(r.rac_id,0)=per0.per_id
    left join person per1 on get_best_result_per_id(r.rac_id,1)=per1.per_id
    group by r.rac_id
    ";
    
    $results_league_group = queryMysql($query);    
    $rounds_in_league_group = mysqli_num_rows(queryMysql($query));
    
        for($i=0;$i<$rounds_in_league_group;$i++){
            $row = mysqli_fetch_row($results_league_group);
          echo '
              <tr>
                 <td><a href="index?race=' . $raceIds[$i] . '">' . $raceNames[$i] . '.</a></td>
                 <td>' . $row[1] . '</td>
                 <td>' . $row[2] . '</td>
                 <td>' . $row[3] . '</td>';
                 $female = $row[4]=="N/A" ? $row[4] : ' - ' . $row[4];
                 $male = $row[5]=="N/A" ? $row[5] : ' - ' . $row[5];
          echo'
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[6] . ')\'>' . $row[8] . '</a>' . $female . '</td>
                 <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[7] . ')\'>' . $row[9] . '</a>' . $male . '</td>
                 <td>' . $row[10] . '</td>
                 <td>' . $row[11] . '</td>
              </tr>';
    }
}

if(isset($league)) get_league_results($league);
if(isset($league_gr)) get_league_group_results($league_gr);

?>

