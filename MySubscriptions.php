<?php

session_start();
if (!isset($_SESSION["User_id"]) && !isset($_SESSION["User_name"]))

{
    header("Location: login.php");
    die();
}
else 
{
    $id= $_SESSION["User_id"] ;
   

  
   
// getting movie_ids for DB
        include 'databased.php';
        $movies = "Select * FROM movies WHERE UserId = '$id'";
            
        $r2 = $conn->query($movies);

        $moviearry = array();
        while($row =mysqli_fetch_assoc($r2))
        {
            $moviearry[] = $row['movie_id'];
        }

        json_encode($moviearry);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body{
                
            background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);     }
        .heading{
            color: white; }
        #grid{
            display: inline-grid;
            width: 100%;
            grid-template-columns: 1fr 1fr 1fr;
            grid-column-gap: 30px; }

        .small_cont{

        }
        .ratings{
            float: right;
            
            border-radius: 25%;
            
            font-size: 15px;
            font-weight: bold;
            
        }

        .show_Btn{

        text-decoration: none;
            border:none;
        
        
        color: rgb(255, 255, 255);
            width: 50px;
            height: 45px;
            font-size: 20px;
            font-weight: 500;
            word-spacing: 3px;
            background-image: linear-gradient(to right, rgb(70, 228, 201), 
            rgb(65, 139, 236));
            cursor: pointer;
            padding: 3%;
        


        }
        .show_Btn:hover{

            background-image: linear-gradient(to left, rgb(70, 228, 201), 
            rgb(65, 139, 236));
        }

        .show_tBtn span{
            width: 60px;
            height: 45px;
            position: relative;
            transition: 0.5s;
        }
        .show_Btn span:after{
        
        content: '\00bb';

            opacity: 0;
            right: -20px;
            transition: 0.5s;
        }

        .show_Btn:hover span{
            padding-right: 25px;
            transition: 0.5s;

        }

        .show_Btn:hover span:after{
            opacity: 1;
            right: 0;

        }
        .box {
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            padding: 2%;
            margin: 5px;
            background-color: rgba(255, 255, 255, 0.171);
            text-align: center;}
        .pic{
            width: 250px ;
            height: 250px;
            margin-bottom: 20px;}
        ul {
            list-style-type: none;
            margin: 5px;
            padding: 5px;
            float: right;
            display: flex;
            width: auto;
  background-color: #f1f1f1;
  
        }
        li{
            list-style-type: none;
            margin: 5px;
        
        }
        li a {
  
            color: #000;

            text-decoration: none;
        }
        li a:hover{
            background-color: #555;
         color: white;
        }
    </style>

    <title>Movies</title>
</head>
<body >
<ul>
  <li><a href="Movieslist.php">Full List   |</a></li>
  <li><a href="MySubscriptions.php">My Subscriptions   |</a></li>
  <li><a  href="logout.php">Logout</a></li>
</ul>
    <h1 class="heading">My Subscriptions</h1>
  
<div>
    <Section id= "grid" >
    
    </Section>
   
</div>    
    
<script>

    //API urls 
    const base_html="https://api.themoviedb.org/3/movie/";
    const v_key= "?api_key=0cf56f8238aaf8582a0bea9fa0aedd9d";
    const base_poster="https://image.tmdb.org/t/p/w342";

   
 //looping with movieId and fetching data from API 
    <?php   foreach($moviearry as $item) {?> 
        
        fetch(base_html+<?php echo $item;?>/*movie_id*/+v_key+"&language=en-US")
        .then( function (response){
            return response.json();
        }).then((data) =>{
            console.log("data available");
            // adding data into the doc
            let cont=document.getElementById("grid");

            let cell = document.createElement("div");
            cell.setAttribute("class", "box");
            
        cell.innerHTML = ` 
            <img  class="pic" src="${base_poster+data.poster_path}" alt="${data.title}"><br>
            <div class= "small_cont">
                <a  class="show_Btn" href="MovieDetail.php?movie_id=${data.id}"><span>Show more </span></a>
            <span class="ratings box">${data.vote_average}</span>
            </div>`;
            cont.appendChild(cell);
        });
        

    <?php }?> 
    
</script>
    
</body>

</html>