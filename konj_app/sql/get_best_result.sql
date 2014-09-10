DROP PROCEDURE IF EXISTS get_best_result;
DELIMITER $
CREATE PROCEDURE get_best_result(race int, sex int)
   BEGIN

/*
declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join league_st_num lsn on 
		rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join league_st_num lpsn on 
			rr.lea_st_num=lpsn.lea_st_num
		inner join person per on lpsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lpsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex);
else
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join race_st_num rsn on 
		rr.rac_st_num=rsn.rac_st_num
	inner join person per on rsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join race_st_num rsn on 
			rr.rac_st_num=rsn.rac_st_num
		inner join person per on rsn.per_id=per.per_id
		where rr.rac_id=race and per.per_sex=sex);
end if;
*/
	select min(rr.res_fin_time) as t, per.per_id, concat(per_nam, ' ', per_sur) as NameSurname
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_sex=sex and 
		rr.res_fin_time=(select min(rr.res_fin_time) as t
		from race_result rr
		inner join race r on rr.rac_id=r.rac_id
		inner join start st on r.st_id=st.st_id
		inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
		inner join person per on sn.per_id=per.per_id
		where rr.rac_id=race 
		and per.per_sex=sex);
END $
DELIMITER ;

/* call get_best_result(1,1);    
 call get_best_result(1,0);    
 call get_best_result(9,1);    
 call get_best_result(11,1);    */

