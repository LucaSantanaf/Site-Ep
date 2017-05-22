<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'):
    include_once "inc/slug.php";
    $img_padrao = $_FILES['img_padrao'];
    $titulo = strip_tags(filter_input(INPUT_POST, 'titulo'));
    $slug = slug($titulo);
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];

    $val_anterior = $_POST['valAnterior'];
    $val_atual = $_POST['valAtual'];
    $descricao = htmlentities($_POST['descricao'], ENT_QUOTES);
    $peso = strip_tags(filter_input(INPUT_POST, 'peso'));
    $qtdEstoque = strip_tags(filter_input(INPUT_POST, 'qtdEstoque'));

    $verificar_slug = BD::conn()->prepare("SELECT id FROM `loja_produtos` WHERE slug = ?");
    $verificar_slug->execute(array($slug));
    if($verificar_slug->rowCount() > 0){
      $slug .= $verificar_slug->rowCount();
    }

    $val->set($titulo, 'Titulo')->obrigatorio();
    $val->set($categoria, 'Categoria')->obrigatorio();
    $val->set($subcategoria, 'Subcategoria')->obrigatorio();
    $val->set($val_atual, 'Valor Atual')->obrigatorio();
    $val->set($descricao, 'Descrição')->obrigatorio();
    $val->set($peso, 'Peso')->obrigatorio();
    $val->set($qtdEstoque, 'Quantidade em Estoque')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="alert">Erro: '.$erro[0].'</div>';
    }
    elseif($img_padrao['error'] == '4'){
      echo '<div class="warning">Informe uma imagem padrão para o produto</div>';
    }
    else{
      $nomeImg = md5(uniqid(rand(), true)).$img_padrao['name'];
      $site->upload($img_padrao['tmp_name'], $img_padrao['name'], $nomeImg, '350', '../../produtos/');
      $now = date('Y-m-d H:i:s');

      $dados = array('img_padrao' => $nomeImg,
                     'titulo' => $titulo,
                     'slug' => $slug,
                     'categoria' => $categoria,
                     'subcategoria' => $subcategoria,
                     'valor_anterior' => $val_anterior,
                     'valor_atual' => $val_atual,
                     'descricao' => $descricao,
                     'peso' => $peso,
                     'estoque' => $qtdEstoque,
                     'qtdVendidos' => 0,
                     'data' => $now);
      if($site->inserir('loja_produtos', $dados)){
        $_SESSION['ultimoId'] = BD::conn()->lastInsertId();
        header("location: Index.php?pagina=passo2");
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
    width:50%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width:50%;
  }

  .cad-produto{
    float: left;
    width: 100%;
    margin-bottom: 10px;
  }

  .fix{
    float: left;
  }

  .fix-right{
    float: right;
    margin-right: 70px;
  }

  .fix-tiny{
    float: left;
    width: 100%;
  }

  .fix-tiny-right{
    float: right;
    margin-top: -160px;
    margin-right: 70px;
  }

  #label-fix-tiny{
    margin-right: 10px;
  }

  form{
    margin-left:20px;
  }
</style>
</head>
<body>
<h1 class="title">Cadastrar novo produto</h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Imagem Padrão</span><br>
      <input type="file" name="img_padrao">
    </label><br>

    <label>
      <span>Titulo do produto</span><br>
      <input type="text" name="titulo">
    </label><br>

      <div class="fix">
        <label>
          <span>Escolha a Categoria:</span><br>
          <select name="categoria">
            <option value="" selected="selected">Selecione...</option>
            <?php
              $pegar_categorias = BD::conn()->prepare("SELECT * FROM `loja_categorias` ORDER BY id DESC");
              $pegar_categorias->execute();
              while($cat = $pegar_categorias->fetchObject()){
            ?>
            <option value="<?php echo $cat->slug; ?>"><?php echo $cat->titulo; ?></option>
            <?php } ?>
          </select>
        </label><br>

        <label>
          <span>Escolha a Subcategoria:</span><br>
          <select name="subcategoria">
            <option value="" selected="selected">Selecione...</option>
          </select>
        </label>
      </div><br>

      <div class="fix-right">
        <label>
          <span>Valor Anterior</span><br>
          <input type="text" name="valAnterior" id="preco">
        </label><br>

        <label>
          <span>Valor Atual</span><br>
          <input type="text" name="valAtual" id="preco1">
        </label>
      </div><br>

    <div class="fix-tiny">
      <label id="label-fix-tiny">
        <span>Escreva as características deste produto</span><br>
        <textarea name="descricao" class="tinymce" cols="30" rows="5"></textarea>
      </label><br>

      <div class="fix-tiny-right">
        <label>
          <span>Peso do Produto</span><br>
          <input type="text" name="peso">
        </label><br>

        <label>
          <span>Quantidade em estoque</span><br>
          <input type="text" name="qtdEstoque">
        </label><br>

        <input type="hidden" name="acao" value="cadastrar">
        <input type="submit" value="Próximo Passo">
      </div>
    </div>
  </form>
</div>
</body>
