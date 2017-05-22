<?php
  $total = $_SESSION['total_compra'] > 0;
	if(isset($parametros[1]) && $parametros[1] == 'add' && isset($parametros[2]) && $parametros[2] != '0'){
		$idProd = (int)$parametros[2];
		$carrinho->verificaAdiciona($idProd);
	}
	if(isset($_SESSION['media_produto'][0])){unset($_SESSION['media_produto'][0]);}
  if ($total) {
    if(count($_SESSION['media_produto']) == 0){unset($_SESSION['valor_frete']);}
  }

/* ESTÁ DANDO ALGUNS NOTICES DA LINHA 14 E 17, MAS APARENTEMENTE NÃO ESTÁ BUGANDO
	//verifica se o produto que o usuário está tentando adicionar está disponível para compra no banco de dados
	$verificar_no_banco = BD::conn()->prepare("SELECT estoque FROM `loja_produtos` WHERE id = ?");
	$produto_Id = (int)$parametros[2];
	$verificar_no_banco->execute(array($produto_Id));
	$fetchEstoque = $verificar_no_banco->fetchObject();
	if($fetchEstoque->estoque == '0'){
		unset($_SESSION['media_produto'][$produto_Id]);
		echo '<p id="alert">Desculpe, mais este produto encontra-se em falta em nosso estoque!</p>';
	}
*/

/* ESTÁ DANDO UM PROBLEMA DE NÃO PODER AUMENTAR A QUANTIDADE DE QUALQUER PRODUTO, PARA MAIS QUE 1
    if(isset($parametros[1]) && $parametros[1] == 'add' || isset($_POST['atualizar'])){
		unset($_SESSION['valor_frete']);
		foreach($_SESSION['media_produto'] as $id => $qtd){
			unset($_SESSION['valor_frete_'.$id]);
		}
	} */

  /* Botão que deleta o produto do carrinho */
	if(isset($parametros[1]) && $parametros[1] == 'del' && isset($parametros[2])){
		$idDel = (int)$parametros[2];
		if($carrinho->deletarProduto($idDel)){
			echo '<script>alert("Produto deletado do carrinho");location.href="'.PATH.'carrinho"</script>';
		}
    else{
			echo '<script>alert("Erro ao deletar produto");location.href="'.PATH.'carrinho"</script>';
		}
	}

  /* Mudar a quantidade de produtos para adicionar ao carrinho, dentro de produto.php*/
	if(isset($_POST['prodSingle'])){
		$produtoValor = $_POST['prodSingle'];

		if($carrinho->setarByPost($produtoValor)){}else{
			echo '<p id="alert">Não foi possivel adicionar este produto</p>';
		}
	}

  /* Proibe que o usuário coloque no carrinho uma quantidade de produtos maior que o mesmo no estoque */
	if(isset($_POST['atualizar'])){
		$produto = $_POST['prod'];
		foreach($produto as $chave => $qtd){
			$selecionar_produto = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE id = ?");
			$selecionar_produto->execute(array($chave));
			$fetchProd = $selecionar_produto->fetchObject();
			if($qtd > $fetchProd->estoque){
				echo '<p id="alert">Não é possivel adicionar mais que: <strong>'.$fetchProd->estoque.'</strong>
              produtos para compra do produto: <strong>'.$fetchProd->titulo.'</strong></p>';

				$warn = true;
			}
		}

    /* Botão para atualizar a quantidades de produtos da compra */
		if($warn == true){}else{
			if($carrinho->atualizarQuantidades($produto)){
				echo '<script>alert("Quantidade foi alterada");location.href="'.PATH.'carrinho"</script>';
			}
      else{
				echo '<script>alert("Erro ao alterar quantidades");location.href="'.PATH.'carrinho"</script>';
			}
		}
	}

//frete
if(isset($_POST['acao']) && $_POST['acao'] == 'calcular'){
$frete = $_POST['frete'];
$_SESSION['frete_type'] = $frete;
$cep = strip_tags(filter_input(INPUT_POST, 'cep'));
  switch($frete){
  	case 'pac';
  		$valor = '41106';
      $cep_origem = '09960010';
  		$peso_total = 0;
  		foreach($_SESSION['media_produto'] as $id => $qtd){
  			$selecionar_produto = BD::conn()->prepare("SELECT peso FROM `loja_produtos` WHERE id = ?");
  			$selecionar_produto->execute(array($id));
  			$fetch_produto = $selecionar_produto->fetchObject();

  			$_SESSION['valor_frete_'.$id] = $carrinho->calculaFrete($valor, $cep_origem, $cep, $fetch_produto->peso);
  		}
  	break;

  	case 'sedex';
  		$valor = '40010';
      $cep_origem = '09960010';
  		$peso_total = 0;
  		foreach($_SESSION['media_produto'] as $id => $qtd){
  			$selecionar_produto = BD::conn()->prepare("SELECT peso FROM `loja_produtos` WHERE id = ?");
  			$selecionar_produto->execute(array($id));
  			$fetch_produto = $selecionar_produto->fetchObject();

  			$_SESSION['valor_frete_'.$id] = $carrinho->calculaFrete($valor, $cep_origem, $cep, $fetch_produto->peso);
  		}
  	break;
  }
}
$_SESSION['valor_frete'] = 0;
if ($total) {
  foreach($_SESSION['media_produto'] as $id => $qtd){
    $_SESSION['valor_frete_'.$id] = str_replace(",",".",$_SESSION['valor_frete_'.$id]);
    $_SESSION['valor_frete'] += ((int)$_SESSION['valor_frete_'.(int)$id]*(int)$qtd);
  }
}
?>
<?php
  if($login->isLogado()){
    echo '<p id="alert">Seu pedido, será enviado para o endereço informado no seu cadastro</p>';
  }
