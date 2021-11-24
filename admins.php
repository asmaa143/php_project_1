<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>
<?php

$_SESSION["trackingUrl"]=$_SERVER["PHP_SELF"]; 
confirmLogin() ?>

<?php
if (isset($_POST["Submit"])) {
    $username = $_POST["username"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmpassword"];
    $Admin=$_SESSION["username"];
    date_default_timezone_set("Africa/Cairo");
    $currentTime = time();
    $dateTime = strftime("%B-%d-%Y  %H:%M:%S", $currentTime);
    
    if (empty($username)||empty($password)||empty($confirmPassword)) {
        $_SESSION["error"] = "All Fields must be filled out";
        Redirect_to("admins.php");
    } elseif (strlen($password) < 4) {
        $_SESSION["error"] = "password must be more than 3 char";
        Redirect_to("categories.php");
    } elseif ($password !== $confirmPassword) {
        $_SESSION["error"] = "password and confirm should match";
        Redirect_to("admins.php");
    } elseif (checkUsernameExists($username)) {
        $_SESSION["error"] = "Username exist";
        Redirect_to("admins.php");
     } else {
    //    global $connectingDB;
         $sql="INSERT INTO admins(datetime,username,password,aname,addedby) VALUES(:datetime,:username,:password,:aname,:addedby)";
         $stmt=$connectingDB->prepare($sql);
         $excute= $stmt->execute([
              
             ':datetime'=>$dateTime,
             ':username'=>$username,  
             ':password'=>$password,
             ':aname'=>$name,
             ':addedby'=>$Admin,
         ]);

         if($excute){
            $_SESSION["success"] = "Admin with id :".$connectingDB->lastInsertId()."added success";
            Redirect_to("admins.php");
         }else{
            $_SESSION["error"] = "something wrong";
            Redirect_to("admins.php");
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
    <title>Admin Page</title>
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
                    <h1><i class="fas fa-edit" style="color: #27aae1;"></i>Manage Admins</h1>
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
                <form action="admins.php" method="POST">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="row mb-3">
                                <label for="username"><span class="labelInfo">Username</span></label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <label for="name"><span class="labelInfo">Name</span></label>
                                <input type="text" name="name" id="name" class="form-control">
                                <small class="text-muted">optionl</small>
                            </div>
                            <div class="row mb-3">
                                <label for="password"><span class="labelInfo">Password</span></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="row mb-3">
                                <label for="confirmpassword"><span class="labelInfo">Confirm Password</span></label>
                                <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
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
                <h2>Admin</h2>
                 <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>     
                            <th>Date&Time</th>
                            <th>Username</th>
                            <th>Added by</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php      
                    
                    $sql="SELECT * FROM admins  ORDER BY id desc";
                    $excute=$connectingDB->query($sql);
                    $sr=0;
                    while($dataRow=$excute->fetch()){
                        $adminid=$dataRow["id"];
                        $admindate=$dataRow["datetime"];
                        $adminuname=$dataRow["username"];
                        $adminAuthor=$dataRow["addedby"];
                        $adminname=$dataRow["aname"];
                    
                        $sr++;
                
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $sr  ?></td>
                            <td><?php  echo $admindate ?></td>
                            <td><?php  echo $adminuname ?></td>
                            <td><?php  echo $adminAuthor ?></td>
                            <td><?php  echo $adminname ?></td>
                       
                        <td><a class="btn btn-danger" href="deleteAdmin.php?id=<?php echo $adminid ?>">Delete</a></td>
                      
                        </tr>
                    </tbody>
                    <?php   }?>
                 </table>
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