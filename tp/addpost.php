<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

include "database.php";
if(!isset($_SESSION['user_rights']) || $_SESSION['user_rights'] !== 'admin'){
    header('Location: index.php');
    die('ACCESS DIEND');
}

?>
<form method="post">
    <input type="text" name="title" placeholder="Post title">  <br>
    <input type="text" name="desc" placeholder="Post desc">  <br>
    <textarea name="content" placeholder="Your post"></textarea> <br>
    <input type="text" name="tags" placeholder="Tags"> <br>
    <input type="submit" value="Post">
</form>

<?php

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
    $post->title =  mysql_real_escape_string(htmlspecialchars($_POST['title']));
    $post->desc =  mysql_real_escape_string(htmlspecialchars($_POST['desc']));
    $post->content =  mysql_real_escape_string(htmlspecialchars($_POST['content']));

    $post->date =   date('Y-m-d H:i:s');

    $post->tags= mysql_real_escape_string(htmlspecialchars($_POST['tags']));
    $exploded= explode(" ",$post->tags);
    $exploded= array_unique($exploded);
    $post->tags = " ".$post->tags;

    $sql = "INSERT INTO posts
 ( post_title, post_desc, post_cont, post_date,post_tags )
  VALUES ( '$post->title','$post->desc',  '$post->content','$post->date','$post->tags')";

    $query = $db->prepare( $sql );

    $query->execute(array(
        ':post_title' => $post->title,
        ':post_desc' => $post->desc,
        ':post_content' => $post->content,
        ':post_date' => $post->date,
        ':post_tags' => $post->tags
    ));




    for($i=0;$i<count($exploded);$i++){

        $sql = "INSERT INTO tags ( tag_title) VALUES ( '$exploded[$i]') ON DUPLICATE KEY UPDATE tag_count=tag_count+1" ;
        $query = $db->prepare( $sql );

        $query->execute(array(
            ':tag_title' => $exploded[$i]
        ));
    }

  header('Location: index.php');

}
?>
</body>
</html>

