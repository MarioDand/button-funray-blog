<!DOCTYPE html>
<html>
<head>
    <title>!!!Post title - to add dynamic title according to the title!!!</title>
    <meta charset="UTF-8">
    <style>



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


        #blog-post{
            border: 1px solid black;
            width: 70%;
            margin: 10px;
            float:left;
            display: inline-block;
        }

        #text-comments, #submit {

            margin-left: 20%;
            margin-bottom: 10px;
            float: left;
            display: inline-block;

            width:50%;
            height:100px;
        }

        .comment-entry {

            margin-left: 20%;
            margin-bottom: 10px;
            float: left;
            display: inline-block;

            width:50%;
            height:100px;
            border: 1px solid grey;
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
    <section id="blog-post">
        <?php
        include "database.php";

        $id = $_GET['id'];

        $query="SELECT post_title, post_desc, post_cont, post_date FROM posts WHERE post_id = $id";

        $sth =  $db->query($query);
        $row = $sth->fetch(PDO::FETCH_ASSOC);

            $title = $row['post_title'];
            $desc = $row['post_desc'];
            $cont = $row['post_cont'];
            $date = $row['post_date'];

            //echo "<div class='posts'>";
            echo "<p>$title</p>";
            echo "<p>$desc</p>";
            echo "<p>$cont</p>";
            echo "<p>$date</p>";
            //echo "</div>";

        ?>
    </section>

    <section id="comments">
        <form action="#" method="post">
            <textarea id="text-comments" name="text-comments" placeholder="enter comments"></textarea><br>
            <input id="submit" type="submit" value="Submit">
        </form>


    <?php
        error_reporting(E_ALL ^ E_NOTICE);
        $comment = trim($_POST['text-comments']);

        if (isset($comment) && strlen($comment) > 0)
        {
            $sql = "INSERT INTO comments ( comment_content, post_id)
                    VALUES ( '$comment', '$id')";

            $query = $db->prepare( $sql );

            $query->execute(array(':comment_content' => $comment));

            header('Location: viewpost.php?id='.$id);
        }

        $query="SELECT comment_content, post_id FROM comments ORDER BY comment_id DESC";

        $commentsValues = $db->query($query);

        while ($row = $commentsValues->fetch(PDO::FETCH_ASSOC))
        {
            $text = $row['comment_content'];
            $postId = $row['post_id'];

            if ($postId == $id)
            {
            echo "<div class='comment-entry'>";
            echo "<p>$text</p>";
            echo "</div>";
            }
        }

    ?>
    </section>
    <aside>
        <p>Sidebar</p>
    </aside>
</main>
<footer>
    <p>Footer</p>
</footer>
</body>
</html>