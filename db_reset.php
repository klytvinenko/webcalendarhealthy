<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Migration;

session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>DB reset</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
        @import url('https://fonts.googleapis.com/css?family=Catamaran:400,800');

        .error-container {
            text-align: center;
            font-size: 180px;
            font-family: 'Catamaran', sans-serif;
            font-weight: 800;
            margin: 20px 15px;
        }

        .error-container>span {
            display: inline-block;
            line-height: 0.7;
            position: relative;
            color: #FFB485;
        }

        .error-container>span {
            display: inline-block;
            position: relative;
            vertical-align: middle;
        }

        .error-container>span:nth-of-type(1) {
            color: #D1F2A5;
            animation: colordancing 4s infinite;
        }

        .error-container>span:nth-of-type(3) {
            color: #F56991;
            animation: colordancing2 4s infinite;
        }

        .error-container>span:nth-of-type(2) {
            width: 120px;
            height: 120px;
            border-radius: 999px;
        }

        .error-container>span:nth-of-type(2):before,
        .error-container>span:nth-of-type(2):after {
            border-radius: 0%;
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: inherit;
            height: inherit;
            border-radius: 999px;
            box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
                inset 0 30px 0 rgba(239, 250, 180, 0.4),
                inset -30px 0 0 rgba(255, 196, 140, 0.4),
                inset 0 -30px 0 rgba(245, 105, 145, 0.4);
            animation: shadowsdancing 4s infinite;
        }

        .error-container>span:nth-of-type(2):before {
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .screen-reader-text {
            position: absolute;
            top: -9999em;
            left: -9999em;
        }

        @keyframes shadowsdancing {
            0% {
                box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
                    inset 0 30px 0 rgba(239, 250, 180, 0.4),
                    inset -30px 0 0 rgba(255, 196, 140, 0.4),
                    inset 0 -30px 0 rgba(245, 105, 145, 0.4);
            }

            25% {
                box-shadow: inset 30px 0 0 rgba(245, 105, 145, 0.4),
                    inset 0 30px 0 rgba(209, 242, 165, 0.4),
                    inset -30px 0 0 rgba(239, 250, 180, 0.4),
                    inset 0 -30px 0 rgba(255, 196, 140, 0.4);
            }

            50% {
                box-shadow: inset 30px 0 0 rgba(255, 196, 140, 0.4),
                    inset 0 30px 0 rgba(245, 105, 145, 0.4),
                    inset -30px 0 0 rgba(209, 242, 165, 0.4),
                    inset 0 -30px 0 rgba(239, 250, 180, 0.4);
            }

            75% {
                box-shadow: inset 30px 0 0 rgba(239, 250, 180, 0.4),
                    inset 0 30px 0 rgba(255, 196, 140, 0.4),
                    inset -30px 0 0 rgba(245, 105, 145, 0.4),
                    inset 0 -30px 0 rgba(209, 242, 165, 0.4);
            }

            100% {
                box-shadow: inset 30px 0 0 rgba(209, 242, 165, 0.4),
                    inset 0 30px 0 rgba(239, 250, 180, 0.4),
                    inset -30px 0 0 rgba(255, 196, 140, 0.4),
                    inset 0 -30px 0 rgba(245, 105, 145, 0.4);
            }
        }

        @keyframes colordancing {
            0% {
                color: #D1F2A5;
            }

            25% {
                color: #F56991;
            }

            50% {
                color: #FFC48C;
            }

            75% {
                color: #EFFAB4;
            }

            100% {
                color: #D1F2A5;
            }
        }

        @keyframes colordancing2 {
            0% {
                color: #FFC48C;
            }

            25% {
                color: #EFFAB4;
            }

            50% {
                color: #D1F2A5;
            }

            75% {
                color: #F56991;
            }

            100% {
                color: #FFC48C;
            }
        }

        /* demo stuff */
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            background-color: #416475;
            margin-bottom: 50px;
        }

        html,
        button,
        input,
        select,
        textarea {
            font-family: 'Montserrat', Helvetica, sans-serif;
            color: #92a4ad;
        }

        h1 {
            text-align: center;
            margin: 30px 15px;
        }

        .zoom-area {
            max-width: 490px;
            margin: 30px auto 30px;
            font-size: 19px;
            text-align: center;
        }

        .link-container {
            text-align: center;
        }

        a.more-link {
            text-transform: uppercase;
            font-size: 13px;
            background-color: #92a4ad;
            padding: 10px 15px;
            border-radius: 0;
            color: #416475;
            display: inline-block;
            margin-right: 5px;
            margin-bottom: 5px;
            line-height: 1.5;
            text-decoration: none;
            margin-top: 50px;
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <div class="container">
    </div>
    <h1>DB refresh</h1>
    <p class="zoom-area">
    <pre>

        <?php


        Migration::reset();
        unset($_SESSION['user']);

        echo "migration: " . isset($_SESSION['migration']) ? "true" : "false";
        ?></pre>
    </p>
    <section class="error-container">
    </section>
    <div class="link-container">
        <a href="index.php" class="more-link">Go to main page</a>
    </div>
</body>

</html>