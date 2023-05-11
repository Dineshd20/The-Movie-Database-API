<?php
session_start();
if (!isset($_SESSION["User_id"]) && !isset($_SESSION["User_name"]))

{echo $_SESSION;
    header("Location: login.php");
    die();
}
else 
{
    $id= $_SESSION["User_id"] ;
   
// getting info about user
    include 'databased.php';
    $info = "Select * FROM Users WHERE UserId = '$id'";
                
    $r1 = $conn->query($info);

    $row = $r1->fetch_assoc();
                
        $email = $row["Email"];

}
?>


<!DOCTYPE html>
<html lang="en">
<head>

<link rel="stylesheet" href="Mainfile.css">
    <title>Account</title>
  
</head>
<body class="AccountB" >

<h1>My Account</h1>
   
    <a href="logout.php">Logout</a>

    <h3>Hello, <span class="info"><?= $_SESSION["User_name"];?></span></h3>
    

   <h3>Your Email is: <span class="info"><?= $email;?></span></h3>
    

    
</body>
</html>