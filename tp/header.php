<DOCTYPE html>
    <html>
    <head>
        <style>

            main,header{
                width:60%;
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
        </style>
    </head>
    <body>
    <header>
        <h1>MY BLOG</h1>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
        <a href="addpost.php">New post</a>
    </header>
    </body>
    </html>

<?php

include "database.php";
