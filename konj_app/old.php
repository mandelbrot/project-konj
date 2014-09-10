<?php

//get_race_league_leaguegroup zamijenjeno sa get_sidebar


//ubacivanje u errorDiv je zamijenjeno s jQueryjem
//echo '<div id="errorDiv">';
//echo '</div>';


//components.php
function get_helper(){
    echo "get_helper funkcija koja dodaje neke JS stvari za IE!";
    echo '<script type="text/javascript">
    	$(document).ready(function () {
    	$("#m-carousel").carousel()
    
    	if (navigator.appName == "Microsoft Internet Explorer")
        {
    		$("select").focus(
    			function () {
    				$(this).css("border", "1px solid #CBCBCB");
    			  }, 
    			function () {
    				$(this).css("border", "1px solid #090909");
    			  }
    			);	
    		$("select").hover(
    			function () {
    				$(this).css("border", "1px solid #A4A4A4");
    			  }, 
    			function () {
    				$(this).css("border", "1px solid #CBCBCB");
    			  }
    			);	
    		$("select").hover.focus(
    			function () {
    				$(this).css("border", "1px solid #090909");
    			  }, 
    			function () {
    				$(this).css("border", "1px solid #CBCBCB");
    			  }
    			);
    	}
    	});
    </script>';
}

function get_registration($raceid){
    $query = "SELECT 
        rac_typ_nam, r.lea_id, val_id, clu_nam, c.clu_email, rac_lea_add, rac_typ_add, rac_nam, rac_nams, rac_fr_dat, rac_to_dat, 
        rac_start_dat, rac_limit_dat, rac_chrono, rac_kmH, rac_kmHD, rac_kmV, rac_kmVD, rac_ent_fee, rac_ent_fee_val, rac_shirt, 
        rac_water, rac_drink, rac_eat, rac_rs, rac_fraid, rac_reg_fr_dat, rac_reg_to_dat, rac_desc, rac_calc, 
        rac_rul, rac_man_eq, r.activity, r.date, rac_chk, rac_lea_rou, s.sco_sys
        FROM race r 
        left join race_type rt on r.rac_typ_id=rt.rac_typ_id
        left join club c on r.org_id=c.clu_id
        left join league l on r.lea_id=l.lea_id
        left join scoring s on l.sco_id=s.sco_id
        where rac_id='$raceid'";
    $result = queryMysql($query);
    $raceInfo = mysqli_fetch_row($result);
    
    echo'
    
<!-- Pivot
================================================== -->
<div class="bs-docs-section">
   <h2>Prijava na ' . $raceInfo[7] . '</h2>
</div>';
}

function get_table(){
    
    echo '<aside>	
		<b>Participants</b>
		<ul class="lista">';
      
    $query = "SELECT per_nam, per_sur, per_id FROM person";
    $result = queryMysql($query);

    $num = mysqli_num_rows(queryMysql($query));

    for ($j = 0 ; $j < $num ; ++$j)
    {
	    $row = mysqli_fetch_row($result);
        $id = $row[2];
        $race='<li class="margin-bottom10">' . $row[0] . $row[1] . '</li>';
        $race='<a href="participant?participant=' . $id . '">' . $race . '</a>';
        
        echo $race;
    }
	
    echo
        '</ul>';
              
    echo
	   '</aside>';
}

