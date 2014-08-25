<!DOCTYPE html>
<html>
<head>
    <title>My blog</title>
    <meta charset="UTF-8">
    <style>



        main,header{
            width: 60%;
            margin-left: 20%;
            border: 1px solid black;
        }
        main{
           height: 100%;
            display: inline-block;
        }
        header{

           margin-bottom: 15px;
            height: 100px;
        }
        footer{
            margin-top: 15px;
            height: 50px;
            margin-left: 20%;
            width: 60%;
            border: 1px solid black;
            display: inline-block;
        }
        aside{
            display: inline-block;
            width: 20%;
           top:15px;
            bottom:0;
            height: 200px;


            margin:2%;
margin-top: 10px;
            border: 1px solid black;
        }
        .posts{
            border: 1px solid black;
            width: 70%;

            margin: 2%;
            margin-top: 10px;
            float:left;
            display: inline-block;
        }
    </style>
</head>
<body>
<header>
    <h1>MY BLOG</h1>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="addpost.php">New post</a>
</header>
<main>
    <section>
    <?php
     include "database.php";

    if(isset($_GET['tag'])){
        $tag = $_GET['tag'];

        $query="SELECT post_id ,post_date,post_desc,post_cont,post_title, post_tags
        FROM posts WHERE (post_tags)LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag' ORDER BY post_date DESC, post_date DESC ";


    }else{

    $query="SELECT post_title, post_desc, post_cont, post_date,post_id,post_count, post_tags FROM posts WHERE post_date <= now()
ORDER BY post_date DESC, post_date DESC";
    }
    $sth =  $db->query($query);
    while ($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        $title = $row['post_title'];
        $desc = $row['post_desc'];
        $cont = $row['post_cont'];
        $date = $row['post_date'];
		$postId = $row['post_id'];
        $postCount = $row['post_count'];
        $tagarray = explode(" ",$row['post_tags']);

        echo "<article class='posts'>";
        echo "<p>$postCount</p>";
        echo "<p><a href='viewpost.php?id=$postId'>$title</a></p>";
        echo "<p>$desc</p>";
        echo "<p>$cont</p>";
        echo "<p>$date</p>";


        foreach($tagarray as $value){

           echo "<a href='index.php?tag=$value' style='text-decoration:none'>$value</a>";
            echo " ";

        }
        echo "</article>";
    }


     ?>
    </section>
    <aside>
        Most popular tags:<br>
        <?php
        $query="SELECT tag_title, tag_count FROM tags ORDER BY tag_count DESC";
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
    </aside>
</main>
<footer>

</footer>
</body>
</html>