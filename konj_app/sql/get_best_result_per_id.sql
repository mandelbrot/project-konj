DROP FUNCTION IF EXISTS get_best_result_per_id;
DELIMITER $
CREATE  FUNCTION get_best_result_per_id (race int, sex int) 

RETURNS int

BEGIN 

declare per_id int;/*
declare league int;
select lea_id into league from race where rac_id=race;

if(league is not null) then
	select per.per_id
		into per_id
		from race_result rr
		inner join league_st_num lsn on 
			rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
		where rr.rac_id=race and per.per_sex=sex and 
			rr.res_fin_time=(select min(rr.res_fin_time) as t
			from race_result rr
			inner join league_st_num lsn on 
				rr.lea_st_num=lsn.lea_st_num
			inner join person per on lsn.per_id=per.per_id
			inner join race r on rr.rac_id=r.rac_id and lsn.lea_id=r.lea_id
			where rr.rac_id=race and per.per_sex=sex);
else
	select per.per_id
		into per_id
		from race_result rr
		inner join race_st_num rsn
			on rr.rac_st_num=rsn.rac_st_num 
			and rr.rac_id=rsn.rac_id
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
	select per.per_id
	into per_id
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
			where rr.rac_id=race and per.per_sex=sex);

return per_id;

END$

/*  select  get_best_result_per_id(2,1);   
  select  get_best_result_per_id(9,1);    
  select  get_best_result_per_id(1,0);
  select  get_best_result_per_id(2,0);     */

