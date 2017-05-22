<head>
<style>
  th, td{
    color:#fff;
    text-align:center;
  }

  .list{
    border-color:#fff;
    margin-left:5px;
    margin-right:5px;
    width:90%;
  }
</style>
</head>
<body>
<h1 class="title">Administradores Cadastrados</h1>
<table border="1" class="list">
  <thead>
    <tr>
      <th valign="middle">Nome</th>
      <th valign="middle">Email</th>
      <th valign="middle">Tipo</th>
      <th valign="middle">Editar</th>
      <th valign="middle">Excluir</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pegar_adms = BD::conn()->prepare("SELECT * FROM `loja_adm` WHERE id != ?");
    $pegar_adms->execute(array($usuarioLogado->id));
    if($pegar_adms->rowCount() == 0){
      echo '<tr><td colspan="4" id="td">Não foram encontrados Administradores!</td></tr>';
    }
    else{
      while($camposListar = $pegar_adms->fetchObject()){
        $tipo = ($camposListar->tipo == '1') ? 'Admin' : 'Editor';
  ?>
    <tr>
      <td valign="middle"><?php echo $camposListar->nome.' '.$camposListar->sobrenome; ?></td>
      <td valign="middle"><?php echo $camposListar->email_log; ?></td>
      <td valign="middle"><?php echo $tipo; ?></td>
      <td valign="middle">
        <a href="Index.php?pagina=editarAdm&adm=<?php echo $camposListar->id; ?>">
          <img src="images/editar.png"></a></td>
      <td valign="middle">
        <a href="Index.php?pagina=listarAdms&excluir=sim&adm=<?php echo $camposListar->id; ?>">
          <img src="images/excluir.png" width="30px" height="30px"></a></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>
<?php
  if(isset($_GET['excluir']) && $_GET['excluir'] == 'sim'):
    $id_adm = (int)$_GET['adm'];
    $deletar = BD::conn()->prepare("DELETE FROM `loja_adm` WHERE id = ?");
    if($deletar->execute(array($id_adm))){
      echo '<script>alert("Administrador excluído com sucesso!");location.href="?pagina=listarAdms"</script>';
    }
  endif;
?>
</body>
