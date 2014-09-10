DROP FUNCTION IF EXISTS PB;
DELIMITER $
CREATE FUNCTION PB (league int, race int, per int) 

RETURNS int

BEGIN 

declare rac_dat datetime;
declare rac_per_res int;
declare per_min_res int;
/*into per_id*/

select r.date into rac_dat from race r where r.rac_id=race;

select rr.res_fin_time_sec into rac_per_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and rr.rac_id=race /*and r.lea_id=league*/;

select min(res_fin_time_sec) into per_min_res
	from race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where per.per_id=per and r.rac_id<>race /*and l.lea_id=league*/
		and r.date<rac_dat;

if(per_min_res is null) then return 1;
else return (select rac_per_res<per_min_res);
end if;

END$

/*  
select  PB(1,1,1);    
select  PB(1,1,2);    
select  PB(1,1,3);      
select  PB(1,1,4);      
select  PB(1,1,5);  
select  PB(1,2,1);    
select  PB(1,2,2);    
select  PB(1,2,3);  

*/

