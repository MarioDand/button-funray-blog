<?php

include "database.php";
if(!isset($_SESSION['user_rights']) || $_SESSION['user_rights'] !== 'admin'){
    header('Location: index.php');
    die('ACCESS DENIED');
}
include "header.php";
include "library.php";
?>

<form method="post">
    <input type="text" class="inputs" name="title" placeholder="Post title" required>
    <input type="text"  class="inputs" name="desc" placeholder="Post desc">
    <textarea name="content"  class="inputs" placeholder="Your post" required></textarea>
    <input type="text"  class="inputs" name="tags" placeholder="Tags">
    <input type="submit"  class="inputs" value="Post">
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
    $post->title =  addslashes(htmlentities($_POST['title']));
    $post->desc =  addslashes(htmlentities($_POST['desc']));
    $post->content =  addslashes($_POST['content']);

    $post->date =   date('Y-m-d H:i:s');

    $post->tags= $_POST['tags'];
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
include "footer.php";
?>
