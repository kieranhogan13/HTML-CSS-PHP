<?php /*library.php*/
include 'core/init.php';
include 'includes/overall/header.php'; 
$search_output = "";
$pagenum = "";
$last = "";
$max = "";
$rows = "";
?>

<h1>Library</h1>
<p>Search the database</p>

<form method="post" action="library.php">
<input name="searchquery" type="text">
<input name="search" type="submit" value="Search">
<select name="filter">
<option value="Book">Book</option>
<option value="Author">Author</option>
<option value="CategoryID">CategoryID</option>
</select>
</form>
<br />
<hr />
<br />
<h2>Results: </h2>
<?php
if(isset($_POST['searchquery']) && ($_POST['searchquery']) != "")
{
	$searchquery = $_POST['searchquery'];
	if($_POST['filter'] == "Book")
	{
		$sqlCommand = "SELECT * FROM `Book` WHERE `BookTitle` LIKE '%".$searchquery."%' $max";
	}
	else if($_POST['filter'] == "Author")
	{
		$sqlCommand = "SELECT * FROM `Book` WHERE `Author` LIKE '%".$searchquery."%' $max";
	}
	else if($_POST['filter'] == "CategoryID")
	{
		$sqlCommand = "SELECT * FROM `Book` WHERE `CategoryID` LIKE '%".$searchquery."%' $max";
	}
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$count = mysql_num_rows($query);
	$page_rows = 4;
	$last = ceil($rows/$page_rows);
	if ($pagenum < 1) 
	{ 
		$pagenum = 1; 
	} 
	elseif ($pagenum > $last) 
	{ 
	$pagenum = $last; 
	} 
	$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 
	if($count >= 1)
	{
		$search_output .= "<hr />$count results for <strong>$searchquery</strong>";
		while($row = mysql_fetch_assoc($query))
		{
			$ISBN = $row['ISBN'];
			$BookTitle = $row['BookTitle'];
			$Author	= $row['Author'];
			$Edition = $row['Edition'];
			$Year = $row['Year'];
			$CategoryID = $row['CategoryID'];
			$Reserved = $row['Reserved'];
			
			echo "Title: $BookTitle <br />Author: $Author <br />Edition: $Edition <br />$Year <br />ISBN: $ISBN <br />$CategoryID <br /><a href=reserved.php>Reserved(Y/N): $Reserved</a><br /><br />";
		}
	}
	else
	{
		$search_output = "<hr />0 results for <strong>$searchquery</strong>";
	}
}
echo $search_output;

if (!(isset($pagenum))) 
	{ 
		$pagenum = 1; 
	} 
echo " --Page $pagenum of $last-- <p>";
if ($pagenum == 1) 

 {
 } 

else 
{
	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a> ";
	echo " ";
	$previous = $pagenum-1;
	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous</a> ";
} 

echo " ---- ";

if ($pagenum == $last) 
{
} 

else 
{
	$next = $pagenum+1;

	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
	echo " ";
	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last ->></a> ";
 } 
?> 

<hr />
<br />
<h2>Reservations: </h2> 
<?php
	$sqlReserved = "SELECT * FROM `Book` WHERE `Reserved` LIKE 'Y'";
	$queryR = mysql_query($sqlReserved) or die (mysql_error());
	$countR = mysql_num_rows($queryR);
	if($countR >= 1)
	{
		while($row = mysql_fetch_assoc($queryR))
		{
			$ISBN = $row['ISBN'];
			$BookTitle = $row['BookTitle'];
			$Author	= $row['Author'];
			$Edition = $row['Edition'];
			$Year = $row['Year'];
			$CategoryID = $row['CategoryID'];
			$Reserved = $row['Reserved'];
			
			echo "Title: $BookTitle <br />Author: $Author <br />Edition: $Edition <br />$Year <br />ISBN: $ISBN <br />$CategoryID <br />Reserved: $Reserved <br /><br />";
		}
	}
	
?>

<div>
</div>
<?php include 'includes/overall/footer.php'; ?>