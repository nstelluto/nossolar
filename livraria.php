<?php
define('DAHORA', '\à\s H:i \d\e d/m/Y');

function limpar_array ($arr) {
	$new_arr = [];
	foreach ($arr as $key => $value) {
		$new_arr[$key] = htmlentities(strip_tags(trim($value)));
	}
	return $new_arr;
}

$array_limpa = limpar_array ($_POST);

class Controle {
	private $conexao = null;
    public function __construct(...$conexao) {
        $this->conexao = mysqli_init();
        $this->conexao->real_connect(...$conexao);
        $this->conexao->set_charset("utf8");
	}
	/*
	A array argumentos vai servir pra gerar a string de consulta por meio do implode.
	ReflectionClass é uma classe que serve pra pegar uma classe e chamar o método escolhido da classe,
	usando o método getMethod, com parametros personalizados de um objeto derivado da classe, usando o
	método invokeArgs

	Por exemplo nesse caso, eu to usando o objeto mysqli_stmt, pra depois usar o bind_param, o problema é
	que bind_param é uma bosta, ele leva dois parametros de entrada, sendo que o primeiro valor é uma
	string com as iniciais dos tipos de dados que vão ser passados pra consulta, o que torna difícil de 
	usar dinamicamente. Por isso eu resolvo construir um objeto da classe ReflectionClass, pra poder passar
	uma array como parametro, sendo que a array daí eu defino quando for chamar meu método inserir, e não
	na construção dele dentro da classe. O primeiro valor da array é sempre uma string, assim como o primeiro
	parametro de entrada do método original (bind_param), já o resto, infelizmente, têm de ser referências
	de variáveis (ou elementos de array). Aí que entra o foreach ali embaixo. A cada elemento da array que
	eu passar quando for chamar o método inserir eu concateno ao elemento tipos da array referencias com a
	inicial do tipo de dado do elemento atual no loop do foreach, e aí também adiciono um novo elemento à
	array referencias, que no final fica exatamente do jeito que o invokeArgs aceita. O resto é história!
	*/
	public function inserir ($tabela, $parametros) {
		$argumentos[] = "INSERT INTO";
		$argumentos[] = $tabela;
		$argumentos[] = "(".implode(', ', array_keys($parametros)).")";
		$argumentos[] = "VALUES";
		$argumentos[] = "(".implode(', ', array_map(function () {return("?");}, $parametros)).")";
		$referencias['tipos'] = '';
        foreach ($parametros as $key => $value) {
            $referencias['tipos'] .= (substr(gettype($value),0,1) == 'f')?'d':substr(gettype($value),0,1);
            $referencias[] = &$parametros[$key];
        }
		$consulta = $this->conexao->prepare(implode(' ', $argumentos));
		$reflexao = new ReflectionClass('mysqli_stmt');
        $metodo = $reflexao->getMethod('bind_param');
		$metodo->invokeArgs($consulta, $referencias);
		$resultado = $consulta->execute();
		if (!$resultado) {
			return false;
		} else {
			return($consulta->affected_rows);
		}
	}

	public function selecionar ($tabela, $colunas, $filtro = null, $ordem = null, $limite = null) {
		$argumentos[] = "SELECT";
		$argumentos[] = implode(', ', $colunas);
		$argumentos[] = "FROM ".$tabela;
		$referencias['tipos'] = '';
		if (!empty($filtro)) {
			$argumentos[] = "WHERE";
			$parametros = $filtro['valores'];
			$comparadores = $filtro['comparadores'];
			$operador = isset($filtro['operador'])? $filtro['operador']: 'OR';
			foreach ($parametros as $key => $value) {
				if (strpos($value,'NULL') === false) {
					$dado = "?";
					$referencias['tipos'] .= (substr(gettype($value),0,1) == 'f')?'d':substr(gettype($value),0,1);
					$referencias[] = &$parametros[$key];
				} else {
					$dado = $value;
				}
				$comparacao[] = $key." ".current($comparadores)." ".$dado;
				next($comparadores);
			}
			$argumentos[] = implode(' '.$operador.' ', $comparacao);
		}
		if (!empty($ordem)) {
			$argumentos[] = "ORDER BY ".key($ordem)." ".current($ordem); 
		}
		if (!empty($limite)) {
			$str = "LIMIT ".current($limite);
			next($limite);
			$str .= " OFFSET ".current($limite);
			$argumentos[] = $str; 
		}
		$consulta = $this->conexao->prepare(implode(' ', $argumentos));
		if (!empty($filtro) && $referencias['tipos'] !== '') {
			$reflexao = new ReflectionClass('mysqli_stmt');
			$metodo = $reflexao->getMethod('bind_param');
			$metodo->invokeArgs($consulta, $referencias);
		}
		$consulta->execute();
		$resultado = $consulta->get_result();
		return (!$resultado) ? false : $resultado->fetch_all(MYSQLI_ASSOC);
	}

