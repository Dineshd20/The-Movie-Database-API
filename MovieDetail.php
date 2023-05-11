<?php
session_start();
if (!isset($_SESSION["User_id"]) && !isset($_SESSION["User_name"]) && !isset($_GET["movie_id"]) )

{
    header("Location: Main.html");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <style>
        body{
                
                background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);  
                color:white;
                }
                .heading{
                    color: white; }
        .box {
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
                padding: 2%;
                margin: 5px;
                background-color: rgba(255, 255, 255, 0.171);
                text-align: center;}


        .movie_detail_page{
            display: grid;

            grid-template-columns: 1fr 1fr 1fr;
            grid-column-gap: 20px;
            grid-row-gap: 15px;
        }
        .h2_heading{
            border-bottom:double 5px aqua;
        }
        .posterBox{
            grid-column-start: 1;
            grid-column-end: 2;
        }
        .detailBox{
            text-align:left;
            grid-column-start: 2;
            grid-column-end: 4;
        }
        .title_heading{
            color:rgb(26, 122, 248);
            text-align: center;
            font-size:35px;
        }
        .videoBox{
            grid-column-start: 2;
            grid-column-end: 4;
        }

        .submitbtn{
            width: 250px;
            height: 40px;
            margin-top: 25px;
            border: none;
            border-radius: 50px;
            background-color: rgb(65, 139, 236);

        
            font-weight: bold;
            font-size:15px;
            transition: 0.4s;
            transition-property: transform;
            color:white;
        }
        .submitbtn:hover{

        transform: translateY(-5px);
        background-color: rgb(26, 122, 248);
        }

        .cont_name{
            text-decoration-line: underline;
            text-decoration-style: double;
        }

        .rate{
            float:right;
            color:white;
        }
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
</head>
<body>

    <ul>
    <li><a href="Movieslist.php">Full List   |</a></li>
    <li><a href="MySubscriptions.php">My Subscriptions   |</a></li>
    <li><a  href="logout.php">Logout</a></li>
    
    </ul>
    <h1 class="heading">Details</h1>

    <div class="movie_detail_page">
        <section class="posterBox box" >
            <div id="poster"></div>
            <button name= "submitted" id="uns_btn" type="submit" class="submitbtn">Unsubscribe</button><br>
        </section>
            
        <section class="detailBox box">
            
            <h2 class="h2_heading title_heading" id="name"><span class="rate" id="rating"></span></h2> 
            

            <h5 class="cont_name">OVERVIEW </h5>          <span class="fetch_cont" id="overview"></span>
            <h3 class="cont_name">GENRE  </h3>   <span class="fetch_cont" id="genre"></span>        
            <h3 class="cont_name">RUNTIME </h3>         <span class="fetch_cont" id="runtime"></span>

            <h3 class="cont_name" >RELEASE DATE </h3>    <span class="fetch_cont" id="rel_date"></span>
            <h3 class="cont_name">REVENUE </h3>   <span class="fetch_cont" id="revenue"></span>       
        </section> 

        <section id= "video" class="videoBox box">
            <h2 class="h2_heading">Trailer & Related Videos</h2>
        </section>

    </div>

    <script>

    
    //getting params from url
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const movie_id = urlParams.get('movie_id');

   // const User_id = < echo $_SESSION["User_id"]?>;

    //variables for fetching
    const base_html="https://api.themoviedb.org/3";
    const v_key= "?api_key=0cf56f8238aaf8582a0bea9fa0aedd9d";
    const base_poster="https://image.tmdb.org/t/p/w342";

    fetch(base_html+"/movie/"+movie_id+v_key)
    .then( function (response){
        return response.json();
    }).then(function (data){

        console.log("data available");
        document.getElementById("name").innerHTML+= data.original_title;
        document.getElementById("rating").innerHTML+= data.vote_average;

        document.getElementById("overview").innerHTML+= data.overview;
        document.getElementById("genre").innerHTML+= data.genres[0].name;
        document.getElementById("runtime").innerHTML+= data.runtime;

        document.getElementById("rel_date").innerHTML+= data.release_date;
        document.getElementById("revenue").innerHTML+= data.revenue;
    
        document.getElementById("poster").innerHTML+=`
        <img  class="pic" src="${base_poster+data.poster_path}" alt="${data.title}">`

    })

    // fetching for movie videos
    fetch(base_html+"/movie/"+movie_id+"/videos"+v_key)
    .then(res=> res.json())
    .then(video=>{
    
        if(video.results.length<1){ 
            document.getElementById("video").innerHTML+="No Video available for this movie on DB";
            console.log("no video");
        }else{
            console.log("video availabe");
            document.getElementById("video").innerHTML+=`
            <iframe width="420" height="315"
            src="https://www.youtube.com/embed/${video.results[0].key}">
            </iframe>  `
        }
    })

    // unsubscribing and subscribing movie from the database 
    document.getElementById('uns_btn').addEventListener('click', unsubscribeBtn);

    function unsubscribeBtn(){

       // var params ="movie_id="+movie_id+"&user_id="+User_id;
        var params ="movie_id="+movie_id;
        var xhr= new XMLHttpRequest();
        xhr.open('POST', 'unsub.php',true);
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');

        xhr.onload=function(){
        
            if(this.status==200){
                console.log(this.responseText);
                document.getElementById('uns_btn').innerHTML=this.responseText; 
            }
        }
        xhr.send(params);
    }

    </script>


</body>
</html>