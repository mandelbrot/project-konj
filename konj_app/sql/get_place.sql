DROP FUNCTION IF EXISTS get_place;
DELIMITER $
CREATE  FUNCTION get_place (race int, person int) 

RETURNS int

BEGIN 

declare place int;
/*declare league int;
declare league_group_sn varchar(1);

select lea_id into league from race where rac_id=race;
select lea_leagr_sn into league_group_sn from race r
inner join league l on r.lea_id=l.lea_id
where rac_id=race;

if(league is null) then
	SELECT count(*)+1 into place
		FROM race_result rr
		where rr.rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join race_st_num rsn 
			on rr.rac_st_num=rsn.rac_st_num and rr.rac_id=rsn.rac_id
		inner join person per on rsn.per_id=per.per_id
		where rr.rac_id=race and per.per_id=person
		);

elseif (lower(league_group_sn = 'n')) then
	SELECT count(*)+1 into place
		FROM race_result rr
		where rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join league_st_num lsn 
			on rr.lea_st_num=lsn.lea_st_num
		inner join person per on lsn.per_id=per.per_id
		where rac_id=race and per.per_id=person 
		);
else 	
	SELECT count(*)+1 into place
		FROM race_result rr
		where rac_id=race and 
		res_fin_time<
		(
		SELECT res_fin_time
		FROM race_result rr 
		inner join league_group_st_num lgsn 
			on rr.leagr_st_num=lgsn.leagr_st_num
		inner join person per on lgsn.per_id=per.per_id
		where rac_id=race and per.per_id=person 
		);
end if;
*/
SELECT count(*)+1 into place
	FROM race_result rr
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
	);
return place;

END$

/*select  get_place(1,1)*/
/*select  get_place(9,1)*/
/*select  get_place(11,5)*/

