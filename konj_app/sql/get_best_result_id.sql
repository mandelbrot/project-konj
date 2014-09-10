DROP FUNCTION IF EXISTS get_best_result_id;
DELIMITER $
CREATE  FUNCTION get_best_result_id (race int, sex int) 

RETURNS int

BEGIN 

declare rr_id int;

select rr.res_id
into rr_id
from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
where r.rac_id=race  and per.per_sex=sex and 
	rr.res_fin_time=(select min(rr.res_fin_time) as t 
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race 
	and per.per_sex=sex);

return rr_id;

END$

/*  select  get_best_result_id(1,0);    
  select  get_best_result_id(1,1);    
  select  get_best_result_id(9,1);    
  select  get_best_result_id(11,1);    */

