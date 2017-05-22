<head>
<style>
  body{
    background-color: orange;
  }

  .produto_box_erro{
    float: left;
    background-color: #f1f1f1;
    border-radius: 4px;
    width: 220px;
    height: 260px;
    margin-left: 10px;
    margin-bottom: 71px;
  }

  .produto_box_erro img{
    width: 200px;
    height: 160px;
    margin-top: -10px;
    margin-bottom: 5px;
    margin-left: 10px;
  }

  .produto_box_erro a:hover{
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

  #produtos-erro{
    margin-left: 100px;
  }
</style>
</head>
<body>
<h1 class="title-page">O que você procura não está aqui</h1>
<div class="content_erro">
  <p>O que você está procurando infelizmente não está aqui, mas não<br>
    se preocupe, temos vários produtos que você pode até gostar.</p>
  <p>Confira..</p>

  <div id="produtos-erro">
    <?php
      $dados = array('id','img_padrao','titulo','slug','valor_atual');
      $site->selecionar('loja_produtos',$dados,false,'id DESC LIMIT 5');
      foreach($site->listar() as $campos){
    ?>
    <div class="produto_box_erro">
      <a href="<?php echo PATH; ?>/produto/<?php echo $campos['slug']; ?>" title="<?php echo $campos['titulo']; ?>"><br>
        <img src="<?php echo PATH; ?>/produtos/<?php echo $campos['img_padrao']; ?>"
          title="<?php echo $campos['titulo']; ?>"><br>
        <center>
          <span class="title"><?php echo $campos['titulo']; ?></span><br>
          <span class="preco">Por: R$ <?php echo number_format($campos['valor_atual'],2,',','.'); ?></span>
        </center>
      </a><br>
        <a href="<?php echo PATH; ?>/carrinho/add/<?php echo $campos['id']; ?>" id="cart">Comprar</a>
    </div>
  <?php } ?>
  </div>
</div>
</body>
