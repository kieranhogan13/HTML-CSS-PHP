<?php /*login.php*/
include 'core/init.php';
include 'includes/overall/header.php';

$UserName = $_POST['UserName'];
$Password = $_POST['Password'];

if ($UserName&&$Password)
{

$connect = mysql_connect("localhost","root","") or die ("Couldn't connect");

mysql_select_db("library") or die ("Couldn't find database");

$query = mysql_query ("SELECT * FROM User WHERE UserName='$UserName'");

$numrows = mysql_num_rows($query);

if ($numrows!=0)
{
	while ($row = mysql_fetch_assoc($query))
	{
		$libraryUserName = $row['UserName'];
		$libraryPassword = $row['Password'];
	}
	
	//check to see if they match
	if ($UserName==$libraryUserName&&$Password==$libraryPassword)
	{
		$_SESSION['UserName']=$UserName; //login session
		header('Location: index.php');
		exit();
	}
	else
		echo "Incorrect password!";
		
}
else
	die ("UserName not found. Please register or try different UserName");

}

else
	die ("Please enter a UserName and a Password");

include 'includes/overall/footer.php';
?>


