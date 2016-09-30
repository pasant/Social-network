<?php 

include("header_searchbox.php");
include("footer.php");
include("connect.php"); 


$_SESSION['uid']=@$_SESSION['userid'];
$id=$_SESSION['uid'];
	$getname="SELECT * FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $userfname=$row["fname"];
    $profile=$row["image"];
    
    if (isset($_POST['send'])) 
{ 


$post = $_POST['post'];
$privacy=$_POST['privacy'];
//there is post
if($post != "")
{

	$posted_time = date("y-m-d");
	$getname="SELECT fname FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $poster_name=$row["fname"];
    

$sql="INSERT INTO `posts`(`user_id` ,`caption`, `posted_time`, `poster_name`, `isPublic`) 
VALUES ('$id','$post','$posted_time','$poster_name','$privacy')";

$resul = mysqli_query($connect,$sql);
	if(!$resul)
		{
			//echo " $post 3";
			die ("Error Adding Post: ".mysqli_error($connect));
		}
}
else
{
	
	echo "<script> alert('You must enter something in post field before you can send it')</script>";
}



} 
?>


<div id="wrapper" >

<div class="postForm">
<form method="POST" action='' >
	<textarea id="post" name="post" rows="5" cols="76"></textarea>
	<input type="submit" name="send" value="post"   style="background-color: #008080; padding: 5px; width:100px; margin-left: 10px; margin-top: 0px; margin-right: 5px; float: right; border: 1px solid #666;"/>
    <select  type="text" name="privacy" id="privacy" style="background-color: #008080; padding: 5px; width:100px; margin-left: 10px; margin-top: -45px; margin-right: 5px; float: right; border: 1px solid #666;">
                      <option value="public">public</option>
                      <option value="private">private</option>
                     </select>
   </form>
   <form method = "post" enctype = "multipart/form-data"/>
    <input type = "file" name = "image"/>
    <input type = "submit" name = "submit1" value = "Upload" style="background-color: #008080; padding: 5px; width:100px; margin-left: 10px; margin-top: 0px; margin-right: 5px; float: right; border: 1px solid #666;" />
    </form>
</div>



	
<?php
include( "connect.php" );
$id=$_SESSION['uid'];
	if(isset ($_POST['submit1'])){

	//$posted_time = date("d-m-Y");
	$posted_time = date("y-m-d");
	$getname="SELECT fname FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $poster_name=$row["fname"];
	$isPublic = "friend";
	
	if(getimagesize($_FILES['image']['tmp_name']) == FALSE)
	{
		echo "please select an image!";
	}
	else
	{
		
		$filetmp = $_FILES["image"]["tmp_name"];
		$filename = $_FILES["image"]["name"];
		$filetype = $_FILES["image"]["type"];
		$filepath = "image/".$filename;
		move_uploaded_file($filetmp,$filepath);
		
	$qry= "INSERT INTO posts(user_id,postimage,posted_time,poster_name,isPublic) 
      VALUES('$id','image/$filename','$posted_time','$poster_name','$isPublic' )";
	$result= mysqli_query($connect,$qry);
	if($result)
	{
		echo "<br/> Image Uploaded!";
	}
	else
	{
		echo "<br/> Image not Uploaded!";
	}

	}
}

?>



<div class="profilePosts">
	<?php

	 $sql1="SELECT * FROM posts inner join users on posts.user_id=users.id WHERE user_id='$id' ORDER BY posts.id DESC LIMIT 10";
	$getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));

	   
    while($record = mysqli_fetch_array($getposts))
	{
        $username=$record['fname'];
		$id = $record['id'];
    	$caption = $record['caption'];
    	$posted_time = $record['posted_time'];
    	$privacy = $record['isPublic'];
		$image = $record['postimage'];
		if($caption != '')
		{
			 echo" <div class='posted_by'><a href='$username'>$username</a> - $posted_time - </div>&nbsp;&nbsp;&nbsp;&nbsp;
            $caption<br /><br />";
		}
		else if($image != '')
		{
			echo" <div class='posted_by'><a href='$username'>$username</a> - $posted_time - </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <img src = '$image' height = 250px width = 250px> <br /><br />";
		}
    
	}
    
    ?>
</div>

<img src="<?php echo "$profile" ; ?>" alt= "problem loading image!" style = "height:220px; width:180px;" >
<br/>
<div class="textHeader"><?php echo "$userfname "; ?>Profile</div>

</div>
<div class="profileLeftSideContent">Some user's content</div>
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