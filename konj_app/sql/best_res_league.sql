DROP FUNCTION IF EXISTS best_res_league;
DELIMITER $
CREATE  FUNCTION best_res_league (league int, sex int, u_sekundama bool) 

RETURNS varchar(15)

BEGIN 

declare per_min_res varchar(15);
/*
select min(res_fin_time_sec) into per_min_res
	from race_result rr
	inner join league_st_num lsn on 
		rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id
	inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
	where per.per_sex=sex and lsn.lea_id=league;
*/
if u_sekundama then 
select CAST(min(res_fin_time_sec) as char) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_sex=sex 
	and r.lea_id=league;
else
select min(res_fin_time) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_sex=sex 
	and r.lea_id=league;
end if;	

return per_min_res;

END$

/*  select  best_res_league(1,1,true)    */

