<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadastrar'){
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $sobrenome = strip_tags(filter_input(INPUT_POST, 'sobrenome'));
    $email = strip_tags(filter_input(INPUT_POST, 'email'));
    $telefone = strip_tags(filter_input(INPUT_POST, 'telefone'));

    $cpf = strip_tags(filter_input(INPUT_POST, 'cpf'));
    $cpf = preg_replace("/[^0-9]/", "", $cpf);

    $rua = strip_tags(filter_input(INPUT_POST, 'rua'));
    $numero = strip_tags(filter_input(INPUT_POST, 'numero'));
    $complemento = strip_tags(filter_input(INPUT_POST, 'complemento'));
    $bairro = strip_tags(filter_input(INPUT_POST, 'bairro'));
    $cidade = strip_tags(filter_input(INPUT_POST, 'cidade'));
    $uf = strip_tags(filter_input(INPUT_POST, 'uf'));

    $cep = strip_tags(filter_input(INPUT_POST, 'cep'));
    $cep = preg_replace("/[^0-9]/", "", $cep);

    $emailLog = strip_tags(filter_input(INPUT_POST, 'email_log'));
    $senhaLog = strip_tags(filter_input(INPUT_POST, 'senha_log'));

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
    $val->set($emailLog, 'Email de Login')->isEmail();
    $val->set($senhaLog, 'Senha de Login')->obrigatorio();

    if(!$val->validar()){
      $erros = $val->getErro();
      echo '<div class="alert">'.$erros[0].'</div>';
    }
    else{
      $verificarUsuario = BD::conn()->prepare("SELECT id_cliente FROM `loja_clientes` WHERE email_log = ?");
      $verificarUsuario->execute(array($emailLog));
      if($verificarUsuario->rowCount() > 0){
        echo '<div class="warning">Já existe um usuário com este e-mail de login, cadastre outro!</div>';
      }
      else{
        $dados = array('nome' => $nome,
                       'sobrenome' => $sobrenome,
                       'email' => $email,
                       'telefone' => $telefone,
                       'cpf' => $cpf,
                       'rua' => $rua,
                       'numero' => $numero,
                       'complemento' => $complemento,
                       'bairro' => $bairro,
                       'cidade' => $cidade,
                       'uf' => $uf,
                       'cep' => $cep,
                       'email_log' => $emailLog,
                       'senha_log' => $senhaLog);

          if($site->inserir('loja_clientes', $dados)){
            echo '<div class="success">O cliente foi cadastrado com sucesso</div>';
          }
      }//Else do usuário já cadastrado
    }//Else do getErros
  }
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
    width:100%;
  }

  .success {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    width:100%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width:100%;
  }
</style>
</head>
<body>
<h1 class="title">Cadastrar Novo Cliente</h1>
<div id="formularios" style="margin-left:10px;">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Nome:</span>
        <input type="text" name="nome">
      </label>

      <label>
        <span>Sobrenome:</span>
        <input type="text" name="sobrenome">
      </label><br>

      <label>
        <span>Email Pessoal:</span>
        <input type="text" name="email">
      </label>

      <label>
        <span>Telefone:</span>
        <input type="text" name="telefone" id="tel" placeholder="Ex: (99)9999-9999">
      </label>
    </div>

      <label>
        <span>CPF:</span>
        <input type="text" name="cpf" id="cpf" placeholder="Ex: 99.999.999-99">
      </label><br>

    <div class="fix">
      <label>
        <span>Rua:</span>
        <input type="text" name="rua">
      </label>

      <label>
        <span>Número:</span>
        <input type="text" name="numero">
      </label>
    </div>

      <label>
        <span>Complemento:</span>
        <input type="text" name="complemento" size="60">
      </label><br>

      <label>
        <span>Bairro:</span>
        <input type="text" name="bairro">
      </label>

      <label>
        <span>Cidade:</span>
        <input type="text" name="cidade">
      </label><br>

    <div class="fix">
      <label>
        <span>UF:</span>
        <input type="text" name="uf" size="1">
      </label>

      <label>
        <span>CEP:</span>
        <input type="text" name="cep" id="cep" placeholder="Ex: 99999-999">
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

    <input type="hidden" name="acao" value="cadastrar">
    <input type="submit" value="Cadastrar Cliente">
  </form>
</div>
</body>
