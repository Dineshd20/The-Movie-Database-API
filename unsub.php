<?php
session_start();

if (isset($_SESSION["User_id"]) && isset($_POST['movie_id']) )
{
  
   $movie_id= $_POST['movie_id'];
   $user_id= $_SESSION['User_id'];
   $msg_return="";
   include 'databased.php';


   $moviecheck = "SELECT * FROM movies WHERE UserId = '$user_id' && movie_id= '$movie_id' ";
   $result= mysqli_query($conn,$moviecheck);
   if(mysqli_num_rows($result) > 0){
          
       $delete = "DELETE FROM movies WHERE UserId='$user_id' AND movie_id='$movie_id'";

         $r2 = $conn->query($delete);

        if ($r2 === true)
        {
            echo "Subscribe";
           
        }   
   } else{
        $add = "INSERT INTO movies (UserId, movie_id)
        VALUES ('$user_id', '$movie_id')";

        $r3 = $conn->query($add);

        if ($r3 === true)
            {
                echo "Unubscribe";
               
            }
    }

}else{
  
    header("Location: login.php");
    exit();
}

