<?php
include "database.php";

if (isset($_POST['post_rem'])) {
    $postId = $_POST['post_id'];
    // create PDO instance; assign it to $db variable
    $sql = "DELETE FROM posts WHERE post_id = '$postId'";
    $query = $db->prepare($sql);
    $query->execute(array(':post_id' => $postId));
}
header('Location: index.php');