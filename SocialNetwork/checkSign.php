<?php
session_start();
include("connect.php");

$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$password=$_POST['password'];
$gender=$_POST['gender'];
$date=$_POST['birthdate'];
$hash=md5($password);
//$image="image/default.jpg";
$status=$_POST['status'];
$about=$_POST['about'];
$phone=$_POST['phone'];
$town=$_POST['town'];
$dir = "image/";

if ($gender == 'male') 
{
   if($opendir = opendir($dir))
   {
	   if(($file = readdir($opendir)) !== False)
	   {
		   $file = "image/default_male.jpg";
		   //$putImage = "INSERT INTO `users`(`image` ) VALUES ('$file')";
	   }
   }
   
}
else if ($gender == 'female') 
{
   if($opendir = opendir($dir))
   {
	   if(($file = readdir($opendir)) !== False)
	   {
		   $file = "image/default_female.jpg";
		   //$putImage = "INSERT INTO `users`(`image` ) VALUES ('$file')";
	   }
   }
}

$_SESSION['fname1']=$fname;
$_SESSION['lname1']=$lname;
$_SESSION['email1']=$email;
$_SESSION['pass1']=$hash;
$_SESSION['image1']=$file;

$check_user = " SELECT * FROM users WHERE email ='$email' ";
$run_user = mysqli_query($connect,$check_user);
if (mysqli_num_rows($run_user)>0)
{
	header("Refresh:0.001; url=http://localhost/SocialNetwork/startup.html");
	echo "<script> alert('Email $email already exists!')</script>";
}
else 
{
	echo "<script> alert('Successful Registration!')</script>";
	
}


$sql="INSERT INTO users(fname,lname,email,password_1,phone,gender,image,birthdate,hometown,martial_status,about_me) 
      VALUES('$fname','$lname','$email','$hash','phone','$gender','$file','$date','$town','$status','$about')";

if(mysqli_query($connect,$sql))
{
	$getid="SELECT id FROM users WHERE email ='$email'";
	$result = mysqli_query($connect, $getid);
    $row = mysqli_fetch_assoc($result);
    $id=$row["id"];
    $_SESSION['userid']=$id;
}
else
{
  die ("Error: ".mysqli_error($connect));
}
header("LOCATION: http://localhost/SocialNetwork/homePage.php");
?>