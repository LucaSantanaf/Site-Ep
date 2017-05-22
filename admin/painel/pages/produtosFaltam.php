<?php
  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
    $idProduto = (int)$_GET['produto'];

    //Pega a imagem padrão do produto
    $pegar_dados_produto = BD::conn()->prepare("SELECT img_padrao FROM `loja_produtos` WHERE id = ?");
    $pegar_dados_produto->execute(array($idProduto));
    $dadosProd = $pegar_dados_produto->fetchObject();

    //Pega as imagens da outra tabela para esse produto
    $verificar_imagens = BD::conn()->prepare("SELECT * FROM `loja_imgProd` WHERE id_produto = ?");
    $verificar_imagens->execute(array($idProduto));

    if($verificar_imagens->rowCount() == 0){
      //Se não existir imagens relacionadas a esse produto
      if(unlink('../../produtos/'.$dadosProd->img_padrao)){
        $deletar_produto = BD::conn()->prepare("DELETE FROM `loja_produtos` WHERE id = ?");
        if($deletar_produto->execute(array($idProduto))){
          echo '<script>alert("Produto excluido corretamente!");location.href="Index.php?pagina=editarProdutos"</script>';
        }
      }
    }
    else{
    //Se existir imagens relacionadas a esse produto
      //deletar as imagens deste produto
      while($dadosImagem = $verificar_imagens->fetchObject()){
        unlink('../../produtos/'.$dadosImagem->img);
      }
      //deletar os demais dados desse produto
      if(unlink('../../produtos/'.$dadosProd->img_padrao)){
        $deletar_produto = BD::conn()->prepare("DELETE FROM `loja_produtos` WHERE id = ?");
        if($deletar_produto->execute(array($idProduto))){
          echo '<script>alert("Produto excluido corretamente!");location.href="Index.php?pagina=editarProdutos"</script>';
        }
      }
    }
  endif;
?>
<head>
<style>
  th, td{
    color:#fff;
    text-align:center;
  }

  .list{
    border-color:#fff;
    margin-left:10px;
    width:640px;
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
</style>
</head>
<body>
<h1 class="title">Produtos em Falta</h1>
<table class="list" border="2">
  <thead>
    <tr>
      <th valign="middle">Titulo</th>
      <th valign="middle">Valor</th>
      <th valign="middle">Estoque</th>
      <th valign="middle">Editar</th>
      <th valign="middle">Excluir</th>
    </tr>
  </thead>

  <tbody>
  <?php
    $pg = (isset($_GET['pg'])) ? (int)htmlentities($_GET['pg']) : '1';
    $maximo = '15';
    $inicio = (($pg * $maximo) - $maximo);

    $selecionar_produtos = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE estoque = 0 LIMIT $inicio, $maximo");
    $selecionar_produtos->execute();
    if($selecionar_produtos->rowCount() == 0){
      echo '<tr><td colspan="5">Não foram encontrados produtos em falta no Banco de Dados</td></tr>';
    }
    else{
      while($produto = $selecionar_produtos->fetchObject()){
  ?>
    <tr>
      <td valign="middle"><?php echo $produto->titulo; ?></td>
      <td valign="middle"><?php echo number_format($produto->valor_atual, 2, ',','.'); ?></td>
      <td valign="middle"><?php echo $produto->estoque; ?></td>
      <td valign="middle">
        <a href="Index.php?pagina=editProduto&produto=<?php echo $produto->id; ?>">
          <img src="images/editar.png"></a></td>
      <td valign="middle">
        <a href="Index.php?pagina=editarProdutos&deletar=sim&produto=<?php echo $produto->id; ?>">
          <img src="images/excluir.png" width="30px" height="30px"></a></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>

<div class="pagination" id="pagina">
  <?php
  	$sql_res = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE estoque != 0");
  	$sql_res->execute();
  	$total = $sql_res->rowCount();
  	$pags = ceil($total/$maximo);
  	$links = '5';

  	echo '<span class="page">Página: '.$pg.' de '.$pags.'</span>';
  	for($i = $pg-$links; $i<=$pg-1;$i++){
  		if($i<=0){}else{
  			echo '<a href="Index.php?pagina=produtosFaltam&pg='.$i.'">'.$i.'</a>';
  		}
  	}echo '<strong>'.$pg.'</strong>';

  	for($i = $pg+1; $i<=$pg+$links; $i++){
  		if($i>$pags){}else{
  			echo '<a href="Index.php?pagina=produtosFaltam&pg='.$i.'">'.$i.'</a>';
  		}
  	}
  	echo '<a href="Index.php?pagina=produtosFaltam&pg='.$pags.'">Última Página</a>';
  ?>
</div>
</body>
