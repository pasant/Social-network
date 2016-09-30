<?php 

include("header_searchbox.php");
include("footer.php");
include("connect.php"); 
$id=$_SESSION['uid'];
$_SESSION['uid']=$id;
$val=$_POST['search_with']  ;
   if($val=='1')
   {
   
    $email=$_POST['search_input'];
   $sql1="SELECT * FROM users WHERE email ='$email'";
  $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
    $record = mysqli_fetch_assoc($getposts);
   }
   else if($val=='2')
   {

   
   $name=$_POST['search_input'];

    $pieces = explode(" ", $name);
   $sql1="SELECT * FROM users WHERE fname ='$pieces[0]' or lname='$pieces[0]'";
  $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
    $record = mysqli_fetch_assoc($getposts);

    }
   else if($val=='3')
   {
   
    $phone=$_POST['search_input'];
    $sql1="SELECT * FROM users WHERE phone ='$phone'";
    $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
    $record = mysqli_fetch_assoc($getposts);
    
   }
   
   else if($val=='4')
   {
   	$hometown=$_POST['search_input'];
    $sql1="SELECT * FROM users WHERE hometown ='$hometown'";
    $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
   $record = mysqli_fetch_assoc($getposts);


   }

   else if($val=='5')
   {
   	$caption=$_POST['search_input'];
    $sql1="SELECT * FROM posts inner join users on posts.user_id=users.id WHERE caption like '%$caption%' ";
    $getposts = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
   $record = mysqli_fetch_assoc($getposts);

   }
 
?>

 <?php if($record==0)
 {
  
  echo "<script> alert('No acounts match your search')</script>";
 }
  else{ do {
?>
  <a href="someone.php?profile_id=<?php echo $record['id'] ; ?>">
 <?php echo $record['fname'] ;echo " " ;echo $record['lname']; ?></a>
 </P>
<?php }while($record=mysqli_fetch_assoc($getposts)); }
?>    
