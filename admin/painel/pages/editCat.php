<?php
  $id_categoria = (int)$_GET['categoria_id'];
  $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_categorias` WHERE id = ?");
  $pegar_dados->execute(array($id_categoria));
  $fetch_categoria = $pegar_dados->fetchObject();

  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'):
    $categoria = strip_tags(filter_input(INPUT_POST, 'categoria'));
    $atualizar = BD::conn()->prepare("UPDATE `loja_categorias` SET titulo = ? WHERE id = ?");

    if($atualizar->execute(array($categoria, $id_categoria))){
      echo '<script>alert("A categoria foi editada corretamente! Porém seu caminho não mudará no site, por questões
            de organização");location.href="?pagina=editCat&categoria_id='.$id_categoria.'"</script>';
    }
  endif;
?>
<head>
<style>
  input[type=text], [type=password] {
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

  #formularios{
    margin-left:10px;
  }
</style>
</head>
<body>
<h1 class="title">Editar Categoria: <?php echo $fetch_categoria->titulo; ?></h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Nome da Categoria</span>
      <input type="text" name="categoria">
    </label><br>
    <input type="hidden" name="acao" value="editar">
    <input type="submit" value="Editar Categoria">
  </form>
</div>
</body>
