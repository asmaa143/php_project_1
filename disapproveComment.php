<?php
require_once("includes/db.php");
require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php  
if(isset($_GET["id"])){

$searchQueryParam=$_GET["id"];
$admin=$_SESSION["username"];

$sql="UPDATE comments SET status='off',approvedBy='$admin' WHERE id='$searchQueryParam'";

$excute=$connectingDB->query($sql);

if($excute){
    $_SESSION["success"] = "Status Updated";
    Redirect_to("comments.php");

}else{
    $_SESSION["error"] = "Error";
    Redirect_to("comments.php");
}




}













?>