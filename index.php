<?php
$tempo_de_vida = 3600;
session_start();
setcookie(session_name(),session_id(),time()+$tempo_de_vida);
if (isset($_GET['sair'])) {
    unset($_SESSION['id']);
    session_destroy();
}
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
    <div id="modal">
        <div id="bloco_modal">
            <div id="controle_modal">
                <a href="1" id="confirmar_modal">
                    <i class="material-icons">done</i>
                </a>
                <a href="0" id="cancelar_modal">
                    <i class="material-icons">clear</i>
                </a>
            </div>
            <div id="mensagem_modal">
                <div class="carregando">
                    <p>Carregando</p>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (!isset($_SESSION['id'])) {
        include './includes/login.php';
    } else {
        include './includes/main.php';
    }
    ?>
</body>
</html>