<?php
    include "database.php";
    include "header.php";
    include "library.php";
    error_reporting(E_ALL ^ E_NOTICE);

    $postId = $_GET['id'];

    $query="SELECT post_title, post_desc, post_cont, post_date, post_count FROM posts WHERE post_id = '$postId'";

    $sth =  $db->query($query);
    $row = $sth->fetch(PDO::FETCH_ASSOC);

    $title = html_entity_decode($row['post_title']);
    $desc = html_entity_decode($row['post_desc']);

    $cont = html_entity_decode(nl2br($row['post_cont']));
    $date = $row['post_date'];
    $count = $row['post_count'];
?>
<?php

?>

<main>
    <section class="viewpost">
        <?php
            if(!isset($_COOKIE[$postId])){
                $sqlCount = "UPDATE posts SET post_count = post_count + 1 WHERE post_id = '$postId'";
                $query = $db->prepare($sqlCount);
                $query->execute(array(':post_count' => $count));
                setcookie($postId, 'count',  time()+(3600*24));
            }

            echo "<div class='innerArticle clearfix'>";
            echo "<p class='postTitle'>$title</p>";
            echo "<p><strong>$desc</strong></p>";
            echo "<p>$cont</p>";
            echo "<p>$date</p>";
            echo "<p><em>Views: $count</em></p>";
            echo "</div>";

        if(isset($_SESSION['user_name']) && $_SESSION['user_name'] &&($_SESSION['user_rights']==='admin')):
            ?>
            <form action="deletePost.php" method="post">
                <input type="hidden" name="post_id" value="<?php echo $postId ?>" />
                <input type="submit" name="post_rem" value="Delete" />
            </form>
        <?php
        endif;
        ?>
    </section>

    <section id="post-comments">
        <form action="#" method="post">
            <textarea id="text-comments" class="comment-input" name="text-comments" placeholder="enter comments"></textarea>

    <?php
        error_reporting(E_ALL ^ E_NOTICE);
        $comment = trim($_POST['text-comments']);
        $comment = htmlentities($comment);
        $comment = addslashes($comment);

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $user_mail = $_SESSION['user_mail'];

        $userCredentials = true;

        if (!$user_name && !$user_id) {
        ?>
            <label for="user" class="comment-input">Author:</label>
            <input type="text" class="comment-input" name="user" id="user" placeholder="guest"/>
            <label for="email" class="comment-input">E-mail:</label>
            <input type="email" class="comment-input" name="email" id="email"/>


            <?php
            $user_name = addslashes(trim($_POST['user']));
            $user_mail = addslashes(trim($_POST['email']));

            $user_id = 0;
            if (!$user_name){
                $user_name = 'guest';
            }
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

        $query="SELECT comment_content, post_id, user_name, comment_date, comment_id FROM comments ORDER BY comment_id DESC";

        $commentsValues = $db->query($query);

        while ($row = $commentsValues->fetch(PDO::FETCH_ASSOC))
        {
            $commentId = $row['comment_id'];
            $dbText = html_entity_decode($row['comment_content']);
            $dbPostId = $row['post_id'];
            $dbUserName = htmlentities($row['user_name']);
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
            echo "<p><em>Commented by $dbUserName $dbUserMail on $dbCommentDate</em></p>";
            echo "<p>$dbText</p>";
            echo "</div>";

            if(isset($_SESSION['user_name']) && $_SESSION['user_name'] &&($_SESSION['user_rights']==='admin')):
                ?>
                <form action="deleteComment.php" method="post">
                    <input type="hidden" name="comment_id" value="<?php echo $commentId ?>" />
                    <input type="hidden" name="post_id" value="<?php echo $postId ?>" />
                    <input type="submit" name="comm_rem" value="Delete" />
                </form>
            <?php
            endif;

            }
        }

    ?>
    </section>
<?php
include "aside.php";
?>
</main>
<?php
include "footer.php";
?>