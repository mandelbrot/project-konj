<?php
require_once "components.php";
include_once 'head.php';

if(isset($_GET['race']))
    $race=sanitizeString($_GET['race']);

function get_race_info($raceid, $prijava){
    $query = "SELECT 
        rac_typ_nam, r.lea_id, val_id, clu_nam, c.clu_web, rac_lea_add, rac_typ_add, rac_nam, rac_nams, rac_fr_dat, 
        rac_to_dat, rac_start_dat, rac_limit_dat, rac_chrono, rac_kmH, rac_kmHD, rac_kmV, rac_kmVD, rac_ent_fee, rac_ent_fee_val, 
        rac_shirt, rac_water, rac_drink, rac_eat, rac_rs, rac_fraid, rac_reg_fr_dat, rac_reg_to_dat, rac_desc, rac_rul, 
        rac_man_eq, r.activity, r.date, rac_chk, rac_lea_rou, s.sco_sys, rac_meal, 
        case when l.lea_gps is null then rac_gps else l.lea_gps end as rac_gps, case when l.lea_web_gps is null then rac_web_gps else l.lea_web_gps end as rac_web_gps 
        FROM race r 
        left join race_type rt on r.rac_typ_id=rt.rac_typ_id
        left join club c on r.org_id=c.clu_id
        left join league l on r.lea_id=l.lea_id
        left join scoring s on l.sco_id=s.sco_id
        where rac_id='$raceid'";
    $result = queryMysql($query);
    $raceInfo = mysqli_fetch_row($result);

    //ako je trka na kronometar onda ukljuciti novi tab na pivotu u kojem je tablica sa checkpointovima
    
    get_race_info_helper($raceid, $raceInfo, $prijava);
}

function get_race_info_helper($raceid, $raceInfo, $prijava){
    $naslov = $prijava ? 
        '<h2 id="metro-pivot2">Prijava na trku ' . $raceInfo[7] . '<small></small></h2>' : 
        '<h1 id="metro-pivot1">' . $raceInfo[7] . '<small></small></h1>';
    
    echo'<div class="bs-docs-section">
           <div class="page-header">
              ' . $naslov . '
           </div>';
           
    $_SESSION['raceid']=$raceid;
    
    //u prijavi smo
    if($prijava && date('Ymd') >= date('Ymd',strtotime($raceInfo[26])) && 
        date('Ymd') <= date('Ymd',strtotime($raceInfo[27])))
    {            
        get_registration_form($raceInfo);        
        return;
    }


    //https://www.google.hr/search?q=php+back+button+document+expired&ie=utf-8&oe=utf-8&rls=org.mozilla:en-US:official&client=firefox-a&gws_rd=cr&ei=bmGWUoLdBIjnygPNrIHYBA
    //http://stackoverflow.com/questions/19188099/removing-post-data-so-back-button-wont-display-document-expired
    //http://stackoverflow.com/questions/11427136/php-document-expired-after-using-the-back-button
    
    //koristiti Post/Redirect/Get pattern?
    //primjer: http://phptutorial.codepoint.net/php_redirection
    //sve isto ko u primjeru samo kaj je 
    //index?race=9&reg - register.php         isto ko i do sad samo ne koristi session(prijava) nego s get(reg)
    //index_validate - validate.php           sve isto, redirectaj na index?race=9&reg=error
    //index?race=9&con - caonfirmation.php    slicno ko i reg, samo s confirmation stringom nekakviim 


    //ako trka nije u ligi onda drugaciji pivot treba
    if($raceInfo[1] == null){ 
        if(date('Ymd') >= date('Ymd',strtotime($raceInfo[26])) && 
            date('Ymd') <= date('Ymd',strtotime($raceInfo[27]))){
            echo'
               <form action="registration" method="post">
                <fieldset>
                    <button type="submit" class="btn" name="prijava" id="prijava">Prijava</button>
                </fieldset>
               </form>';	
			$_SESSION['raceid_prijava']=$raceid;
        }
        get_info_race_normal($raceid,$raceInfo);
    }
    else{
        get_info_race_league($raceid,$raceInfo);
    }
    
    echo'    
    <hr class="bs-docs-separator">
    </div>';
}
    
