<?php
	if(isset($_POST['acao']) && $_POST['acao'] == 'mudar'){
		$imagem = $_FILES['nova_imagem'];
    $nomeNovo = md5(uniqid(rand(), true)).$imagem['name'];
    $tmp = $imagem['tmp_name'];
    $name = $imagem['name'];
    $pasta = '../clientes/';

		if($usuarioLogado->imagem == ''){
      if($site->upload($tmp, $name, $nomeNovo, '150', $pasta)){
        $atualizar_banco = BD::conn()->prepare("UPDATE `loja_clientes` SET `imagem` = ? WHERE id_cliente = ?");
        if($atualizar_banco->execute(array($nomeNovo, $usuarioLogado->id_cliente))){
          echo '<script>alert("Sua Imagem de Perfil foi alterada!");location.href="?pagina=mudar_imagem"</script>';
        }
        else{
          echo '<script>alert("Erro ao enviar imagem")</script>';
        }
      }
		}
		else{
			unlink('../clientes/'.$usuarioLogado->imagem);
		}
	}
?>
<head>
<style>
	body{
		background-color: orange;
	}

	#form-mudar-img{
		background-color: #d3d3d3;
		margin-left: 200px;
		margin-right: 200px;
		width: 400px;
	}

	form{
		margin-left: 10px;
	}

	.title-mudar-imagem{
		background-color: #4c4cff;
		padding: 17px 15px;
		height: 60px;
		color: #fff;
		margin: 0;
	}

	.title-mudar-imagem span{
		font-family: Verdana, sans-serif;
		font-weight: bold;
		font-size: 21px;
		margin-left: 10px;
	}

	#mudar_imagem input[type=submit]{
		background-color: #4CAF50;
		color: white;
		padding: 8px 14px;
		font-size: 16px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	#mudar_imagem input[type=submit]:hover{
		text-decoration: none;
	}
</style>
</head>
<body>
<div id="form-mudar-img">
<h1 class="title-mudar-imagem"><span>Mudar Imagem de Perfil</span></h1>
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Escolha a sua nova imagem<span><br>
      <input type="file" name="nova_imagem">
    </label><br>

		<label id="mudar_imagem">
	    <input type="hidden" name="acao" value="mudar">
	    <input type="submit" value="Mudar Imagem">
		</label>
  </form>
</div>
</body>
