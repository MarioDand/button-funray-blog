<DOCTYPE html>
    <html>
    <head>
        <style>

            main,header{
                width:60%;
                margin-left: 20%;
                border: 1px solid black;
            }
            main{
                height: 100%;
                display: inline-block;
            }

            header{

                margin-bottom: 15px;
                height: 100px;
            }
        </style>
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
    </body>
    </html>

<?php
include "database.php";
?>