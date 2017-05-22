<?php include_once "inc/header.php"; ?>
<div id="conteudo">
<?php
  $url = (isset($_GET['url'])) ? htmlentities(strip_tags($_GET['url'])) : '';
  $parametros = explode('/', $url);
  $paginas_permitidas = array('login','produto','carrinho','verificar', 'finalizar', 'cadastre-se', 'localizacao');

  if(isset($_GET['s']) && $_GET['s'] != ''){
    include_once "pages/busca.php";
  }
  else{
    if($url == ''){
        include_once "pages/home.php";
    }
    elseif(in_array($parametros[0], $paginas_permitidas)){
        include_once "pages/".$parametros[0].'.php';
    }
    elseif($parametros[0] == 'categoria'){
        if(isset($parametros[1]) && !isset($parametros[2])){
          include_once "pages/categoria.php";
        }
        elseif(isset($parametros[2])){
          include_once "pages/subcategoria.php";
        }
    }
    else{
        include_once "pages/erro404.php";
    }
  }
?>
</div>
<?php include_once "inc/footer.php"; ?>
