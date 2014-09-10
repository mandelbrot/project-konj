DROP FUNCTION IF EXISTS get_rac_avg_res;
DELIMITER $
CREATE  FUNCTION get_rac_avg_res (race int, sex int) 

RETURNS VARCHAR(15)

BEGIN 

declare avg_sek int;
/*declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select avg(res_fin_time_sec)
		into avg_sek
		from race_result rr
		inner join league_st_num lsn on 
			rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex;
else
	select avg(res_fin_time_sec)
		into avg_sek
		from race_result rr
		inner join race_st_num rsn on 
			rr.rac_st_num=rsn.rac_st_num
		inner join person per on rsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id 
		where rr.rac_id=9 and per.per_sex=1;
end if;
*/
select avg(res_fin_time_sec)
	into avg_sek
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_sex=sex;

return concat(floor(avg_sek/3600),":",
		left(concat(floor(avg_sek/60),"00"),2),":",
		left(concat(avg_sek-floor(avg_sek/60)*60,"00"),2));

END$

/*  select  get_rac_avg_res(2,1);    
select  get_rac_avg_res(1,1); 
select  get_rac_avg_res(1,0); 
select  get_rac_avg_res(9,1); 
*/

