<?php
  $id_pedido = (int)$_GET['compra_id'];
  $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_pedidos` WHERE id = ?");
  $pegar_dados->execute(array($id_pedido));
  $fetchPedido = $pegar_dados->fetchObject();
  if($fetchPedido->status == 0){
    $status = 'Pendente';
  }
  elseif($fetchPedido->status == 1){
    $status = 'Aguardando Envio';
  }
  elseif($fetchPedido->status == 2){
    $status = 'Pedido Enviado';
  }

  $pegar_cliente = BD::conn()->prepare("SELECT * FROM `loja_clientes` WHERE id_cliente = ?");
  $pegar_cliente->execute(array($fetchPedido->id_cliente));
  $dadosCliente = $pegar_cliente->fetchObject();
?>
<head>
<style>
  .list{
     border-color:#fff;
     margin-left:10px;
     margin-right:5px;
     width:90%;
  }

  div.ocultar{
    display:none;
  }

  th, td{
    padding-left:5px;
    color:#fff;
  }

  input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #deletar{
    background-color: #ff0000;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-top: 15px;
    margin-bottom: 15px;
  }

  #td-compra, #td-rastreamento{
    width:27%;
  }

  #td-com, #td-ras{
    width:73%;
  }

  #td-rua{
    width:15%;
  }

  #td-r{
    width:85%;
  }

  #td-pedido{
    width:30%;
  }

  #td-ped{
    width:70%;
  }
</style>
</head>
<body>
<h1 class="title">Detalhes da Compra</h1>
<table border="1" class="list">
  <tr>
    <td id="td-compra">Compra realizada por:</td>
    <td id="td-com"><?php echo $dadosCliente->nome.' '.$dadosCliente->sobrenome; ?></td>
  </tr>

  <tr>
    <td>E-mail</td>
    <td><?php echo $dadosCliente->email; ?></td>
  </tr>

  <tr>
    <td>Telefone</td>
    <td><?php echo $dadosCliente->telefone; ?></td>
  </tr>

  <tr>
    <td>CPF do Cliente</td>
    <td><?php echo $dadosCliente->cpf; ?></td>
  </tr>
</table>

<h1 class="title">Endereço de entrega</h1>
<table border="1" class="list">
  <tr>
    <td id="td-rua">Rua:</td>
    <td id="td-r"><?php echo $dadosCliente->rua; ?></td>
  </tr>

  <tr>
    <td>Número:</td>
    <td><?php echo $dadosCliente->numero; ?></td>
  </tr>

  <tr>
    <td>Complemento:</td>
    <td><?php echo $dadosCliente->complemento; ?></td>
  </tr>

  <tr>
    <td>Bairro:</td>
    <td><?php echo $dadosCliente->bairro; ?></td>
  </tr>

  <tr>
    <td>Cidade:</td>
    <td><?php echo $dadosCliente->cidade; ?></td>
  </tr>

  <tr>
    <td>UF:</td>
    <td><?php echo $dadosCliente->uf; ?></td>
  </tr>

  <tr>
    <td>CEP:</td>
    <td><?php echo $dadosCliente->cep; ?></td>
  </tr>
</table>

<h1 class="title">Dados do Pedido</h1>
<table border="1" class="list">
  <tr>
    <td id="td-pedido">Status do Pedido:</td>
    <td id="td-ped"><?php echo $status; ?></td>
  </tr>
  <?php if($fetchPedido->status == 2): ?>
  <tr>
    <td id="td-rastreamento">Código de rastreamento:</td>
    <td id="td-ras"><?php echo $fetchPedido->codigo_rastreio; ?></td>
  </tr>
  <?php endif; ?>

  <tr>
    <td>Valor total da compra:</td>
    <td>R$ <?php echo number_format($fetchPedido->valor_total, 2,',','.'); ?></td>
  </tr>

  <tr>
    <td>Tipo de Frete:</td>
    <td><?php echo $fetchPedido->tipo_frete; ?></td>
  </tr>

  <tr>
    <td>Valor do Frete:</td>
    <td><?php echo number_format($fetchPedido->valor_frete, 2,',','.'); ?></td>
  </tr>

  <tr>
    <td>Data de Criação:</td>
    <td><?php echo date('d/m/Y', strtotime($fetchPedido->criado)); ?></td>
  </tr>
</table>

<h1 class="title">Produtos do Pedido</h1>
<table border="1" class="list">
  <thead>
    <tr>
      <th>Produto</th>
      <th>Valor Unitário</th>
      <th>Quantidade</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pegar_produtos = BD::conn()->prepare("SELECT * FROM `loja_produtos_pedidos` WHERE id_pedido = ?");
    $pegar_produtos->execute(array($fetchPedido->id));

    while($produto = $pegar_produtos->fetchObject()){
      $pegar_dados_produto = BD::conn()->prepare("SELECT titulo, valor_atual FROM `loja_produtos` WHERE id = ?");
      $pegar_dados_produto->execute(array($produto->id_produto));
      $fetch = $pegar_dados_produto->fetchObject();
  ?>
    <tr>
      <td><?php echo $fetch->titulo; ?></td>
      <td><?php echo number_format($fetch->valor_atual, 2, ',','.'); ?></td>
      <td><?php echo $produto->qtd; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<br>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <div>
      <label>
        <span>Mudar status do pedido:</span>
        <select name="status">
          <option value="0" <?php if($fetchPedido->status == 0){echo 'selected';} ?> >Pendente</option>
          <option value="1" <?php if($fetchPedido->status == 1){echo 'selected';} ?> >Aguardando Envio</option>
          <option value="2" <?php if($fetchPedido->status == 2){echo 'selected';} ?> >Pedido Enviado</option>
        </select>
      </label>

      <div class="ocultar">
        <label>
          <span>Código de rastreio:</span>
          <input type="text" name="codigo" value="">
        </label>
      </div>
    </div>
  <input type="hidden" name="acao" value="mudar">
  <input type="submit" value="Mudar Status">
</div>
<a href="#" id="deletar" onClick="javascript:confirmPedido(<?php echo $id_pedido; ?>);">Deletar Pedido</a>
<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'mudar'):
    $status = $_POST['status'];
    $codigo_rastreio = strip_tags(filter_input(INPUT_POST, 'codigo'));

    if($codigo_rastreio == ''){
      $atualizar = BD::conn()->prepare("UPDATE `loja_pedidos` SET `status` = ? WHERE id = ?");
      $dados = array($status, $id_pedido);
      if($atualizar->execute($dados)){
        echo '<script>alert("Status modificado com sucesso!");location.href="?pagina=detalhes_compra&compra_id='.$id_pedido.'"</script>';
      }
    }
    else{
      $atualizar = BD::conn()->prepare("UPDATE `loja_pedidos` SET `status` = ?, codigo_rastreio = ? WHERE id = ?");
      $dados = array($status, $codigo_rastreio, $id_pedido);
      if($atualizar->execute($dados)){
        echo '<script>alert("Status modificado com sucesso!");location.href="?pagina=detalhes_compra&compra_id='.$id_pedido.'"</script>';
      }
    }
  endif;

  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'){
    $deletar = BD::conn()->prepare("DELETE FROM `loja_pedidos` WHERE id = ?");
    if($deletar->execute(array($id_pedido))){
      $deletar_produtos_pedidos = BD::conn()->prepare("DELETE FROM `loja_produtos_pedidos` WHERE id_pedido = ?");
      if($deletar_produtos_pedidos->execute(array($id_pedido))){
        echo '<script>alert("Pedido excluído com sucesso!");location.href="Index.php"</script>';
      }
    }
  }
?>
</body>
