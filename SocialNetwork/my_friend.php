<?php 

include("header_searchbox.php");
include("footer.php");
include("connect.php"); 
 
   

    $id=$_SESSION['uid'];
    $_SESSION['uid']=$id;
    $sql1="SELECT * FROM friends inner join users on id=friend_id WHERE user_id ='$id'";
    $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
    $record = mysqli_fetch_assoc($getposts);


?>
<?php do {
?>
  <a href="someone.php?profile_id=<?php echo $record['friend_id'] ; ?>">
 <?php echo $record['fname'] ;echo " " ;echo $record['lname']  ; ?></a>
 </P>
<?php }while($record=mysqli_fetch_assoc($getposts));
?>    
