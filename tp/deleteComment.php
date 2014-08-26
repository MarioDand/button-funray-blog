<?php
include "database.php";
$post =  $_POST['post_id'];

if (isset($_POST['comm_rem'])) {
    $commId = $_POST['comment_id'];
    // create PDO instance; assign it to $db variable
    $sql = "DELETE FROM comments WHERE comment_id = '$commId'";
    $query = $db->prepare($sql);
    $query->execute(array(':comment_id' => $commId));
}
header('Location: viewpost.php?id='.$post);
