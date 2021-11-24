<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>
<?php 

$_SESSION["trackingUrl"]=$_SERVER["PHP_SELF"];
confirmLogin() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Comments</title>
</head>

<body>
    <!-- start navbar -->
    <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">AMIT.COM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
                  <h1><i class="fas fa-comments" style="color: #27aae1;"></i>Manage Comment</h1>
                </div>
            </div>
        </div>
    </header>
  
  
    <section class="container py-2 mb-4">

           <div class="row">
               <div class="col-lg-12">
               <?php
                echo errorMessage();
                echo successMessage();
                ?>
                 <h2>Un-Approved Comments</h2>
                 <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php      
                    
                    $sql="SELECT * FROM comments WHERE status='off' ORDER BY id desc";
                    $excute=$connectingDB->query($sql);
                    $sr=0;
                    while($dataRow=$excute->fetch()){
                        $commentid=$dataRow["id"];
                        $commentdate=$dataRow["datetime"];
                        $commentname=$dataRow["name"];
                        $comment=$dataRow["comment"];
                        $commentpostid=$dataRow["post_id"];
                        $sr++;
                
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $sr  ?></td>
                            <td><?php  echo $commentname ?></td>
                            <td><?php  echo $commentdate ?></td>
                            <td><?php  echo $comment ?></td>
                            <td><a class="btn btn-success" href="approveComment.php?id=<?php echo $commentid ?>">
                            Approve</a>
                        </td>
                        <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $commentid ?>">Delete</a></td>
                        <td><a class="btn btn-primary" href="fullPost.php?id=<?php echo   $commentpostid ?>">Live Preview</a></td>
                        </tr>
                    </tbody>
                    <?php   }?>
                 </table>

                 <h2>Approved Comments</h2>
                 <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Dis Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php      
                    
                    $sql="SELECT * FROM comments WHERE status='on' ORDER BY id desc";
                    $excute=$connectingDB->query($sql);
                    $sr=0;
                    while($dataRow=$excute->fetch()){
                        $commentid=$dataRow["id"];
                        $commentdate=$dataRow["datetime"];
                        $commentname=$dataRow["name"];
                        $comment=$dataRow["comment"];
                        $commentpostid=$dataRow["post_id"];
                        $sr++;
                
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $sr  ?></td>
                            <td><?php  echo $commentname ?></td>
                            <td><?php  echo $commentdate ?></td>
                            <td><?php  echo $comment ?></td>
                            <td><a class="btn btn-success" href="disapproveComment.php?id=<?php echo $commentid ?>">
                           Dis Approve</a>
                        </td>
                        <td><a class="btn btn-danger" href="deleteComment.php?id=<?php echo $commentid ?>">Delete</a></td>
                        <td><a class="btn btn-primary" href="fullPost.php?id=<?php echo   $commentpostid ?>">Live Preview</a></td>
                        </tr>
                    </tbody>
                    <?php   }?>
                 </table>
               </div>
           </div>
    </section>



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