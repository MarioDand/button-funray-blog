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
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$title?></title>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="Styles/viewpost.css"/>
</head>
<body>
<?php
    include "header.php";
?>
<main>
    <section id="blog-post">
        <?php
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
        $user_mail = $_SESSION['user_mail'];

        $userCredentials = true;

        if (!$user_name && !$user_id) {
        ?>

            <label for="user">Author:</label>
            <input type="text" name="user" id="user" placeholder="guest"/>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email"/>
        <?php
            $user_name = trim($_POST['user']);
            $user_mail = trim($_POST['email']);

            $user_id = 0;
            $user_name = 'guest';
        }

        ?>
            <input id="submit" type="submit" value="Submit">

        </form>
        </section>
        <section id="published-comments">
        <?php
        if (isset($comment) && strlen($comment) > 0)
        {
           $sql = "INSERT INTO comments ( comment_content, post_id, user_name, user_mail) VALUES ( '$comment', '$postId', '$user_name', '$user_mail')";

            $query = $db->prepare( $sql );

            $query->execute(array(':comment_content' => $comment, ':post_id' =>$postId, ':user_name' => $user_name, '"user_mail' => $user_mail));

            header('Location: viewpost.php?id='.$postId);
        }


        $query="SELECT comment_content, post_id, user_name, user_mail, comment_date FROM comments ORDER BY comment_id DESC";

        $commentsValues = $db->query($query);

        while ($row = $commentsValues->fetch(PDO::FETCH_ASSOC))
        {

            $dbText = htmlentities($row['comment_content']);
            $dbPostId = $row['post_id'];
            $dbUserName = $row['user_name'];
            $dbUserMail = $row['user_mail'];
            if(!$dbUserMail) {
                $dbUserMail = null;
            }
            else
            {
                $dbUserMail = "($dbUserMail)";
            }
            $dbCommentDate = $row['comment_date'];


            if ($dbPostId == $postId)
            {
            echo "<div class='comment-entry'>";
            echo "<p>Commented by $dbUserName $dbUserMail on $dbCommentDate</p>";
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