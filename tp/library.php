<?php
include "database.php";
//include "index.php";

function showTags() {
    global $db;
    $query = "SELECT tag_title, tag_count FROM tags ORDER BY tag_count DESC LIMIT 10";
    $sth = $db->query($query);

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $title = html_entity_decode($row['tag_title']);
        $count = $row['tag_count'];

        echo "<li><a href='index.php?tag=$title'> $title ( $count )</a></li>";
    }
}

function getOffset() {
    if (isset($_GET['page'])) {
        $offset = ($_GET['page'] - 1) * 5;
    } else {
        $offset = 0;
    }
    return $offset;
}

function showPosts($query, &$pagePostCount) {
    global $db;

    $sth = $db->query($query);

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        createPost($row);
        $pagePostCount++;
    }
}

function createPost($row) {
    $title = html_entity_decode($row['post_title']);
    $desc = html_entity_decode($row['post_desc']);
    $cont = html_entity_decode(nl2br($row['post_cont']));
    $date = $row['post_date'];
    $postId = $row['post_id'];
    $count = $row['post_count'];
    $tagArray = explode(" ", htmlentities($row['post_tags']));

    echo "<article class='posts'>";
    echo "<div class='innerArticle clearfix'>";
    echo "<h4><a href='viewpost.php?id=$postId' class='postTitle'>$title</a></h4>";
    echo "<h2>$desc</h2>";
    echo "<div class='divContent'>$cont</div>";
    echo "<p>$date</p>";
    echo "<p>Views: $count</p>";
    if (isset($_SESSION['user_name']) && $_SESSION['user_name'] && ($_SESSION['user_rights'] === 'admin')):
        ?>
        <form action="deletePost.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $postId ?>"/>
            <input type="submit" name="post_rem" value="Delete"/>
        </form>
    <?php
    endif;
    foreach ($tagArray as $value) {
        echo "<a href='index.php?tag=$value'>$value</a> ";
    }
    echo "</div>";
    echo "</article>";
}

function getQueries(&$query, &$checkquery, $offset) {
    $testoff = $offset + 6;
    if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];
        $query = "SELECT * FROM posts WHERE post_tags
            LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
            ORDER BY post_date DESC LIMIT $offset, 5";
        $checkquery = "SELECT * FROM posts WHERE post_tags
     LIKE '% $tag %' OR post_tags LIKE '$tag %' OR post_tags LIKE '% $tag'
         ORDER BY post_date DESC LIMIT $testoff,1";
    } else {
        $query = "SELECT * FROM posts ORDER BY post_date DESC LIMIT $offset,5";
        $checkquery = "SELECT * FROM posts ORDER BY post_date DESC LIMIT $testoff,1";
    }
}