<?php
  $pegar_slug = strip_tags(trim($parametros[1]));

  $selecionar_produto = "SELECT * FROM `loja_produtos` WHERE slug = ? ";
  $executar = BD::conn()->prepare($selecionar_produto);
  $executar->execute(array($pegar_slug));

  $fetch_produto = $executar->fetchObject();

//Pegar imagens do produto
  $sqlPegar = "SELECT * FROM `loja_imgProd` WHERE id_produto = ? ";
  $executarImg = BD::conn()->prepare($sqlPegar);
  $executarImg->execute(array($fetch_produto->id));
?>
<head>
<style>
  body{
    background-color: orange;
  }

  #bloco-produto{
    background-color: #f1f1f1;
    width: 980px;
    height: 480px;
    margin-left: 100px;
    margin-right: 100px;
    margin-bottom: 10px;
  }

  /* Primeiro Bloco */
  #first-block{
    float:left;
    background-color: #98ea22;
    display: inline-block;
    width: 460px;
    height: 100%;
  }

  #content-first-block{
    float:right;
    width:415px;
    height:350px;
    margin-left: 30px;
    margin-right: 30px;
  }

  .img-big{
    margin-top: 10px;
    margin-right: 10px;
  }

  .img-big img{
    padding-right: 10px;
  }

  #gallery{
    list-style-type:none;
    float:left;
    margin-top: 3px;
    width: 440px;
    padding:0px;
  }

  #gallery li{
    width:105px;
    height:70px;
    background:#fff;
    float:left;
    margin-top: 5px;
    margin-right: 4px;
    margin-bottom: 5px;
    overflow:hidden;
  }

  .send-to{
    float:left;
    width:100%;
  }

  #enviar_amigo{
    background-color: #2196F3;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-bottom: 10px;
  }

  /* Segundo Bloco */
  #second-block{
    float:left;
    background-color: #98ea22;
    width: 520px;
    height: 100%;
  }

  #second-block form{
    margin-left: 5px;
  }

  #second-block h1{
    margin-left: 5px;
  }

  #btn_buy{
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  /* Descrição do Produto */
  #desc-prod{
    background-color: #d3d3d3;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border: 1px solid #808080;
    border-bottom: none;
    width: 170px;
    cursor: pointer;
  }

  #desc-prod span{
    padding: 5px;
    font-size: 15px;
  }

  #content_dados_produto{
    float: left;
    background-color: #f1f1f1;
    width: 100%;
    height: auto;
    border: 1px solid #808080;
    margin-bottom: 10px;
  }

  #content_dados_produto p{
    background-color: #f1f1f1;
  }


  /* Produtos Relacionados */
  #related{
    float:right;
    background-color: #f44336;
    width: 100%;
  }

  .prod_rel{
    float: left;
    background-color: #f1f1f1;
    border-radius: 4px;
    width: 215px;
    height: 265px;
    margin-left: 10px;
    margin-bottom: 10px;
  }

  .prod_rel img{
    width: 200px;
    height: 160px;
    margin-top: 5px;
    margin-bottom: 5px;
  }

  .prod_rel span{
    margin-bottom: 5px;
  }

  .prod_rel a:hover{
    text-decoration: none;
  }

  #buy{
    background-color: blue;
    padding: 10px;
    color: #fff;
    font-size: 10px bold;
    position: absolute;
    margin-top: 5px;
    margin-left: 70px;
  }

  #buy a:hover{
    text-decoration: none;
  }
</style>
</head>
<body>
<div class="container" id="bloco-geral">

<div id="bloco-produto">
<!-- Bloco da esquerda -->
  <div id="first-block">
    <div id="content-first-block">
      <div class="img-big">
        <a href="<?php echo PATH.'produtos/'.$fetch_produto->img_padrao; ?>">
          <img src="<?php echo PATH.'produtos/'.$fetch_produto->img_padrao; ?>" width="440px">
        </a>
      </div>
  <?php
    if($executarImg->rowCount() == 0){} else{
  ?>
      <ul id="gallery">
  <?php
    while($imgProd = $executarImg->fetchObject()){
  ?>
      <li>
        <a href="<?php echo PATH; ?>produtos/<?php echo $imgProd->img; ?>" title="<?php echo $fetch_produto->titulo; ?>">
        <img src="<?php echo PATH; ?>produtos/<?php echo $imgProd->img; ?>" width="100%" height="100%"></a>
      </li>
  <?php }  ?>
      </ul>
  <?php } ?>
      <div class="send-to"><a href="<?php echo PATH; ?>inc/enviar_amigo.php?produto_id=<?php echo $fetch_produto->id; ?>"
        id="enviar_amigo">Enviar para um Amigo</a>
      </div>
    </div>
  </div>


<!-- Bloco da direita -->
  <div id="second-block">
    <h1 class="title"><?php echo $fetch_produto->titulo; ?></h1>

    <form action="<?php echo PATH.'carrinho'; ?>" method="post" enctype="multipart/form-data">
      <div id="dados_produto">
      <?php if($fetch_produto->valor_anterior != '0.00000'){ ?>
        <span class="de">
          <span class="de">de: <strike>R$ <?php echo number_format((float)$fetch_produto->valor_anterior,2,',','.');?></strike></span>
        </span><br>
      <?php } ?>
        <span class="por">Por: <?php echo number_format((float)$fetch_produto->valor_atual,2,',','.'); ?></span><br>

        <span class="parcelas">Em até 12x sem juros no cartão</span><br>
        <span class="exemplares">Vendidos: <?php echo $fetch_produto->qtdVendidos; ?></span>

        <div class="qtd">
          <label>
            <span>Quantidade</span>
              <input type="text" name="prodSingle[<?php echo $fetch_produto->id; ?>]" value="1" size="2"><br>
              <input type="submit" value="comprar" name="comprar" id="btn_buy">
          </label>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Descrição dos produtos -->
  <div id="desc-prod">
    <span><b>Descrição do Produto</b></span>
  </div>
  <div id="content_dados_produto">
      <p><?php echo html_entity_decode($fetch_produto->descricao); ?></p>
  </div>
</div><!-- Termina o Bloco Geral -->


<div id="related">
  <h2>Produtos Relacionados</h2>

<?php
  $pegar_relacionado = "SELECT id, img_padrao, titulo, slug, valor_atual FROM `loja_produtos` WHERE subcategoria = ?
  AND id != ? ORDER BY id DESC LIMIT 4";
  $execRel = BD::conn()->prepare($pegar_relacionado);
  $execRel->execute(array($fetch_produto->subcategoria, $fetch_produto->id));

  if($execRel->rowCount() == 0){
  echo '<p>Não encontramos nenhum produto relacionado a este!</p>';
  }
  else{
  while($prodRel = $execRel->fetchObject()){
?>

  <div class="prod_rel">
    <center>
      <a href="<?php echo PATH.'/produto/'.$prodRel->slug; ?>">
        <img src="<?php echo PATH.'/produtos/'.$prodRel->img_padrao; ?>" border="0"
          title="<?php echo $prodRel->titulo; ?>" alt=""><br>
        <span class="tit"><?php echo substr($prodRel->titulo,0,25); ?></span><br>
        <span>Por: R$ <?php echo number_format((float)$prodRel->valor_atual,2,',','.'); ?></span>
      </a>
    </center>
    <a href="<?php echo PATH.'carrinho/add/'.$prodRel->id;?>" id="buy">Comprar</a>
  </div>
<?php } } ?>
</div>
</body>
