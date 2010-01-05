<?

while (list($key,$value) = each($_POST))
{
	${$key} = $value;
}


if ($_action == '1') {


$sql = " UPDATE ext_users SET 
	username = '{$_username}', 
	param_1 = '{$_param_1}', 
	process_hour_interval = '{$_process_hour_interval}', 
	process_date_last = '{$_process_date_last}', 
	process_date_next = '{$_process_date_next}', 
	status = '{$_status}' 
	WHERE 1
	AND user_id = '{$_user_id}'
	AND ext_id = '{$_ext_id}';";
  
	
} else {
  	
  $sql = " INSERT INTO ext_users SET 
	user_id = '{$_user_id}',
	ext_id = '{$_ext_id}', 
	username = '{$_username}', 
	param_1 = '{$_param_1}', 
	process_hour_interval = '{$_process_hour_interval}', 
	process_date_last = '{$_process_date_last}', 
	process_date_next = '{$_process_date_next}', 
	status = '{$_status}' 

;";	
  	
  	
  }


DB::query($sql , false);


header("Location: /?a=exts.users&ext_id={$_ext_id}");
?>