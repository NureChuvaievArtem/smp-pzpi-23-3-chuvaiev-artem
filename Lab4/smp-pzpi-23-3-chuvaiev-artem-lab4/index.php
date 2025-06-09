<?php
include_once("./scripts/database.php");
include_once("./scripts/init.php");
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Мій сайт</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/products.css">
</head>

<body>

    <?php include_once("./layout/header.php"); ?>

    <div class="content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch ($page) {
            case "cart":
                require_once("cart.php");
                break;
            case "profile":
                require_once("profilePage.php");
                break;
            case "products":
                require_once("products.php");
                break;
            case "login":
                require_once("login.php");
                break;
            case "home":
                require_once("home.php");
                break;
            default:
                require_once("page404.php");
                break;
        }
        ?>
    </div>

    <?php include_once("./layout/footer.php"); ?>

</body>

</html>