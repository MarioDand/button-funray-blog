<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="post">
    <input type="text" name="name" required="required"/> Username <br>
    <input type="password" name="pass" required="required"/> Password <br>
    <input type='password' name='confPass' required="required"/> Confirm password <br>
    <input type="email" name="email" required="required"/> E-mail <br>
    <input type="submit" value="Register" required="required"/>
</form>

<?php
include "database.php";

class User
{
    public $name;
    public $pass;
    public $confPass;
    public $email;
    public $right;
}

if ($_POST && isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["confPass"]) && isset($_POST["email"])) {
    $validateForm = true;
    $namePattern = "/^[A-Za-z1-9]{5,}$/";
    $passPattern = "/^.{5,}$/";

    $InputedName = $_POST["name"];
    $InputedMail = strtolower($_POST["email"]);

    $checkUserExist = "SELECT user_name FROM users where user_name = '$InputedName'";
    $checkEmailExist = "SELECT user_mail FROM users where user_mail = '$InputedMail'";

    $sthUser = $db->query($checkUserExist);
    $sthEmail = $db->query($checkEmailExist);

    $rowUser = $sthUser->fetch(PDO::FETCH_ASSOC);
    $rowEmail = $sthEmail->fetch(PDO::FETCH_ASSOC);

    if ($rowUser['user_name']) {
        echo "Username already exists <br>";
        $validateForm = false;
    }

    if ($rowEmail['user_mail']) {

        echo "Email address already exists <br>";
        $validateForm = false;
    }

    if (!preg_match($namePattern, $_POST['name'])) {
        echo "Enter correct name <br>";
        $validateForm = false;
    }

    if ($_POST["pass"] !== $_POST["confPass"]) {
        echo "Password don't match <br>";
        $validateForm = false;
    }

    if (!preg_match($passPattern, $_POST['pass'])) {
        echo "The password must be at least 5 characters <br>";
        $validateForm = false;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Enter valid a email <br>";
        $validateForm = false;
    }

    if ($validateForm === false) die();

    $hashed = create_hash($_POST['pass']);
    echo $hashed . "<br>";

    $user = new User;
    $user->name = htmlentities($_POST['name']);
    $user->pass = $hashed;
    $user->confPass = htmlentities($_POST['confPass']);
    $user->email = htmlentities(strtolower($_POST['email']));
    $user->right = 'user';

    $sql = "INSERT INTO users
 ( user_name, user_pass, user_mail, user_rights )
  VALUES ('$user->name','$user->pass','$user->email','$user->right')";

    $query = $db->prepare($sql);

    $query->execute(array(
        ':user_name' => $user->name,
        ':user_pass' => $user->pass,
        ':user_mail' => $user->email,
        ':user_rights' => $user->right
    ));

    if ($validateForm === true) {
        header('Location: index.php');
    }
}
?>
</body>
</html>

