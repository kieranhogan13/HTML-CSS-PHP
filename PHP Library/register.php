<?php /*register.php*/
include 'core/init.php';
include 'includes/overall/header.php'; 

if(isset($_POST["UserName"]))
{ 
	$UserName = $_POST["UserName"]; 
}

if (empty($_POST) === false)
{
	$required_fields = array('UserName','Password','ConfirmPassword','FirstName','Surname','AddressLine1','AddressLine2','City','Telephone','Mobile');
	foreach($_POST as $key=>$value)
	{
		if (empty($value) && in_array($key, $required_fields) === true) 
		{
			$echo = 'All fields are required';
			break 1;
		}
	}
	
	if(empty($errors) === true)
	{
		$sql = "SELECT * FROM User WHERE UserName = '$UserName'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		if ($count == 1)
		{
			$errors[] = 'Sorry, the UserName \'' . $_POST['UserName'] . '\' is already taken.';
		}
		if (preg_match("/\\s/", $_POST['UserName']) == true)
		{
			$errors[] = 'Your UserName must not contain any spaces';
		}
		
		if (strlen($_POST['Password']) != 6)
		{
			$errors[] = 'Your password must be 6 characters exactly';
		}
		if ($_POST['Password'] != $_POST['ConfirmPassword'])
		{
			$errors[] = 'Your passwords do not match';
		}
	}
}
?>
<h1>Register</h1>
<?php
if (isset($_GET['success']) && empty($_GET['success']))
{
	echo 'Congratulations, you have registered successfully'; 
}
else
{
	if (empty($_POST) === false && empty($errors) === true)
	{
		$register_data = array
		(
			'UserName' => $_POST['UserName'],
			'Password' => $_POST['Password'],
			'FirstName' => $_POST['FirstName'],
			'Surname' => $_POST['Surname'],
			'AddressLine1' => $_POST['AddressLine1'],
			'AddressLine2' => $_POST['AddressLine2'],
			'City' => $_POST['City'],
			'Telephone' => $_POST['Telephone'],
			'Mobile' => $_POST['Mobile']
		);
		register_user($register_data);
		header('Location:register.php?success');
		exit();
	}
	else if (empty($errors) === false)
	{
		echo output_errors($errors);
	}

?>


	<form method="post" action="">
		<ul>
			<li>
				UserName:<br />
				<input type="text" name="UserName" />
			</li>
			<li>
				Password:<br />
				<input type="password" name="Password" />
			</li>
			<li>
				Confirm Password:<br />
				<input type="password" name="ConfirmPassword" />
			</li>
			<li>
				First Name:<br />
				<input type="text" name="FirstName" />
			</li>
			<li>
				Surname:<br />
				<input type="text" name="Surname" />
			</li>
			<li>
				Address Line 1:<br />
				<input type="text" name="AddressLine1" />
			</li>
			<li>
				Address Line 2:<br />
				<input type="text" name="AddressLine2" />
			</li>
			<li>
				City:<br />
				<input type="text" name="City" />
			</li>
			<li>
				Telephone:<br />
				<input type="text" name="Telephone" />
			</li>
			<li>
				Mobile:<br />
				<input type="text" name="Mobile" />
			</li>
			<li>
				<input type="submit" value="Register" /><br />
			</li>
		</ul>
	</form>

<?php
}
 include 'includes/overall/footer.php'; 
 ?>