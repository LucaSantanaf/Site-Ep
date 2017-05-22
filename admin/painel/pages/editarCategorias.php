<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'){
  	$id_categoria = (int)$_GET['categoria_id'];
  	$deletar_categoria = BD::conn()->prepare("DELETE FROM `loja_categorias` WHERE id = ?");

  	if($deletar_categoria->execute(array($id_categoria))){
  		echo '<script>alert("Categoria excluida com sucesso!");location.href="Index.php?pagina=editarCategorias"</script>';
  	}
  }
?>
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
<h1 class="title">Editar Categorias</h1>
<table border="1" class="list">
  <thead>
    <tr>
      <th valign="middle">Titulo</th>
      <th valign="middle">Visualizações</th>
      <th valign="middle">Editar</th>
      <th valign="middle">Excluir</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $array = array('id', 'titulo', 'views');
    $site->selecionar('loja_categorias', $array);
    foreach($site->listar() as $categorias){
  ?>
    <tr>
      <td valign="middle"><?php echo $categorias['titulo']; ?></td>
      <td valign="middle"><?php echo $categorias['views']; ?></td>
      <td valign="middle">
        <a href="Index.php?pagina=editCat&categoria_id=<?php echo $categorias['id']; ?>">
          <img src="images/editar.png"></a></td>
      <td valign="middle">
        <a href="#" onClick="javascript:confirmCat(<?php echo $categorias['id']; ?>);">
          <img src="images/excluir.png" width="30px" height="30px"></a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</body>
