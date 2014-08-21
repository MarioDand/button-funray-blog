<DOCTYPE html>
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


if(isset($_POST['user'])&&isset($_POST['pass'])){

    $Name = htmlentities($_POST['user']);
    $Password = htmlentities($_POST['pass']);

    if (($Name !== '') && ($Password !== '')) {

        $query = "SELECT user_name, user_pass FROM users where user_name = '$Name' AND user_pass = '$Password'";

        $sth = $db->query($query);

        $row = $sth->fetch(PDO::FETCH_ASSOC);
        var_dump($row);

        if($row['user_name']!== '' AND $row['user_pass']!== ''){

            $_SESSION['user_name'] = $row['user_pass'];
            echo "Successfully login";
        }


    } else {
        echo "Sorry... You entered wrong Username or Password... Please retry...";
    }
}
