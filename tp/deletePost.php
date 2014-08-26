<?php
include "database.php";

if (isset($_POST['post_rem'])) {
    $postId = $_POST['post_id'];
    $tagsSql = "SELECT post_tags FROM posts WHERE post_id = '$postId'";
    $sth =  $db->query($tagsSql);
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $tags = $row['post_tags'];

    $keywords = explode(" ", trim($tags));

    for($i = 0; $i < count($keywords); $i++){
        $currTag = $keywords[$i];
        $currTagSql = "UPDATE tags SET tag_count = tag_count - 1 WHERE tag_title = '$currTag'";
        $query = $db->prepare($currTagSql);
        $query->execute(array(':tag_count' => tag_count - 1));

    }

    // create PDO instance; assign it to $db variable
    $sql = "DELETE FROM posts WHERE post_id = '$postId'";
    $query = $db->prepare($sql);
    $query->execute(array(':post_id' => $postId));
}
header('Location: index.php');