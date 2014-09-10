DROP FUNCTION IF EXISTS PB_league;
DELIMITER $
CREATE  FUNCTION PB_league (league int, per int) 

RETURNS varchar(15)

BEGIN 

declare per_min_res varchar(15);

select min(res_fin_time) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and r.lea_id=league;

return per_min_res;

END$

/*  
select  PB_league(1,1);    
select  PB_league(1,2); 
select  PB_league(1,3); 
select  PB_league(1,4);  
select  PB_league(1,5);
*/

