<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'):
    $imagem = $_FILES['imagem'];
    $titulo = strip_tags(filter_input(INPUT_POST, 'titulo'));
    $descricao = strip_tags(filter_input(INPUT_POST, 'descricao'));
    $link = strip_tags(filter_input(INPUT_POST, 'link'));

    $val->set($titulo, 'Titulo')->obrigatorio();
    $val->set($descricao, 'Descricao')->obrigatorio();
    $val->set($link, 'Link')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="warning">Erro : '.$erro[0].'</div>';
    }
    elseif($imagem['error'] == 4){
      echo '<div class="alert">Erro: Informe a imagem para cadastro</div>';
    }
    else{
      $img = md5(uniqid(rand(), true)).$imagem['name'];

      if($site->upload($imagem['tmp_name'], $imagem['name'], $img, '885', '../../banners/')){
      $dados = array('titulo' => $titulo, 'descricao' => $descricao, 'link' => $link, 'imagem' => $img);
        if($site->inserir('loja_banners', $dados)){
          echo '<div class="success">Novo Banner cadastrado com sucesso!</div>';
        }
      }
    }
  endif;
if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'){
  $id_banner = (int)$_GET['banner'];

  $datas = array('id', 'imagem');
  $condicao = array('id' => $id_banner);
  $site->selecionar('loja_banners', $datas, $condicao);

  foreach($site->listar() as $campos){
    if(unlink('../../banners/'.$campos['imagem'])){
      $deletar = BD::conn()->prepare("DELETE FROM `loja_banners` WHERE id = ?");
      if($deletar->execute(array($id_banner))){
        echo '<script>alert("Banner excluido com sucesso!");location.href="?pagina=banners"</script>';
      }
    }
  }
}
?>
<head>
<style>
  #deletar{
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

  #formularios{
    margin-left: 10px;
  }

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

  .success {
    padding: 10px;
    background-color: #4CAF50;
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

  .imagem-banner{
    margin-left:10px;
    display: inline-block;
  }

  .img{
    width: 300px;
    height: 200px;
    margin-bottom: 5px;
  }
</style>
</head>
<body>
<h1 class="title">Edição de Banners</h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Imagem (885x200)</span>
      <input type="file" name="imagem">
    </label>

    <div class="fix">
      <label>
        <span>Titulo</span>
        <input type="text" name="titulo">
      </label><br>

      <label>
        <span>Descrição</span>
        <input type="text" name="descricao">
      </label>
    </div>

    <label>
      <span>Link do Banner</span>
      <input type="text" name="link">
    </label><br>

    <input type="hidden" name="acao" value="cadastrar">
    <input type="submit" value="Cadastrar Banner">
  </form>
</div>

<h1 class="title">Banners já cadastrados</h1>
<?php
  $data = array('id', 'titulo', 'descricao', 'link', 'imagem');
  $site->selecionar('loja_banners', $data, false, 'id DESC');

  $count = 0;
  foreach($site->listar() as $campos){
    $count++;
?>
<div class="imagem-banner">
  <div><img src="../../banners/<?php echo $campos['imagem']; ?>" alt="" class="img"></div>
  <a href="?pagina=banners&deletar=sim&banner=<?php echo $campos['id']; ?>" id="deletar">Deletar Banner</a>
</div>
<?php }
  if($count == 0){
    echo '<p align="center">Não existem banners</p>';
  }
?>
</body>
