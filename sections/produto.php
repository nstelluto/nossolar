<?php
session_start();
include('../livraria.php');
date_default_timezone_set('America/Sao_Paulo');
$controle = new Controle ('localhost', 'root', 'usbw', 'nosso_lar', 3306);
$codigo = htmlspecialchars($_GET['id']);
$tabela = 'vw_produtos';
$filtro = [
    'valores' => [
        'id' => $codigo
    ],
    'comparadores' => ['=']
];
$resultado = $controle->selecionar($tabela, ['*'], $filtro)[0];
$propriedade_privada = $_SESSION['id'] == $resultado['id_usuario']? true: false;
?>
<div style="--nv: <?php echo $resultado['nivel']; ?>; --ml: <?php echo $resultado['quantia']; ?>%;"
    class="<?php echo $propriedade_privada? 'propriedade_privada': ''; ?>">    
    <h2 id="nome_produto" title="<?php echo $resultado['nome']; ?>"><?php echo $resultado['nome']; ?></h2>
    <div id="icone_produto">
        <i class="material-icons icone_alma">delete_outline</i>
    </div>
    <table id="detalhes_produto">
        <tr>
            <td>Nível</td>
            <td id="nivel_produto"><?php echo $resultado['nivel']; ?></td>
        </tr>
        <tr>
            <td>Quantia</td>
            <td id="quantia_produto"><?php echo $resultado['quantia']; ?></td>
        </tr>
        <tr>
            <td>Faixa</td>
            <td id="sugerido_produto">$ <?php echo $resultado['sugerido']; ?></td>
        </tr>
        <tr>
            <td>Preço</td>
            <td id="preco_produto">$ <?php echo $resultado['preco']; ?></td>
        </tr>
        <tr>
            <td>Diferença</td>
            <td id="desconto_produto"><?php echo round($resultado['desconto'], 2); ?>%</td>
        </tr>
    </table>
    <h3 id="vendedor_produto">Vendedor: <a 
        href="<?php echo $resultado['id_usuario']; ?>"
        class="visitar_perfil">
        <?php echo $resultado['usuario']; ?>
    </a></h3>
    <div id="acoes_produto">
        <?php
        if ($propriedade_privada) {
        ?>
        <a href="<?php echo $resultado['id']; ?>" id="deletar_produto">
            <i class="material-icons">delete_forever</i> <span>Excluir produto</span>
        </a>
        <?php
        } else {
        ?>
        <a href="<?php echo $resultado['id']; ?>" id="comprar_produto">
            <i class="material-icons">add_shopping_cart</i> <span>Adicionar ao carrinho</span>
        </a>
        <?php
        }
        ?>
    </div>
    <section id="comentarios_produto">
        <h3>Comentários</h3>
        <?php

        $tabela = 'vw_comentarios';
        $filtro = [
            'valores' => [
                'produto' => $codigo
            ],
            'comparadores' => ['=']
        ];
        $ordem = [
            'data' => 'DESC'
        ];

        $comentarios = $controle->selecionar($tabela, ['*'], $filtro, $ordem);
        if (!$comentarios || empty($comentarios) || sizeof($comentarios) === 0) {
        ?>
        <p>Sem comentários...</p>
        <?php
        } else {
            foreach ($comentarios as $comentario) {
        ?>
        <div class="comentario" data-comentario="<?php echo $comentario['codigo']; ?>">
            <p class="texto"><?php echo $comentario['texto']; ?></p>
            <div class="detalhes">
                <h4><a href="<?php echo $comentario['id_usuario']; ?>" class="visitar_perfil" 
                    title="<?php echo $comentario['usuario']; ?>"><?php echo $comentario['nome']; ?></a></h4>
                <p><small><?php echo date(DAHORA, $comentario['data']); ?></small></p>
            </div>
            <div class="acoes_comentario">
                <?php
                if ($comentario['id_usuario'] === $_SESSION['id']) {
                ?>
                <a href="<?php echo $comentario['codigo']; ?>" data-tipo="comentario" class="editar_comentario">
                    <i class="material-icons">edit</i> Editar</a>
                <a href="<?php echo $comentario['codigo']; ?>" data-tipo="comentario" class="remover_comentario">
                    <i class="material-icons">cancel_presentation</i> Remover</a>
                <?php
                } elseif ($propriedade_privada) {
                ?>
                <a href="<?php echo $comentario['codigo']; ?>" data-tipo="comentario" class="responder_comentario">
                    <i class="material-icons">textsms</i> Reponder</a>
                <?php
                }
                ?>
            </div>
            <?php
            $tabela = 'vw_respostas';
            $filtro = [
                'valores' => [
                    'comentario' => $comentario['codigo']
                ],
                'comparadores' => ['=']
            ];
    
            $respostas = $controle->selecionar($tabela, ['*'], $filtro);
            if (isset($respostas) && !empty($respostas) && sizeof($respostas) !== 0) {
                foreach ($respostas as $resposta) {
            ?>
            <div class="respostas_comentario">
                <div class="resposta" data-resposta="<?php echo $resposta['codigo']; ?>">
                    <p class="texto"><?php echo $resposta['texto']; ?></p>
                    <div class="detalhes">
                        <h4><a href="<?php echo $resposta['id_usuario']; ?>" class="visitar_perfil" 
                            title="<?php echo $resposta['usuario']; ?>"><?php echo $resposta['nome']; ?></a></h4>
                        <p><small><?php echo date(DAHORA, $resposta['data']); ?></small></p>
                    </div>
                    <div class="acoes_comentario">
                        <a href="<?php echo $resposta['codigo']; ?>" data-tipo="resposta" class="editar_comentario">
                            <i class="material-icons">edit</i> Editar
                        </a>
                        <a href="<?php echo $resposta['codigo']; ?>" data-tipo="resposta" class="remover_comentario">
                            <i class="material-icons">cancel_presentation</i> Remover
                        </a>
                    </div>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
        <?php
            }
        }
        ?>
    </section>
    <?php
    if (!$propriedade_privada) {
    ?>
    <a href="#" id="comentar_produto"><i class="material-icons">textsms</i> Comentar</a>
    <?php
    }
    ?>
</div>