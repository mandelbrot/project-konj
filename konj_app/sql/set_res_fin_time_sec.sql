DROP FUNCTION IF EXISTS set_res_fin_time_sec;
DELIMITER $
CREATE  FUNCTION set_res_fin_time_sec () 

RETURNS int

BEGIN 

update race_result set 
	res_fin_time_sec=substring_index(res_fin_time,':',1)*3600+
	substring_index(substring_index(res_fin_time,':',-2),':',1)*60+
	substring_index(substring_index(res_fin_time,':',-1),':',1);

return 1;

END$

/*  select  set_res_fin_time_sec()    */

