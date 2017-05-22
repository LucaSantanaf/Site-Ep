<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'):
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $sobrenome = strip_tags(filter_input(INPUT_POST, 'sobrenome'));
    $email_log = strip_tags(filter_input(INPUT_POST, 'email_log'));
    $senha_log = strip_tags(filter_input(INPUT_POST, 'senha_log'));

    $tipo = $_POST['tipo'];

    $val->set($nome, 'Nome')->obrigatorio();
    $val->set($sobrenome, 'Sobrenome')->obrigatorio();
    $val->set($email_log, 'Email de Login')->isEmail();
    $val->set($senha_log, 'Senha de Login')->obrigatorio();
    $val->set($tipo, 'Tipo de Usuário')->obrigatorio();

    $verificar_adm = BD::conn()->prepare("SELECT id FROM `loja_adm` WHERE email_log = ?");
    $verificar_adm->execute(array($email_log));

    if(!$val->validar()){
      $erros = $val->getErro();
      echo '<div class="alert">Erro: '.$erros[0].'</div>';
    }
    elseif($verificar_adm->rowCount() > 0){
      echo '<div class="warning">Erro: Usuário já cadastrado com esse Email, escolha outro!</div>';
    }
    else{
      $dados_cadastrar = array('nome' => $nome,
                               'sobrenome' => $sobrenome,
                               'email_log' => $email_log,
                               'senha_log' => $senha_log,
                               'tipo' => $tipo);

      if($site->inserir('loja_adm', $dados_cadastrar)){
        echo '<div class="success">O novo Administrador foi cadastrado com sucesso!</div>';
      }
      else{
        echo '<div class="alert">Erro: Não foi possível cadastrar o novo Administrador</div>';
      }
    }
  endif;
?>
<head>
<style>
  input[type=text], [type=password] {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 2px;
      margin-bottom: 2px;
      resize: vertical;
  }

  input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .alert {
    padding: 10px;
    background-color: #f44336;
    color: white;
    width: 100%;
  }

  .success {
    background-color: #4CAF50;
    padding: 10px;
    color: white;
    width: 100%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width: 100%;
  }
</style>
</head>
<body>
<h1 class="title">Cadastrar Administrador</h1>
<div id="formularios" style="margin-left:10px;">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Nome:</span><br>
        <input type="text" name="nome">
      </label><br>

      <label>
        <span>Sobrenome:</span><br>
        <input type="text" name="sobrenome">
      </label>
    </div>

    <label>
      <span>Email de Login:</span><br>
      <input type="text" name="email_log">
    </label><br>

    <label>
      <span>Senha de Login:</span><br>
      <input type="password" name="senha_log">
    </label><br>

    <label>
      <span>Selecione o Tipo:</span><br>
      <input type="radio" name="tipo" value="1">Admin<br>
      <input type="radio" name="tipo" value="2">Editor
    </label><br>

    <input type="hidden" name="acao" value="cadastrar">
    <input type="submit" value="Cadastrar Administrador">
  </form>
</div>
</body>
