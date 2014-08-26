<?php
include "database.php";

if (isset($_POST['post_rem'])) {
    $postId = $_POST['post_id'];
    $tagsSql = "SELECT post_tags FROM posts WHERE post_id = '$postId'";
    $sth =  $db->query($tagsSql);
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $tags = $row['post_tags'];

    //$keywords = preg_split("/[ ]+/", "$tags");
    // create PDO instance; assign it to $db variable
    $sql = "DELETE FROM posts WHERE post_id = '$postId'";
    $query = $db->prepare($sql);
    $query->execute(array(':post_id' => $postId));
}
header('Location: index.php');