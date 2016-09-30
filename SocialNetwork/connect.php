<?php
$servername="localhost";
$sqluser="root";
$sqlpass="";
$db="friendzonia";
$connect =mysqli_connect($servername,$sqluser,$sqlpass);
if(!$connect)
{
die("Connection Failed.<br>".mysqli_error());
}

$select=mysqli_select_db($connect,$db);
if(!$select)
{
	die("Couldn't select db.<br>".mysqli_error($connect));
}

?>