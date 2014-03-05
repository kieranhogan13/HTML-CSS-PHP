<aside>
	<?php /*aside*/
	if (logged_in() === true)
	{
		include 'includes/widgets/logged_in.php'; 
	}
	else
	{
		include 'includes/widgets/login.php'; 
	}
	?>
</aside>