//admin.php   
    function get_page_participant_new_OLD(){ 
        echo' 
        <form action="admin?participant=new" method="post"> 
            <fieldset> 
                <label>Ime:</label> 
                <input type="text" class="input-xxlarge" placeholder="Type participant\'s name..." maxlength="80" name="participant_nam" 
                    value="' . (isset($_SESSION['participant_nam']) ? $_SESSION['participant_nam'] : '') . '"> 
                <label>Prezime:</label> 
                <input type="text" class="input-xxlarge" placeholder="Type participant\'s surname..." maxlength="80" name="participant_sur" 
                    value="' . (isset($_SESSION['participant_sur']) ? $_SESSION['participant_sur'] : '') . '"> 
                <span class="help-block"></span> 
                <label>Spol:</label> 
                <label class="radio"> 
                <input type="radio" name="participant_sex" id="spolM" value="' . $_SESSION['participant_sex'] . '" checked> 
                <span class="metro-radio">M</span> 
                </label> 
                <label class="radio"> 
                <input type="radio" name="participant_sex" id="spolF" value="' . $_SESSION['participant_sex'] . '"> 
                <span class="metro-radio">&#381;</span> 
                </label>     
                <span class="help-block"></span> 
                <br/> 
                <label>Godina ro&#273;enja:</label> 
                <input type="text" placeholder="Type participant\'s birth year..." maxlength="4" minlength="4" name="participant_god_rodj"
                    value="' . (isset($_SESSION['participant_god_rodj']) ? $_SESSION['participant_god_rodj'] : '') . '"> 
                <span class="help-block"></span> 
                <label>Datum ro&#273;enja (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="Type participant\'s birth date..." maxlength="19" minlength="19" name="participant_dat_rodj"
                    value="' . (isset($_SESSION['participant_dat_rodj']) ? $_SESSION['participant_dat_rodj'] : '') . '"> 
                <span class="help-block"></span> 
                <label>Mob.:</label> 
                <input type="text" placeholder="Type participant\'s mobile..." maxlength="20" name="participant_mob" 
                    value="' . (isset($_SESSION['participant_mob']) ? $_SESSION['participant_mob'] : '') . '"> 
                <span class="help-block"></span> 
                <label>E-mail.:</label> 
                <input type="text" placeholder="Type participant\'s e-mail..." maxlength="50" name="participant_email"  
                    value="' . (isset($_SESSION['participant_email']) ? $_SESSION['participant_email'] : '') . '"> 
                <span class="help-block"></span>'; 
                  
        $query = "SELECT clu_id, clu_nam   
            FROM club"; 
        $result = queryMysql($query); 
        $num = mysqli_num_rows(queryMysql($query)); 
          
        echo' 
        <label>Klub:</label> 
        <select name="participant_club"> 
        <option value="null">Select a club...</option>'; 
        for($i=0;$i<$num;$i++){   
            $row = mysqli_fetch_row($result); 
            echo'  
            <option value="' . $row[0] . '" ' . ($row[0] == $_SESSION['participant_club'] ? "selected=\"selected\"" : "") . '>' . $row[1] . '</option>';        
        } 
        echo' 
        </select> 
        <a href="admin?club=new"><span aria-hidden="true" class="icon-plus-5"></span></a> 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }   
        function get_page_league_group_new_OLD(){ 
        echo' 
        <form action="admin?league_group=new" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type league group name..." maxlength="80" name="league_group_nam" 
                    value="' . (isset($_SESSION["league_group_nam"]) ? $_SESSION["league_group_nam"] : '') . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter league group name..." maxlength="20" name="league_group_nams" 
                    value="' . (isset($_SESSION["league_group_nams"]) ? $_SESSION["league_group_nams"] : '') . '"> 
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_group_desc"  
                    value="' . (isset($_SESSION["league_group_desc"]) ? $_SESSION["league_group_desc"] : '') . '">' . (isset($_SESSION["league_group_desc"]) ? $_SESSION["league_group_desc"] : '') . '</textarea> 
                <span class="help-block"></span>  
                <label>Pravila:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_group_rul"  
                    value="' . (isset($_SESSION["league_group_rul"]) ? $_SESSION["league_group_rul"] : '') . '">' . (isset($_SESSION["league_group_rul"]) ? $_SESSION["league_group_rul"] : '') . '</textarea> 
                <span class="help-block"></span>                
                '; 
  
                $query2 = "SELECT clu_id, clu_nam   
                FROM club"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Klub:</label> 
                <select name="league_group_club"> 
                <option value="null">Select organizer...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
                    echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["league_group_club"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
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
                    echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["league_group_sco"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
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
        function get_page_scoring_new_OLD(){ 
        echo' 
        <form action="admin?scoring=new" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type name..." maxlength="80" name="scoring_nam" 
                    value="' . (isset($_SESSION["scoring_nam"]) ? $_SESSION["scoring_nam"] : '') . '"> 
                <label>Sustav:</label> 
                <textarea rows="3" type="text" placeholder="Type system..." maxlength="200" name="scoring_sys"  
                    value="' . (isset($_SESSION["scoring_sys"]) ? $_SESSION["scoring_sys"] : '') . '">' . (isset($_SESSION["scoring_sys"]) ? $_SESSION["scoring_sys"] : '') . '</textarea> 
                <span class="help-block"></span>  
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="scoring_desc"  
                    value="' . (isset($_SESSION["scoring_desc"]) ? $_SESSION["scoring_desc"] : '') . '">' . (isset($_SESSION["scoring_desc"]) ? $_SESSION["scoring_desc"] : '') . '</textarea> 
                <span class="help-block"></span>  
        <br/><br/> 
        <button type="submit" id="spremi" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }     
        function get_page_event_new_OLD(){ 
        echo' 
        <form action="admin?event=new" method="post"> 
            <fieldset> 
				<label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type event name..." maxlength="80" name="event_nam" 
                    value="' . (isset($_SESSION["event_nam"]) ? $_SESSION["event_nam"] : '') . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type shorter event name..." maxlength="20" name="event_nams" 
                    value="' . (isset($_SESSION["event_nams"]) ? $_SESSION["event_nams"] : '') . '"> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="event_fr_dat"
                    value="' . (isset($_SESSION["event_fr_dat"]) ? $_SESSION["event_fr_dat"] : '') . '"> 
                <input type="text" placeholder="..." maxlength="19" name="event_to_dat"
                    value="' . (isset($_SESSION["event_to_dat"]) ? $_SESSION["event_to_dat"] : '') . '"> 
                <span class="help-block"></span> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="event_start_dat"
                    value="' . (isset($_SESSION["event_start_dat"]) ? $_SESSION["event_start_dat"] : '') . '"> 
                <input type="text" placeholder="..." maxlength="19" name="event_limit_dat"
                    value="' . (isset($_SESSION["event_limit_dat"]) ? $_SESSION["event_limit_dat"] : '') . '"> 
                <span class="help-block"></span> 
                <label>Utrke (id):</label> 
                <textarea rows="2" type="text" placeholder="Type event race id\'s..." maxlength="200" name="event_rac"  
                    value="' . (isset($_SESSION["event_rac"]) ? $_SESSION["event_rac"] : '') . '">' . (isset($_SESSION["event_rac"]) ? $_SESSION["event_rac"] : '') . '</textarea> 
                <span class="help-block"></span> 
                <label>Opis:</label> 
                <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="event_desc"  
                    value="' . (isset($_SESSION["event_desc"]) ? $_SESSION["event_desc"] : '') . '">' . (isset($_SESSION["event_desc"]) ? $_SESSION["event_desc"] : '') . '</textarea> 
                <span class="help-block"></span>  
                <label>Pravila:</label> 
                <textarea rows="3" type="text" placeholder="Type rules..." maxlength="200" name="event_rul"  
                    value="' . (isset($_SESSION["event_rul"]) ? $_SESSION["event_rul"] : '') . '">' . (isset($_SESSION["event_rul"]) ? $_SESSION["event_rul"] : '') . '</textarea> 
                <span class="help-block"></span>                
                ';
  
                $query2 = "SELECT clu_id, clu_nam   
                FROM club"; 
                $result2 = queryMysql($query2); 
                $num2 = mysqli_num_rows(queryMysql($query2)); 
                echo ' 
                <label>Klub:</label> 
                <select name="event_club"> 
                <option value="null">Select organizer...</option>'; 
                for($i=0;$i<$num2;$i++){   
                    $row2 = mysqli_fetch_row($result2); 
                    echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["event_club"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
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
function get_page_league_new_OLD(){ 
    echo' 
    <form action="admin?league=new" method="post"> 
        <fieldset> 
            <label>Naziv:</label> 
            <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="league_nam" 
                value="' . (isset($_SESSION["league_nam"]) ? $_SESSION["league_nam"] : '') . '"> 
            <label>Kratki naziv:</label> 
            <input type="text" placeholder="Type shorter league name..." maxlength="20" name="league_nams" 
                value="' . (isset($_SESSION["league_nams"]) ? $_SESSION["league_nams"] : '') . '"> 
            <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
            <input type="text" placeholder="..." maxlength="19" name="league_to_dat"
                value="' . (isset($_SESSION["league_to_dat"]) ? $_SESSION["league_to_dat"] : '') . '"> 
            <input type="text" placeholder="..." maxlength="19" name="league_fr_dat"
                value="' . (isset($_SESSION["league_fr_dat"]) ? $_SESSION["league_fr_dat"] : '') . '"> 
            <span class="help-block"></span> 
            <label>Broj kola   -   broj kola koji se boduje:</label> 
            <input class="input-mini" type="text" placeholder="..." name="league_day"
                value="' . (isset($_SESSION["league_day"]) ? $_SESSION["league_day"] : '') . '"> 
            <input class="input-mini" type="text" placeholder="..." name="league_day_sco"
                value="' . (isset($_SESSION["league_day_sco"]) ? $_SESSION["league_day_sco"] : '') . '"> 
            <span class="help-block"></span> 
            <label>Startnina:</label> 
            <input type="text" placeholder="..." name="league_ent_fee"
                value="' . (isset($_SESSION["league_ent_fee"]) ? $_SESSION["league_ent_fee"] : '') . '"> 
            <label>Opis:</label> 
            <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_desc"  
                value="' . (isset($_SESSION["league_desc"]) ? $_SESSION["league_desc"] : '') . '">' . (isset($_SESSION["league_desc"]) ? $_SESSION["league_desc"] : '') . '</textarea> 
            <span class="help-block"></span>  
            <label>Pravila:</label> 
            <textarea rows="3" type="text" placeholder="Type description..." maxlength="200" name="league_rul"  
                value="' . (isset($_SESSION["league_rul"]) ? $_SESSION["league_rul"] : '') . '">' . (isset($_SESSION["league_rul"]) ? $_SESSION["league_rul"] : '') . '</textarea> 
            <span class="help-block"></span>                
            '; 

            $query2 = "SELECT clu_id, clu_nam   
            FROM club per"; 
            $result2 = queryMysql($query2); 
            $num2 = mysqli_num_rows(queryMysql($query2)); 
            echo ' 
            <label>Klub:</label> 
            <select name="league_club"> 
            <option value="null">Select organizer...</option>'; 
            for($i=0;$i<$num2;$i++){   
                $row2 = mysqli_fetch_row($result2); 
                echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["league_club"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
            } 
            echo ' 
            </select>'; 
              
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
                echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["league_league_group"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
            } 
            echo ' 
            </select>'; 

    echo' 
    <span class="help-block"></span> 
    <br/><br/> 
    <button type="submit" class="btn">Spremi</button> 
    </fieldset> 
    </form>'; 
}  
    function get_page_start_num_new_OLD(){  
        echo '<h2>Startni brojevi</h2>';
        
        echo' 
        <form action="admin?st_num=new" method="post"> 
            <fieldset> 
                <label>Ime:</label> 
                <input type="text" class="input-xxlarge" placeholder="Type st. number name..." maxlength="80" name="st_num_name" 
                    value="' . (isset($_SESSION['st_num_name']) ? $_SESSION['st_num_name'] : '') . '"> 
                <label>Tip:</label> 
                <input type="text" class="input-mini" placeholder="Type st. number type..." maxlength="80" name="st_num_type" 
                    value="' . (isset($_SESSION['st_num_type']) ? $_SESSION['st_num_type'] : '') . '">
            <span class="help-block"></span> 
            <br/><br/> 
            <button type="submit" class="btn">Spremi</button> 
            </fieldset> 
        </form>'; 
    }   
function get_page_club_new_OLD(){ 
        echo' 
        <form action="admin?club=new" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input type="text" class="input-xxlarge"  placeholder="Type club\'s name..." name="club_nam"
                    value="' . (isset($_SESSION["club_nam"]) ? $_SESSION["club_nam"] : '') . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type club\'s shorter name..." name="club_nams"
                    value="' . (isset($_SESSION["club_nam"]) ? $_SESSION["club_nam"] : '') . '"> 
                <label>Adresa:</label> 
                <input type="text" placeholder="Type club\'s adress..." name="club_adr"
                    value="' . (isset($_SESSION["club_adr"]) ? $_SESSION["club_adr"] : '') . '"> 
                <label>Grad:</label> 
                <input type="text" placeholder="Type club\'s town..." name="club_tow"  
                    value="' . (isset($_SESSION["club_tow"]) ? $_SESSION["club_tow"] : '') . '"> 
                <label>&#381;upanija:</label> 
                <input type="text" placeholder="Type club\'s county..." name="club_cou" 
                    value="' . (isset($_SESSION["club_cou"]) ? $_SESSION["club_cou"] : '') . '"> 
                <label>Dr&#382;ava:</label> 
                <input type="text" placeholder="Type club\'s state..." name="club_sta"  
                    value="' . (isset($_SESSION["club_sta"]) ? $_SESSION["club_sta"] : '') . '"> 
                <label>Web:</label> 
                <input type="text" placeholder="Type club\'s web adress..." name="club_web" 
                    value="' . (isset($_SESSION["club_web"]) ? $_SESSION["club_web"] : '') . '"> 
                <label>E-mail:</label> 
                <input type="text" placeholder="Type club\'s email..." name="club_email" 
                    value="' . (isset($_SESSION["club_email"]) ? $_SESSION["club_email"] : '') . '"> 
                <label>Telefon:</label> 
                <input type="text" placeholder="Type club\'s telephone..." name="club_tel" 
                    value="' . (isset($_SESSION["club_tel"]) ? $_SESSION["club_tel"] : '') . '"> 
                <label>Telefon2:</label> 
                <input type="text" placeholder="Type club\'s telephone..." name="club_tel2"
                    value="' . (isset($_SESSION["club_tel2"]) ? $_SESSION["club_tel2"] : '') . '"> 
                <label>Fax:</label> 
                <input type="text" placeholder="Type club\'s fax..." name="club_fax" 
                    value="' . (isset($_SESSION["club_fax"]) ? $_SESSION["club_fax"] : '') . '"> 
                <label>Mob:</label> 
                <input type="text" placeholder="Type club\'s mobile..." name="club_mob" 
                    value="' . (isset($_SESSION["club_mob"]) ? $_SESSION["club_mob"] : '') . '"> 
                <label>Mob2:</label> 
                <input type="text" placeholder="Type club\'s mobile..." name="club_mob2" 
                    value="' . (isset($_SESSION["club_mob2"]) ? $_SESSION["club_mob2"] : '') . '"> 
                <label>Ra&#269;un:</label> 
                <input type="text" placeholder="Type club\'s account number..." name="club_acc" 
                    value="' . (isset($_SESSION["club_acc"]) ? $_SESSION["club_acc"] : '') . '"> 
                <label>Ra&#269;un2:</label> 
                <input type="text" placeholder="Type club\'s account number..." name="club_acc2"
                    value="' . (isset($_SESSION["club_acc2"]) ? $_SESSION["club_acc2"] : '') . '"> 
                <span class="help-block"></span> 
                <br/><br/> 
                <button type="submit" class="btn">Spremi</button> 
            </fieldset> 
        </form>'; 
    }   
    function get_page_race_new_OLD(){ 
        echo' 
        <form action="admin?race=new" method="post"> 
            <fieldset> 
                <label>Naziv:</label> 
                <input class="input-xxlarge" type="text" placeholder="Type race name..." maxlength="80" name="race_nam" 
                    value="' . (isset($_SESSION["race_nam"]) ? $_SESSION["race_nam"] : '') . '"> 
                <label>Kratki naziv:</label> 
                <input type="text" placeholder="Type participant\'s surname..." maxlength="20" name="race_nams" 
                    value="' . (isset($_SESSION["race_nams"]) ? $_SESSION["race_nams"] : '') . '"> 
                <label>Trajanje od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="race_fr_dat"
                    value="' . (isset($_SESSION["race_fr_dat"]) ? $_SESSION["race_fr_dat"] : '') . '"> 
                <input type="text" placeholder="..." maxlength="19" name="race_to_dat"
                    value="' . (isset($_SESSION["race_to_dat"]) ? $_SESSION["race_to_dat"] : '') . '"> 
                <label>Start:</label> 
                <input type="text" placeholder="..." name="race_start_dat"
                    value="' . (isset($_SESSION["race_start_dat"]) ? $_SESSION["race_start_dat"] : '') . '"> 
                <span class="help-block"></span> 
                <label>Duljina kmH kmV:</label> 
                <input type="text" placeholder="..." name="race_kmh"
                    value="' . (isset($_SESSION["race_kmh"]) ? $_SESSION["race_kmh"] : '') . '"> 
                <input type="text" placeholder="..." name="race_kmv"
                    value="' . (isset($_SESSION["race_kmv"]) ? $_SESSION["race_kmv"] : '') . '"> 
                <span class="help-block"></span> 
                <label>Startnina:</label> 
                <input type="text" placeholder="..." name="race_ent_fee"
                    value="' . (isset($_SESSION["race_ent_fee"]) ? $_SESSION["race_ent_fee"] : '') . '"> 
                      
                <br/><br/> 
                  
                <label class="checkbox"> 
                    <input type="checkbox" name="race_shirt" 
                    '. ($_SESSION["race_shirt"] == 1 || $_SESSION["race_shirt"] == "D" || $_SESSION["race_shirt"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Majica</span> 
                </label> 
                      
                <label class="checkbox"> 
                    <input type="checkbox" name="race_water" 
                    '. ($_SESSION["race_water"] == 1 || $_SESSION["race_water"] == "D" || $_SESSION["race_water"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Voda</span> 
                </label>  
                                      
                <label class="checkbox"> 
                    <input type="checkbox" name="race_drink" 
                    '. ($_SESSION["race_drink"] == 1 || $_SESSION["race_drink"] == "D" || $_SESSION["race_drink"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Pi&#263;e</span> 
                </label>  
                                                
                <label class="checkbox"> 
                    <input type="checkbox" name="race_eat" 
                    '. ($_SESSION["race_eat"] == 1 || $_SESSION["race_eat"] == "D" || $_SESSION["race_eat"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Hrana</span> 
                </label>  
                                                                 
                <label class="checkbox"> 
                    <input type="checkbox" name="race_rs" 
                    '. ($_SESSION["race_rs"] == 1 || $_SESSION["race_rs"] == "D" || $_SESSION["race_rs"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">GSS</span> 
                </label>                     
                <label class="checkbox"> 
                    <input type="checkbox" name="race_fraid" 
                    '. ($_SESSION["race_fraid"] == 1 || $_SESSION["race_fraid"] == "D" || $_SESSION["race_fraid"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Prva pomo&#263;</span> 
                </label>       
                                                                                 
                <label class="checkbox"> 
                    <input type="checkbox" name="race_chk" 
                    '. ($_SESSION["race_chk"] == 1 || $_SESSION["race_chk"] == "D" || $_SESSION["race_chk"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Checkpoints</span> 
                </label>  
                                                
                <label class="checkbox"> 
                    <input type="checkbox" name="race_meal" 
                    '. ($_SESSION["race_meal"] == 1 || $_SESSION["race_meal"] == "D" || $_SESSION["race_meal"] == "Y" ? " checked " : "") .'
                    ><span class="metro-checkbox">Jelo nakon utrke</span> 
                </label>                
                  
                <br/> 
                  
                <label>Registracije od (YYYY-MM-DD HH:MM:SS) do (YYYY-MM-DD HH:MM:SS):</label> 
                <input type="text" placeholder="..." maxlength="19" name="race_reg_fr_dat"
                    value="' . (isset($_SESSION["race_reg_fr_dat"]) ? $_SESSION["race_reg_fr_dat"] : '') . '"> 
                <input type="text" placeholder="..." maxlength="19" name="race_reg_to_dat"
                    value="' . (isset($_SESSION["race_reg_to_dat"]) ? $_SESSION["race_reg_to_dat"] : '') . '"> 
                  
                  
                <label>Opis:</label> 
                <textarea rows="3" placeholder="Type race description..."  maxlength="300" name="race_desc"
                    value="' . (isset($_SESSION["race_desc"]) ? $_SESSION["race_desc"] : '') . '">' . (isset($_SESSION["race_desc"]) ? $_SESSION["race_desc"] : '') . '</textarea> 
                <span class="help-block"></span> 
                  
                <label>Pravila:</label> 
                <textarea rows="5" type="text" placeholder="Type race rules..."  maxlength="500" name="race_rul" 
                    value="' . (isset($_SESSION["race_rul"]) ? $_SESSION["race_rul"] : '') . '">' . (isset($_SESSION["race_rul"]) ? $_SESSION["race_rul"] : '') . '</textarea> 
                <span class="help-block"></span> 
                  
                <label>Obavezna oprema:</label> 
                <textarea rows="2" type="text" placeholder="Type mandatory equipment..."  maxlength="200" name="race_man_eq"  
                    value="' . (isset($_SESSION["race_man_eq"]) ? $_SESSION["race_man_eq"] : '') . '">' . (isset($_SESSION["race_man_eq"]) ? $_SESSION["race_man_eq"] : '') . '</textarea> 
                <span class="help-block"></span>               
                '; 

        $query2 = "SELECT clu_id, clu_nam   
        FROM club"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
  
        echo '<label>Organizator:</label> 
            <select name="race_club"> 
            <option value="null">Select club...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["race_club"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select>'; 
          
        $query2 = "SELECT lea_id, lea_nam   
            FROM league"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
  
        echo '<label>Liga:</label> 
            <select name="race_league"> 
            <option value="null">Select league...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["race_league"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select>'; 
                  
        $query2 = "SELECT leagr_id, leagr_nam   
            FROM league_group"; 
        $result2 = queryMysql($query2); 
        $num2 = mysqli_num_rows(queryMysql($query2)); 
  
        echo '<label>Liga-grupa:</label> 
            <select name="race_league_group"> 
            <option value="null">Select league group...</option>'; 
        for($i=0;$i<$num2;$i++){   
            $row2 = mysqli_fetch_row($result2); 
            echo '<option value="' . $row2[0] . '" ' . ($row2[0] == $_SESSION["race_league_group"] ? "selected=\"selected\"" : "") . '>' . $row2[1] . '</option>';        
        } 
        echo ' 
        </select>'; 
          
        echo' 
        <span class="help-block"></span> 
        <br/><br/> 
        <button type="submit" class="btn">Spremi</button> 
        </fieldset> 
        </form>'; 
    }  
?>

<script>
function checkForm() {
		alert("check");
    if($("#name").val().trim() == ''){
	
        //$("#errorDiv").html("<font color=red>Upiši ime!</font>");  
			$("#name").closest("div").addClass("error");
		alert("checkForm");
        return false;
    }
    else if(document.getElementById('surname').value.trim() == ''){
        $("#errorDiv").html("<font color=red>Upiši prezime!</font>");   
        return false;
    }
    else if(document.getElementById('god_rodj').value.trim() == '' || 
            document.getElementById('god_rodj').value.trim().length != 4 || 
            document.getElementById('god_rodj').value.trim() <="1900" || 
            document.getElementById('god_rodj').value.trim() >="2000"){
        $("#errorDiv").html("<font color=red>Upiši ispravnu godinu rodenja!</font>");   
        return false;
    }
    else{
//        alert();
//        $.ajax({
//            type: "POST",
//            url: $(this).attr('action'), 
//            success: function(data) {
//                if( data['error'] == false) {
//                    var msg = 'We got your flag. Our moderators will now look into it. You may close the window now!';
//                    $('#spc-comment-flag-response').html(msg);
//                }
//                else {
//                    $('#spc-comment-flag-response').html(data);
//                }   
//            },
//        });
//    
//        $.post("/myapp/rest/customer/created", function(data, status) {
//        if (status === "200") {
//            // redirect to destination
//            return true;
//        } else {
//            //display error information in the current form page
//            $("#errorDiv").html("<font color=red>ID already exists!</font>");
//            return false;
//        }
//        });
    }
}
</script>