?>
<head>
  <title>Carrinho</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?php echo PATH; ?>images/favicon.png">
      <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>css/bootstrap.min.css">
    <!--  <link rel="stylesheet" type="text/css" href="</?php echo PATH; ?>css/style.css"> -->
<style>
  body{
    background-color: orange;
  }

  #carrinho-h1{
    background-color: #4c4cff;
    color: #fff;
    padding: 17px 15px;
    margin-top: 0;
    height: 60px;
  }

  #carrinho-h1 span{
    font-family: Verdana, sans-serif;
    font-weight: bold;
    font-size: 21px;
    margin-left: 10px;
  }

  thead{
    background-color: #ddd;
  }

  tr{
    height: 35px;
  }

  tr td p{
    margin-left: 10px;
    margin-top: 10px;
  }

  #tb-img-carrinho{
    width: 180px;
  }

  #tb-img-carrinho img{
    padding: 5px;
  }

  #tb-desc-carrinho{
    width: 380px;
  }

  #tb-desc-carrinho span{
    padding: 5px;
  }

  #tb-deletar-carrinho{
    width: 120px;
  }

  #tb-carrinho{
    width: 170px;
  }

  #th-prd{
    padding-left: 50px;
    font-size: 17px;
  }

  #th-qtd{
    padding-left: 38px;
    padding-right: 38px;
  }

  #uni{
    padding-left: 30px;
    padding-right: 30px;
  }

  #sub{
    padding-left: 50px;
    padding-right: 50px;
  }

  #rmv{
    padding-left: 23px;
    padding-right: 23px;
  }

  .carrinho-page {
    float: left;
    width: 90%;
    height: auto;
    background-color: #f1f1f1;
    margin-top: 56.5px;
    margin-left: 68px;
    margin-right: 68px;
    margin-bottom: 56.5px;
  }

  .carrinho-page span{
    margin: 0;
  }

  .carrinho{
    background-color: #fff;
    margin-left: 10px;
    margin-right: 10px;
  }

  #prd-txt1 {
    float: left;
    vertical-align: middle;
    font-size: 17px;
  }

  .cols-total{
    background-color: #f1f1f1;
  }

  .total {
    background-color: #ddd;
    font-size: 18px;
    font-weight: bold;
  }

  .total-last{
    background-color: #ddd;
    font-size: 18px;
    color: #090;
  }

  #btn-del-carrinho{
    background-color: #ff0000;
    padding: 10px;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
  }

  #opcoes {
    float:left;
    width: 100%;
    height: 165px;
    background-color: #fff;
    margin-left: 0;
    margin-top: 10px;
  }

  .calcular{
    margin-top: 10px;
  }

  .calcular form{
    margin-left: 10px;
  }

  #outros {
    float: right;
    margin-top: 10px;
    margin-right: 10px;
  }

  #continuar {
    padding: 6px;
    float: left;
    color: #fff;
    background-color: #4c4cff;
    border: 1px solid #fff;
    font-size: 16px;
    margin-top: 10px;
    text-decoration: none;
  }

  #finalizar {
    padding: 6px;
    float: left;
    color: #fff;
    background-color: #4CAF50;
    border: 1px solid #fff;
    font-size: 16px;
    margin-top: 10px;
    text-decoration: none;
  }

  #quant{
    border: 1px;
    border-color: #777;
    border-style: solid;
    border-radius: 3px;
    margin-top: 35px;
    text-align: center;
  }

  #update {
    background-color: #4c4cff;
    color: #fff;
    width: 88%;
    padding-left: 2.5px;
    padding-top: 5px;
    padding-bottom: 5px;
    border: 0;
    margin-top: 10px;
    font-size: 14px;
  }

  .btn-frete{
    padding: 6px;
    float: left;
    color: #fff;
    background-color: #4c4cff;
    border: 1px solid #fff;
    font-size: 16px;
    text-decoration: none;
  }

  #resultado-frete{
    font-size: 16px;
    font-weight: bold;
  }

  .calcular span{
    font-size: 16px;
    font-weight: bold;
  }

  .calcular input[type=text],{
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 2px;
    margin-bottom: 2px;
    resize: vertical;
  }

  .calcular select{
    font-size: 15px;
    border-radius: 4px;
    padding: 3px;
    width: 100%;
  }

  #alert {
    padding: 4px;
    background-color: #f44336;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }
