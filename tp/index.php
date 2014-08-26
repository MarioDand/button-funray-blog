<!DOCTYPE html>
<html>
<head>
    <title>БГ-ТАТИ</title>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="Styles/index.css"/>
</head>
<body>
<header>
    <h1><a href="index.php">MY BLOG</a></h1>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="addpost.php">New post</a>
</header>
<main>
    <section>
    <?php
     include "database.php";
    include "header.php";
    
    if(isset($_GET['tag'])){
        $tag = $_GET['tag'];

        if(isset($_GET['page'])){

        $page =$_GET['page'];
            $offset =($page-1)*5;
        $query="SELECT post_id ,post_date,post_desc,post_cont,post_title,post_count, post_tags
        FROM posts WHERE post_tags LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
         ORDER BY post_date DESC LIMIT 5 OFFSET $offset";
        }else{
            $query="SELECT post_id ,post_date,post_desc,post_cont,post_title,post_count, post_tags
        FROM posts WHERE post_tags LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
         ORDER BY post_date DESC LIMIT 5";

        }

    }else{
      if(isset($_GET['page'])){
          $page =$_GET['page'];
          $offset =($page-1)*5;
          $query="SELECT post_id, post_title, post_desc, post_cont, post_date,post_count, post_tags FROM posts WHERE post_date <= now()
ORDER BY post_date DESC  LIMIT 5 OFFSET $offset";
      }else{
        $query="SELECT post_id,post_title, post_desc, post_cont, post_date,post_count, post_tags FROM posts WHERE post_date <= now()
ORDER BY post_date DESC LIMIT 5";
      }



    }
    $sth =  $db->query($query);
    while ($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $title = $row['post_title'];
        $desc = $row['post_desc'];
        $cont = $row['post_cont'];
        $date = $row['post_date'];
        $postId = $row['post_id'];
        $count = $row['post_count'];
        $tagarray = explode(" ",$row['post_tags']);

        echo "<article class='posts'>";
        echo "<p>$count</p>";
        echo "<p><a href='viewpost.php?id=$postId'>$title</a></p>";
        echo "<p>$desc</p>";
        echo "<p>$cont</p>";
        echo "<p>$date</p>";


        foreach($tagarray as $value){
          if(isset($_GET['page'])){
              $page=$_GET['page'];
           echo "<a href='index.php?tag=$value&page=$page'  style='text-decoration:none'>$value</a>";
            echo " ";
          }else{
              echo "<a href='index.php?tag=$value'  style='text-decoration:none'>$value</a>";
              echo " ";
          }
        }
        echo "</article>";
    }
     echo "<div id='pages'>";

    echo "</div>";
     ?>
    </section>
    <aside>
        Most popular tags:<br>
        <?php
        $query="SELECT tag_title, tag_count FROM tags ORDER BY tag_count DESC LIMIT 10";
        $sth =  $db->query($query);
        while ($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
            $title = $row['tag_title'];
            $count = $row['tag_count'];

            ?>
            <a href='index.php?tag=<?=$title?>' style="text-decoration:none;"><?=$title?> (<?=$count?>)</a><br>
        <?php
        }

        ?>
        <form method="get">
            <label for="tag">Search tags:</label><br>
            <input type="text" name="tag" id="tag"><br>
            <input type="submit">
        </form>
    </aside>
</main>
<footer>

</footer>
</body>
</html>