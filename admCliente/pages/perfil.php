<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'){
    $nome = strip_tags(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $sobrenome = strip_tags(filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_STRING));
    $email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
    $telefone = strip_tags(filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING));

    $cpf = strip_tags(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING));
    $cpf = preg_replace("/[^0-9]/", "", $cpf);

    $rua = strip_tags(filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING));
    $numero = strip_tags(filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING));
    $complemento = strip_tags(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING));
    $bairro = strip_tags(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING));
    $cidade = strip_tags(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING));
    $uf = strip_tags(filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING));

    $cep = strip_tags(filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING));
    $cep = preg_replace("/[^0-9]/", "", $cep);

    $email_log = strip_tags(filter_input(INPUT_POST, 'email_log', FILTER_SANITIZE_STRING));
    $senha_log = strip_tags(filter_input(INPUT_POST, 'senha_log', FILTER_SANITIZE_STRING));

    $val->set($nome, 'Nome')->obrigatorio();
    $val->set($sobrenome, 'Sobrenome')->obrigatorio();
    $val->set($email, 'Email')->isEmail();
    $val->set($telefone, 'Telefone')->isTel();
    $val->set($cpf, 'Cpf')->isCpf();
    $val->set($rua, 'Rua')->obrigatorio();
    $val->set($numero, 'Numero')->obrigatorio();
    $val->set($complemento, 'Complemento')->obrigatorio();
    $val->set($bairro, 'Bairro')->obrigatorio();
    $val->set($cidade, 'Cidade')->obrigatorio();
    $val->set($uf, 'UF')->obrigatorio();
    $val->set($cep, 'CEP')->obrigatorio();
    $val->set($email_log, 'Email de Login')->isEmail();
    $val->set($senha_log, 'Senha de Login')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="erro">Erro: '.$erro[0].'</div>';
    }
    else{
      $atualizar = BD::conn()->prepare("UPDATE `loja_clientes` SET nome = ?, sobrenome = ?, email = ?,
        telefone = ?, cpf = ?, rua = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, uf = ?,
        cep = ?, email_log = ?, senha_log = ? WHERE id_cliente = ?");
      $dados_atualizar = array($nome, $sobrenome, $email, $telefone, $cpf, $rua, $numero, $complemento, $bairro,
                               $cidade, $uf, $cep, $email_log, $senha_log, $usuarioLogado->id_cliente);
      if($atualizar->execute($dados_atualizar)){
        $_SESSION['media_emailLog'] = $email_log;
        $_SESSION['media_senhaLog'] = $senha_log;

        echo '<script>alert("Seus dados foram modificados com sucesso!");location.href="?pagina=perfil"</script>';
      }
    }
  }
?>
<head>
<style>
  .form-perfil{
    background-color:#f1f1f1;
    margin-left: 221px;
    width:60%;
  }

  #title-form-perfil{
		background-color: #4c4cff;
		padding: 17px 15px;
		height: 60px;
		color: #fff;
		margin: 0;
	}

	#title-form-perfil span{
		font-family: Verdana, sans-serif;
		font-size: 25px;
		margin-left: 10px;
	}

  body{
    background-color: orange;
  }

  form span{
    margin-left: 10px;
  }

  input[type=text], [type=password] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 2px;
      margin-bottom: 2px;
      margin-left: 10px;
      resize: vertical;
  }

  input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 16px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
    margin-bottom: 10px;
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

  span{
    font-style: Verdana, sans-serif;
    font-weight: bold;
    font-size: 16px;
    margin-left:10px;
  }

  .perfil-left{
    width: 260px !important;
  }

  .perfil-right{
    width: 260px !important;
    margin-left: 100px;
  }
</style>
</head>
<body>
<div class="form-perfil">
<h1 id="title-form-perfil"><span>Editar Perfil</span></h1>
  <form action="" method="post" enctype="multipart/form-data">
    <label class="perfil-left">
      <span>Nome</span>
      <input type="text" name="nome" value="<?php echo $usuarioLogado->nome; ?>">
    </label>

    <label class="perfil-right">
      <span>Sobrenome</span>
      <input type="text" name="sobrenome" value="<?php echo $usuarioLogado->sobrenome; ?>">
    </label><br>

    <label class="perfil-left">
      <span>Email</span>
      <input type="text" name="email" value="<?php echo $usuarioLogado->email; ?>">
    </label>

    <label class="perfil-right">
      <span>Telefone</span>
      <input type="text" name="telefone" value="<?php echo $usuarioLogado->telefone; ?>" id="tel">
    </label><br>

    <label class="perfil-left">
      <span>CPF</span>
      <input type="text" name="cpf" value="<?php echo $usuarioLogado->cpf; ?>" id="cpf">
    </label><br>

    <label class="perfil-left">
      <span>Rua</span>
      <input type="text" name="rua" value="<?php echo $usuarioLogado->rua; ?>">
    </label>

    <label class="perfil-right">
      <span>Número</span>
      <input type="text" name="numero" value="<?php echo $usuarioLogado->numero; ?>">
    </label><br>

    <label>
      <span>Complemento</span>
      <input type="text" name="complemento" size="56px" value="<?php echo $usuarioLogado->complemento; ?>">
    </label><br>

    <label class="perfil-left">
      <span>Bairro</span>
      <input type="text" name="bairro" value="<?php echo $usuarioLogado->bairro; ?>">
    </label>

    <label class="perfil-right">
      <span>Cidade</span>
      <input type="text" name="cidade" value="<?php echo $usuarioLogado->cidade; ?>">
    </label><br>

    <label class="perfil-left">
      <span>UF</span>
      <input type="text" name="uf" value="<?php echo $usuarioLogado->uf; ?>">
    </label>

    <label class="perfil-right">
      <span>CEP</span>
      <input type="text" name="cep" value="<?php echo $usuarioLogado->cep; ?>" id="cep">
    </label><br>

    <label class="perfil-left">
      <span>Email de Login</span>
      <input type="text" name="email_log" value="<?php echo $usuarioLogado->email_log; ?>">
    </label>

    <label class="perfil-right">
      <span>Senha de Login</span>
      <input type="text" name="senha_log" value="<?php echo $usuarioLogado->senha_log; ?>">
    </label><br>

    <input type="hidden" name="acao" value="editar">
    <input type="submit" value="Editar Perfil">
  </form>
</div>
<body>