</style>
</head>
<body>
<div class="carrinho-page">
  <h1 id="carrinho-h1"><span>Minhas compras</span></h1>

<form action="<?php echo PATH.'carrinho/atualizar'; ?>" method="post" enctype="multipart/form-data">
  <table border="0" class="carrinho">
    <thead>
      <tr>
        <th colspan="2" id="th-prd">Produto</th>
        <th id="th-qtd">Quantidade</th>
        <th id="uni">Valor Unitário</th>
        <th id="sub">Subtotal</th>
        <th id="rmv">Remover</th>
      </tr>
    </thead>

    <tbody>
    <?php
   		if($carrinho->qtdProdutos() == 0){
		    echo '<tr><td colspan="5"><p>Não existem produtos em seu carrinho!</p></td></tr>';
			}
      else{
			  $total = 0;
			  foreach($_SESSION['media_produto'] as $id => $quantidade){
  				$id = (int)$id;
  				$selecao = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE id = ?");
  				$selecao->execute(array($id));
  				$fetchProduto = $selecao->fetchObject();
  	  ?>
      <tr>
        <td align="center" valign="middle" id="tb-img-carrinho">
          <img src="<?php echo PATH; ?>/produtos/<?php echo $fetchProduto->img_padrao; ?>"
          width="180px" height="140px" title="<?php echo $fetchProduto->titulo; ?>" id="prd1"></td>

        <td align="center" valign="middle" id="tb-desc-carrinho">
          <span id="prd-txt1"><?php echo $fetchProduto->titulo; ?></span></td>

        <td align="center" valign="middle" id="tb-carrinho-qtd">
          <input type="text" name="prod[<?php echo $id; ?>]" value="<?php echo $quantidade; ?>" size="1" id="quant"><br>
          <input type="submit" name="atualizar" id="update" value="Atualizar Quantidades"></td>

        <td align="center" valign="middle" id="tb-carrinho">
          R$ <?php echo number_format($fetchProduto->valor_atual,2,',','.'); ?></td>

        <td align="center" valign="middle" id="tb-carrinho">
          R$ <?php echo number_format($fetchProduto->valor_atual * $quantidade,2,',','.'); ?></td>

        <td align="center" valign="middle" id="tb-deletar-carrinho">
          <a href="<?php echo PATH.'carrinho/del/'.$id; ?>" title="Deletar Produto" id="btn-del-carrinho">Deletar</a></td>
      </tr>

<?php $total += $fetchProduto->valor_atual * $quantidade; ?>

<?php } } ?>
      <tr>
        <td colspan="4" class="cols-total"></td>
        <td align="right" valign="middle" class="total">Total:</td>
        <td align="center" valign="middle" class="total-last">R$ <?php echo (isset($_SESSION['valor_frete'])) ?
          number_format($total+$_SESSION['valor_frete'],2,',','.') : number_format($total,2,',','.'); ?></td>
      </tr>
    </tbody>
  </table>
</form>

<div id="opcoes">
  <div id="outros">
    <span id="resultado-frete">Valor do frete: R$ <?php echo number_format($_SESSION['valor_frete'],2,',','.'); ?></span><br>
      <a href="<?php echo PATH.'verificar'; ?>" id="finalizar">Finalizar Compra</a>
      <a href="<?php echo PATH; ?>" id="continuar">Continuar Comprando</a>
  </div>

  <div class="calcular">
    <form action="<?php echo PATH.'carrinho'; ?>" method="post" enctype="multipart/form-data">
      <label>
        <span>Escolha a forma de envio</span><br>
          <select name="frete">
            <option value="">Selecione...</option>
            <option value="pac">PAC</option>
            <option value="sedex">SEDEX</option>
          </select>
      </label>
<br>
      <label>
        <span>Seu CEP</span><br>
        <?php if($login->isLogado()) { ?>
          <input type="text" name="cep" value="<?php echo $usuarioLogado->cep; ?>">
        <?php }else{ ?>
          <input type="text" name="cep" value="">
        <?php } ?>
      </label><br>
      <input type="hidden" name="acao" value="calcular">
      <input type="submit" value="Calcular Frete" class="btn-frete">
    </form>
  </div>
</div>

</div>
<?php
  if ($total) {
    (isset($_SESSION['valor_frete'])) ?
      $_SESSION['total_compra'] = number_format($total+$_SESSION['valor_frete'],2,',','.') :
      $_SESSION['total_compra'] = number_format($total,2,',','.');
      $_SESSION['total_compra'] = str_replace(",",".", $_SESSION['total_compra']);
  }
?>
