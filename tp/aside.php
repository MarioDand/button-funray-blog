<?php

?>
<aside class="tags-viewpost">
    <h3 class="tagsHeading">Most popular tags:</h3>
    <ul>
        <?php showTags() ?>
    </ul>
    <form method="get">
        <label for="tag">Search tags:</label>
        <input type="text" name="tag" id="tag">
        <input type="submit" value="search">
    </form>

    Blog archive:
    <?php
    $curyear = date('Y');
    ?>
    <ul>
        <?php
        for ($year = $curyear; $year >= $curyear - 5; $year--){
        //-------------------------PROVERKA------------------------------
        $sql = "SELECT count(*) FROM posts WHERE YEAR(post_date)='$year'";
        $result = $db->prepare($sql);
        $result->execute();
        $number_of_rows = $result->fetchColumn();
        //---------------------------------------------------------------------
        if ($number_of_rows > 0){ ?>
        <li>
            <a href="javascript:void(0)" onclick="showHide(this)">
                <span class="zip">&#9658</span><?= $year ?>
            </a>
            <span> (<?= $number_of_rows ?>)</span>
            <ul class="hide">
                <?php
                for ($m = 12; $m >= 1; $m--){
                //-------------------------PROVERKA------------------------------
                $sql = "SELECT count(*) FROM posts WHERE YEAR(post_date)='$year' AND MONTH(post_date)='$m'";
                $result = $db->prepare($sql);
                $result->execute();
                $number_of_rows = $result->fetchColumn();
                //---------------------------------------------------------------------
                if ($number_of_rows > 0){
                $monthName = date("F", mktime(0, 0, 0, $m, 10));
                ?>

                <li>
                    <a href="javascript:void(0)" onclick="showHide(this)">
                        <span class="zip">&#9658</span><?= $monthName ?>
                    </a>
                    <span> (<?= $number_of_rows ?>) </span>
                    <ul class="hide">

                        <?php
                        $query = "SELECT * FROM posts WHERE YEAR(post_date)='$year' AND MONTH(post_date)='$m' ORDER BY post_date DESC";
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
