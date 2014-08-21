<!DOCTYPE html>
<html>
<head>
    <title>!!!Post title - to add dynamic title according to the title!!!</title>
    <meta charset="UTF-8">
    <style>

        div{
            border: 1px solid black;
            width: 70%;
            margin: 10px;
            float:left;
            display: inline-block;
        }

        main,header{
            width: 60%;
            margin-left: 20%;
        }
        main{
            min-height: 300px;
        }
        header{
            border: 1px solid black;
            margin-bottom: 15px;
            height: 100px;
        }
        footer{
            margin-top: 15px;
            height: 50px;
            margin-left: 20%;
            width: 60%;
            border: 1px solid black;
            display: inline-block;
        }
        aside{
            height: 100%;
            width: 24%;
            display: inline-block;
            margin-top: 10px;
            margin-left: 10px;
            min-height: 275px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<header>
    <h1>MY BLOG</h1>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="addpost.php">New post</a>
</header>
<main>
    <section>
        <?php
        include "database.php";

        $id = $_GET['id'];
        echo $id."<br>";
        $query="SELECT post_title, post_desc, post_cont, post_date FROM posts WHERE post_id = $id";

        $sth =  $db->query($query);
        $row = $sth->fetch(PDO::FETCH_ASSOC);

            $title = $row['post_title'];
            $desc = $row['post_desc'];
            $cont = $row['post_cont'];
            $date = $row['post_date'];

            echo "<div class='posts'>";
            echo "<p>$title</p>";
            echo "<p>$desc</p>";
            echo "<p>$cont</p>";
            echo "<p>$date</p>";
            echo "</div>";

        ?>
    </section>
    <aside>

    </aside>
</main>
<footer>

</footer>
</body>
</html>