<head>
<style>
  body{
    background-color: orange;
  }

  table{
    margin-left:10px;
    margin-right:5px;
    width:90%;
  }

  tr{
    background-color: #ddd;
  }

  .home-cliente{
    background-color: #f1f1f1;
    margin-left: 166px;
    margin-right: 166px;
    width: 70%;
  }

  .title-det-compra{
    background-color: #4c4cff;
		padding: 10px 15px;
    height: 60px;
    color: #fff;
    margin: 0;
  }

  .title-detalhes-compra{
    background-color: #777;
    margin: 10px 0;
    padding: 13px 15px;
    height: 50px;
    color: #fff;
  }

	.title-detalhes-compra span{
		font-family: Verdana, sans-serif;
		font-weight: bold;
		font-size: 21px;
		margin-left: 10px;
	}

  .dados-pedido{
     margin: 10px;
     width: 58%;
  }

  .endereco-entrega{
    margin: 10px;
    width: 90%;
  }

  .produtos-pedidos{
    width: 75%;
    margin: 10px;
  }

  #td-left-det-compra{
    background-color: #ddd;
    padding-left: 5px;
  }

  #td-right-det-compra{
    background-color: #fff;
    padding-left: 5px;
  }

  #cod-ras-det-compra-left{
    width: 27%;
  }

  #cod-ras-det-compra-right{
    width: 73%;
    padding-left: 5px;
  }

  #ende-entrega-left{
    background-color: #ddd;
    padding-left: 5px;
    width: 15%;
  }

  #ende-entrega-right{
    background-color: #fff;
    padding-left: 5px;
    width: 85%;
  }

  #dados-pedido-det-compra-left, #left-det-compra{
    background-color: #ddd;
    padding-left: 5px;
    width: 37%;
  }

  #dados-pedido-det-compra-right, #right-det-compra{
    background-color: #fff;
    padding-left: 5px;
    width: 63%;
  }

  #produtos-ped-prod{
    width: 56%;
  }

  #produtos-ped-val-uni{
    width: 22%;
  }

  #produtos-ped-quant{
    width: 22%;
  }

  #det-compra{
    background-color: #fff;
  }
</style>
</head>
<body>
<div class="home-cliente">
<h1 class="title-det-compra">Detalhes da compra</h1>
<?php
  $idCompra = (int)$_GET['id'];
  $pegar_dados_compra = BD::conn()->prepare("SELECT * FROM `loja_pedidos` WHERE id = ? AND id_cliente = ?");
  $data = array($idCompra, $usuarioLogado->id_cliente);
  $pegar_dados_compra->execute($data);

  if($pegar_dados_compra->rowCount() == 0){
    echo '<script>alert("Não foi possível encontrar este pedido!");location.href="Index.php"</script>';
  }
  else{
    $fetchCompra = $pegar_dados_compra->fetchObject();
    if($fetchCompra->status == 0){
      $status = 'Pendente';
    }
    elseif($fetchCompra->status == 1){
      $status = 'Aguardando Envio';
    }
    elseif($fetchCompra->status == 2){
      $status = 'Pedido Enviado';
    }
  }
?>
<h3 class="title-detalhes-compra"><span>Endereço de entrega</span></h3>
<table border="1" class="endereco-entrega">
  <tr>
    <td id="ende-entrega-left">Rua:</td>
    <td id="ende-entrega-right"><?php echo $usuarioLogado->rua; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">Número:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->numero; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">Complemento:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->complemento; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">Bairro:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->bairro; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">Cidade:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->cidade; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">UF:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->uf; ?></td>
  </tr>

  <tr>
    <td id="td-left-det-compra">CEP:</td>
    <td id="td-right-det-compra"><?php echo $usuarioLogado->cep; ?></td>
  </tr>
</table>

<h3 class="title-detalhes-compra"><span>Dados do Pedido</span></h3>
<table border="1" class="dados-pedido">
  <tr>
    <td id="dados-pedido-det-compra-left">Status do Pedido:</td>
    <td id="dados-pedido-det-compra-right"><?php echo $status; ?></td>
  </tr>
<?php if($fetchCompra->status == 2): ?>
  <tr>
    <td id="cod-ras-det-compra-left">Código de rastreamento:</td>
    <td id="cod-ras-det-compra-right"><?php echo $fetchCompra->codigo_rastreio; ?>
      <a href="http://websro.correios.com.br/sro_bin/txect01$.Inexistente?P_LINGUA=001&P_TIPO=002&P_COD_LIS=<?php echo $fetchCompra->codigo_rastreio;?>" target="_blank">Rastrear</a></td>
  </tr>
<?php endif; ?>
  <tr>
    <td id="left-det-compra">Valor total da compra:</td>
    <td id="right-det-compra">R$ <?php echo number_format($fetchCompra->valor_total, 2,',','.'); ?></td>
  </tr>

  <tr>
    <td id="left-det-compra">Tipo de Frete:</td>
    <td id="right-det-compra"><?php echo $fetchCompra->tipo_frete; ?></td>
  </tr>

  <tr>
    <td id="left-det-compra">Valor do Frete:</td>
    <td id="right-det-compra"><?php echo number_format($fetchCompra->valor_frete, 2,',','.'); ?></td>
  </tr>

  <tr>
    <td id="left-det-compra">Data de Criação:</td>
    <td id="right-det-compra"><?php echo date('d/m/Y', strtotime($fetchCompra->criado)); ?></td>
  </tr>

  <tr>
    <td id="left-det-compra">Última Modificação:</td>
    <td id="right-det-compra"><?php echo date('d/m/Y', strtotime($fetchCompra->modificado)); ?></td>
  </tr>
</table>

<h3 class="title-detalhes-compra"><span>Produtos do Pedido</span></h3>
<table border="1" class="produtos-pedidos">
  <thead>
    <tr>
      <th id="produtos-ped-prod">Produto</th>
      <th id="produtos-ped-val-uni">Valor Unitário</th>
      <th id="produtos-ped-quant">Quantidade</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pegar_produtos = BD::conn()->prepare("SELECT * FROM `loja_produtos_pedidos` WHERE id_pedido = ?");
    $pegar_produtos->execute(array($idCompra));

    while($produto = $pegar_produtos->fetchObject()){
      $pegar_dados_produto = BD::conn()->prepare("SELECT titulo, valor_atual FROM `loja_produtos` WHERE id = ?");
      $pegar_dados_produto->execute(array($produto->id_produto));
      $fetch = $pegar_dados_produto->fetchObject();
  ?>
    <tr>
      <td id="det-compra"><?php echo $fetch->titulo; ?></td>
      <td id="det-compra"><?php echo number_format($fetch->valor_atual, 2, ',','.'); ?></td>
      <td id="det-compra"><?php echo $produto->qtd; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>
</body>