function get_info_race_normal($raceid,$raceInfo){
				        
    $query2 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
    	   rr.res_fin_time vrijeme, round($raceInfo[14]/get_time_decimal(rr.res_fin_time),2) as 'kmH/h',
			round($raceInfo[16]/get_time_decimal(rr.res_fin_time),2) as 'kmV/h',per.per_id
        FROM race_result rr 
    	inner join race r on rr.rac_id=r.rac_id
    	inner join start st on r.st_id=st.st_id
    	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
    	inner join person per on sn.per_id=per.per_id
        where rr.rac_id='$raceid' and per.per_sex=1
        order by rr.res_fin_time";
    $result2 = queryMysql($query2);
    $num2 = mysqli_num_rows(queryMysql($query2));

    $query3 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
    	   rr.res_fin_time vrijeme, round($raceInfo[14]/get_time_decimal(rr.res_fin_time),2) as 'kmH/h',
			round($raceInfo[16]/get_time_decimal(rr.res_fin_time),2) as 'kmV/h',per.per_id
        FROM race_result rr 
    	inner join race r on rr.rac_id=r.rac_id
    	inner join start st on r.st_id=st.st_id
    	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
    	inner join person per on sn.per_id=per.per_id
        where rr.rac_id='$raceid' and per.per_sex=0
        order by rr.res_fin_time";
    $result3 = queryMysql($query3);
    $num3 = mysqli_num_rows(queryMysql($query3));
    
    if($num2==0 && $num3==null){
        echo 'Nema rezultata za odabranu trku';
        return;
    } 
    
    echo'

    <div class="bs-docs-example bs-docs-example-pivot">
      <div id="pivot" class="pivot slide">
         <div class="pivot-headers">
            <a href="#pivot" data-pivot-index="0" class="active">Rezultati</a>
            <a href="#pivot" data-pivot-index="1">Uvod</a>
            <a href="#pivot" data-pivot-index="2">Info</a>
            <a href="#pivot" data-pivot-index="3">Natjecatelji</a>
            ';
    if (strtolower($raceInfo[33])=="d"){
        echo '<a href="#pivot" data-pivot-index="4">Checkpoints</a>';
    }
   
    echo'</div>
         <div class="pivot-items">';
               
    echo'<div id="pivot-item-0" class="pivot-item active">
			<table class="table table-condensed table-hover table-striped">
			  <thead>
			  <tr>
				 <th class="span1">R.br.</th>
				 <th class="span1">St.br.</th>
				 <th class="span1">Trka&#269;</th>
				 <th class="span1">Rezultat</th>
				 <th class="span1">kmH/h</th>
				 <th class="span1">kmV/h</th>
			  </tr>
			  </thead>
			  <tbody>';
                  
    for($i=0;$i<$num2;$i++)
	{
        if($i == 0)
		{
            echo '
              <tr>
                 <td colspan=6><b>Mu&#353;ki</b></td>
              </tr>';  
        }
        $row = mysqli_fetch_row($result2);
        echo '
          <tr>
             <td>' . ($i+1) . '.</td>
             <td>' . $row[0] . '.</td>
             <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
             <td>' . $row[2] . '</td>
             <td>' . $row[3] . '</td>
             <td>' . $row[4] . '</td>
          </tr>';       
    }
    for($i=0;$i<$num3;$i++)
	{
        if($i == 0){
            echo '
              <tr>
                 <td colspan=6><b>&#381;ene</b></td>
              </tr>';  
        }
        $row = mysqli_fetch_row($result3);
        echo '
          <tr>
             <td>' . ($i+1) . '.</td>
             <td>' . $row[0] . '.</td>
             <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
             <td>' . $row[2] . '</td>
             <td>' . $row[3] . '</td>
             <td>' . $row[4] . '</td>
          </tr>';       
    }
    
    echo '
              </tbody>
           </table>
        </div>';
    echo'
        <div id="pivot-item-1" class="pivot-item">
          <p>' . $raceInfo[28] . '</p>
        </div>
        ';
    
    echo '
        <div id="pivot-item-2" class="pivot-item">
          <p><b>Tip utrke</b>: ' . $raceInfo[0] . '</p>
          <p><b>Organizator</b>: <a href="' . $raceInfo[4] . '">' . $raceInfo[3] . '</a></p>
          <p><b>GPS + Profil</b>: </p>
          <p><a title="Konj" href="' . $raceInfo[38] . '" target="_blank"><img alt="" src="data:image/jpeg;base64,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" /></a></p>
        </div>';
           
    $query = "SELECT concat(rr.rac_reg_nam, ' ', rr.rac_reg_sur), rac_reg_sex, rac_reg_year, rac_reg_paid_fee 
        FROM konj.race_registration rr
        inner join race r on rr.rac_id=r.rac_id
        where rr.rac_id='$raceid'";
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));
    
    if($num==0){
        echo '<div id="pivot-item-3" class="pivot-item">Nema podataka o natjecateljima</div>';
    }  
    else{   
        echo '
            <div id="pivot-item-3" class="pivot-item">
                <table class="table table-condensed table-hover table-bordered table-striped">
                      <thead>
                      <tr>
                         <th class="span1">R.br.</th>
                         <th class="span1">Trka&#269;</th>
                         <th class="span1">Spol</th>
                         <th class="span1">Godi&#353;te</th>
                         <th class="span1">Startnina</th>
                      </tr>
                      </thead>
                      <tbody>';

        for($i=0;$i<$num;$i++){
            $row = mysqli_fetch_row($result);
            echo '
              <tr>
                 <td>' . ($i+1) . '.</td>
                 <td>' . str_replace("c", "c", $row[0]) . '</td>
                 <td>' . ($row[1] == 1 ? "M" : "&#381;") . '</td>
                 <td>' . $row[2] . '</td>
                 <td>' . ($row[3] == 1 ? "DA" : "NE") . '</td>
              </tr>';       
        }
        
        echo '
                  </tbody>
               </table>
            </div>';    
    }
       
    //checkpoints?
    if (strtolower($raceInfo[33])=="d"){
        echo '
            <div id="pivot-item-4" class="pivot-item">
               <h3>Checkpoints</h3>
        
               <h4>Some charts <small>thanks to Nick Downie (http://www.chartjs.org/)</small></h4>
               <div class="row-fluid">
                  <div class="span10">
                     <canvas id="myChart" width="500" height="380"></canvas>
                  </div>
               </div>
            </div>';
    }

    echo'
             </div>
          </div>
       </div>
       <br/>
    ';
}

