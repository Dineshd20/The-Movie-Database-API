<?php
session_start();
if (isset($_SESSION["User_id"]) && isset($_SESSION["User_name"]))
{
    header("Location: MySubscriptions.php");
    exit();
}else{
    $error_msg= "";
    $user_error_msg="";
    $email_error_msg="";
    $validate = true;
    $reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
    $reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
    $reg_user = "/^[a-zA-Z0-9_-]+$/";


    if (isset($_POST["submitted"]) )
    { 
        $email = trim($_POST["email"]);

        $username = trim($_POST["uname"]);
    

        $password = trim($_POST["pswd"]);
        $repass = trim($_POST["pswdr"]);
   
        // valditing email
        $emailMatch = preg_match($reg_Email, $email);
        if($email == null || $email == "" || $emailMatch == false)
            {
                $validate = false;
            }
        // valditing username
        $userMatch = preg_match($reg_user, $username );
        if($username == null || $username == "" || $userMatch ==false){
            $validate = false;
        }   
        // valditing passowrd and repassowrd
        $pswdLen = strlen($password);
        $pswdMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false)
            {
            $validate = false;
            }
        
        if($repass == null || $repass == "" || $repass !=$password)
            {
                $validate = false;
            }
             
       

  
    // if validate add to database
        if($validate == true){

            $furthervalidate = true;
             // checking if user already exists

        include 'databased.php';

        $usercheck = "SELECT Username FROM Users WHERE Username = '$username'";
        $result= mysqli_query($conn,$usercheck);
        if(mysqli_num_rows($result) > 0){
            $user_error_msg = "Username already taken.";
            $furthervalidate = false;}
            
         // checking if email already exists

         $emailcheck = "SELECT Email FROM Users WHERE Email = '$email'";
         $result= mysqli_query($conn,$emailcheck);
         if(mysqli_num_rows($result) > 0){
             $email_error_msg = "email  already taken.";
             $furthervalidate = false;
             
         } 
            if($furthervalidate ==true){
                include 'databased.php';
$Randomkey= uniqid();
                $add = "INSERT INTO Users (Username, Email, Password, RandomKey)
                VALUES('$username','$email',  '$password', '$Randomkey')";
                    $r2 = $conn->query($add);
                
                if ($r2 === true)
                {
                    header("Location: login.php");
                    exit();
                    
                }

            }else{
            $error_msg=  "Signup failed. Try Again with proper inputs.";
            
        }
            
        }
        else{
            $error_msg=  "Signup failed. Try Again with proper inputs.";
            
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
    <title>Sign up</title>
</head>
<body class="body">
    


  
<div  class= "box" id="signupForm">
    <form method="post" id="signup" action="signup.php" class="signup" >
        <h1 >Sign Up</h1><br>
	
        <p class="err_msg"><?= $error_msg;?></p><br>
        <label  class="name ">Email</label><br>
        <p class="err_msg"><?= $email_error_msg;?></p>
        <input name="email" id="mail" type="username" placeholder="fake@example.com" ><br><br>
        <label  class="name">Username</label><br>
        <p class="err_msg"><?= $user_error_msg;?></p>
        <input  name="uname"  id="uname" type="username" placeholder="Username" ><br><br>
        <label  class="name">Passowrd</label><br>
        <p class="err_msg"></p>
        <input  name="pswd"  id="pass"  type="password" placeholder="(8 character long Including 1 non-letter)" ><br><br>
        <label class="name">Confirm Passowrd</label><br>
        <p class="err_msg"></p>
        <input  name="pswdr" id="r_pass" type="password" placeholder="Password" ><br><br>




        <button name ="submitted" type="submit" class="submitbtn">Sign Up</button><br>
        <span class="spn">Have an account <a href="login.php">Sign In</a></span>
    </form>



</div>
</body>
</html>