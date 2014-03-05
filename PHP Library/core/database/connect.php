<?php /*connect.php*/
$connect_error = 'Sorry were experiencing connection issues.';
mysql_connect('localhost','root','') or die($connect_error);
mysql_select_db('library') or die($connect_error);

?>