<?php /*users.php*/

function array_sanitize(&$item)
{
	$item = mysql_real_escape_string($item);	
}

function register_user($register_data)
{
	array_walk($register_data, 'array_sanitize');

	$fields = '`' . implode('`, `', array_keys($register_data)) .'`';
	$data = '\'' . implode('\', \'', $register_data) .'\'';

	mysql_query("INSERT INTO `User` ($fields) VALUES ($data)");
}

function user_data($UserName)
{
	$data = array();
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1)
	{
		unset($func_get_args[0]);
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		
	}
}

function logged_in ()
{
	return (isset($_SESSION['UserName'])) ? true : false;
} 

function user_exists($UserName)
{
	$UserName = sanitize($UserName);
	return (mysql_result(mysql_query("SELECT * FROM 'User' WHERE 'UserName' = '$UserName' "), 0) == 1) ? true : false;
}

?>