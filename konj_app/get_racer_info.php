<?php

require_once "components.php";
include_once 'head.php';

if(isset($_GET['racer']))
    $racer=sanitizeString($_GET['racer']);

function get_racer($racerID){
        
    $query = "SELECT concat(per_nam, ' ', per_sur) as ime_prezime, per_sex FROM person where per_id=" . $racerID;
    $result = queryMysql($query);

    $num = mysqli_num_rows(queryMysql($query));

    if($num<1) return;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
	    $row = mysqli_fetch_row($result);
        $racer = $row[0];
        $sex = $row[1];
    }
    
    echo '
<div class="bs-docs-section">
   <div class="page-header">
      <h1 id="metro-pivot1">' . $racer . '<small></small></h1>
   </div>';
           
    //sve utrke u kojima je trkac sudjelovao
    $query = "select rac_nam, r.rac_id, sn_id, place_sex, place, result, r.rac_fr_dat from race r
    	inner join (
    	select rr.rac_id as rac_id, r.rac_fr_dat, 
        	sn.sn_id as sn_id,
        	get_place(r.rac_id,$racerID) as place,
        	get_place_sex(r.rac_id,$racerID,$sex) as place_sex,
            rr.res_fin_time as result
    	from race_result rr 
		inner join race r on rr.rac_id=r.rac_id
		inner join start st on r.st_id=st.st_id
		inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
		inner join person per on sn.per_id=per.per_id
    	where per.per_id=$racerID) as rr
    	   on r.rac_id=rr.rac_id
    	order by r.rac_fr_dat;";
    $result = queryMysql($query);
    $num_races = mysqli_num_rows(queryMysql($query));

    if($num<1){
        echo 'Racer hasn\'t raced yet.';  
    } 
    else{
        echo'
            <div class="bs-docs-example bs-docs-example-pivot">
            <div id="pivot" class="pivot slide">';
         
        echo'<div class="pivot-items">';
        
        //table
        echo'
            <div id="pivot-item-0" class="pivot-item active">';
        echo'
            <table class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
             <th class="span4">Race</th>
             <th class="span1">St.br.</th>
             <th class="span1">Poredak(' . get_sex($sex) . ')</th>
             <th class="span1">Poredak(Uk.)</th>
             <th class="span1">Vrijeme</th>
             <th class="span1">Datum</th>
             <th>Prosjek</th>
            </tr>
            </thead>
            <tbody>';
        
        for ($j = 0 ; $j < $num_races ; ++$j)
        {
    	    $row = mysqli_fetch_row($result);
            echo '
              <tr>
                 <td><a href="index?race=' . $row[1] . '">'. $row[0] .'</a></td>
                 <td>' . $row[2] . '</td>
                 <td>' . $row[3] . '</td>
                 <td>' . $row[4] . '</td>
                 <td>' . $row[5] . '</td>
                 <td>' . $row[6] . '</td>
                 <td></td>
              </tr>';
        }     
    
        //table
        echo'
                      </tbody>
                   </table>
                </div>';
                
        echo'
             </div>
          </div>
       </div>';
    }

echo'
    <br/>
    <hr class="bs-docs-separator">
    </div>
    ';
   
    //sve lige u kojima je trkac sudjelovao
//    select l.lea_nam, l.lea_id from league_st_num lsn 
//    inner join league l on lsn.leagr_id=l.leagr_id
//    where per_id=1
//    
//    //sve lige-grupe u kojima je trkac sudjelovao
//    select lg.lea_gro_nam, lg.leagr_id from league_st_num lsn 
//    inner join league_group lg on lsn.leagr_id=lg.leagr_id
//    where per_id=1

}

if(isset($racer)) get_racer($racer);

?>