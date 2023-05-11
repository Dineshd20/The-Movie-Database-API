<?php

session_start();
if (isset($_SESSION["User_id"]) && isset($_SESSION["User_name"]))

{
    header("Location: MySubscriptions.php");
    
}else{
    $errorMsg = "";
    if (isset($_POST["submitted"]) )
    { 

        $username = trim($_POST["uname"]);
        $password = trim($_POST["pswd"]);
        

        if (strlen($username)>0 && strlen($password)>0){
            $error = "";
            include 'databased.php';
            $matching = "SELECT UserId, Username FROM Users
            WHERE Username = '$username' AND Password = '$password'";
            
            $result= $conn->query($matching);
            if($row = $result->fetch_assoc()){
            
                session_start();
                $_SESSION["User_id"] = $row["UserId"];
                $_SESSION["User_name"] = $row["Username"];
            
                header("Location: MySubscriptions.php");
                $conn->close();
                exit();
            } else
            {
                $errorMsg= "Try Agian.";
                
                
                $conn->close();
            }

        }else
        {
            $errorMsg = "Login Failed.";
        
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Mainfile.css">
    <title>Login</title>
</head>
<body class="body">
<div  class= "box" id="signForm">
    <form action="login.php" id= "signin" class="signin box" method="post" >
        <h1 >Sign In</h1><br>
        <p class= "err_msg"><?=  $errorMsg;?></p>
        <label class="name">Username:</label><br>
        <p class="err_msg" id="uname_msg"></p>
        <input name="uname" id="uname" type="username" placeholder="Username" ><br>
        <label class="name">Passowrd:</label><br>
        <p class="err_msg" id="pswd_msg"></p>
        <input name="pswd"  id="pass" type="password" placeholder="Password" ><br>


        <button name= "submitted" type="submit" class="submitbtn">Sign In</button><br>
        <span class="spn">Don't have an account <a href="signup.php">Sign Up</a></span>
    </form>
</div>
</body>
</html>