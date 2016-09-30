<?php
session_start();
include("connect.php");

$loginEmail = $_POST['loginEmail'];
$loginPass = md5($_POST['loginPass']);


$_SESSION['loginEmail1']=$loginEmail;
$_SESSION['loginPass1']=$loginPass;

$check_user = " SELECT * FROM users WHERE email ='$loginEmail' && password_1='$loginPass' ";
$run_user = mysqli_query($connect,$check_user);

if (mysqli_num_rows($run_user)==0)
{
	
	echo "<script> alert('Wrong Login data !')</script>";
	header("Refresh:0.1; url=http://localhost/SocialNetwork/startup.html");
	
}
else if(mysqli_num_rows($run_user)==1)
{

    $getid="SELECT id FROM users WHERE email ='$loginEmail'";
	$result = mysqli_query($connect, $getid);
    $row = mysqli_fetch_assoc($result);
    $id=$row["id"];
    $_SESSION['userid']=$id;
	header("Refresh:0.01; url=http://localhost/SocialNetwork/homePage.php");
}
else
{ //el mafrood my7salsh el klam da
	echo "<script> alert('Error duplicate!<br>')</script>";
}

?>