<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadCat'):
    include_once "inc/slug.php";
    $categoria = strip_tags(filter_input(INPUT_POST, 'categoria'));
    $slug = slug($categoria);

    $val->set($categoria, 'Categoria')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="alert">'.$erro[0].'</div>';
    }
    else{
      $dados = array('titulo' => $categoria, 'slug' => $slug, 'views' => 0);
      if($site->inserir('loja_categorias', $dados)){
        echo '<div class="success">Categoria foi inserida com sucesso!</div>';
      }
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
</style>
</head>
<body>
<h1 class="title">Cadastrar Nova Categoria</h1>
<div id="formularios" style="margin-left:10px;">
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Nome da Categoria</span>
      <input type="text" name="categoria">
    </label><br>
    <input type="hidden" name="acao" value="cadCat">
    <input type="submit" value="Cadastrar Categoria">
  </form>
</div>
</body>
