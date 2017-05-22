<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'):
    include_once "inc/slug.php";
    $categoria = $_POST['categorias'];
    $subcategoria = strip_tags(filter_input(INPUT_POST, 'subcategoria'));
    $slug = slug($subcategoria);

    $val->set($categoria, 'Categoria')->obrigatorio();
    $val->set($subcategoria, 'Subcategoria')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="alert">Erro: '.$erro[0].'</div>';
    }
    else{
      $dados = array('id_cat' => $categoria, 'titulo' => $subcategoria, 'slug' => $slug, 'views' => 0);
      if($site->inserir('loja_subcategorias', $dados)){
        echo '<div class="success">A subcategoria foi cadastrada com sucesso!</div>';
      }
    }
  endif;
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
    width: 100%;
  }

  .success {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    width: 100%;
  }

  .info {
    padding: 10px;
    background-color: #2196F3;
    color: white;
    width: 100%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width: 100%;
  }
</style>
</head>
<body>
<h1 class="title">Cadastrar Nova Subcategoria</h1>
<div id="formularios" style="margin-left:10px;">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Selecione a Categoria</span><br>
        <select name="categorias">
          <option value="" selected="selected">Escolha a Categoria...</option>
          <?php
            $pegar_cats = BD::conn()->prepare("SELECT * FROM `loja_categorias` ORDER BY id DESC");
            $pegar_cats->execute();
            while($cat = $pegar_cats->fetchObject()){
              echo '<option value="'.$cat->id.'">'.$cat->titulo.'</option>';
            }
          ?>
        </select>
      </label><br>

      <label>
        <span>Nome da Subcategoria:</span><br>
        <input type="text" name="subcategoria">
      </label><br>
    </div>

    <input type="hidden" name="acao" value="cadastrar">
    <input type="submit" value="Cadastrar Subcategoria">
  </form>
</div>
</body>