function get_info_race_league($raceID, $raceInfo){    
    $rbr_kola = $raceInfo[34];
    
    $query2 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
    	rr.res_fin_time vrijeme, rr2.res_fin_time vrijeme_prosl_kola, r.lea_id, 
		per.per_id
        FROM race_result rr 
    	inner join race r on rr.rac_id=r.rac_id
    	inner join start st on r.st_id=st.st_id
    	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
    	inner join person per on sn.per_id=per.per_id
        inner join league l on r.lea_id=l.lea_id
        left outer join (
            select rr.sn_id, res_fin_time from race_result rr
			inner join race r on rr.rac_id=r.rac_id
			inner join start st on r.st_id=st.st_id
			inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
			inner join person per on sn.per_id=per.per_id
            where rr.rac_id =(
            select rac_id from race r
            inner join (
            select lea_id from race r
            where r.rac_id=$raceID) as league
             on r.lea_id=league.lea_id
            and $rbr_kola>rac_lea_rou
            limit 1)
        ) as rr2
        on rr.sn_id=rr2.sn_id
        where r.rac_id=$raceID and per.per_sex=1 
        order by rr.res_fin_time";
    $result2 = queryMysql($query2);
    $num2 = mysqli_num_rows(queryMysql($query2));

    $query3 = "SELECT rr.sn_id, concat(per.per_nam, ' ', per.per_sur) as trkac, 
    	rr.res_fin_time vrijeme, rr2.res_fin_time vrijeme_prosl_kola, r.lea_id, 
		per.per_id
        FROM race_result rr 
    	inner join race r on rr.rac_id=r.rac_id
    	inner join start st on r.st_id=st.st_id
    	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
    	inner join person per on sn.per_id=per.per_id
        inner join league l on r.lea_id=l.lea_id
        left outer join (
            select rr.sn_id, res_fin_time from race_result rr
			inner join race r on rr.rac_id=r.rac_id
			inner join start st on r.st_id=st.st_id
			inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
			inner join person per on sn.per_id=per.per_id
            where rr.rac_id =(
            select rac_id from race r
            inner join (
            select lea_id from race r
            where r.rac_id=$raceID) as league
             on r.lea_id=league.lea_id
            and $rbr_kola>rac_lea_rou
            limit 1)
        ) as rr2
        on rr.sn_id=rr2.sn_id
        where r.rac_id=$raceID and per.per_sex=0 
        order by rr.res_fin_time";
    $result3 = queryMysql($query3);
    $num3 = mysqli_num_rows(queryMysql($query3));
    
    if($num2==0 && $num3==null){
        echo 'Nema rezultata za ovo kolo';
        return;
    } 
    
    echo'
    <div class="bs-docs-example bs-docs-example-pivot">
      <div id="pivot" class="pivot slide">
         <div class="pivot-headers">
            <a href="#pivot" data-pivot-index="0" class="active">Rezultati</a>
            <a href="#pivot" data-pivot-index="1">Uvod</a>
            <a href="#pivot" data-pivot-index="2">Info</a>
            <a href="#pivot" data-pivot-index="3">Natjecatelji</a>
            ';
    if (strtolower($raceInfo[33])=="d"){
        echo '<a href="#pivot" data-pivot-index="4">Checkpoints</a>';
    }
   
    echo'</div>
         <div class="pivot-items">';
               
    echo'<div id="pivot-item-0" class="pivot-item active">
           <table class="table table-condensed table-hover  table-striped">
              <thead>
              <tr>
                 <th class="span1">R.br.</th>
                 <th class="span1">St.br.</th>
                 <th class="span1">Trka&#269;</th>
                 <th class="span1">Rezultat</th>
                 <th class="span1">Pro&#353;lo kolo</th>
              </tr>
              </thead>
              <tbody>';
              
    if($num2 > 0){
        echo '
          <tr>
             <td colspan=5><b>Mu&#353;ki</b></td>
          </tr>';  
    }
    for($i=0;$i<$num2;$i++){
        $row = mysqli_fetch_row($result2);
        echo '
          <tr>
             <td>' . ($i+1) . '.</td>
             <td>' . $row[0] . '.</td>
             <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
             <td>' . $row[2] . ' ' . (round_res_last_round($row[2], $row[3]) ? 
                '<span aria-hidden="true" class="icon-thumbs-up-2"></span>' : 
                '<span aria-hidden="true" class="icon-thumbs-down-2"></span>') . '</td>
             <td>' . (is_null($row[3]) ? "   " : $row[3]) . '</td>
          </tr>';       
    }
 
    if($num3 > 0){
        echo '
          <tr>
             <td colspan=5><b>&#381;ene</b></td>
          </tr>';  
    }
    for($i=0;$i<$num3;$i++){
        $row = mysqli_fetch_row($result3);
        echo '
          <tr>
             <td>' . ($i+1) . '.</td>
             <td>' . $row[0] . '.</td>
             <td><a href="#" onclick=\'ajaxGetComponent("racer", ' . $row[5] . ')\'>' . $row[1] . '</a></td>
             <td>' . $row[2] . ' ' . (round_res_last_round($row[2], $row[3]) ? 
                '<span aria-hidden="true" class="icon-thumbs-up-2"></span>' : 
                '<span aria-hidden="true" class="icon-thumbs-down-2"></span>') . '</td>
             <td>' . $row[3] . '</td>
          </tr>';       
    }
    
    echo '
              </tbody>
           </table>
        </div>';
    echo'
        <div id="pivot-item-1" class="pivot-item">
          <p>' . $raceInfo[28] . '</p>
        </div>
        ';
    
    echo '
        <div id="pivot-item-2" class="pivot-item">
          <p><b>Tip utrke</b>: ' . $raceInfo[0] . '</p>
          <p><b>Organizator</b>: <a href="' . $raceInfo[4] . '">' . $raceInfo[3] . '</a></p>
          <p><b>GPS + Profil</b>: </p>
          <p><a title="Konj" href="' . $raceInfo[38] . '" target="_blank"><img alt="" src="data:image/jpeg;base64,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" /></a></p>
        </div>';
       
    //registrirani        
    $query = "SELECT concat(rr.rac_reg_nam, ' ', rr.rac_reg_sur), rac_reg_sex, rac_reg_year, rac_reg_paid_fee 
        FROM race_registration rr
        inner join race r on rr.rac_id=r.rac_id
        where rr.rac_id='$raceID'";
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));
    
    if($num==0){
        echo '<div id="pivot-item-3" class="pivot-item">Nema podataka o natjecateljima</div>';
    }  
    else{   
        echo '
            <div id="pivot-item-3" class="pivot-item">
                <table class="table table-condensed table-hover table-bordered table-striped">
                      <thead>
                      <tr>
                         <th class="span1">R.br.</th>
                         <th class="span1">Trka&#269;</th>
                         <th class="span1">Spol</th>
                         <th class="span1">Godi&#353;te</th>
                         <th class="span1">Startnina</th>
                      </tr>
                      </thead>
                      <tbody>';

        for($i=0;$i<$num;$i++){
            $row = mysqli_fetch_row($result);
            echo '
              <tr>
                 <td>' . ($i+1) . '.</td>
                 <td>' . str_replace("c", "c", $row[0]) . '</td>
                 <td>' . ($row[1] == 1 ? "M" : "&#381;") . '</td>
                 <td>' . $row[2] . '</td>
                 <td>' . ($row[3] == 1 ? "DA" : "NE") . '</td>
              </tr>';       
        }
        
        echo '
                  </tbody>
               </table>
            </div>';    
    }
            
    //checkpoints?
    if (strtolower($raceInfo[33])=="d"){
        echo '
            <div id="pivot-item-4" class="pivot-item">
               <h3>Item 4</h3>
        
               <h4>Some charts <small>thanks to Nick Downie (http://www.chartjs.org/)</small></h4>
               <div class="row-fluid">
                  <div class="span10">
                     <canvas id="myChart" width="500" height="380"></canvas>
                  </div>
               </div>
            </div>';
    }

    echo'
             </div>
          </div>
       </div>
       <br/>
    ';
}

