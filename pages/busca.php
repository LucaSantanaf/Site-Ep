<head>
<style>
  body{
    background-color: orange;
  }

  h3{
    margin-left: 10px;
  }

  #produtos{
    margin-left: 10px;
  }

  .produto_box_pesquisa{
    float: left;
    background-color: #f1f1f1;
    border-radius: 4px;
    width: 220px;
    height: 260px;
    margin-left: 15px;
    margin-top: 20px;
    margin-bottom: 20px;
  }

  .produto_box_pesquisa img{
    width: 200px;
    height: 160px;
    margin-top: -10px;
    margin-bottom: 5px;
    margin-left: 10px;
  }

  .produto_box_pesquisa a:hover{
    text-decoration: none;
  }

  #cart{
    background-color: blue;
    padding: 10px;
    color: #fff;
    font-size: 10px bold;
    position: absolute;
    margin-top: -20px;
    margin-left: 70px;
  }

  #cart a:hover{
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
    float: left;
    width: 100%;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 33px;
  }

  .success {
    padding: 4px;
    background-color: #4CAF50;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }
</style>
</head>
<body>
<h3>Resultado da pesquisa</h3>
<div class="content_erro">
  <div id="content_produtos" class="page_erro">
  <?php
  $pesquisa = strip_tags(trim(htmlentities($_GET['s'])));
    if($_GET['s'] != ''){
      $explode = explode(' ', $_GET['s']);
      $num = count($explode);
      $busca = '';

      for($i = 0; $i < $num; $i++){
        $busca .= "`titulo` LIKE :busca$i";
        if($i != $num - 1){
          $busca .= 'AND';
        }
      }

      $pg = (isset($_GET['pagina'])) ? (int)htmlentities($_GET['pagina']) : '1';
      $maximo = '5';
      $inicio = (($pg * $maximo) - $maximo);
        $buscar = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE $busca LIMIT $inicio, $maximo");
        for($i = 0; $i < $num; $i++){
          $buscar->bindValue(":busca$i",'%'.$explode[$i].'%', PDO::PARAM_STR);
        }
        $buscar->execute();
      }//se a buscar for diferente de vazio

  if($buscar->rowCount() > 0){
    echo '<p class="success">Sua pesquisa retornou <b>'.$buscar->rowCount().'</b> resultados</p>';
    echo '<div id="produtos">';
      while($resultado = $buscar->fetchObject()){
  ?>

    <div class="produto_box_pesquisa">
      <a href="<?php echo PATH; ?>/produto/<?php echo $resultado->slug; ?>" title="<?php echo $resultado->title; ?>"><br>
        <img src="<?php echo PATH; ?>/produtos/<?php echo $resultado->img_padrao; ?>"
          title="<?php echo $resultado->titulo; ?>"><br>
        <center>
          <span class="title"><?php echo $resultado->titulo; ?></span><br>
          <span class="preco">Por: R$ <?php echo number_format($resultado->valor_atual,2,',','.'); ?></span>
        </center>
      </a><br>
        <a href="<?php echo PATH; ?>/carrinho/add/<?php echo $resultado->id; ?>" id="cart">Comprar</a>
    </div>
  <?php } } ?>
  </div>
    <div class="pagination" id="pagina">
    <?php
      $sql_res = BD::conn()->prepare("SELECT id FROM `loja_produtos` WHERE  $busca");
      for($i = 0; $i < $num; $i++){
        $sql_res->bindValue(":busca$i",'%'.$explode[$i].'%', PDO::PARAM_STR);
      }
      $sql_res->execute();
      $total = $sql_res->rowCount();
      $pags = ceil($total/$maximo);
      $links = '5';

      echo '<span class="page">Página: '.$pg.' de '.$pags.'</span>';
      for($i = $pg-$links; $i<=$pg-1;$i++){
        if($i<=0){}else{
          echo '<a href="'.PATH.'/?s='.$pesquisa.'&pagina='.$i.'">'.$i.'</a>';
        }
      }echo '<strong>'.$pg.'</strong>';

      for($i = $pg+1; $i<=$pg+$links; $i++){
        if($i>$pags){}else{
          echo '<a href="'.PATH.'/?s='.$pesquisa.'&pagina='.$i.'">'.$i.'</a>';
        }
      }
      echo '<a href="'.PATH.'/?s='.$pesquisa.'&pagina='.$pags.'">Última Página</a>';
    ?>
    </div>
  </div>
</div>
</body>
