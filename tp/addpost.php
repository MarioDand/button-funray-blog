<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form method="post">
    <input type="text" name="title" placeholder="Post title">  <br>
    <input type="text" name="desc" placeholder="Post desc">  <br>
    <textarea name="content" placeholder="Your post"></textarea> <br>
    <input type="submit" value="Post">
</form>

<?php
include "database.php";
date_default_timezone_get();
session_start();

class Post
{
    public  $title;
    public  $desc;
    public  $content;
    public $date;
}

if($_POST && isset($_POST["title"]) && isset($_POST["desc"])&& isset($_POST["content"])){



    $post = new Post;
    $post->title =  htmlentities($_POST['title']);
    $post->desc =  htmlentities($_POST['desc']);
    $post->content =  htmlentities($_POST['content']);
    $post->date =   date('Y-m-d H:i:s');



    $sql = "INSERT INTO posts
 ( post_title, post_desc, post_cont, post_date )
  VALUES ( '$post->title','$post->desc',  '$post->content','$post->date' )";


    $query = $db->prepare( $sql );

    $query->execute(array(
        ':post_title' => $post->title,
        ':post_desc' => $post->desc,
        ':post_content' => $post->content,
        ':post_date' => $post->date
    ));



}
?>
</body>
</html>

