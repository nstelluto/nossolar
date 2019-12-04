<?php
// function teste ($tabela, $arr, $filtro = null) {
//     $argumentos[] = "INSERT INTO";
// 	$argumentos[] = $tabela;
// 	$argumentos[] = "(".implode(', ', array_keys($arr)).")";
// 	$argumentos[] = "VALUES";
// 	$argumentos[] = "(".implode(', ', array_map(function () {return("?");}, $arr)).")";
// 	echo implode(' ', $argumentos);
// }

$tabelas = [
	'a' => [
		'coluna1',
		'coluna2',
		'coluna3'
	],
	'b' => [
		'coluna1',
		'coluna2',
		'coluna3'
	]
];

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
        return($consulta->execute());
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
			$operador = $filtro['operador'];
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
			$argumentos[] = key($ordem)." ".current($ordem); 
		}
		if (!empty($limite)) {
			$str = key($limite)." ".current($limite);
			next($limite);
			$str .= ", ".key($limite)." ".current($limite);
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

	public function asd ($tabelas) {
		$str = "SELECT *,
		(`nivel`*`quantia`*1000) AS `sugerido`,
		(((`preco`- (SELECT `sugerido`))/(SELECT `sugerido`))*100) AS `porcentagem`
		FROM `produtos` ORDER BY `porcentagem` ASC";
	}
	
	public function juncao ($tabelas) {
		foreach ($tabelas as $key => $value) {

		}
	}

	function __destruct() {
        $this->conexao->close();
    }
}
// SELECT P.codigo,
// CONCAT_WS(" - ",P.nome, N.nome) AS nome,
// P.nivel,
// P.quantia,
// P.preco,
// (N.rpm * P.quantia) AS sugerido,
// (((P.preco - (SELECT sugerido))/(SELECT sugerido)) * 100) AS desconto,
// P.usuario as id_usuario,
// U.nome as usuario
// FROM produtos AS P
// INNER JOIN usuarios AS U
// INNER JOIN niveis AS N
// ON P.usuario = U.codigo
// AND P.nivel = N.codigo