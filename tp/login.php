<?php

include "database.php";
include "header.php";

?>
        <form method="post">
            <label for="user"class="login">Log in:</label>
            <input type="text" class="login" name="user" placeholder="Username"/>
            <input type="password" class="login" name="pass" placeholder="Password"/>
            <input type="submit" class="login">
        </form>

<?php

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_POST['user']) && isset($_POST['pass'])) {

    $Name = htmlentities(trim($_POST['user']));
    $Password = htmlentities(trim($_POST['pass']));

    if (($Name !== '') && ($Password !== '')) {

        $query = "SELECT * FROM users where user_name = '$Name'";
        $sth = $db->query($query);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        $checkPass = crypt($Password, $row['user_pass']);

        if (($checkPass === $row['user_pass']) && (($row['user_name'] !== '' && $row['user_pass'] !== ''))) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_mail'] = $row['user_mail'];
            $_SESSION['user_rights'] = $row['user_rights'];

            header('Location: index.php');
        } else {
            echo "Sorry... You entered wrong Username or Password... Please retry...";
        }
    }
}
include "footer.php";