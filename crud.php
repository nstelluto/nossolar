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


if (isset($_POST['editar_usuario'])) {
    $mensagem['codigo'] = 1;
    $mensagem['texto'] = 'Perfil atualizado!';
    $formulario = limpar_array($_POST);
    unset($formulario['editar_usuario']);

    if (count($formulario) === 0) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Formulário vazio!';
    } else {
        $tabela = 'usuarios';
        $filtro = [
            'valores' => [
                'codigo' => $_SESSION['id']
            ],
            'comparadores' => ['='],
            'operador' => 'AND'
        ];
        $resultado = $controle->atualizar($tabela, $formulario, $filtro);
    }

    if (!$resultado || $resultado !== 1) {
        $mensagem['codigo'] = 2;
        $mensagem['texto'] = 'Erro ao atualizar perfil!';
    }

    echo json_encode($mensagem);
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
?>