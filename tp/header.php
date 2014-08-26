
<!DOCTYPE html>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="Styles/index.css">
</head>
<body>
    <?php include "database.php"; ?>

    <div class="wrapper">
    <header>
        <a href="index.php" >
            <div class="logo">BG Tati</div>
        </a>

        <nav>
            <ul class="navUl">
                <li>
                    <?php if(isset($_SESSION['user_name']) && $_SESSION['user_name'] &&($_SESSION['user_rights']==='user')): ?>
                    <a >Hello <?php echo $_SESSION['user_name']; ?> </a>
                    <a href="logout.php">Log out</a>
                </li>

                <li>
                    <?php elseif(isset($_SESSION['user_name']) && $_SESSION['user_name']&&($_SESSION['user_rights']==='admin')): ?>
                    <a>Hello <?php echo $_SESSION['user_name']; ?> </a>
                    <a href="addpost.php">Add post</a>
                    <a href="logout.php">Log out</a>
                </li>

                <li>
                    <?php else: ?>
                        <a href="register.php">Register</a>
                        <a href="login.php">Login</a>
                        <a>Hello Guest </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

    </header>

