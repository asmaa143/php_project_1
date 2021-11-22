
<?php require_once("includes/db.php");?>
<?php  

function Redirect_to($new_location){
   header("Location:$new_location");
   exit;
}

function checkUsernameExists($username){
  
   global $connectingDB;
   $sql="SELECT username FROM admins WHERE username=:username";
   $stmt=$connectingDB->prepare($sql);
   $stmt->execute([
      ":username"=>$username,

   ]);
   $result=$stmt->rowCount();
  if($result==1){
     return true;
  }else{
     return false;
  }

   
}


function login($username,$password){
   global $connectingDB;
   $sql="SELECT * FROM admins WHERE username=:username AND password=:password LIMIT 1";
   $stmt=$connectingDB->prepare($sql);
   $stmt->execute([
       ":username"=>$username,
       ":password"=>$password,
   ]);

   $result=$stmt->rowCount();
   if($result==1){
      return $found_account=$stmt->fetch();
   }else{
       return null;
   }
}


function confirmLogin(){
   if(isset($_SESSION["user_id"])){
      return true;
   }else{
      $_SESSION["error"]="Login required";
      Redirect_to("login.php");
   }
}







?>