<?php /*init.php*/
session_start();

require 'core/database/connect.php';
require 'core/functions/users.php';
require 'core/functions/general.php';

if (logged_in() === true)
{
	$user_data = user_data($_SESSION['UserName'], 'UserName' , 'FirstName', 'Surname');
}
$errors = array();
?>