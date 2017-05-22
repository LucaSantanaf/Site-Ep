<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Subcategoria</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?php echo PATH; ?>/images/favicon.png">
      <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>css/bootstrap.min.css">
<style>
  body{
    background-color: orange;
  }

  .side-cat-sub{
    float: left;
    margin-bottom: 10px;
  }

  #content-produtos{
    float: left;
    margin-left: 10px;
    margin-right: 10px;
    width: 80%;
  }

  #produtos{
    float: left;
    width: 100%;
  }

  #produto_box{
    float: left;
    background-color: #f1f1f1;
    border-radius: 4px;
    width: 240px;
    height: 280px;
    margin-left: 10px;
    margin-bottom: 10px;
  }

  #produto_box img{
    width: 200px;
    height: 160px;
    margin-top: 15px;
    margin-bottom: 5px;
  }

  #produto_box a:hover{
    text-decoration: none;
  }

  #produto_box span{
    font-size: 15px;
    cursor: pointer;
    color: #000;
  }

  #cart{
    background-color: blue;
    padding: 10px;
    color: #fff;
    font-size: 10px bold;
    position: absolute;
    margin-top: 5px;
    margin-left: 80px;
  }

  #cart a:hover{
    text-decoration: none;
  }

  #cart-cat{
    background-color: blue;
    padding: 10px;
    color: #fff;
    font-size: 10px bold;
    position: absolute;
    margin-top: -10px;
    margin-left: 80px;
  }

  #cart-cat a:hover{
    text-decoration: none;
  }

  .pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
  }

  .pagination a.active {
    background-color: #4CAF50;
    color: white;
  }

  .pagination a:hover:not(.active) {
    background-color: #ddd;
  }

  #pagina{
    margin-left:10px;
    margin-top:10px;
  }

  .title-subcat{
    margin-left: 7px;
  }

  .active{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 100%;
    padding: 8px 8px;
  }

  #sidebar_menu {
    background-color: #f1f1f1;
    float: left;
    width: 200px;
    margin: 0px;
    margin-top: 20px;
    margin-left: 3px;
  }

  #sidebar_menu ul{
    background-color: #f1f1f1;
    list-style-type: none;
    margin:0;
    padding:0;
  }

  #sidebar_menu ul li p:hover {
    background-color: #939393;
    width: 200px;
    color: #fff;
  }

  #sidebar_menu ul li p{
    background-color: #f1f1f1;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  #sidebar_menu ul li p.active{
    background-color: #777;
    display: block;
    color: #fff;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  #sidebar_menu ul ul{
    display: none;
  }

  #sidebar_menu ul ul p{
    background-color: #ddd;
  }

  #marcas_menu {
    background-color: #f1f1f1;
    float: left;
    width: 200px;
    margin: 0px;
    margin-top: 20px;
    margin-left: 3px;
  }

  #marcas_menu ul{
    background-color: #f1f1f1;
    list-style-type: none;
    margin:0;
    padding:0;
  }

  #marcas_menu ul li a{
    background-color: #f1f1f1;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  .marcas{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 200px;
    padding: 8px 8px;
  }

  .imagem-banner{
    margin-left:10px;
  }

  .img{
    width: 160px;
    height: 120px;
    margin-bottom: 0px;
    margin-left: 10px;
  }
</style>
</head>
<body>
<div class="side-cat-sub">
  <div id="sidebar_menu">
    <ul>
      <li class="active"><span>Categorias</span></li>
      <?php $site->getMenu(); ?>
    </ul>
  </div>
<br>
  <div id="marcas_menu">
    <div class="marcas"><span>Nossas Marcas</span></div>
    <?php
      $data = array('id', 'titulo', 'link', 'imagem');
      $site->selecionar('loja_marcas', $data, false, 'id DESC');

      $count = 0;
      foreach($site->listar() as $campos){
        $count++;
    ?>
    <ul class="imagem-banner">
      <li><a href="#"><img src="marcas/<?php echo $campos['imagem']; ?>" alt="" class="img"></a></li>
    </ul>
    <?php } ?>
  </div>
</div>

<div id="content-produtos">
<?php
  $pegar_sub = htmlentities($parametros[2]);
  $site->atualizarViewSub($pegar_sub);

  $pegar_dados_sub = BD::conn()->prepare("SELECT titulo FROM `loja_subcategorias` WHERE slug = ?");
  $pegar_dados_sub->execute(array($pegar_sub));
  $fetch_sub = $pegar_dados_sub->fetchObject();
?>

<h1 class="title-subcat">Categoria | <?php echo $fetch_sub->titulo; ?></h1>

  <div id="produtos">
  <?php
    $pegar_categoria = htmlentities($parametros[1]);
    $pg = (isset($_GET['pagina'])) ? (int)htmlentities($_GET['pagina']) : '1';
    $maximo = '8';
    $inicio = (($pg * $maximo) - $maximo);
    $sql = "SELECT * FROM `loja_produtos` WHERE categoria = ? AND subcategoria = ? ORDER BY id DESC
            LIMIT $inicio, $maximo";
    $executar_cat = BD::conn()->prepare($sql);
    $executar_cat->execute(array($pegar_categoria, $pegar_sub));

    if($executar_cat->rowCount() == 0) {
      echo '<p align="center">Não existem produtos nesta categoria</p>';
    }
    else{
      while($produto = $executar_cat->fetchObject()){

  ?>
    <div id="produto_box">
      <center>
      <a href="<?php echo PATH.'/produto->slug/'; ?>" title="<?php echo $produto->titulo; ?>">
        <img src="<?php echo PATH; ?>/produtos/<?php echo $produto->img_padrao;?>"
          title="<?php echo $produto->titulo; ?>"alt="" width="100px"><br>
          <span class="title"><?php echo $produto->titulo; ?></span><br>
          <span class="preco">Por: R$ <?php echo number_format($produto->valor_atual, 2, ',','.'); ?></span>
      </a>
      </center>
      <a href="<?php echo PATH.'/carrinho/add/'.$produto->id; ?>" id="cart">Comprar</a>
    </div>
  <?php } } ?>
  </div>

  <div class="pagination" id="pagina">
    <?php
      $sql_res = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE categoria = ? AND subcategoria = ? ");
      $sql_res->execute(array($pegar_categoria, $pegar_sub));
      $total = $sql_res->rowCount();
      $pags = ceil($total/$maximo);
      $links = '5';

      echo '<span class="page">Página: '.$pg.' de '.$pags.'</span>';
      for($i = $pg-$links; $i<=$pg-1;$i++){
        if($i<=0){}else{
          echo '<a href="'.PATH.'/categoria/'.$pegar_categoria.'/'.$pegar_sub.'&pagina='.$i.'">'.$i.'</a>';
        }
      }echo '<strong>'.$pg.'</strong>';

      for($i = $pg+1; $i<=$pg+$links; $i++){
        if($i>$pags){}else{
          echo '<a href="'.PATH.'/categoria/'.$pegar_categoria.'/'.$pegar_sub.'&pagina='.$i.'">'.$i.'</a>';
        }
      }
      echo '<a href="'.PATH.'/categoria/'.$pegar_categoria.'/'.$pegar_sub.'&pagina='.$pags.'">Última Página</a>';
    ?>
  </div>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    }
}
</script>
</body>
