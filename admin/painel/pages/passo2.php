<?php
  if(!isset($_SESSION['ultimoId'])){
    header("location: Index.php");
  }
?>
<?php
  $pegar_imagens_produto = BD::conn()->prepare("SELECT * FROM `loja_imgProd` WHERE id_produto = ?");
  $pegar_imagens_produto->execute(array($_SESSION['ultimoId']));
  $contar = $pegar_imagens_produto->rowCount();

  $qtdFaltam = 6-$contar;

  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
    $idImagem = (int)$_GET['imagem'];

    $selecionar_img = BD::conn()->prepare("SELECT img FROM `loja_imgProd` WHERE id = ?");
    $selecionar_img->execute(array($idImagem));
    $fetchImagem = $selecionar_img->fetchObject();

    if(unlink('../../produtos/'.$fetchImagem->img)){
      $deletar = BD::conn()->prepare("DELETE FROM `loja_imgProd` WHERE id = ?");
      if($deletar->execute(array($idImagem))){
        echo '<script>alert("Imagem foi deletada com sucesso!");location.href="?pagina=passo2"</script>';
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
    width:50%;
  }

  .info {
    padding: 10px;
    background-color: #2196F3;
    color: white;
    width:50%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width:50%;
  }

  form{
    margin-left:5px;
  }

  p{
    margin-left:5px;
  }

  .completar{
    float:left;
    width: 100%;
    margin-top: 10px;
    margin-left: 5px;
    margin-top: 20px;
  }

  .btn-completar {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .btn-completar:hover{
    text-decoration: none;
    color: #fff;
  }

  .imagem-passo2{
    float:left;
    margin-left: 5px;
  }

  .img-passo2 img{
    margin-bottom: 7px;
  }

  p{
    margin-left:5px;
  }

  #deletar-img-passo2{
    background-color: #ff0000;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-top: 15px;
    margin-bottom: 15px;
  }

  .content-passo2{
    margin-left: 10px;
  }
</style>
</head>
<body>
<div class="content-passo2">
<h1 class="title">Passo 2 > Imagens dos produtos</h1>
<div class="info">
  <p>Você ainda pode enviar <strong><?php echo $qtdFaltam; ?></strong> de <strong>6</strong> imagens para esse produto</p>
</div>

  <?php if($contar == 6): ?>
    <div class="alert">
      <p>Você já enviou <b>6</b> imagens de <b>6</b> imagens</p>
    </div>
  <?php endif; ?>

<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrarImg'):
    $imagem = $_FILES['imagem'];
    $tmp = $imagem['tmp_name'];
    $name = $imagem['name'];
    $novoNome = md5(uniqid(rand(), true)).$name;

    if($site->upload($tmp, $name, $novoNome, '500', '../../produtos/')){
      $dados = array('id_produto' => $_SESSION['ultimoId'], 'img' => $novoNome);
      if($site->inserir('loja_imgProd', $dados)){
        echo '<script>alert("Imagem cadastrada com sucesso!");location.href="?pagina=passo2"</script>';
      }
    }
  endif;
?>

<?php if($contar != 6): ?>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <label class="img">
      <span>Escolha uma imagem</span>
      <input type="file" name="imagem">
    </label><br>

    <input type="hidden" value="cadastrarImg" name="acao">
    <input type="submit" value="Enviar Imagem" name="send">
  </form>
</div>
<?php endif; ?>

<h1 class="title">Imagens para esse produto</h1>
<?php
  while($fetchImagens = $pegar_imagens_produto->fetchObject()):
?>
<div class="imagem-passo2">
  <div class="img-passo2"><img src="../../produtos/<?php echo $fetchImagens->img; ?>" width="200px" alt=""></div>
  <a href="?pagina=passo2&deletar=sim&imagem=<?php echo $fetchImagens->id; ?>" id="deletar-img-passo2">Deletar Imagem</a>
</div>
<?php endwhile; ?>

<div class="completar">
  <a href="Index.php?pagina=passo2&completar=ok" class="btn-completar">Completar Cadastro</a>
<?php
  if(isset($_GET['completar']) && $_GET['completar'] == 'ok'){
    unset($_SESSION['ultimoId']);
    header("location: Index.php");
  }
?>
</div>
</div>
</body>
