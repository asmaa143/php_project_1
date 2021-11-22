<?php

require_once("includes/functions.php");
require_once("includes/sessions.php");

?>

<?php

$_SESSION["user_id"]=null;
$_SESSION["username"]=null;
$_SESSION["admin_name"]=null;

session_destroy();

Redirect_to("login.php")



?>