<?php
set_include_path('includes');
session_start();
$_SESSION['id'] = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Nosso Lar</title>
</head>
<body class="inteiro">
    <?php
    if (!isset($_SESSION['id'])) {
        include 'login.php';
    } else {
        include 'main.php';
    }
    ?>
    <script src="js/script.js"></script>
</body>
</html>