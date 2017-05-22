<head>
<style>
  th, td{
    color:#fff;
    text-align:center;
  }

  .list{
    border-color:#fff;
    margin-left:10px;
    margin-right:10px;
  }
</style>

</head>
<body>
<h1 class="title">Clientes Cadastrados</h1>
<table border="1" class="list">
  <thead>
    <tr>
      <th valign="middle">Nome</th>
      <th valign="middle">Email</th>
      <th valign="middle">Telefone</th>
      <th valign="middle">Último Login</th>
      <th valign="middle">Editar</th>
      <th valign="middle">Excluir</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pegar_clientes = BD::conn()->prepare("SELECT id_cliente, imagem, nome, sobrenome, email, telefone, data_log
                                           FROM `loja_clientes` ORDER BY id_cliente DESC");
    $pegar_clientes->execute();
    if($pegar_clientes->rowCount() == 0){
      echo '<tr><td colspan="6">Desculpe, mas não foram encontrados clientes cadastrados!</td></tr>';
    }
    else{
      while($cliente = $pegar_clientes->fetchObject()){
  ?>
    <tr>
      <td valign="middle"><?php echo $cliente->nome.' '.$cliente->sobrenome; ?></td>
      <td valign="middle"><?php echo $cliente->email; ?></td>
      <td valign="middle"><?php echo $cliente->telefone; ?></td>
      <td valign="middle"><?php echo date('d/m/Y H:i:s', strtotime($cliente->data_log)); ?></td>
      <td valign="middle">
        <a href="Index.php?pagina=editarCliente&cliente=<?php echo $cliente->id_cliente; ?>">
          <img src="images/editar.png"></a></td>
      <td valign="middle">
        <a href="Index.php?pagina=listarClientes&deletar=sim&cliente=<?php echo $cliente->id_cliente; ?>">
          <img src="images/excluir.png" width="30px" height="30px"></a></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>
<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
    $id_cliente = (int)$_GET['cliente'];

    $dados_cliente = BD::conn()->prepare("SELECT imagem FROM `loja_clientes` WHERE id_cliente = ?");
    $dados_cliente->execute(array($id_cliente));
    $fetchCliente = $dados_cliente->fetchObject();

    if($fetchCliente->imagem == ''){
      $verificar_pedidos = BD::conn()->prepare("SELECT * FROM `loja_pedidos` WHERE id_cliente = ?");
      $verificar_pedidos->execute(array($id_cliente));

      if($verificar_pedidos->rowCount() >= 1){
        while($fetch_pedido = $verificar_pedidos->fetchObject()){
          $deletar_pedido = BD::conn()->prepare("DELETE FROM `loja_pedidos` WHERE id = ?");

          if($deletar_pedido->execute(array($fetch_pedido->id))){
            $deletar_produtos_pedidos = BD::conn()->prepare("DELETE FROM `loja_produtos_pedidos` WHERE id_pedido = ?");
            $deletar_produtos_pedidos->execute(array($fetch_pedido->id));
          }
        }
      $deletar = BD::conn()->prepare("DELETE FROM `loja_clientes` WHERE id_cliente = ?");
        if($deletar->execute(array($id_cliente))){
          echo '<script>alert("O cliente foi excluído com sucesso!");location.href="?pagina=listarClientes"</script>';
        }
      }
    }
    else{
      unlink('../../clientes/'.$fetchCliente->imagem);
      $verificar_pedidos = BD::conn()->prepare("SELECT * FROM `loja_pedidos` WHERE id_cliente = ?");
      $verificar_pedidos->execute(array($id_cliente));

      if($verificar_pedidos->rowCount() >= 1){
        while($fetch_pedido = $verificar_pedidos->fetchObject()){
          $deletar_pedido = BD::conn()->prepare("DELETE FROM `loja_pedidos` WHERE id = ?");

          if($deletar_pedido->execute(array($fetch_pedido->id))){
            $deletar_produtos_pedidos = BD::conn()->prepare("DELETE FROM `loja_produtos_pedidos` WHERE id_pedido = ?");
            $deletar_produtos_pedidos->execute(array($fetch_pedido->id));
          }
        }
      $deletar = BD::conn()->prepare("DELETE FROM `loja_clientes` WHERE id_cliente = ?");
        if($deletar->execute(array($id_cliente))){
          echo '<script>alert("O cliente foi excluído com sucesso!");location.href="?pagina=listarClientes"</script>';
        }
      }
    }
  endif;
?>
</body>
