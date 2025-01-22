<?php
include_once("pages/lib.php");
//для создания базы данный
//include_once("pages/createdb.php")

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="wwwroot/css/bootstrap.css">
    <title>Магазин</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php include_once("pages/menu.php"); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php Menu::Getpage($_GET['page']);
                echo "Ваш roleId: " . htmlspecialchars($_SESSION['roleId'])
                ?>
            </div>
        </div>
    </div>
</body>

</html>