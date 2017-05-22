<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Categoria</title>
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
    margin-top: -5px;
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

  .title-cat{
    margin-left: 7px;
  }
</style>
</head>
<body>
<div class="side-cat-sub">
  <?php include_once "inc/sidebar_menu.php"; ?>
</div>

<div id="content-produtos">
<?php
  $pegar_categoria = htmlentities($parametros[1]);
  $site->atualizarViewCat($pegar_categoria);

  $pegar_dados_categoria = BD::conn()->prepare("SELECT titulo FROM `loja_categorias` WHERE slug = ?");
  $pegar_dados_categoria->execute(array($pegar_categoria));
  $fetch_cat = $pegar_dados_categoria->fetchObject();
?>

<h1 class="title-cat"><?php echo $fetch_cat->titulo; ?></h1>

  <div id="produtos">
  <?php
    //Pega os posts referentes a essa categoria
    $pg = (isset($_GET['pagina'])) ? (int)htmlentities($_GET['pagina']) : '1';
    $maximo = '8';
    $inicio = (($pg * $maximo) - $maximo));

    $sql = "SELECT * FROM `loja_produtos` WHERE categoria = ? ORDER BY id DESC";
    $executar_cat = BD::conn()->prepare($sql);
    $executar_cat->execute(array($pegar_categoria));

    if($executar_cat->rowCount() == 0) {
      echo '<p align="center">Não existem produtos nesta categoria</p>';
    }
    else{
      while($produto = $executar_cat->fetchObject()){

  ?>
    <div id="produto_box">
      <center>
      <a href="<?php echo PATH.'produto->slug/'; ?>" title="<?php echo $produto->titulo; ?>"><br>
        <img src="<?php echo PATH; ?>/produtos/<?php echo $produto->img_padrao;?>"
          title="<?php echo $produto->titulo; ?>"alt="" width="100px"><br>
          <span class="title"><?php echo $produto->titulo; ?></span><br>
          <span class="preco">Por: R$ <?php echo number_format($produto->valor_atual, 2, ',','.'); ?></span>
      </a>
      </center>
      <a href="<?php echo PATH.'carrinho/add/'.$produto->id; ?>" id="cart">Comprar</a>
    </div>
  <?php } } ?>
  </div>

  <div class="pagination" id="pagina">
    <?php
    	$sql_res = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE categoria = ?");
    	$sql_res->execute(array($pegar_categoria));
    	$total = $sql_res->rowCount();
    	$pags = ceil($total/$maximo);
    	$links = '5';

    	echo '<span class="page">Página: '.$pg.' de '.$pags.'</span>';
    	for($i = $pg-$links; $i<=$pg-1;$i++){
    		if($i<=0){}else{
    			echo '<a href="'.PATH.'categoria/'.$pegar_categoria.'&pagina='.$i.'">'.$i.'</a>';
    		}
    	}echo '<strong>'.$pg.'</strong>';

    	for($i = $pg+1; $i<=$pg+$links; $i++){
    		if($i>$pags){}else{
    			echo '<a href="'.PATH.'categoria/'.$pegar_categoria.'&pagina='.$i.'">'.$i.'</a>';
    		}
    	}
    	echo '<a href="'.PATH.'categoria/'.$pegar_categoria.'&pagina='.$pags.'">Última Página</a>';
    ?>
  </div>
</div>
</body>
