<!DOCTYPE html>
    <html>
    <head>
        <link type="text/css" rel="stylesheet" href="Styles/index.css">
    </head>
    <body>
    <header>
        <h1><a href="index.php">BLOG</a></h1>

        <?php if(isset($_SESSION['user_name']) && $_SESSION['user_name'] &&($_SESSION['user_rights']==='user')){
?>
        <a>Hello <?php echo $_SESSION['user_name']; ?> </a>
            <a href="logout.php">Log out</a>
        <?php }elseif(isset($_SESSION['user_name']) && $_SESSION['user_name']&&($_SESSION['user_rights']==='admin')){
            ?>
            <a>Hello <?php echo $_SESSION['user_name']; ?> </a>
            <a href="addpost.php">Add post</a>
            <a href="logout.php">Log out</a>
        <?php
        }else{
            ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a>Hello Guest </a>
                <?php
        }
        ?>
    </header>

<?php
include "database.php";
?>