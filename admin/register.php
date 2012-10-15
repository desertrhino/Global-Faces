<?
session_start(); 
require_once('../includes/config.php');

/**
 * Returns true if the username has been taken
 * by another user, false otherwise.
 */
function usernameTaken($username){
   global $connect;
   if(!get_magic_quotes_gpc()){
      $username = addslashes($username);
   }
   $q = "select username from tblContacts where username = '$username'";
   $result = mysql_query($q, $connect);
   return (mysql_num_rows($result) > 0);
}

/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $password){
   global $connect;
   $q = "INSERT INTO tblContacts (username, password) VALUES ('$username', '$password')";
   /* $q = "INSERT INTO tblContacts (Name_Last, Name_First, HomeNo, WorkNo, MobNo, Email, username, password) VALUES ('$Name_Last', '$Name_First', '$HomeNo', '$WorkNo', '$MobNo', '$Email', '$username', '$password')";*/
   return mysql_query($q, $connect);
}

/**
 * Displays the appropriate message to the user
 * after the registration attempt. It displays a 
 * success or failure status depending on a
 * session variable set during registration.
 */
function displayStatus(){
   $uname = $_SESSION['reguname'];
   if($_SESSION['regresult']){
?>

<h1>Registered!</h1>
<p>Thank you <b><? echo $uname; ?></b>, your information has been added to the database, you may now <a href="index.php" >log in</a>.</p>

<?
   }
   else{
?>

<h1>Registration Failed</h1>
<p>We're sorry, but an error has occurred and your registration for the username <b><? echo $uname; ?></b>, could not be completed.<br>
Please try again at a later time.</p>

<?
   }
   unset($_SESSION['reguname']);
   unset($_SESSION['registered']);
   unset($_SESSION['regresult']);
}

if(isset($_SESSION['registered'])){
/**
 * This is the page that will be displayed after the
 * registration has been attempted.
 */
?>

<html>
<title>Registration Page</title>
<body>
<? displayStatus(); ?>
</body>
</html>

<?
   return;
}

/**
 * Determines whether or not to show to sign-up form
 * based on whether the form has been submitted, if it
 * has, check the database for consistency and create
 * the new account.
 */
if(isset($_POST['subjoin'])){
   /* Make sure all fields were entered */
   if(!$_POST['user'] || !$_POST['pass']){
      die('You didn\'t fill in a required field.');
   }

   /* Spruce up username, check length */
   $_POST['user'] = trim($_POST['user']);
   if(strlen($_POST['user']) > 30){
      die("Sorry, the username is longer than 30 characters, please shorten it.");
   }

   /* Check if username is already in use */
   if(usernameTaken($_POST['user'])){
      $use = $_POST['user'];
      die("Sorry, the username: <strong>$use</strong> is already taken, please pick another one.");
   }

   /* Add the new account to the database */
   $md5pass = md5($_POST['pass']);
   $_SESSION['reguname'] = $_POST['user'];
   $_SESSION['regresult'] = addNewUser($_POST['user'], $md5pass);
   $_SESSION['registered'] = true;
   echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
   return;
}
else{
/**
 * This is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
?>

<html>
<title>Registration Page</title>
<body>
<h1>Register</h1>
<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><input type="text" name="user" maxlength="30"></td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30"></td></tr>
<!--
<tr><td>First Name:</td><td><input type="text" name="Name_First" maxlength="50"></td></tr>
<tr><td>Last Name:</td><td><input type="text" name="Name_Last" maxlength="50"></td></tr>
<tr><td>Home Phone:</td><td><input type="text" name="HomeNo" maxlength="11"></td></tr>
<tr><td>Work Phone:</td><td><input type="text" name="WorkNo" maxlength="11"></td></tr>
<tr><td>Mobile Phone:</td><td><input type="text" name="MobNo" maxlength="11"></td></tr>
<tr><td>Email:</td><td><input type="text" name="Email" maxlength="50"></td></tr>
!-->
<tr><td colspan="2" align="right"><input type="submit" name="subjoin" value="Join!"></td></tr>
</table>
</form>
</body>
</html>


<?
}
?>