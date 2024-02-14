<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHMS</title>
    <link rel="stylesheet" href="./assets/css/bulma/bulma.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- DO NOT TOUCH -->
    <?php session_start(); ?>
    <?php require_once('./utils/env.php'); ?>
    <?php
    require_once('./database/db.php');
    $db = new DB('./database/phms.db');
    if (!$db) {
        die("SQLiteDatabase Error: " . $db->lastErrorMsg());
    };
    ?>
    <?php $errors = array(); ?>
    <?php
    function redirect($url)
    {
        header("Location: /?page=$url");
    }

    function getcookie($name)
    {
        if (isset($_COOKIE[$name])) {
            if (empty($_COOKIE[$name])) {
                return null;
            }
            return $_COOKIE[$name];
        }
        return null;
    }

    function is_authenticated()
    {
        return getcookie('user') !== null;
    }
    ?>
    <main class="__main">
        <div class="__head">
            <?php include('./pages/partial/header.php'); ?>
        </div>
        <div class="__body">
            <?php
            $url = $_SERVER['REQUEST_URI'];
            $path = parse_url($url, PHP_URL_PATH);

            if ($path !== '/' && $path !== '/index.php') {
                include './pages/404.php';
                return;
            }

            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page === "") {
                    include "./pages/home.php";
                } else {
                    if (file_exists('./pages/' . $page . '.php')) {
                        include './pages/' . $page . '.php';
                    } else {
                        include './pages/404.php';
                    }
                }
            } else {
                include './pages/home.php';
            }
            ?>
        </div>
        <div class="__foot">
            <?php include('./pages/partial/footer.php') ?>
        </div>
    </main>
    <style>
        .__main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .__head {
            flex: 0 0 auto;
        }

        .__body {
            flex: 1 1 auto;
        }

        .__foot {
            flex: 0 0 auto;
        }
    </style>
    <script src="./assets/js/main.js"></script>
</body>

</html>