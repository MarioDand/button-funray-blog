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
ob_start();
session_start();
class User
{
    public $id;
    public $name;
    public $pass;
    public $email;
    public $right;

    function __construct()
    {
        $this->id = 123;
        $this->name = $_POST["name"];
        $this->pass = $_POST["pass"];;
        $this->right="user";

    }


}

if($_POST && isset($_POST["name"]) && isset($_POST["pass"])){
$p = new User;

}
?>
</body>
</html>

