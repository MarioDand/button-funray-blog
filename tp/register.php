<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="post">
    <input type="text" name="name"> Username <br>
    <input type="password" name="pass"> Password <br>
    <input type="email" name="email"> E-mail <br>
    <input type="submit" value="Register">
</form>

<?php
include "database.php";
session_start();

class User
{
    public  $name;
    public  $pass;
    public  $email;
    public  $right;
}

if($_POST && isset($_POST["name"]) && isset($_POST["pass"])&& isset($_POST["email"])){



    $user = new User;
    $user->name =  htmlentities($_POST['name']);
    $user->pass =  htmlentities($_POST['pass']);
    $user->email =  htmlentities($_POST['email']);
    $user->right =  'user';



    $sql = "INSERT INTO user
 ( user_name, user_pass, user_mail, user_rights )
  VALUES ( '$user->name','$user->pass',  '$user->email','$user->right' )";


    $query = $db->prepare( $sql );

    $query->execute(array(
        ':user_name' => $user->name,
        ':user_pass' => $user->pass,
        ':user_mail' => $user->email,
        ':user_rights' => $user->right
    ));



}
?>
</body>
</html>

