<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php
if (isset($_POST["Submit"])) {
    $category = $_POST["title"];
    $admin = "amit";
    date_default_timezone_set("Africa/Cairo");
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y  %H:%M:%S", $currentTime);
    
    if (empty($category)) {
        $_SESSION["error"] = "All Fields must be filled out";
        Redirect_to("categories.php");
    } elseif (strlen($category) < 3) {
        $_SESSION["error"] = "title must be more than 2 char";
        Redirect_to("categories.php");
    } elseif (strlen($category) > 49) {
        $_SESSION["error"] = "title must be less than 50 char";
        Redirect_to("categories.php");
    } else {
    //    global $connectingDB;
         $sql="INSERT INTO category(title,author,datetime) VALUES(:title,:admin,:datetime)";
         $stmt=$connectingDB->prepare($sql);
         $excute= $stmt->execute([
             ':title'=>$category,
             ':admin'=>$admin,
             ':datetime'=>$dateTime,
         ]);

         if($excute){
            $_SESSION["success"] = "category with id :".$connectingDB->lastInsertId()."added success";
            Redirect_to("categories.php");
         }else{
            $_SESSION["error"] = "something wrong";
            Redirect_to("categories.php");
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
    <title>Categories</title>
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
                        <a class="nav-link" href="myProfile.php">
                            <i class="fas fa-user text-success"></i>
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">
                            Post
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admins.php">
                            Manage Admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comments.php">
                            Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Blog.php?page=1">
                            Live Blog
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-sign-out-alt text-danger"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-edit" style="color: #27aae1;"></i>Manage Category</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- start mainArea -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-10 offset-lg-1" style="min-height: 450px;">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form action="categories.php" method="POST">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="row mb-3">
                                <label for="title"><span class="labelInfo">Category Title</span></label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <div class="d-grid">
                                        <a class="btn btn-warning" href="dashboard.php">
                                            <i class="fas fa-arrow-left"></i>
                                            Back To Dashboard
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="d-grid">
                                        <button type="submit" name="Submit" class="btn btn-success">
                                            <i class="fas fa-check"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- end mainArea -->

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