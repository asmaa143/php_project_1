<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

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
                if (isset($_GET["searchBtn"])) {
                    $search = $_GET["search"];
                    $sql = "SELECT * FROM posts
                     WHERE datetime LIKE :search
                     OR title LIKE :search
                     OR category LIKE :search
                     OR post LIKE :search  
                     ";

                    $stmt = $connectingDB->prepare($sql);
                    $stmt->execute([
                        ":search" => '%' . $search . '%',
                    ]);
                } elseif (isset($_GET["page"])) {
                    $page = $_GET["page"];
                    if ($page == 0 || $page < 1) {
                        $showPostForm = 0;
                    } else {
                        $showPostForm = ($page * 4) - 4;
                    }

                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $showPostForm,4";
                    $stmt = $connectingDB->query($sql);


                }elseif(isset($_GET["cat"])){
                     $cat=$_GET["cat"];
                     $sql="SELECT * FROM posts WHERE category='$cat' ORDER BY id desc";
                     $stmt=$connectingDB->query($sql);

                   
                } else {
                    $connectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc";
                    $stmt = $connectingDB->query($sql);
                }

                while ($dataRows = $stmt->fetch()) {
                    $Id = $dataRows["id"];
                    $dateTime = $dataRows["datetime"];
                    $title = $dataRows["title"];
                    $category = $dataRows["category"];
                    $admin = $dataRows["author"];
                    $image = $dataRows["image"];
                    $post = $dataRows["post"];

                ?>
                    <div class="card mb-3">
                        <img style="max-height: 300px;" src="uploads/<?php echo $image ?>" class="img-fluid card-img-top" alt="">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $title ?></h4>
                            <small class="text-muted">Wrriten By : <?php echo $admin ?>
                                on <?php echo $dateTime ?></small>
                            <span class="badge bg-dark text-light ">Comments <?php echo approveComments($Id); ?> </span>
                            <hr>
                            <p class="card-text">
                                <?php if (strlen($post) > 150) {
                                    $post = substr($post, 0, 150) . '...';
                                }
                                echo $post;

                                ?>
                                <a href="fullPost.php?id=<?php echo $Id ?>" class="float-end">
                                    <span class="btn btn-info">Read More</span>
                                </a>
                            </p>
                        </div>
                    </div>
                <?php  } ?>

                <nav>
                    <ul class="pagination pagination-md">

                        <?php
                        if (isset($page)) {
                            if ($page > 1) {
                        ?>

                                <li class="page-item">
                                    <a class="page-link" href="blog.php?page=<?php echo $page - 1 ?>">&laquo;</a>
                                </li>
                        <?php }
                        } ?>

                        <?php
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $connectingDB->query($sql);
                        $rowPaginate = $stmt->fetch();
                        $totalPosts = array_shift($rowPaginate);
                        $postPaginate = $totalPosts / 4;
                        $postPaginate = ceil($postPaginate);

                        for ($i = 1; $i <= $postPaginate; $i++) {
                            if(isset($page)){
                            if ($i == $page) { ?>
                                <li class="page-item active">
                                    <a href="blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $i ?>" class="page-link"><?php echo $i ?></a>
                                </li>

                        <?php }
                        } }?>



                        <?php

                        if (isset($page) && !empty($page)) {
                            if ($page + 1 <= $postPaginate) {
                        ?>
                                <li class="page-item">
                                    <a class="page-link" href="blog.php?page=<?php echo $page + 1 ?>">&raquo;</a>
                                </li>
                        <?php }
                        } ?>



                    </ul>
                </nav>


            </div>

            <div class="col-sm-4">
                  <div class="card mt-4">
                      <div class="card-body">
                          <img src="images/images.png" class="d-block img-fluid mb-3" alt="">
                          <div class="text-center">
                           Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                           Odio, harum qui reprehenderit minus pariatur asperiores accusantium 
                           facilis facere dolor dignissimos placeat inventore exercitationem iure,
                            dolorum sapiente, impedit mollitia magnam labore.

                          </div>
                      </div>
                  </div>
                  <br>
                  <div class="card">
                      <div class="card-header bg-dark text-light">
                         <h2 class="lead">Sign Up</h2>
                      </div>
                      <div class="card-body">
                          <div class="d-grid">
                             <button class="btn btn-success text-center text-white">Jion Us</button>
                             <button class="btn btn-danger mt-1 text-center text-white">Login</button>
                          </div>
                          <div class="input-group mt-2 mb-3">
                                <input type="Email" class="form-control">
                                <div class="input-group-append">
                                <button class="btn btn-primary text-white text-center">Subscribe</button>
                                </div>
                          </div>
                      </div>
                  </div>
                  <br>
                  <div class="card">

                    <div class="card-header bg-primary text-light">
                         <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">

                      <?php 
                      $sql="SELECT * FROM category ORDER BY id desc";
                      $stmt=$connectingDB->query($sql);
                      while($dataRow=$stmt->fetch()){
                          $catId=$dataRow["id"];
                          $catName=$dataRow["title"];

                          ?>


                          <a class="text-decoration-none" href="blog.php?cat=<?php echo $catName?>">
                    
                            <span class="text-info"><?php echo $catName ?></span><br>
                        </a>
                     <?php } ?>
                            
                           
                    </div>
                  </div>
                  <br>
                  <div class="card">
                      
                  </div>
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