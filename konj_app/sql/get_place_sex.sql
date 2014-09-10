DROP FUNCTION IF EXISTS get_place_sex;
DELIMITER $
CREATE  FUNCTION get_place_sex (race int, person int, sex int) 

RETURNS int

BEGIN 

declare place int;
/*declare league int;

select lea_id into league from race where rac_id=race;

if(league is not null) then
	SELECT count(*)+1 into place
	FROM race_result rr 
	inner join league_st_num lsn on rr.lea_st_num=lsn.lea_st_num
	inner join person per on lsn.per_id=per.per_id 
	where rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	left outer join league_st_num lsn 
		on rr.lea_st_num=lsn.lea_st_num
	left outer join person per on lsn.per_id=per.per_id
	where rac_id=race and per.per_id=person and lsn.lea_id=league
	)
	and per.per_sex=sex and lsn.lea_id=league;
else
	SELECT count(*)+1 into place
	FROM race_result rr
	inner join race_st_num rsn 
		on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
	inner join person per on rsn.per_id=per.per_id 
	where rr.rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	inner join race_st_num rsn 
		on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
	inner join person per on rsn.per_id=per.per_id
	where rr.rac_id=race and per.per_id=person
	)
	and per.per_sex=sex;
end if;
*/
	SELECT count(*)+1 into place
	FROM race_result rr
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and 
	res_fin_time<
	(
	SELECT res_fin_time
	FROM race_result rr 
	inner join race r on rr.rac_id=r.rac_id
	inner join start st on r.st_id=st.st_id
	inner join st_num sn on rr.sn_id=sn.sn_id and st.st_id=sn.st_id
	inner join person per on sn.per_id=per.per_id
	where rr.rac_id=race and per.per_id=person
	)
	and per.per_sex=sex;

return place;

END$

/*select  get_place_sex(9,3,1);
select  get_place_sex(1,2,1);
select  get_place_sex(1,2,0);
select  get_place_sex(9,5,0);*/