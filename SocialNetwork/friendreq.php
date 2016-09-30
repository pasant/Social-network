<?php

include("header_searchbox.php");
include("footer.php");
include("connect.php"); 
 $id=$_SESSION['uid'];
 $_SESSION['uid']=$id;
   $sql1="SELECT users.id , users.fname ,friend_requests.state FROM users inner join friend_requests on users.id=friend_requests.user_from WHERE friend_requests.user_to ='$id' and friend_requests.state='0'";
    $getreq = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
   // $record3=mysqli_fetch_assoc($getreq);

if(isset($_POST['save'])) 
{
while ($rec2=mysqli_fetch_assoc($getreq)){
	$name=$rec2['fname'];
	$state=$_POST[$name];
	if($state=='acc')
	{
		echo  "$id ";
		echo "$rec2[id]";


	$sql="UPDATE friend_requests SET state='1' WHERE  user_to='$id' and user_from='$rec2[id]' ";
    mysqli_query($connect,$sql ) or die(mysqli_error($connect)); 


	$sql2="INSERT INTO friends(user_id,friend_id) VALUES ('$id','$rec2[id]')";
    mysqli_query($connect,$sql2 ) or die(mysqli_error($connect)); 
    $sql3="INSERT INTO friends(user_id,friend_id) VALUES ('$rec2[id]','$id')";
    mysqli_query($connect,$sql3 ) or die(mysqli_error($connect)); 




	}
	else if($state=='rej')
	{
	$sql="UPDATE friend_requests SET state='2' WHERE  user_to='$id' and user_from='$rec2[id]' ";
    mysqli_query($connect,$sql ) or die(mysqli_error($connect)); 

	}
	else if($state=='ignore')
	{
	
	}

}


}

?>
 <?php if(mysqli_num_rows($getreq)==0)
 {
 	echo" you don't have any friend requests ! ";
 }
else { 

	?>
<form method="POST" action="">
<?php while($record3=mysqli_fetch_assoc($getreq)) {
	
?>
  
  <a href="someone.php?profile_id=<?php echo $record3['id'] ; ?>">
 <?php echo $record3['fname'] ; ?></a>
 <select  type="text" name='<?php echo $record3['fname']; ?>' id='<?php  echo $record3['fname'] ; ?>' >
                      <option value="acc">Accept</option>
                      <option value="rej">regect</option>
                      <option value="ignore">ignore</option>

                     </select>


 </P>
 </P>

<?php 
}
 }
     
?> 
<input type="submit" name="save" id="save" value="save">  
</form>