function get_registration_form($raceInfo)
{
//forma za unos podataka...
    $name=isset($_SESSION['rac_reg_name']) ? $_SESSION['rac_reg_name'] : "" ;
    $surname=isset($_SESSION['rac_reg_surname']) ? $_SESSION['rac_reg_surname'] : "" ;
    $god_rodj=isset($_SESSION['rac_reg_god_rodj']) ? $_SESSION['rac_reg_god_rodj'] : "" ;
    $_SESSION['rac_reg_sex']=isset($_SESSION['rac_reg_sex']) ? $_SESSION['rac_reg_sex'] : 1 ;
    $_SESSION['rac_reg_shirt']=isset($_SESSION['rac_reg_shirt']) ? $_SESSION['rac_reg_shirt'] : "S" ;
    $_SESSION['rac_reg_meal']=isset($_SESSION['rac_reg_meal']) ? $_SESSION['rac_reg_meal'] : 0 ;
    if(strtolower($raceInfo[20]) == "n" || $raceInfo[20] == null)
        unset($_SESSION['rac_reg_shirt']);
    if(strtolower($raceInfo[36]) == "n" || $raceInfo[36] == null)
        unset($_SESSION['rac_reg_meal']);
        
    echo'
       <form action="index_validate" method="post" id="registration">
        <fieldset>
			<div class="control-group">
				<label>Ime:</label>
				<input type="text" placeholder="Type your name..." name="rac_reg_name" id="name"
					value="' . $name . '">
			</div>
			<div class="control-group">
				<label>Prezime:</label>
				<input type="text" placeholder="Type your surname..." name="rac_reg_surname" id="surname" 
					value="' . $surname . '">
			</div>
            <span class="help-block"></span>
            <label>Spol:</label>
            <label class="radio">
            <input type="radio" name="rac_reg_sex" id="spolM" value="1" ' . 
                ($_SESSION['rac_reg_sex'] == 1 ? "checked" : "") . ' >
            <span class="metro-radio">M</span>
            </label>
            <label class="radio">
            <input type="radio" name="rac_reg_sex" id="spolF" value="0" ' . 
                ($_SESSION['rac_reg_sex'] == 0 ? "checked" : "") . ' >
            <span class="metro-radio">&#381;</span>
            </label>    
            <span class="help-block"></span>
            <br/>
			<div class="control-group">
				<label>Godina ro&#273;enja:</label>
				<input type="text" placeholder="Type your birth year..." name="rac_reg_god_rodj" id="god_rodj" 
					value="' . $god_rodj . '">
			</div>
            <span class="help-block"></span>' . 
            ((strtolower($raceInfo[20]) == "n" || $raceInfo[20] == null) ? "" : 
            " <label>Majica:</label><select name=\"rac_reg_shirt\">
                <option value=\"S\" ". ($_SESSION['rac_reg_shirt'] == "S" ? "selected" : "") .">S</option>
                <option value=\"M\" ". ($_SESSION['rac_reg_shirt'] == "M" ? "selected" : "") .">M</option>
                <option value=\"L\" ". ($_SESSION['rac_reg_shirt'] == "L" ? "selected" : "") .">L</option>
                <option value=\"XL\" ". ($_SESSION['rac_reg_shirt'] == "XL" ? "selected" : "") .">XL</option>
                </select>") 
            . '<br/>' . 
            ((strtolower($raceInfo[36]) == "n" || $raceInfo[36] == null) ? "" : 
            " <label>Meni:</label><select name=\"rac_reg_meal\">
                <option value=0 ". ($_SESSION['rac_reg_meal'] == "0" ? "selected" : "") . ">Mesni</option>
                <option value=1 ". ($_SESSION['rac_reg_meal'] == "1" ? "selected" : "") . ">Vegetarijanski</option>
                </select>") 
            . '<br/><br/>
            <button type="submit" class="btn" id="register">Prijava</button>
        </fieldset>
       </form>';
    
    echo'    
        <hr class="bs-docs-separator">
        </div>';    
}

if(isset($race)) get_race_info($race,false);

?>

<script type="text/javascript">
$(document).ready(function() {
	$(".races-active").hide();
	$('#register').click(function(e){
		error=false;
		$(".control-group").removeClass("error");
		$(".help-inline").remove();
		if($("#name").val().trim() == ''){
			$("#name").closest("div").addClass("error");
			$("#name").closest("div").append("<span class=\"help-inline\">Upi&#353;i ime!</span>");
			error=true;
		}
		if($("#surname").val().trim() == ''){
			$("#surname").closest("div").addClass("error");
			$("#surname").closest("div").append("<span class=\"help-inline\">Upi&#353;i prezime!</span>");
			error=true;
		}
		if(document.getElementById('god_rodj').value.trim() == '' || 
            document.getElementById('god_rodj').value.trim().length != 4 || 
            document.getElementById('god_rodj').value.trim() <="1900" || 
            document.getElementById('god_rodj').value.trim() >="2000"){
			$("#god_rodj").closest("div").addClass("error");
			$("#god_rodj").closest("div").append("<span class=\"help-inline\">Upi&#353i godinu ro&#273;enja!</span>");
			error=true;
		}
		if(error){
			e.preventDefault();
		}
		else{
			//POST
		}
	});
});

</script>