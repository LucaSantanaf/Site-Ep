<?php
  $idProduto = (int)$_GET['produto'];
  $pegar_dados_produto = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE id = ?");
  $pegar_dados_produto->execute(array($idProduto));
  $dadosProd = $pegar_dados_produto->fetchObject();

  //Codigo para edição do produto
  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'){
    $imagemPadrao = $_FILES['img_padrao'];
    $titulo = strip_tags(filter_input(INPUT_POST, 'titulo'));
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $valAnterior = $_POST['valAnterior'];
    $valAtual = $_POST['valAtual'];
    $descricao = htmlentities($_POST['descricao'], ENT_QUOTES);
    $peso = strip_tags(filter_input(INPUT_POST, 'peso'));
    $qtdEstoque = strip_tags(filter_input(INPUT_POST, 'qtdEstoque'));

    if($imagemPadrao['error'] == '4'){
      //Não selecionou uma nova imagem
      if($categoria == '' && $subcategoria == ''){
        $update = BD::conn()->prepare("UPDATE `loja_produtos` SET titulo = ?, valor_anterior = ?, valor_atual = ?,
          descricao = ?, peso = ?, estoque = ? WHERE id = ?");
        $dados = array($titulo, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);

        if($update->execute($dados)){
          echo '<script>alert("O Produto foi editado com sucesso!");location.href="Index.php?pagina=editProduto&produto='.$idProduto.'"</script>';
        }
      }
      else{
        $update = BD::conn()->prepare("UPDATE `loja_produtos` SET titulo = ?, categoria = ?, subcategoria = ?,
          valor_anterior = ?, valor_atual = ?, descricao = ?, peso = ?, estoque = ? WHERE id = ?");
        $dados = array($titulo, $categoria, $subcategoria, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);

        if($update->execute($dados)){
          echo '<script>alert("O Produto foi editado com sucesso!");location.href="Index.php?pagina=editProduto&produto='.$idProduto.'"</script>';
        }
      }
    }//Se preencher uma categoria e subcategoria
    else{
      //Selecionou uma nova imagem
      if($categoria == '' && $subcategoria == ''){
        unlink('../../produtos/'.$dadosProd->img_padrao);
        $nomeImg = md5(uniqid(rand(), true)).$imagemPadrao['name'];

        if($site->upload($imagemPadrao['tmp_name'], $imagemPadrao['name'], $nomeImg, '350', '../../produtos/')){
          $update = BD::conn()->prepare("UPDATE `loja_produtos` SET img_padrao = ?, titulo = ?, valor_anterior = ?,
             valor_atual = ?, descricao = ?, peso = ?, estoque = ? WHERE id = ?");
          $dados = array($nomeImg, $titulo, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);

          if($update->execute($dados)){
            echo '<script>alert("O Produto foi editado com sucesso!");location.href="Index.php?pagina=editProduto&produto='.$idProduto.'"</script>';
          }
        }//Enviou a imagem também
      }
      else{
        unlink('../../produtos/'.$dadosProd->img_padrao);
        $nomeImg = md5(uniqid(rand(), true)).$imagemPadrao['name'];

        if($site->upload($imagemPadrao['tmp_name'], $imagemPadrao['name'], $nomeImg, '350', '../../produtos/')){
          $update = BD::conn()->prepare("UPDATE `loja_produtos` SET img_padrao = ?, titulo = ?, categoria = ?,
            subcategoria = ?, valor_anterior = ?, valor_atual = ?, descricao = ?, peso = ?, estoque = ? WHERE id = ?");
          $dados = array($nomeImg, $titulo, $categoria, $subcategoria, $valAnterior, $valAtual, $descricao, $peso, $qtdEstoque, $idProduto);

          if($update->execute($dados)){
            echo '<script>alert("O Produto foi editado com sucesso!");location.href="Index.php?pagina=editProduto&produto='.$idProduto.'"</script>';
          }
        }//Enviou a imagem
      }
    }
  }//Se existir o POST
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

  .fix{
    float: left;
  }

  .fix-tiny{
    float:left;
    width:100%;
  }

  #label-fix-tiny{
    margin-right:10px;
  }
</style>
</head>
<body>
<h1 class="title">Editar: <?php echo $dadosProd->titulo; ?></h1>
<div id="formularios">
  <form action=""  method="post" enctype="multipart/form-data" style="margin-left:20px;">
    <label>
      <span>Mudar Imagem Padrão?</span><br>
      <input type="file" name="img_padrao">
    </label><br>

    <label>
      <span>Titulo do produto</span><br>
      <input type="text" name="titulo" value="<?php echo $dadosProd->titulo; ?>">
    </label><br>

    <div class="fix" style="float:left;">
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
    </div>

    <div class="fix-right" style="float:right; margin-right:10px;">
      <label>
        <span>Valor Anterior</span><br>
        <input type="text" name="valAnterior" id="preco" value="<?php echo $dadosProd->valor_anterior; ?>">
      </label><br>

      <label>
        <span>Valor Atual</span><br>
        <input type="text" name="valAtual" id="preco1" value="<?php echo $dadosProd->valor_atual; ?>">
      </label><br>
    </div>

    <div class="fix-tiny">
      <label id="label-fix-tiny">
        <span>Escreva as características deste produto</span><br>
        <textarea name="descricao" class="tinymce" cols="30" rows="5"
                  value="<?php echo $dadosProd->descricao; ?>"></textarea>
      </label><br>

      <div class="fix">
        <label>
          <span>Peso do Produto</span><br>
          <input type="text" name="peso" value="<?php echo $dadosProd->peso; ?>">
        </label><br>

        <label>
          <span>Quantidade em estoque</span><br>
          <input type="text" name="qtdEstoque" value="<?php echo $dadosProd->estoque; ?>">
        </label><br>

        <input type="hidden" name="acao" value="editar">
        <input type="submit" value="Editar Produto">
      </div>
    </div>
  </form>
</div>
</body>
