<?php

session_start();
include("footer.php");
include("connect.php"); 
$id= $_SESSION['uid'];
$_SESSION['uid']=$id;
$sql1="SELECT * FROM friend_requests WHERE user_to ='$id' and state='0'";
$result = mysqli_query($connect,$sql1) or die(mysqli_error($connect));
if ($result)
  {
  // Return the number of rows in result set
  $rowcount=mysqli_num_rows($result);
  
  }
  else
  {
    $rowcount='0';
  }
?>



<!doctype html>
<html> 
	<head>
		<title > FriendZonia </title>
		<link rel="stylesheet" type="text/css"href="style.css">
              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
               <script type="text/javascript">
       function validatesearch()
       {
             // alert('hi ');
              var search_in=document.getElementById("search_input").value;
              var search_wi=document.getElementById("search_with").value;
              if(search_in==null || search_wi==null|| search_wi==""|| search_wi=="")
              {
                     alert("search! enter what do you want to search about and how ");
                     return false;
              }
              return true;
       }
</script>
	</head>
	<body>
       <div class="headerMenu">
       	<div id="wrapper">
       		<div class="logo">
       			<h2> FriendZonia </h2>
       		</div>
                     
       	       <div class="search_box">
                     <form action="search.php" method="post" id="search" onsubmit="return validatesearch()">
                     <input type="text" name="search_input" id="search_input"size="60" placeholder="Search ..." /> 
                     <select  type="text" name="search_with" id="search_with">
                     <option value="">search with</option>
                      <option value="1">email</option>
                     <option value="2">Name</option>
                     <option value="3">Phonenumber</option>
                     <option value="4">Hometowen</option>
                      <option value="5">part of a post ! </option>
                     </select>
                      </p>         
                     </form>
                     </div>

                     <div id="menu">
                            <a href="homePage.php" />Home</a>
                            <a href="profile.php" />Profile </a>
                            <a href="editProfile.php" />Profile Edit</a>
                            <a href="my_friend.php" />Friends</a>
                            <a href="friendreq.php" />friend requests  <?php echo $rowcount ; ?></a>
                            <a href="index.html" />Logout</a>
                     </div>
              </div>
              <div id="wrapper" >
