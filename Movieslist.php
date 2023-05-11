<?php
session_start();
if (!isset($_SESSION["User_id"]) && !isset($_SESSION["User_name"]) )

{
    header("Location: Main.html");
    die();
}else{
   $user_id= $_SESSION["User_id"];

    include 'databased.php';
        $moviesdata = "Select * FROM movies WHERE UserId = '$user_id'";
            
        $r2 = $conn->query($moviesdata);

        $moviearry = array();
        while($row =mysqli_fetch_assoc($r2))
        {
            $moviearry[] = $row['movie_id'];
        }

     $jsonS= json_encode($moviearry);

     
   
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
        .subBtn{
            background-color: #137952;/* Green */
                border: none;
                color: white;
               padding: 10px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
           
                cursor: pointer;
        }
        .subBtn:hover{
          
            background-color: #024e31; 
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
    <h1 class="heading">All collection</h1>

<div  >
    <Section id= "grid" >
        
    </Section>
   
</div>    
    
<script>

    //const queryString = window.location.search;
   // console.log(queryString);
    const base_html="https://api.themoviedb.org/3";
    const v_key= "?api_key=0cf56f8238aaf8582a0bea9fa0aedd9d";
    
    const base_poster="https://image.tmdb.org/t/p/w342";

   //JSON.parse parse it.
let movieArry = JSON.parse('<?= $jsonS; ?>');


//Log the data to the console
console.log(movieArry);
    
    fetch(base_html+"/movie/popular"+v_key+"&language=en-US&page=1")
    .then( function (response){
        return response.json();
    }).then((data) =>{
    
        
        let cont=document.getElementById("grid");

       for(let i=0; i <data.results.length; i++){


        // checking if user has already sub a movie
        let su="Subscribe";
        for (let j = 0; j < movieArry.length; j++) {

            if(data.results[i].id==movieArry[j])
            {su="Unsubscribe";}  
        } 
        

        // printing data into doc

        let cell = document.createElement("div");
        cell.setAttribute("class", "box");
        
       
    cell.innerHTML = ` 
        <img  class="pic" src="${base_poster+data.results[i].poster_path}" alt="${data.results[i].title}"><br>
        <div class= "small_cont">
        <button class="subBtn" id="sub_btn${data.results[i].id}"  onclick="return subscribeBtn();" value="${data.results[i].id}">${su}</button>
        <span class="ratings box">${data.results[i].vote_average}</span>
        </div>`

        cont.appendChild(cell);
       }
    
    });
    
    // sub and unsub movie request
    function subscribeBtn(){
        console.log("subBtn hit");
     var movie_id= event.srcElement.value;
    
    // var uns= event.srcElement.innerHTML="";
     var params ="movie_id="+movie_id;
    var xhr= new XMLHttpRequest();
    xhr.open('POST', 'sub.php',true);
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

    xhr.onload=function(){
    
        if(this.status==200){
            document.getElementById('sub_btn'+movie_id).innerHTML=this.responseText;
        }
    }
   xhr.send(params);
    }
    
    </script>
    
</body>
</html>