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

        label, input {
            margin-left: 20%;
            margin-bottom: 10px;
            float: left;

            width:40%;

        }

        .comment-entry  {

            margin-left: 20%;
            margin-bottom: 10px;
            float: left;
            display: inline-block;
            padding: 5px;
            width:50%;
            height: auto;
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
    <h1><a href="index.php">MY BLOG</a></h1>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="addpost.php">New post</a>
</header>
<main>
    <section id="blog-post">
        <?php
        include "database.php";

        $postId = $_GET['id'];

        $query="SELECT post_title, post_desc, post_cont, post_date, post_count FROM posts WHERE post_id = '$postId'";

        $sth =  $db->query($query);
        $row = $sth->fetch(PDO::FETCH_ASSOC);

            $title = $row['post_title'];
            $desc = $row['post_desc'];
            $cont = $row['post_cont'];
            $date = $row['post_date'];
            $count = $row['post_count'];

            if(!isset($_COOKIE[$postId])){
                $sqlCount = "UPDATE posts SET post_count = post_count + 1 WHERE post_id = '$postId'";
                $query = $db->prepare($sqlCount);
                $query->execute(array(':post_count' => $count));
                setcookie($postId, 'count',  time()+(3600*24));
            }

            echo "<p>$count</p>";
            echo "<p>$title</p>";
            echo "<p>$desc</p>";
            echo "<p>$cont</p>";
            echo "<p>$date</p>";


        ?>
    </section>

    <section id="post-comments">
        <form action="#" method="post">
            <textarea id="text-comments" name="text-comments" placeholder="enter comments"></textarea>

    <?php
        error_reporting(E_ALL ^ E_NOTICE);
        $comment = trim($_POST['text-comments']);

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];

        if (!$user_name && !$user_id) {
            $user_id = 0;
            $user_name = 'guest';

        ?>

            <label for="user">Author:</label>
            <input type="text" name="user" id="user"/>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email"/>


        <?php
            $user_name = trim($_POST['user']);
            $user_mail = trim($_POST['email']);

           /* $sql = "INSERT INTO users ( user_name, user_mail)VALUES ('$user_name','$user_mail')";

            $query = $db->prepare($sql);

            $query->execute(array(
                ':user_name' => $user_name,
                ':user_mail' => $user_mail
            ));
           */
        }

        ?>
            <input id="submit" type="submit" value="Submit">
        </form>
        </section>
        <section id="published-comments">
        <?php
        if (isset($comment) && strlen($comment) > 0)
        {
           $sql = "INSERT INTO comments ( comment_content, post_id, user_name) VALUES ( '$comment', '$postId', '$user_name')";

            $query = $db->prepare( $sql );

            $query->execute(array(':comment_content' => $comment, ':post_id' =>$postId, ':user_name' => $user_name));

            header('Location: viewpost.php?id='.$postId);
        }


        $query="SELECT comment_content, post_id, user_name, comment_date FROM comments ORDER BY comment_id DESC";

        $commentsValues = $db->query($query);

        while ($row = $commentsValues->fetch(PDO::FETCH_ASSOC))
        {

            $dbText = htmlentities($row['comment_content']);
            $dbPostId = $row['post_id'];
            $dbUserName = $row['user_name'];
            $dbCommentDate = $row['comment_date'];

            if ($dbPostId == $postId)
            {
            echo "<div class='comment-entry'>";
            echo "<p>Commented by $dbUserName on $dbCommentDate</p>";
            echo "<p>$dbText</p>";
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