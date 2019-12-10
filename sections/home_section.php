<?php
session_start();
include('../livraria.php');
date_default_timezone_set('America/Sao_Paulo');
$controle = new Controle ('localhost', 'root', 'usbw', 'nosso_lar', 3306);
$tabela = 'vw_produtos';
$colunas = ['*'];
$filtro = [
    'valores' => [
        'id_usuario' => $_SESSION['id']
    ],
    'comparadores' => ['!='],
];
$ordem = [
    'desconto' => 'ASC'
];
$limite = [5, 0];
$destaques = $controle->selecionar($tabela, $colunas, $filtro, $ordem, $limite);
$limite = [10, 5];
$restantes = $controle->selecionar($tabela, $colunas, $filtro, $ordem, $limite);
?>
<div>
    <h2>Destaques</h2>
    <div id="destaques">
        <div id="slide">
            <?php
            echo gerar_cards($destaques);
            ?>
        </div>
        <div id="controle">
            <a href="#" class="proximo">
                <i class="material-icons">navigate_next</i>
            </a>
            <a href="#" class="anterior">
                <i class="material-icons">navigate_before</i>
            </a>
        </div>
    </div>
    <h2>Outros produtos</h2>
    <div id="home_produtos">
        <?php
        echo gerar_cards($restantes);
        ?>
    </div>
</div>