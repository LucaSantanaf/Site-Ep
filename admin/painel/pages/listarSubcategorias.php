<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'){
  	$subcatId = (int)$_GET['subcat'];
  	$deletar = BD::conn()->prepare("DELETE FROM `loja_subcategorias` WHERE id = ?");

  	if($deletar ->execute(array($subcatId))){
  		echo '<script>alert("Subcategoria excluida com sucesso!");location.href="Index.php?pagina=listarSubcategorias"</script>';
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
    border-color: #fff;
    margin-left:10px;
  }

  .title{
    margin-left: 10px;
  }
</style>
</head>
<body>
<h1 class="title">Editar Subcategorias</h1>
<table border="1" class="list">
  <thead>
    <tr>
      <th valign="middle">Categoria</th>
      <th valign="middle">Titulo de Subcategoria</th>
      <th valign="middle">Views</th>
      <th valign="middle">Editar</th>
      <th valign="middle">Excluir</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pegar_subcategorias = BD::conn()->prepare("SELECT * FROM `loja_subcategorias` ORDER BY id DESC");
    $pegar_subcategorias->execute();
    if($pegar_subcategorias->rowCount() == 0){
      echo '<tr><td colspan="5">Não existem subcategorias cadastradas</td></tr>';
    }
    else{
      while($subcat = $pegar_subcategorias->fetchObject()){
        $cat = BD::conn()->prepare("SELECT titulo FROM `loja_categorias` WHERE id = ?");
        $cat->execute(array($subcat->id_cat));
        $fetchCat = $cat->fetchObject();
  ?>
    <tr>
      <td valign="middle"><?php echo $fetchCat->titulo; ?></td>
      <td valign="middle"><?php echo $subcat->titulo; ?></td>
      <td valign="middle"><?php echo $subcat->views; ?></td>
      <td valign="middle">
        <a href="?pagina=editarSubcategoria&subcategoria=<?php echo $subcat->id;?>">
          <img src="images/editar.png"></a></td>
      <td valign="middle">
        <a href="#" onClick="javascript:confirmSub(<?php echo $subcat->id; ?>);">
          <img src="images/excluir.png" width="30px" height="30px"></a></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>
</body>
