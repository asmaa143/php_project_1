<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>
<?php

if(isset($_SESSION["user_id"])){
    Redirect_to("blog.php");
}


if(isset($_POST["Submit"])){
    $username=$_POST["username"];
    $password=$_POST["password"];

    if(empty($password)||empty($username)){
        $_SESSION["error"]="field is require";
        Redirect_to("login.php");
    }else{
       $found_account=login($username,$password);
       if($found_account){
        $_SESSION["user_id"]=$found_account["id"];
        $_SESSION["username"]=$found_account["username"];
        $_SESSION["admin_name"]=$found_account["aname"];
        $_SESSION["success"]="Welcome ".$_SESSION["username"];
        if(isset($_SESSION["trackingUrl"])){
            Redirect_to($_SESSION["trackingUrl"]);
        }else{
            Redirect_to("post.php");
        }
     
       }else{
        $_SESSION["error"]="Incorrect username/password";
        Redirect_to("login.php");
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
    <title>Login</title>
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
              
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>


    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                
                </div>
            </div>
        </div>
    </header>
    

    <section class="container py-2 mb-4">
        <div class="row">
            <div style="min-height: 500px;" class="col-sm-6 offset-sm-3">
            <?php
                echo errorMessage();
                echo successMessage();
                ?>
                  <div class="card bg-secondary text-light">
                     <div class="card-header">
                         <h4>Welcome</h4>
                     </div>
                     <div class="card-body bg-dark">
                             <form method="post" action="login.php">
                                  <div class="row mb-3">
                                       <label for="username"><span class="labelInfo">Username:</span></label>
                                       <div class="input-group mb-3">
                                            <span class="input-group-text bg-info">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" name="username" class="form-control">
                                       </div>
                                  </div>
                                  <div class="row mb-3">
                                       <label for="username"><span class="labelInfo">Password:</span></label>
                                       <div class="input-group mb-3">
                                            <span class="input-group-text bg-info">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control">
                                       </div>
                                  </div>
                                  <div class="d-grid">
                                        <input type="submit" name="Submit" class="btn btn-info" value="Login">
                                  </div>
                             </form>
                     </div>
                  </div>
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