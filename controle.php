<?php
include('livraria.php');
date_default_timezone_set('America/Sao_Paulo');
$controle = new Controle ('localhost', 'root', 'usbw', 'nosso_lar', 3306);
$tabela = 'vw_produtos';
$colunas = [
    'nome',
    'nivel',
    'quantia',
    'sugerido',
    'preco',
    'desconto',
    'id_usuario',
    'usuario'
];
$resultado = $controle->selecionar($tabela, $colunas);
?>