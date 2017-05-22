<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'cadCliente'){
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

    $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
    $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));

    $val = new Validacao();
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
      echo '<p class="alert">'.$erros[0].'</p>';
    }
    else{
      $verificarUsuario = BD::conn()->prepare("SELECT id_cliente FROM `loja_clientes` WHERE email_log = ? ");
      $verificarUsuario->execute(array($emailLog));
      if($verificarUsuario->rowCount() > 0){
        echo '<p class="warning">Já existe um usuário com este e-mail de login, cadastre outro!</p>';
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
            if(isset($_SESSION['valor_frete'])){
              echo '<script>alert("Cadastro realizado com sucesso, agora você irá para tela de login para
              efetuar sua compra");location.href="'.PATH.'verificar"</script>';
            }
            else{
              echo '<p id="success">Seu cadastro foi realizado com sucesso em nosso site</p>';
            }
          }//Se inserir
      }//Else do usuário já cadastrado
    }//Else do getErros
  }
?>
<head>
<style>
  body{
    background-color: orange;
  }

  .container{
    width: 60%;
    margin-left: 277px;
    margin-right: 277px;
  }

  form{
    background-color:#f1f1f1;
    width:100%;
    margin-top:10px;
    margin-bottom:30px;
  }

  legend{
    font-size: 21px;
  }

  article{
    margin-left: 30px;
    margin-top: -10px;
  }

  label{
    margin-left: 10px;
  }

  span{
    font-family: Verdana, sans-serif;
    font-weight: bold;
    font-size: 16px;
    margin-left:10px;
  }

  input[type=text], [type=password] {
      width: 100%;
      padding: 7px;
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
    padding: 4px;
    background-color: #f44336;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }

  .success {
    padding: 4px;
    background-color: #4CAF50;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }

  .info {
    padding: 4px;
    background-color: #2196F3;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }

  .warning {
    padding: 4px;
    background-color: #ff9800;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }

  .closebtn {
      margin-left: 15px;
      margin-top: 5px;
      color: white;
      font-weight: bold;
      float: right;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: 0.3s;
  }

  .closebtn:hover {
      color: black;
  }

  #cadastro-h1{
    background-color: #4c4cff;
    margin-top: -10px;
    padding-top: 15px;
    height: 60px;
    color: #fff;
  }

  #cadastro-h1 span{
    margin-left: 40px;
    font-size: 25px;
  }

  #btn-cadastrar{
    margin-left: 10px;
  }
</style>
</head>
<body>
<div class="container">
  <div id="cadastro_cliente">
    <form action="" method="post" enctype="multipart/form-data">
      <h1 id="cadastro-h1"><span>Faça seu cadastro em nossa loja</span></h1>
      <fieldset>
        <legend><center><strong>Dados Pessoais</strong></center></legend>
        <article>
          <label>
            <span>Nome</span>
            <input type="text" name="nome" id="nome-cad">
          </label><br>

          <label>
            <span>Sobrenome</span>
            <input type="text" name="sobrenome" id="sobrenome-cad">
          </label><br>

          <label>
            <span>Telefone</span>
            <input type="text" name="telefone" id="tel">
          </label><br>

          <label>
            <span>E-mail para contato</span>
            <input type="text" name="email" id="email-cad">
          </label><br>

          <label>
            <span>CPF</span>
            <input type="text" name="cpf" size="4" id="cpf">
          </label>
        </article>
      </fieldset>

      <fieldset>
       <legend><center><strong>Endereço</strong></center></legend>
        <article>
          <label>
            <span>Rua</span>
            <input type="text" name="rua">
          </label><br>

          <label>
            <span>Número</span>
            <input type="text" name="numero" size="1">
          </label><br>

          <label>
            <span>CEP</span>
            <input type="text" name="cep" id="cep">
          </label><br>

          <label>
            <span>Complemento</span>
            <input type="text" name="complemento" size="60">
          </label><br>

          <label>
            <span>Bairro</span>
            <input type="text" name="bairro">
          </label><br>

          <label>
            <span>Cidade</span>
            <input type="text" name="cidade">
          </label><br>

          <label>
            <span>UF</span>
            <input type="text" name="uf" size="1">
          </label>
        </article>
      </fieldset>

      <fieldset>
       <legend><center><strong>Dados de Login</strong></center></legend>
        <article>
          <label>
            <span>Email de Login</span><br>
            <input type="text" name="emailLog">
          </label><br>

          <label>
            <span>Senha de Login</span>
            <input type="password" name="senhaLog">
          </label><br>

          <label id="btn-cadastrar">
            <input type="hidden" name="acao" value="cadCliente">
            <input type="submit" value="Cadastrar">
          </label>
        </article>
      </fieldset>
    </form>
  </div>
</div>
</body>
