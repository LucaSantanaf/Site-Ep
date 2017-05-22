<?php
	$id = (int)$_GET['subcategoria'];
	$pegar_subcategoria = BD::conn()->prepare("SELECT * FROM `loja_subcategorias` WHERE id = ?");
	$pegar_subcategoria->execute(array($id));
	$fetchSub = $pegar_subcategoria->fetchObject();

  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'){
  	$categoria = $_POST['categorias'];
  	$subcategoria = strip_tags(filter_input(INPUT_POST, 'subcategoria'));

  	$val->set($categoria, 'Categoria')->obrigatorio();
  	$val->set($subcategoria, 'Subcategoria')->obrigatorio();

  	if(!$val->validar()){
  		$erro = $val->getErro();
  		echo '<div class="alert">Erro: '.$erro[0].'</div>';
  	}
    else{
  		$atualizarSub = BD::conn()->prepare("UPDATE `loja_subcategorias` SET id_cat = ?, titulo = ? WHERE id = ?");
  		$dadosAtualizar = array($categoria, $subcategoria, $id);
  		if($atualizarSub->execute($dadosAtualizar)){
  			echo '<script>alert("Subcategoria foi editada com sucesso, porem o caminho no site não mudou para questões de organização");
  			location.href="index.php?pagina=editarSubcategoria&subcategoria='.$id.'"</script>';
  	}
  }
}
?>
<head>
<style>
	input[type=text], [type=password], select {
			width: 100%;
			padding: 5px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
			margin-top: 2px;
			margin-bottom: 2px;
			resize: vertical;
	}

	input[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 8px 12px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	.alert {
		padding: 10px;
		background-color: #f44336;
		color: white;
		width:50%;
	}

	#formularios{
		margin-left:10px;
	}
</style>
</head>
<body>
<h1 class="title">Editar Subcategoria: <?php echo $fetchSub->titulo; ?></h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Selecione a Categoria</span><br>
        <select name="categorias">
          <?php
            $pegar_cats = BD::conn()->prepare("SELECT * FROM `loja_categorias` ORDER BY id DESC");
            $pegar_cats->execute();
            while($cat = $pegar_cats->fetchObject()){
              if($cat->id == $fetchSub->id_cat){
                echo '<option value="'.$cat->id.'" selected="selected">'.$cat->titulo.'</option>';
              }
              else{
                echo '<option value="'.$cat->id.'">'.$cat->titulo.'</option>';
              }
            }
          ?>
        </select>
      </label><br>

      <label>
        <span>Nome da Subcategoria:</span><br>
        <input type="text" name="subcategoria" value="<?php echo $fetchSub->titulo; ?>">
      </label><br>
    </div>

    <input type="hidden" name="acao" value="editar">
    <input type="submit" value="Editar Subcategoria">
  </form>
</div>
</body>
