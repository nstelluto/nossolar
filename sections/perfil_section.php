<?php
session_start();
include('../livraria.php');
date_default_timezone_set('America/Sao_Paulo');
$controle = new Controle ('localhost', 'root', 'usbw', 'nosso_lar', 3306);

$codigo = isset($_GET['perfil']) ? htmlspecialchars($_GET['perfil']): $_SESSION['id'];

$tabela = 'usuarios';
$filtro = [
    'valores' => [
        'codigo' => $codigo
    ],
    'comparadores' => ['='],
    'operador' => 'AND'
];

$resultado = $controle->selecionar($tabela, ['*'], $filtro);

if (!$resultado || empty($resultado) || sizeof($resultado) === 0) {
    var_dump($_SESSION);
?>
<h3>Erro ao carregar perfil de usuário...</h3>
<?php
exit;
}
$perfil = $resultado[0];
?>
<div>
    <div id="perfil_usuario">
        <div id="nome_usuario">
            <h2>nome: <span><?php echo $perfil['nome']; ?></span></h2>
        </div>
        <div id="usuario_usuario">
            <p>usuario: <span><?php echo $perfil['usuario']; ?></span></p>            
        </div>
        <?php if (!isset($_GET['perfil'])) { ?>
        <div id="email_usuario">
            <p>e-mail: <span><?php echo $perfil['email']; ?></span></p>
        </div>
        <a href="<?php echo $perfil['codigo']; ?>" id="editar_usuario"><i class="material-icons">edit</i> Editar perfil</a>
        <?php } ?>
    </div>
    <hr>
    <section id="produtos_usuario">
        <h4>Produtos</h4>
        <div id="estoque_usuario">
            <?php
            $tabela = 'vw_produtos';
            if (!isset($_GET['perfil'])) { 
            ?>
            <a href="#novo_produto" id="add_novo_produto">
                <i class="material-icons">add_box</i>
                <span>Adicionar novo produto</span>
            </a>
            <?php
                $filtro = [
                    'valores' => [
                        'id_usuario' => $_SESSION['id']
                    ],
                    'comparadores' => ['=']
                ];
            }
            else {
                $filtro = [
                    'valores' => [
                        'id_usuario' => htmlspecialchars($_GET['perfil'])
                    ],
                    'comparadores' => ['=']
                ];
            }
            $produtos = $controle->selecionar($tabela, ['*'], $filtro);
            echo gerar_cards($produtos, 'linhas')
            ?>
        </div>
    </section>
</div>