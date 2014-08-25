<!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
    </head>
    <body>
    <fieldset style="width: 30%">
        <form method="post">
            <input type="text" name="user" placeholder="Username"/><br>
            <input type="password" name="pass" placeholder="Password"/><br>
            <input type="submit">
        </form>
    </fieldset>
    </body>
    <head>

    </head>
    </html>


<?php
include "database.php";


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['user']) && isset($_POST['pass'])) {

    $Name = htmlentities(trim($_POST['user']));
    $Password = htmlentities(trim($_POST['pass']));

    if (($Name !== '') && ($Password !== '')) {

        $query = "SELECT user_id, user_name, user_mail, user_pass FROM users where user_name = '$Name'";
        $sth = $db->query($query);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $checkPass = crypt($Password, $row['user_pass']);

        if (($checkPass === $row['user_pass']) && (($row['user_name'] !== '' && $row['user_pass'] !== ''))) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_mail'] = $row['user_mail'];

            echo "Successfully login";
            header('Location: index.php');
        } else {
            echo "Sorry... You entered wrong Username or Password... Please retry...";
        }
    }
}
