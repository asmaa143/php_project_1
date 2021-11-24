<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php  
if(isset($_GET["id"])){

$searchQueryParam=$_GET["id"];


$sql="DELETE FROM category  WHERE id='$searchQueryParam'";

$excute=$connectingDB->query($sql);

if($excute){
    $_SESSION["success"] = "Deleted Success";
    Redirect_to("categories.php");

}else{
    $_SESSION["error"] = "Error";
    Redirect_to("categories.php");
}




}