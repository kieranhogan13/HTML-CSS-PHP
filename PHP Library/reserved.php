<?php /*reserved.php*/
include 'core/init.php';
include 'includes/overall/header.php'; 
$Reserved = 'Y';

if ($Reserved == 'Y')
{
	echo "This book has already been reserved. Please pick a different book";
}
else if ($Reserved == 'N')
{
	echo "This book has been reserved";
	$sqlReserved = "UPDATE Book SET Reserved='Y' WHERE `BookTitle=$";
	$queryR = mysql_query($sqlReserved) or die (mysql_error());
}
else
{
	echo "There has been an error";
}
?>



<?php include 'includes/overall/footer.php'; ?>