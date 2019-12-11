<?php
session_start();
include('livraria.php');
date_default_timezone_set('America/Sao_Paulo');
$controle = new Controle ('localhost', 'root', 'usbw', 'nosso_lar', 3306);

if (isset($_POST['excluir_produto'])) {
    $filtro = [
        'valores' => [
            'codigo' => $_POST['excluir_produto'],
            'usuario' => $_SESSION['id']
        ],
        'comparadores' => ['=','='],
        'operador' => 'AND'
    ];
    $resultado = $controle->deletar('produtos', $filtro);
    if (!$resultado) {
        echo "Erro ao excluir produto!";
    } else {
        echo "Produto excluído com sucesso!";
    }
    exit;
}
if (isset($_POST['envio'])) {
    if ($_POST['envio'] === 'cadastro') {
        $mensagem = ['codigo' => 2, 'texto' => 'Cadastro realizado!'];
        $tabela = 'usuarios';
        array_walk($_POST, function (&$elemento, $chave) {
            $elemento = htmlspecialchars(trim($elemento));
        });
        

        if ($_POST['cadastro_senha'] !== $_POST['confirmar_senha']) {
            $mensagem['codigo'] = 3;
            $mensagem['texto'] = 'Senha inválida!';
        }
        if (preg_match('/[[:space:]]/', $_POST['cadastro_usuario']) > 0) {
            $mensagem['codigo'] = 3;
            $mensagem['texto'] = 'Usuário inválido!'; 
        }

        if ($mensagem['codigo'] > 2) {
            echo json_encode($mensagem);
            exit;
        }

        $parametros['nome'] = $_POST['cadastro_nome'];
        $parametros['email'] = $_POST['cadastro_email'];
        $parametros['usuario'] = $_POST['cadastro_usuario'];
        $parametros['senha'] = md5($_POST['cadastro_senha']);
        
        $filtro = [
            'valores' => [
                'usuario' => $parametros['usuario'],
                'email' => $parametros['email']
            ],
            'comparadores' => [
                '=','='
            ],
            'operador' => 'OR'
        ];
        
        $checagem = $controle->selecionar($tabela, ['*'], $filtro);
        
        if (sizeof($checagem) !== 0) {
            $mensagem['codigo'] = 3;
            $mensagem['texto'] = 'Usuário já existe!';
            $resultado = false;
        } else {
            $resultado = $controle->inserir($tabela, $parametros);
        }
        
        
        if (!$resultado || $resultado !== 1) {
            $mensagem['codigo'] = 3;
            $mensagem['texto'] = 'Erro ao realizar cadastro!';
        }
        
        echo json_encode($mensagem);
        exit;
    } elseif ($_POST['envio'] === 'login') {
        $mensagem = ['codigo' => 1, 'texto' => 'Login realizado!'];
        $tabela = 'usuarios';
        array_walk($_POST, function (&$elemento, $chave) {
            $elemento = htmlspecialchars(trim($elemento));
        });
        
        $parametros['usuario'] = $_POST['login_usuario'];
        $parametros['senha'] = md5($_POST['login_senha']);
        
        $filtro = [
            'valores' => [
                'usuario' => $parametros['usuario'],
                'senha' => $parametros['senha']
            ],
            'comparadores' => [
                '=','='
            ],
            'operador' => 'AND'
        ];
        
        $resultado = $controle->selecionar($tabela, ['*'], $filtro);
        
        if (!$resultado || empty($resultado) || sizeof($resultado) === 0) {
            $mensagem['codigo'] = 3;
            $mensagem['texto'] = 'Login inválido';
        } else {
            $_SESSION['id'] = $resultado[0]['codigo'];
        }
        
        echo json_encode($mensagem); 
        exit;       
    }
}
if (isset($_POST['comentario']) && isset($_POST['produto'])) {
    $limite = 256;

    $mensagem = ['codigo' => 1, 'texto' => 'Comentário enviado!'];
    if (empty($_POST['comentario'])) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Comentário vazio!';
    } elseif (strlen($_POST) >= $limite) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Fala muito!';
    } else {
        $tabela = 'comentarios';
        $parametros = [
            'data' => time(),
            'usuario' => $_SESSION['id'],
            'produto' => htmlspecialchars($_POST['produto']),
            'texto' => htmlspecialchars($_POST['comentario'])
        ];
        $resultado = $controle->inserir($tabela, $parametros);
    }

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 3;
        $mensagem['texto'] = 'Erro ao enviar comentário!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_POST['resposta']) && isset($_POST['comentario_alvo'])) {
    $limite = 256;

    $mensagem = ['codigo' => 1, 'texto' => 'Resposta enviada!'];
    if (empty($_POST['resposta'])) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Resposta vazia!';
    } elseif (strlen($_POST) >= $limite) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Fala muito!';
    } else {
        $tabela = 'respostas';
        $parametros = [
            'data' => time(),
            'usuario' => $_SESSION['id'],
            'comentario' => htmlspecialchars($_POST['comentario_alvo']),
            'texto' => htmlspecialchars($_POST['resposta'])
        ];
        $resultado = $controle->inserir($tabela, $parametros);
    }

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 3;
        $mensagem['texto'] = 'Erro ao enviar resposta!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_POST['remover_comentario']) && isset($_POST['tipo_comentario'])) {
    $mensagem['codigo'] = 1;
    $mensagem['texto'] = 'Comentário removido!';

    $tabela = htmlspecialchars($_POST['tipo_comentario']).'s';

    $filtro = [
        'valores' => [
            'codigo' => $_POST['remover_comentario'],
            'usuario' => $_SESSION['id']
        ],
        'comparadores' => ['=','='],
        'operador' => 'AND'
    ];

    $checagem = $controle->selecionar($tabela, ['*'], $filtro);

    if (!$checagem || empty($checagem) || sizeof($checagem) === 0) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao remover comentário!';
    } else {
        $resultado = $controle->deletar($tabela, $filtro);
    }

    if (!$resultado) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao remover comentário!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_POST['solicitar_edicao'])) {
?>
<form>
    <input type="hidden" name="solicitacao_edicao" value="<?php echo $_SESSION['id']; ?>">
    <div class="modal_input">
        <label>Nome <input type="checkbox" name="nome"></label>
    </div>
    <div class="modal_input">
        <label>Usuario <input type="checkbox" name="usuario"></label>
    </div>
    <div class="modal_input">
        <label>E-mail <input type="checkbox" name="email"></label>
    </div>
    <div class="modal_input">
        <label>Senha <input type="checkbox" name="senha"></label>
    </div>
</form>
<?php
    exit;
}
if (isset($_POST['solicitacao_edicao'])) {
    unset($_POST['solicitacao_edicao']);

    if (count($_POST) === 0) {
?>
<p>Ok. Vamos fingir que nada aconteceu.</p>
<?php
    } else {
?>
<form>
    <input type="hidden" name="editar_usuario" value="<?php echo $_SESSION['id']; ?>">
<?php
        $formulario = limpar_array($_POST);
        foreach ($formulario as $nome => $campo) {
            $type = "text";
            if ($nome === 'senha') {
                $type = "password";
            }
?>
    <input type="<?php echo $type; ?>"
    class="modal_input"
    name="<?php echo $nome; ?>"
    placeholder="<?php echo ucfirst($nome); ?>">
<?php
        }
?>
</form>
<?php
    }
    exit;
}
if (isset($_POST['editar_usuario'])) {
    $mensagem['codigo'] = 1;
    $mensagem['texto'] = 'Perfil atualizado!';
    $formulario = limpar_array($_POST);
    unset($formulario['editar_usuario']);
    $filtro_checagem['valores'] = $formulario;

    if (count($formulario) === 0) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Formulário vazio!';
    } else {
        $tabela = 'usuarios';
        if (isset($formulario['senha'])) {
            $formulario['senha'] = md5($formulario['senha']);
            unset($filtro_checagem['valores']['senha']);
        }

        $filtro = [
            'valores' => [
                'codigo' => $_SESSION['id']
            ],
            'comparadores' => ['='],
            'operador' => 'AND'
        ];

        $filtro_checagem['comparadores'] = array_map(function () {
            return '=';
        }, $filtro_checagem['valores']);

        $filtro_checagem['operador'] = 'OR';

        $checagem = $controle->selecionar($tabela, ['*'], $filtro_checagem);

        if (!$checagem || count($checagem) === 0) {
            $resultado = $controle->atualizar($tabela, $formulario, $filtro);
        } elseif ($checagem[0]['usuario'] == $formulario['usuario'] || $checagem[0]['email'] == $formulario['email']) {
            $resultado = false;
        } else {
            $resultado = $controle->atualizar($tabela, $formulario, $filtro);
        }
    }

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao atualizar perfil!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_POST['editar_comentario']) && isset($_POST['tipo_comentario'])) {
    $mensagem['codigo'] = 1;
    $mensagem['texto'] = 'Comentário atualizado!';
    $formulario = limpar_array($_POST);
    $tabela = $formulario['tipo_comentario'].'s';
    unset($formulario['tipo_comentario']);
    
    $filtro = [
        'valores' => [
            'codigo' => $formulario['editar_comentario'],
            'usuario' => $_SESSION['id']
        ],
        'comparadores' => ['=', '='],
        'operador' => 'AND'
    ];
    
    // $mensagem['texto'] = $formulario;
    // echo json_encode($mensagem);
    // exit;
    $resultado = $controle->atualizar($tabela, ['texto' => $formulario['texto']], $filtro);

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao atualizar comentário!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_POST['solicitar_adicao'])) {
    $tabela = 'niveis';
    $ordem = [
        'codigo' => 'ASC'
    ];
    $resultado = $controle->selecionar($tabela, ['*'], null, $ordem);
?>
<form>
    <div class="modal_input">
        <label>Nível da alma</label>
        <select name="nivel" >
<?php
    foreach ($resultado as $nivel) {
?>
            <option value="<?php echo $nivel['codigo']; ?>">[<?php echo sprintf('%02d', $nivel['codigo']); ?>] <?php echo $nivel['nome']; ?></option>
<?php
    }
?>
        </select>
    </div>
    <div class="modal_input">
        <label>Nome da alma</label>
        <input type="text" name="nome">
    </div>
    <div class="modal_input">
        <label>Quantia de alma (ml)</label>
        <input type="number" min="1" max="100" value="10" name="quantia">
    </div>
    <div class="modal_input">
        <label>Preço da alma ($)</label>
        <input type="text" placeholder="Sugerido: $ 500.00" name="preco">
    </div>
</form>
<?php
    exit;
}
if (isset($_POST['adicionar_produto'])) {
    $limite = 32;

    $formulario = limpar_array($_POST);

    $mensagem = ['codigo' => 1, 'texto' => 'Produto adicionado à loja!'];
    if (empty($formulario['adicionar_produto'])) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Formulário vazio!';
    } elseif (strlen($formulario['nome']) > 32) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Nome muito grande!';
        echo json_encode($mensagem);
        exit;
    } else {
        $tabela = 'produtos';
        
        $parametros = [
            'nivel' => $formulario['nivel'],
            'quantia' => $formulario['quantia'],
            'preco' => $formulario['preco'],
            'usuario' => $_SESSION['id']
        ];

        if (!empty($formulario['nome'])) {
            $parametros['nome'] = $formulario['nome'];
        }

        $resultado = $controle->inserir($tabela, $parametros);
    }

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao adicionar produto!';
    }

    echo json_encode($mensagem);
    exit;
}
if (isset($_GET['busca'])) {
    $busca = limpar_array($_GET)['busca'];
    $tabelas = ['vw_produtos', 'usuarios'];
    $filtro = [
        [
            'valores' => [
                'nome' => $busca,
                'quantia' => $busca,
                'preco' => $busca,
                'usuario' => $busca
            ],
            'comparadores' => ['LIKE', 'LIKE', 'LIKE', 'LIKE'],
            'operador' => 'OR'
        ],
        [
            'valores' => [
                'nome' => $busca,
                'usuario' => $busca,
                'email' => $busca
            ],
            'comparadores' => ['LIKE', 'LIKE', 'LIKE'],
            'operador' => 'OR'
        ]
    ];
    $produtos = $controle->selecionar($tabelas[0], ['*'], $filtro[0]);
    $usuarios = $controle->selecionar($tabelas[1], ['*'], $filtro[1]);
?>
<h3>Produtos</h3>
<div id="resultado_produtos">
<?php
    if (!$produtos || empty($produtos) || sizeof($produtos) === 0) {
?>
<p>Nada encontrado...</p>
<?php
    } else {
        echo gerar_cards($produtos, 'linhas');
    }
?>
</div>
<h3>Usuários</h3>
<div id="resultado_usuarios">
<?php
    if (!$usuarios || empty($usuarios) || sizeof($usuarios) === 0) {
?>
<p>Nada encontrado...</p>
<?php
    } else {
        foreach ($usuarios as $usuario) {
            echo
            '<a href="'.$usuario['codigo'].'" class="card_produto" title="'.$usuario['nome'].'">
				<i class="material-icons">person</i>
				<span class="estoque_nome">'.$usuario['nome'].'</span>
				<span class="estoque_ml">'.$usuario['usuario'].'</span>
				<span class="estoque_preco">'.$usuario['email'].'</span>
			</a>';
        }
    }
?>
</div>
<?php
    exit;
}
?>