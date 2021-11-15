<?php   
  
  session_start();


  function errorMessage(){
      if(isset($_SESSION["error"])){
        $output="<div class=\"alert alert-danger\">";
        $output .=htmlentities($_SESSION["error"]);
        $output .="</div>";
        $_SESSION["error"]=null;
        return $output;
      }
        
  }


  function successMessage(){
   if(isset($_SESSION["success"])){
    $output="<div class=\"alert alert-success\">";
    $output .=htmlentities($_SESSION["success"]);
    $output .="</div>";
    $_SESSION["success"]=null;
    return $output;
   }
}





?>