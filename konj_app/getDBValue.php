<?php 
include 'functions.php';

$action = isset($_POST['race_st_num']) ? $_POST['race_st_num'] : "";
$type = isset($_POST['type']) ? $_POST['type'] : "";
$id = isset($_POST['race']) ? $_POST['race'] : "";

$error = "0";
if($type == "check_race_st_id" && $action != "" && ($action != "null" && $id != "new") && ($id != "" || $id != "new"))
{
	//ako je startni broj id isti ko i u utrci onda vraaa false (false = nema errora)
	//ako je startni broj id isti razlieit ko i u utrci onda gleda da li ima spremljenih rezultata
	//s tim id. ako ima onda true
    $query = "SELECT case when (select st_id from race where rac_id = " . $id . ") = " . $action . " 
		then false 
		else 
		(
			case when (SELECT count(*) from race_result rr
				inner join race r on rr.rac_id = r.rac_id
				where r.st_id = " . $action . ") > 0 
			then true
			else (
				case when (SELECT count(*) from race_result rr
					inner join race r on rr.rac_id = r.rac_id
					where r.st_id = (select st_id from race where rac_id = " . $id . ")) > 0 
				then true
				else false end
			) 
            end
		) 
		end as aa";
	//echo $query;
    $result = queryMysql($query);
    $num = mysqli_num_rows(queryMysql($query));
    if($num > 0)
    {
	   $row = mysqli_fetch_row($result);
       $error = $row[0];
    }
    else
	   $error = "0";
       
	echo $error;
}
else
{
    echo $error;    
}

?>