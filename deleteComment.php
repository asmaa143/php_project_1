<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>
<?php  

if(isset($_GET["id"])){

    $searchQueryParam=$_GET["id"];
  
    $sql="DELETE FROM  comments  WHERE id='$searchQueryParam'";
    
    $excute=$connectingDB->query($sql);
    
    if($excute){
        $_SESSION["success"] = "Comments Deleted";
        Redirect_to("comments.php");
    
    }else{
        $_SESSION["error"] = "Error";
        Redirect_to("comments.php");
    }
    
    
    
    
    }




?>