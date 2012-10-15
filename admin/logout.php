<?
session_start(); 
include("../includes/config.php");
include("login.php");
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   setcookie("cookname", "", time()-60*60*24*100, "/");
   setcookie("cookpass", "", time()-60*60*24*100, "/");
}
if(!$logged_in){
   header( 'Location: ../' ) ;
}
else
{
   /* Kill session variables */
   unset($_SESSION['username']);
   unset($_SESSION['password']);
   $_SESSION = array(); // reset session array
   session_destroy();   // destroy session.
   header( 'Location: ../' ) ;
}
?>