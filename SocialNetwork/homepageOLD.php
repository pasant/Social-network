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
	
	$chars = array("<3", "[peace]", "[umbr]" ,":-D" ,":-)" ,";-)" ,":-P" ,":-*" ,":-@" ,":-(" ,":-S" ,":'-(");
    $icons = array("&#10084;", "&#9774;", "&#9730;" ,"&#128512" ,"&#128522" ,"&#128521" ,"&#128540" ,"&#128536" ,"&#128544" ,"&#128553" ,"&#128533" ,"&#128546");
 
	$posted_time = date("y-m-d");
	$getname="SELECT fname FROM users WHERE id ='$id'";
	$result = mysqli_query($connect, $getname);
    $row = mysqli_fetch_assoc($result);
    $poster_name=$row["fname"];
	
	$post_em = str_replace($chars,$icons,$post);
    

$sql="INSERT INTO `posts`(`user_id` ,`caption`, `posted_time`, `poster_name`, `isPublic`) 
VALUES ('$id','$post_em','$posted_time','$poster_name','$privacy')";

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
    <input type = "submit" name = "submit1" value = "post image" style="background-color: #008080; padding: 5px; width:100px; margin-left: 10px; margin-top: 0px; margin-right: 5px; float: right; border: 1px solid #666;" />
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
	if(!$result)
	{
		echo "<script> alert('Error uploading image!')</script>";
	}

	}
}

?>

<div class="profilePosts">
	<?php
	/*$sql1="SELECT * FROM friends inner join users on id=friend_id 
	inner join posts on posts.user_id=friend_id WHERE friends.user_id ='$id' 
	ORDER BY posted_time asc";*/
	
	$sql1="SELECT * FROM posts ,users ,friends 
	WHERE users.id = friends.friend_id
	AND posts.user_id = friends.friend_id
	AND friends.user_id ='$id'
	AND posts.isPublic = 'friend'
	OR(posts.user_id = '$id' AND users.id = '$id' AND friends.user_id = '$id')
	OR(posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id AND posts.isPublic != 'friend'
	AND posts.user_id NOT IN 
	(SELECT friends.user_id FROM friends join posts ON friends.user_id = posts.user_id WHERE posts.isPublic = 'friend'))
	ORDER BY posts.id DESC";
	

	/*$sql1="SELECT * FROM posts ,users ,friends 
    WHERE posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id OR( posts.isPublic = 'friend' 
	AND posts.user_id IN (SELECT posts.user_id FROM posts, friends WHERE posts.isPublic = 'friend' 
	AND friends.user_id = '$id' AND friends.friend_id = posts.user_id))
	ORDER BY posts.id DESC";*/

	
	/*$sql1="SELECT * FROM posts ,users ,friends 
	WHERE posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id AND posts.isPublic != 'friend'
	AND posts.user_id NOT IN (SELECT friends.user_id FROM friends join posts ON friends.user_id = posts.user_id WHERE posts.isPublic = 'friend')
	ORDER BY posts.id DESC";*/
	
	/*$sql1="SELECT * FROM posts ,users ,friends 
	WHERE posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id
	OR(users.id = friends.friend_id
	AND posts.user_id = friends.friend_id
	AND friends.user_id ='$id'
	AND friends.friend_id != posts.user_id)	ORDER BY posts.id DESC";*/
	
	/*$sql1="SELECT * FROM posts ,users ,friends 
	WHERE posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id ORDER BY posts.id DESC";*/
	
	/*$sql1="SELECT * FROM posts ,users ,friends 
	WHERE posts.isPublic = 'friend'
	OR(posts.user_id = '$id' AND users.id = '$id' AND friends.user_id = '$id' AND posts.user_id = users.id)
	OR(posts.user_id = users.id AND posts.isPublic = 'public' AND posts.user_id = friends.user_id)
	ORDER BY posts.id DESC";*/

	
	
	
	$getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
	
	//$sql2="SELECT * FROM posts,friends inner join users on posts.user_id=users.id WHERE user_id='$id' ORDER BY posts.id DESC";
	//$getposts2 = mysqli_query($connect,$sql2) or die(mysqli_error($connect));

	   
    while($record = mysqli_fetch_array($getposts))
	{
        $username=$record["fname"];
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
	
	/*while($record2 = mysqli_fetch_array($getposts2))
	{
        $username=$record2["fname"];
		$id = $record2['id'];
    	$caption = $record2['caption'];
    	$posted_time = $record2['posted_time'];
    	$privacy = $record2['isPublic'];
		$image = $record2['postimage'];
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
    
	}*/
	

    
    ?>
</div>

</div>

<img src="<?php echo "$profile" ; ?>" alt= "problem loading image!" style = "height:50px; width:50px;" >

<div class="textHeader"><?php echo "Welcome $userfname! "; ?>

</div>