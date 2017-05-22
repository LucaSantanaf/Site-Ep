<?php
if(!$login->isLogado()){
	header("Location: ".PATH."");
}
elseif($carrinho->qtdProdutos() == 0){
	header("Location: ".PATH."");
}
elseif(!isset($_SESSION['frete_type']) || !isset($_SESSION['valor_frete'])){
	echo '<script>alert("Por favor, calcule o frete da sua compra");location.href="'.PATH.'carrinho"</script>';
}
else{

	if(!isset($_SESSION['realizado'])){
		$strSQL = "INSERT INTO `loja_pedidos` (id_cliente, valor_total, status, criado, modificado, tipo_frete, valor_frete) VALUES(?,?,0,NOW(),NOW(), ?, ?)";
		$stmt =  BD::conn()->prepare($strSQL);
		$stmt->execute(array($usuarioLogado->id_cliente, $_SESSION['total_compra'], $_SESSION['frete_type'], $_SESSION['valor_frete']));
		$_SESSION['lastId'] = BD::conn()->lastInsertId();

		foreach($_SESSION['media_produto'] as $id => $qtd){
			$strSQLdois = "INSERT INTO `loja_produtos_pedidos` (id_pedido, id_produto, qtd) VALUES(?,?,?)";
			$stmtdois = BD::conn()->prepare($strSQLdois);
			$stmtdois->execute(array($_SESSION['lastId'], $id, $qtd));

			$atualizar_qtds = BD::conn()->prepare("UPDATE `loja_produtos` SET estoque = estoque-$qtd, qtdVendidos = qtdVendidos+$qtd WHERE id = ?");
			$atualizar_qtds->execute(array($id));
		}

		$_SESSION['realizado'] = 1;
	}

//instancio a classe
	require_once "classes/PagSeguroLibrary/PagSeguroLibrary.php";
	$pagseguro = new PagSeguroPaymentRequest();

//seto o tipo de moeda utilizada
$pagseguro->setCurrency('BRL');
$array_types = array('pac' => 1, 'sedex' => 2);
//informar o tipo de frete
$pagseguro->setShippingType($array_types[$_SESSION['frete_type']]);

//informar o código de referencia da compra
$pagseguro->setReference($_SESSION['lastId']);

//informo os dados do cliente

$pagseguro->setShippingAddress($usuarioLogado->cep, $usuarioLogado->rua, $usuarioLogado->numero, $usuarioLogado->complemento, $usuarioLogado->bairro, $usuarioLogado->cidade, $usuarioLogado->uf, 'BRA');

//recuperar os ids dos produtos selecionados no site, em uma só variavel usando o implode
$ids = implode(', ', array_keys($_SESSION['media_produto']));
$sql = sprintf("SELECT * FROM `loja_produtos` WHERE id IN (%s)", $ids);
$executar = BD::conn()->prepare($sql);
$executar->execute();

  while($row = $executar->fetchObject()){
  	$id = $row->id;
  	$produto = $row->titulo;
  	$qtd = $_SESSION['media_produto'][$id];
  	$preco = $row->valor_atual;
  	$peso = (int)$row->peso;

  	//adicionar ao carrinho
  	$pagseguro->addItem($id, $produto, $qtd, $preco, $peso, $_SESSION['valor_frete_'.$id]);

  	//agora iremos utilizar a classe AccountCredentials para adicionar nossas credencias
  	$credenciais = new PagSeguroAccountCredentials('fimoculosgordox@gmail.com','FE7800015E444134BE0141342B86A5CD');
  	$url = $pagseguro->register($credenciais);

  	session_destroy();
  	header("Location: $url");
  }

}//aqui termina o else
?>
