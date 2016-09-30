<?php 

include("header_searchbox.php");
include("footer.php");
include("connect.php"); 
 
   $id_profile =$_GET['profile_id'];
   $id=$_SESSION['uid'];
    $_SESSION['uid']=$id;

  $sql1="SELECT * FROM friends WHERE user_id ='$id_profile' and friend_id ='$id' "; 
  $friend = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
    

    if($id== $id_profile)
    {
      header("Refresh:0.0; url=http://localhost/SocialNetwork/profile.php");
    }
    $_SESSION['uid']=$id;
    $getname="SELECT * FROM users WHERE id ='$id_profile'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $userfname=$row["fname"];
	$profile=$row["image"];
   
if (isset($_POST['add'])) 
{ 
  
$sql="INSERT INTO `friend_requests`(`user_from`, `user_to`) VALUES ('$id','$id_profile')";


  if(!mysqli_query($connect,$sql))
    {
      echo " a33333333";
      die ("Error Adding Post: ".mysqli_error($connect));
    }
}



?>


<div id="wrapper" >
<div class="profilePosts">
	<?php
 if(mysqli_num_rows($friend)!=0)// we are friends
	{
   $sql1="SELECT * FROM posts WHERE user_id='$id_profile' ORDER BY id DESC LIMIT 10";
 }
 else // not friend
  {
   $sql1="SELECT * FROM posts WHERE user_id='$id_profile' and isPublic='public' ORDER BY id DESC LIMIT 10";
  }
  $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
while($record = mysqli_fetch_array($getposts))
	{
		$id = $record['id'];
    	$caption = $record['caption'];
    	$posted_time = $record['posted_time'];
    	$privacy = $record['isPublic'];
		$image = $record['postimage'];
		if($caption != '')
		{
			 echo" <div class='posted_by'><a href='$userfname'>$userfname</a> - $posted_time - </div>&nbsp;&nbsp;&nbsp;&nbsp;
            $caption<br /><br />";
		}
		else if($image != '')
		{
			echo" <div class='posted_by'><a href='$userfname'>$userfname</a> - $posted_time - </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <img src = '$image' height = 250px width = 250px> <br /><br />";
		}
    
	}
    
    ?>

</div>

<img src="<?php echo "$profile" ; ?>" alt= "problem loading image!" style = "height:220px; width:180px;"  >
<br/>
<?php if(mysqli_num_rows($friend)==0)
{?>
<form method="POST" action=''>
	<input type="submit" name="add" id="add"   value="add as friend" />
   </form>
<?php } ?>
<div class="textHeader"><?php echo "$userfname "; ?>Profile</div>

</div>
<div class="profileLeftSideContent">
<?php 
 echo 'Name: ';echo $row["fname"] ; echo ' '; echo $row["lname"] ;
 ?>
<br/>
<?php
echo 'Email:';echo $row["email"];
?>
<br/>
<?php
echo 'Hometown: ';echo $row["hometown"];
?>
<br/>
<?php
echo 'Gender: ';echo $row["gender"];
?>
<br/>
<?php
echo 'Phone: ';echo $row["phone"];
?>
<br/>

<?php
echo 'Marital status: ';echo $row["martial_status"];
?>
<br/>
<?php
if(mysqli_num_rows($friend)!=0)
{
echo 'Birthdate: ';echo $row["birthdate"];
?>
<br/>
<?php
echo 'adout: '; echo $row["about_me"];
}





?>
</div>
<!--<div class="textHeader"><?php echo "$userfname"; ?>Friends</div>
<div class="profileLeftSideContent">
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;
<img src="#" height="50" width="50" />&nbsp;&nbsp;-->