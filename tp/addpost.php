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
    <input type="text" name="tags" placeholder="Tags"> <br>
    <input type="submit" value="Post">
</form>

<?php
include "database.php";


class Post
{
    public  $title;
    public  $desc;
    public  $content;
    public $date;
    public $tags;
}

if($_POST && isset($_POST["title"]) && isset($_POST["desc"])&& isset($_POST["content"])&& isset($_POST["tags"])){



    $post = new Post;
    $post->title =  htmlentities($_POST['title']);
    $post->desc =  htmlentities($_POST['desc']);
    $post->content =  htmlentities($_POST['content']);

    $post->date =   date('Y-m-d H:i:s');

    $post->tags= trim($_POST['tags']); //string of tags
    $exploded= explode(" ",$post->tags); // array of tags
    $exploded= array_unique($exploded);//unique array of tags
    $post->tags = " ".implode(" ",$exploded);

    $sql = "INSERT INTO posts( post_title, post_desc, post_cont, post_date,post_tags )
  VALUES ( '$post->title','$post->desc',  '$post->content','$post->date','$post->tags')";

    $query = $db->prepare( $sql );

    $query->execute(array(
        ':post_title' => $post->title,
        ':post_desc' => $post->desc,
        ':post_content' => $post->content,
        ':post_date' => $post->date,
        ':post_tags' => $post->tags
    ));





foreach($exploded as $tag){

    $sql = "INSERT INTO tags (tag_title) VALUES ('$tag') ON DUPLICATE KEY UPDATE tag_count=tag_count+1" ;
    $query = $db->prepare( $sql );

    $query->execute(array(
        ':tag_title' => $tag
    ));
}



  header('Location: index.php?action=updated');

}
?>
</body>
</html>

