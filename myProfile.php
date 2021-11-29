<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>
<?php

$_SESSION["trackingUrl"] = $_SERVER["PHP_SELF"];
confirmLogin() ?>

<?php

$AdminId = $_SESSION["user_id"];
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $connectingDB->query($sql);
while ($dataRow = $stmt->fetch()) {
    $exName = $dataRow["aname"];
    $exbio=$dataRow["bio"];
    $eximage=$dataRow["image"];
    $exheadline=$dataRow["headline"];
}





if (isset($_POST["Submit"])) {
    $aname = $_POST["name"];
    $headline = $_POST["headline"];
    $bio = $_POST["bio"];
    $image = $_FILES["image"]["name"];
    $target = "uploads/" . basename($_FILES["image"]["name"]);

   if (strlen($headline) >12 ) {
        $_SESSION["error"] = "headline must be less than 12 char";
        Redirect_to("myProfile.php");
    } elseif (strlen($bio) > 1000) {
        $_SESSION["error"] = "bio must be less than 1000 char";
        Redirect_to("myProfile.php");
    } else {
        if(!empty($_FILES["image"]["name"])){
            $sql="UPDATE admins SET 
            aname='$aname',bio='$bio',image='$image',headline='$headline'
            WHERE id='$AdminId'";
        }else{
            $sql="UPDATE admins SET 
            aname='$aname',bio='$bio',headline='$headline'
            WHERE id='$AdminId'";
        }
     
       $excute=$connectingDB->query($sql);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target);
        if ($excute) {
            $_SESSION["success"] = "Admin update success";
            Redirect_to("myProfile.php");
        } else {
            $_SESSION["error"] = "something wrong";
            Redirect_to("myProfile.php");
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
    <title>My Profile</title>
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
                    <h1><i class="fas fa-user" style="color: #27aae1;"></i>My Profile</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- start mainArea -->
    <section class="container py-2 mb-4">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?php echo $exName ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="uploads/<?php echo $eximage   ?>" class="img-fluid mb-3 d-block" alt="">
                        <div>
                            <?php  echo $exbio?>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-9 " style="min-height: 450px;">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <form action="myProfile.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Edit Profile</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="row mb-3">
                             
                                <input placeholder="enter Name" type="text" name="name" id="title" class="form-control">
                            </div>

                            <div class="row mb-3">
                               
                                <input  placeholder="enter Headline" type="text" name="headline" id="title" class="form-control">
                                <small class="muted">Add Profissional Link</small>
                                <span class="text-danger">Not More Than 12</span>
                            </div>

                            <div class="row mb-3">
                               
                                <textarea placeholder="Enter bio" class="form-control" name="bio" id="bio" cols="30" rows="6"></textarea>
                            </div>
                            <div class="row mb-3">
                                <label for="image"><span class="labelInfo">Image</span></label>
                                <input type="file" name="image" id="image" class="form-control">
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