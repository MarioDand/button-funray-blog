<?php
include "database.php";
include "header.php";
?>
<main>
<section class="articlesSection clearfix">
    <?php
    //-----------------------------------QUERIES-----------------------------------------------
    if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];

        if (isset($_GET['page'])) {
            $offset = ($_GET['page'] - 1) * 5;
        } else {
            $offset = 0;
        }
        $testoff = $offset + 6;
        $query = "SELECT * FROM posts WHERE post_tags
     LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
         ORDER BY post_date DESC LIMIT $offset,5";
        $checkquery = "SELECT * FROM posts WHERE post_tags
     LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
         ORDER BY post_date DESC LIMIT $testoff,1";

    } else {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $offset = ($page - 1) * 5;
        } else {
            $offset = 0;
        }
        $testoff = $offset + 6;
        $query = "SELECT * FROM posts ORDER BY post_date DESC LIMIT $offset,5";
        $checkquery = "SELECT * FROM posts ORDER BY post_date DESC LIMIT $testoff,1";
    }
    //-----------------------------------QUERIES-------------------------------------------------

    $postcount = 0;

    $sth = $db->query($query);
    $check = $db->query($checkquery);
    //------------------------ECHO POSTS------------------------------------------------------------
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $title = html_entity_decode($row['post_title']);
        $desc = html_entity_decode($row['post_desc']);
        $cont = html_entity_decode($row['post_cont']);
        $date = $row['post_date'];
        $postId = $row['post_id'];
        $count = $row['post_count'];
        $tagarray = explode(" ", html_entity_decode($row['post_tags']));

        echo "<article class='posts'>";
        echo "<p>$count</p>";
        echo "<p><a href='viewpost.php?id=$postId'>$title</a></p>";
        echo "<p>$desc</p>";
        echo "<p>$cont</p>";
        echo "<p>$date</p>";

        if (isset($_SESSION['user_name']) && $_SESSION['user_name'] && ($_SESSION['user_rights'] === 'admin')):
            ?>
            <form action="deletePost.php" method="post">
                <input type="hidden" name="post_id" value="<?php echo $postId ?>"/>
                <input type="submit" name="post_rem" value="Delete"/>
            </form>
        <?php
        endif;

        foreach ($tagarray as $value) {
            echo "<a href='index.php?tag=$value'  >$value</a>";
            echo " ";
        }
        echo "</article>";
        $postcount++;
    }
    //------------------------ECHO POSTS------------------------------------------------------------
    $test = $check->fetch(PDO::FETCH_ASSOC);
    if ($postcount <= 5 && !$test) {
        $postcount = 0;
    } else {
        $postcount = true;
    }
    echo "<div id='pages'>";
    if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $nextpage = $page + 1;
            $prevpage = $page - 1;
            if ($prevpage == 1) {
                echo "<a href='index.php?tag=$tag'  >Newer posts</a>";
            } else {
                echo "<a href='index.php?tag=$tag&page=$prevpage' >Newer posts</a>";
            }
            echo " ";
            if ($postcount == true) {
                echo "<a href='index.php?tag=$tag&page=$nextpage'  >Older posts</a>";
            }
        } else {
            if ($postcount == true) {
                echo "<a href='index.php?tag=$tag&page=2' >Older posts</a>";
            }
        }
    } else {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $nextpage = $page + 1;
            $prevpage = $page - 1;
            if ($prevpage == 1) {
                echo "<a href='index.php'  >Newer posts</a>";
            } else {
                echo "<a href='index.php?page=$prevpage'  >Newer posts</a>";
            }
            echo " ";
            if ($postcount == true) {
                echo "<a href='index.php?page=$nextpage' >Older posts</a>";
            }
        } else {
            if ($postcount == true) {
                echo "<a href='index.php?page=2' >Older posts</a>";
            }
        }

    }

    echo "</div>";
    ?>
</section>
<aside>
    Most popular tags:<br>
    <?php
    $query = "SELECT tag_title, tag_count FROM tags ORDER BY tag_count DESC LIMIT 10";
    $sth = $db->query($query);
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $title = $row['tag_title'];
        $count = $row['tag_count'];

        ?>
        <a href='index.php?tag=<?= $title ?>'><?= $title ?> (<?= $count ?>)</a><br>
    <?php
    }

    ?>
    <form method="get">
        <label for="tag">Search tags:</label><br>
        <input type="text" name="tag" id="tag"><br>
        <input type="submit">
    </form>
</aside>
<aside>
    Blog archive:<br>
    <?php
    $curyear = date('Y');
    echo "<ul>";
    for ($y = $curyear;
    $y >= $curyear - 5;
    $y--){
    //-------------------------PROVERKA------------------------------
    $sql = "SELECT count(*) FROM posts WHERE YEAR(post_date)='$y'";
    $result = $db->prepare($sql);
    $result->execute();
    $number_of_rows = $result->fetchColumn();
    //---------------------------------------------------------------------
    if ($number_of_rows > 0){
    ?>
    <li><a href="javascript:void(0)" onclick="showHide(this)"><span class="zip">&#9658</span><?= $y ?>
        </a><span> (<?= $number_of_rows ?>)</span>
        <ul class="hide">
            <?php
            for ($m = 12;
            $m >= 1;
            $m--){
            //-------------------------PROVERKA------------------------------
            $sql = "SELECT count(*) FROM posts WHERE YEAR(post_date)='$y' AND MONTH(post_date)='$m'";
            $result = $db->prepare($sql);
            $result->execute();
            $number_of_rows = $result->fetchColumn();
            //---------------------------------------------------------------------
            if ($number_of_rows > 0){
            $monthName = date("F", mktime(0, 0, 0, $m, 10));
            ?>
            <li><a href="javascript:void(0)" onclick="showHide(this)"><span class="zip">&#9658</span><?= $monthName ?>
                </a><span> (<?= $number_of_rows ?>)</span>
                <ul class="hide">
                    <?php
                    $query = "SELECT * FROM posts WHERE YEAR(post_date)='$y' AND MONTH(post_date)='$m' ORDER BY post_date DESC";
                    $sth = $db->query($query);
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                        $title = $row['post_title'];
                        $id = $row['post_id'];
                        $title = substr($title, 0, 10) . '...';
                        echo "<li><a href='viewpost.php?id=$id'>$title</a></li>";

                    }
                    echo "</ul></li>";
                    }

                    }
                    echo "</ul></li>";
                    }

                    }
                    echo "</ul>";
                    ?>

</aside>
<script>
    function showHide(e) {
        var child = e.parentNode.children[2];
        if (child.style.display == "none") {
            child.style.display = "list-item";
            e.children[0].innerHTML = "&#9660";
        } else {
            child.style.display = "none";
            e.children[0].innerHTML = "&#9658";
        }

    }

</script>
</main>
<?php include "footer.php"; ?>