	public function atualizar ($tabela, $parametros, $filtro = null) {
		$argumentos[] = "UPDATE";
		$argumentos[] = $tabela;
		$argumentos[] = "SET";
		$referencias['tipos'] = '';
		$colunas = [];
        foreach ($parametros as $key => $value) {
			$colunas[] = $key." = ?";
            $referencias['tipos'] .= (substr(gettype($value),0,1) == 'f')?'d':substr(gettype($value),0,1);
            $referencias[] = &$parametros[$key];
		}
		$argumentos[] = implode(', ', $colunas);
		if (!empty($filtro)) {
			$argumentos[] = "WHERE";
			$valores = $filtro['valores'];
			$comparadores = $filtro['comparadores'];
			$operador = isset($filtro['operador'])? $filtro['operador']: 'OR';
			foreach ($valores as $key => $value) {
				if (strpos($value,'NULL') === false) {
					$dado = "?";
					$referencias['tipos'] .= (substr(gettype($value),0,1) == 'f')?'d':substr(gettype($value),0,1);
					$referencias[] = &$valores[$key];
				} else {
					$dado = $value;
				}
				$comparacao[] = $key." ".current($comparadores)." ".$dado;
				next($comparadores);
			}
			$argumentos[] = implode(' '.$operador.' ', $comparacao);
		}
		$consulta = $this->conexao->prepare(implode(' ', $argumentos));
		$reflexao = new ReflectionClass('mysqli_stmt');
        $metodo = $reflexao->getMethod('bind_param');
        $metodo->invokeArgs($consulta, $referencias);
        $resultado = $consulta->execute();
		if (!$resultado) {
			return false;
		} else {
			return($consulta->affected_rows);
		}
	}

	public function deletar ($tabela, $filtro) {
		$argumentos[] = "DELETE FROM";
		$argumentos[] = $tabela;
		$argumentos[] = "WHERE";
		$valores = $filtro['valores'];
		$comparadores = $filtro['comparadores'];
		$operador = isset($filtro['operador'])? $filtro['operador']: 'OR';
		$referencias['tipos'] = '';
		foreach ($valores as $key => $value) {
			if (strpos($value,'NULL') === false) {
				$dado = "?";
				$referencias['tipos'] .= (substr(gettype($value),0,1) == 'f')?'d':substr(gettype($value),0,1);
				$referencias[] = &$valores[$key];
			} else {
				$dado = $value;
			}
			$comparacao[] = $key." ".current($comparadores)." ".$dado;
			next($comparadores);
		}
		$argumentos[] = implode(' '.$operador.' ', $comparacao);
		$consulta = $this->conexao->prepare(implode(' ', $argumentos));
		$reflexao = new ReflectionClass('mysqli_stmt');
        $metodo = $reflexao->getMethod('bind_param');
        $metodo->invokeArgs($consulta, $referencias);
        return($consulta->execute());
	}

	function __destruct() {
        $this->conexao->close();
    }
}

function gerar_cards ($linhas, $tipo = 'blocos') {
	$html = '';
	if ($tipo == 'linhas') {
		foreach ($linhas as $linha) {
			$html .=
			'<a href="'.$linha['id'].'" class="card_produto" title="'.$linha['nome'].'">
				<i class="material-icons">delete_outline</i>
				<span class="estoque_nome">'.$linha['nome'].'</span>
				<span class="estoque_ml">'.$linha['quantia'].'ml</span>
				<span class="estoque_preco">$ '.$linha['preco'].'</span>
			</a>';
		}			
	} else {
		foreach ($linhas as $linha) {
			$html .= 
			'<a href="'.$linha['id'].'" class="card_produto" title="'.$linha['nome'].'">
				<div class="card_icone"
				style="--nv: '.$linha['nivel'].'; --ml: '.$linha['quantia'].'%;">
					<i class="material-icons icone_alma">delete_outline</i>
				</div>
				<h3 class="card_nome">'.$linha['nome'].'</h3>
				<table class="detalhes_produto">
					<tr>
						<td>Nível</td>
						<td>'.$linha['nivel'].'</td>
					</tr>
					<tr>
						<td>Quantia</td>
						<td>'.$linha['quantia'].'</td>
					</tr>
					<tr>
						<td>Faixa</td>
						<td>$ '.$linha['sugerido'].'</td>
					</tr>
					<tr>
						<td>Preço</td>
						<td>$ '.$linha['preco'].'</td>
					</tr>
					<tr>
						<td>Diferença</td>
						<td>'.sprintf("%+d", $linha['desconto']).'%</td>
					</tr>
				</table>
			</a>';
		}
	}
	return $html;
}