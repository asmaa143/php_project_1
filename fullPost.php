<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php   
$searchQueryParam=$_GET["id"];
?>
<?php

if (isset($_POST["Submit"])) {
    $name = $_POST["name"];
    $email=$_POST["email"];
    $comment=$_POST["comment"];
    date_default_timezone_set("Africa/Cairo");
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y  %H:%M:%S", $currentTime);
    
    if (empty($name)||empty($email)||empty($comment)) {
        $_SESSION["error"] = "All Fields must be filled out";
        Redirect_to("fullPost.php?id= {$searchQueryParam}");
    } elseif (strlen($comment) > 500) {
        $_SESSION["error"] = "Comments must be less than 500  char";
        Redirect_to("fullPost.php?id= {$searchQueryParam}");
    
    } else {
    //    global $connectingDB;
         $sql="INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id) VALUES(:datetime,:name,:email,:comment,'pendig','off',:postID)";
         $stmt=$connectingDB->prepare($sql);
         $excute= $stmt->execute([
             ':datetime'=>$dateTime,
             ':name'=>$name,
             ':email'=> $email,
             ':comment'=>$comment,
             ':postID'=>$searchQueryParam
        
         ]);
       
         if($excute){
            $_SESSION["success"] = "Comment added success";
            Redirect_to("fullPost.php?id= {$searchQueryParam}");
         }else{
            $_SESSION["error"] = "something wrong";
            Redirect_to("fullPost.php?id= {$searchQueryParam}");
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Blog</title>
</head>

<body>
    <!-- start navbar -->
    <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">AMIT.COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">
                            Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Contact Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comments.php">
                            Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Features
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav mx-auto">
                    <form class="d-flex" action="">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search">
                        <button name="searchBtn" type="submit" class="btn btn-primary">Search</button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <div class="container">
        <div class="row my-4">
            <div class="col-sm-8">
                <h1>Complete Blog</h1>
                <h1 class="lead">Complete Blog Using PHP</h1>
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <?php   
                 if(isset($_GET["searchBtn"])){
                     $search=$_GET["search"];
                     $sql="SELECT * FROM posts
                     WHERE datetime LIKE :search
                     OR title LIKE :search
                     OR category LIKE :search
                     OR post LIKE :search  
                     ";

                     $stmt=$connectingDB->prepare($sql);
                     $stmt->execute([
                         ":search"=> '%'.$search.'%',
                     ]);                   
                 }

                 else{
                    $connectingDB;
                    if(!isset($searchQueryParam)){
                        $_SESSION["error"]="Bad Request";
                          Redirect_to("blog.php");
                    }
        
                    $sql="SELECT * FROM posts WHERE id='$searchQueryParam'";
                    $stmt=$connectingDB->query($sql);
                 }

                 while($dataRows=$stmt->fetch()){
                    $Id=$dataRows["id"];
                    $dateTime=$dataRows["datetime"];
                    $title=$dataRows["title"];
                    $category=$dataRows["category"];
                    $admin=$dataRows["author"];
                    $image=$dataRows["image"];
                    $post=$dataRows["post"];
              
                ?>
                <div class="card mb-3">
                    <img style="max-height: 300px;" 
                    src="uploads/<?php echo $image?>" class="img-fluid card-img-top" alt="">
                    <div class="card-body">
                         <h4 class="card-title"><?php echo $title?></h4>
                         <small class="text-muted">Wrriten By : <?php echo $admin?> 
                         on <?php echo $dateTime?></small>
                         <span class="badge bg-dark text-light ">Comments  <?php echo approveComments($Id); ?></span>
                         <hr>
                         <p class="card-text">
                                  <?php  
                                    echo $post;
                                  ?>
                                 
                         </p>
                    </div>
                 </div>
                 <?php  }?>
                 <span class="labelInfo">Comments</span>
                 <br><br>
                 <?php
                 $sql="SELECT * FROM comments WHERE post_id='$searchQueryParam' AND status='on'";
                 $stmt=$connectingDB->query($sql);
                 while($dataRows=$stmt->fetch()){
                     $commentname=$dataRows["name"];
                     $commentcontent=$dataRows["comment"];
                     $commentDate=$dataRows["datetime"];

               
              
                 
                 ?>

                 <div>
                     <div style="background-color:#F6F7F9;" class="media">
                           <img class="float-start img-fluid " src="images/images.png"
                            width="60px" alt="">
                            <div class="media-body mr-2">
                                <h6 class="lead"><?php echo $commentname?></h6>
                                <p class="small"><?php echo $commentDate?></p>
                                <p ><?php echo $commentcontent?></p>
                            </div>
                     </div>
                 </div>
                 <hr>
                 <?php   }?>
                 <!-- comment part -->
                       <div class="mt-3">
                          <form method="post" action="fullPost.php?id=<?php echo $searchQueryParam ?>">
                              <div class="card mb-3">
                                 <div class="card-header">
                                     <h5 class="labelInfo">Share Your Comment</h5>
                                 </div>
                                 <div class="card-body">
                                 <div class="input-group mb-3">
                                          <span class="input-group-text">
                                              <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control">
                                     </div>
                                     <div class="input-group mb-3">
                                          <span class="input-group-text">
                                              <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control">
                                     </div>
                                     <div class="input-group mb-3">
                                         
                                            <textarea class="form-control" name="comment" id="" ></textarea>
                                     </div>
                                     <div>
                                         <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                     </div>
                                 </div>
                              </div>

                        </form>
                       </div>

            </div>
            <div class="col-sm-4">

            </div>
        </div>
    </div>


    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">
                        Theme By | Amit | <span id="year"></span> &copy; ---All right
                    </p>
                    <p class="text-center small">
                        <a style="color:white ;text-decoration:none;cursor: pointer;" href="#">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat veniam nostrum non
                            mollitia porro dignissimos exercitationem asperiores? Temporibus, porro itaque.
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 10px; background: #27aae1;"></div>



    <!-- end navbar -->








    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        $("#year").text(new Date().getFullYear())
    </script>
</body>

</html>