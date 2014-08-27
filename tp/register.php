<?php
include "database.php";
include "header.php";
?>
<form method="post">
    <label for="username" class="register">Username: </label>
    <input type="text" class="register" id="username" name="name" required="required"/>

    <label for="pass" class="register">Password: </label>
    <input type="password" class="register" id="pass" name="pass" required="required"/>

    <label for="confirm" class="register">Confirm Password:</label>
    <input type='password' class="register" id="confirm" name='confPass' required="required"/>

    <label for="email" class="register">Email: </label>
    <input type="email" class="register" id="email" name="email" required="required"/>
    <input type="submit" class="register" value="Register" required="required"/>
</form>

<?php

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
        echo "Username already exists ";
        $validateForm = false;
    }

    if ($rowEmail['user_mail']) {

        echo "Email address already exists ";
        $validateForm = false;
    }

    if (!preg_match($namePattern, $_POST['name'])) {
        echo "Enter correct name ";
        $validateForm = false;
    }

    if ($_POST["pass"] !== $_POST["confPass"]) {
        echo "Password don't match ";
        $validateForm = false;
    }

    if (!preg_match($passPattern, $_POST['pass'])) {
        echo "The password must be at least 5 characters ";
        $validateForm = false;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Enter valid a email ";
        $validateForm = false;
    }

    if ($validateForm === false) die();

    $hashed = create_hash($_POST['pass']);

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

<?php
function create_hash($value)
{
    return $hash = crypt($value, '$2a$12$'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
}
include "footer.php"
?>
