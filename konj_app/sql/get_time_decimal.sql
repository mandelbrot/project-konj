DROP FUNCTION IF EXISTS get_time_decimal;
DELIMITER $
CREATE  FUNCTION get_time_decimal (score varchar(10)) 

RETURNS float

BEGIN 

declare time_dec float;

select substring_index(score,':',1) + 
substring_index(substring_index(score,':',-2),':',1)/60 + 
substring_index(substring_index(score,':',-1),':',1)/3600
into time_dec;

return time_dec;

END$

/*select  get_time_decimal('4:56:23')*/