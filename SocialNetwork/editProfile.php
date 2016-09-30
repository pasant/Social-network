<?php 
include("header_searchbox.php") ;
include("connect.php") ;

$id=$_SESSION['uid'];
$_SESSION['uid']=$id;
if(isset($_SESSION['userfname_S']))
{
   $username=$_SESSION['userfname_S'];
}
else
{
	$username= @$_SESSION['userfname_L'];
}



  $senddata = @$_POST['senddata'];
  $updateinfo = @$_POST['updateinfo'];
  
//Handle Password Edit
  if ($senddata) 
 {
	 
	$old_passwordb = $_POST['oldpassword'];
  	$new_passwordb = $_POST['newpassword'];
  	$repeat_passwordb = $_POST['newpassword2'];
	 
  	$old_password = md5($_POST['oldpassword']);
  	$new_password = md5($_POST['newpassword']);
  	$repeat_password = md5($_POST['newpassword2']);
	
	
	if($old_passwordb == '' || $new_passwordb == '' || $repeat_passwordb == '' 
	|| $old_passwordb == null || $new_passwordb == null || $repeat_passwordb == null)
	{
		echo '<script> alert("Enter old and new password!!"); </script>';
	
	}
	else
	{
		//$password_query = mysqli_query($connect," SELECT * FROM users WHERE id='$id' ");
	$check_pass = " SELECT * FROM users WHERE password_1='$old_password' ";
$run_pass = mysqli_query($connect,$check_pass);

if (mysqli_num_rows($run_pass)==0)
{
	
	echo '<script> alert("Old password is incorrect!"); </script>';
	header("Refresh:0.1; url=http://localhost/SocialNetwork/editProfile.php");
	
}
else if(mysqli_num_rows($run_pass)==1)
{
	//$db_password = $row['password_1'];
    //$old_password_md5 = md5($old_password);

         	if ($new_password == $repeat_password) 
         	{
          	  //$new_password_md5 = md5($new_password);
            	$password_update_query = mysqli_query($connect,"UPDATE users SET password_1='$new_password' WHERE id ='$id'");
				if($password_update_query)
				{
            	echo '<script> alert("Password updated successfully!"); </script>';
				}
				else
				{
					echo '<script> alert("unsuccessful update!"); </script>';
				}
            }
         	else
       		{
       		    echo '<script> alert("Check new password entered!"); </script>';
       	    }
    
 }
		
	}
	
 }
 //Handle info edit
 else if($updateinfo)
 {
 	$firstname = $_POST['fnameedit'];
   	$lastname = $_POST['lnameedit'];
   	$about = $_POST['aboutedit'];
	$id=$_SESSION['uid'];

 	//$get_info = mysqli_query($connect,"SELECT fname, lname, about FROM users WHERE id='$id'");
  	//$get_row = mysqli_fetch_assoc($get_info);
  	//$db_firstname = $get_row['first_name'];
  	//$db_last_name = $get_row['last_name'];
  	//$db_bio = $get_row['about'];
	
	if($firstname != '')
	{
			$info_query = mysqli_query($connect,"UPDATE users SET fname='$firstname' WHERE id='$id'");
	}
	
	if($lastname != '')
	{
			$info_query = mysqli_query($connect,"UPDATE users SET lname='$lastname' WHERE id='$id'");
	}
	
	if($about != '')
	{
			$info_query = mysqli_query($connect,"UPDATE users SET about_me='$about' WHERE id='$id'");
	}

   	//$info_query = mysqli_query($connect,"UPDATE users SET fname='$firstname', lname='$lastname', about_me='$about' WHERE id='$id'");
    echo "<script>alert('Your profile info has been updated!')</script>";
 }
 

?>

<h2>Edit your Account Settings below</h2>
<hr />
<div class="editData">


<form method = "post" enctype = "multipart/form-data"/>
<br/>
<input type = "file" name = "image"/>
<br/> <br/>
<input type = "submit" name = "sumit" value = "Upload" />
<input type="submit" name="remove" id="remove" value="Remove Profile Picture">
</form>

<?php 

