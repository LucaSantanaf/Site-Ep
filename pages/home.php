<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Episeg</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?php echo PATH; ?>images/favicon.png">
      <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>css/bootstrap.min.css">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
      <link rel="stylesheet" href="css/gallery.theme.css">
      <link rel="stylesheet" href="css/gallery.min.css">
<style>
  body{
    background-color: orange;
  }

  .container-home{
    float: left;
    width: 80%;
    margin-left: 10px;
    padding: 0;
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
    margin-top: -5px;
    margin-bottom: 5px;
  }

  #produto_box .preco{
    margin-bottom: 5px;
  }

  #produto_box a:hover{
    text-decoration: none;
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

  #side_home{
    float: left;
  }

  #prod-h1{
    margin-left: 5px;
  }

  #slide-item{
    height: 400px;
    margin-left: 0px;
  }

  #gallery{
    margin-top: -20px;
  }
</style>
</head>
<body>

<!-- SlideShow -->
<div class="gallery autoplay items-3" id="gallery">
  <?php
    foreach($site->getBanners() as $banner){
  ?>
  <div id="item-1" class="control-operator"></div>
  <div id="item-2" class="control-operator"></div>
  <div id="item-3" class="control-operator"></div>

  <figure class="item" id="slide-item">
    <a href="<?php echo $banner['link'];?>">
      <img src="<?php echo PATH;?>/banners/<?php echo $banner['imagem'];?>" height="400px" width="100%">
    </a>
  </figure>

  <div class="controls">
    <a href="#item-1" class="control-button">•</a>
    <a href="#item-2" class="control-button">•</a>
    <a href="#item-3" class="control-button">•</a>
  </div>
  <?php } ?>
</div>

<!-- SideBar das Categorias-->
<div>
  <div id="side_home">
    <?php include_once "inc/sidebar_menu.php"; ?>
  </div>

  <!-- Produtos Principal -->
  <div class="container-home">
  <h1 id="prod-h1">Produtos em destaque</h1>
    <div id="content-produtos">
      <div id="produtos">
      <?php
        foreach($site->getProdutosHome(12) as $produto){
      ?>
        <div id="produto_box">
          <center>
          <a href="<?php echo PATH.'produto/'.$produto['slug']; ?>"
          title="<?php echo $produto['titulo'];?>"><br>

            <img src="<?php echo PATH; ?>/produtos/<?php echo $produto['img_padrao']; ?>"
            title="<?php echo $produto['titulo'];?>"><br>
              <span class="title"><?php echo $produto['titulo'];?></span><br>
              <span class="preco">Por: R$ <?php echo number_format($produto['valor_atual'], 2, ',','.');?>
              </span><br>
          </a>
          </center>
            <a href="<?php echo PATH.'carrinho/add/'.$produto['id']; ?>" id="cart">Comprar</a>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
</div>
</body>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-white", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-white";
}
</script>