if(strpos($_SERVER['HTTP_USER_AGENT'],'Mediapartners-Google') !== false) {
        exit();
    }

include("connect.php") ;

$id=$_SESSION['uid'];
$posted_time = date("y-m-d");
	
	$getname="SELECT fname FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $poster_name=$row["fname"];
	$isPublic = "friend";
	$post = "$poster_name updated profile picture!";
	$removepost = "$poster_name removed profile picture!";

if(isset ($_POST['sumit'])){
	
	if(getimagesize($_FILES['image']['tmp_name']) == FALSE)
	{
		echo '<script> alert("please select an image!") </script>';
	}
	else
	{
		
		$filetmp = $_FILES["image"]["tmp_name"];
		$filename = $_FILES["image"]["name"];
		$filetype = $_FILES["image"]["type"];
		$filepath = "image/".$filename;
		move_uploaded_file($filetmp,$filepath);
		
	$qry= "UPDATE users SET image='image/$filename' WHERE  id ='$id'";
	$result= mysqli_query($connect,$qry);
	if($result)
	{
		echo '<script> alert("Image Uploaded!") </script>';
	}
	else
	{
		echo  '<script> alert("Image not Uploaded!") </script>';
	}
	$sql="INSERT INTO posts(user_id,caption,posted_time,poster_name,isPublic) 
      VALUES('$id','$post','$posted_time','$poster_name','$isPublic' )";

    $result1= mysqli_query($connect,$sql);

	if(!$result1)
		{
			die ("Error Adding Post: ".mysqli_error($connect));
		}

	}
}

if(isset($_POST['remove']))
{
	$getgender="SELECT gender FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getgender);
    $row = mysqli_fetch_assoc($result);
    $gender=$row["gender"];
	if($gender == 'male')
	{
		$qry= "UPDATE users SET image='image/default_male.jpg' WHERE  id ='$id'";
	$result= mysqli_query($connect,$qry);
	if($result)
	{
		echo '<script> alert("profile picture removed!") </script>';
	}
	else
	{
		echo '<script> alert("error removing profile picture!") </script>';
	}
	}
	if($gender == 'female')
	{
		$qry= "UPDATE users SET image='image/default_female.jpg' WHERE  id ='$id'";
	$result= mysqli_query($connect,$qry);
	if($result)
	{
		echo '<script> alert("profile picture removed!") </script>';
	}
	else
	{
		echo '<script> alert("error removing profile picture!") </script>';
	}
	}
	$sql="INSERT INTO posts(user_id,caption,posted_time,poster_name,isPublic) 
      VALUES('$id','$removepost','$posted_time','$poster_name','$isPublic' )";

    $result2 = mysqli_query($connect,$sql);

	if(!$result2)
		{
			die ("Error Adding Post: ".mysqli_error($connect));
		}
	
}

?>
<hr />
<form action="editProfile.php" method="post">
<p>CHANGE YOUR PASSWORD:</p> <br />
<label for="oldpassword">Old Password:</label>
<input type="password" name="oldpassword" id="oldpassword" placeholder="Old Password" size="40"><br />

<label for="newpassword">New Password:</label>
<input type="password" name="newpassword" id="newpassword" placeholder="New Password" size="40"><br />

<label for="newpassword2">Re-type New Password:</label>
<input type="password" name="newpassword2" id="newpassword2" placeholder="Re-type New Password" size="40"><br />
<input type="submit" name="senddata" id="senddata" value="Update Information">
</form>
<hr />

<form action="editProfile.php" method="post">
<p>UPDATE YOUR PROFILE INFO:</p> <br />
<label for="fname">First Name</label>
<input type="text" name="fnameedit" id="fname" size="40" placeholder="First Name"><br />

<label for="lname">Last Name</label>
<input type="text" name="lnameedit" id="lname" size="40" placeholder="Last Name"><br />

<label for="about">About</label>
<input type="text" name="aboutedit" id="about" size="300" placeholder="About you !" /><br /><br>
<!--<textarea name="about" id="about" rows="7" cols="40" /textarea>-->
<input type="submit" name="updateinfo" id="updateinfo" value="Update Information">

</form>

<hr />




<br />
<br />
</div>