<?php
  $id_cliente = (int)$_GET['cliente'];
  $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_clientes` WHERE id_cliente = ?");
  $pegar_dados->execute(array($id_cliente));
  $cliente = $pegar_dados->fetchObject();

  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'):
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

    //Validação de campos
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
      $atualizar_campos = BD::conn()->prepare("UPDATE `loja_clientes` SET nome = ?, sobrenome = ?, email = ?,
        telefone = ?, cpf = ?, rua = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, uf = ?, cep = ?,
        email_log = ?, senha_log = ? WHERE id_cliente = ?");
      $dados_atualizar = array($nome, $sobrenome, $email, $telefone, $cpf, $rua, $numero, $complemento, $bairro,
                               $cidade, $uf, $cep, $emailLog, $senhaLog, $id_cliente);
      if($atualizar_campos->execute($dados_atualizar)){
        echo '<script>alert("Os dados do Cliente foram atualizados");location.href="?pagina=editarCliente&cliente='.$id_cliente.'"</script>';
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
    width:50%;
  }

  #formularios{
    margin-left:10px;
  }
</style>
</head>
<body>
<h1 class="title">Editar: <?php echo $cliente->nome.' '.$cliente->sobrenome; ?></h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Nome:</span>
        <input type="text" name="nome" value="<?php echo $cliente->nome; ?>">
      </label>

      <label>
        <span>Sobrenome:</span>
        <input type="text" name="sobrenome" value="<?php echo $cliente->sobrenome; ?>">
      </label><br>

      <label>
        <span>Email Pessoal:</span>
        <input type="text" name="email" value="<?php echo $cliente->email; ?>">
      </label>

      <label>
        <span>Telefone:</span>
        <input type="text" name="telefone" value="<?php echo $cliente->telefone; ?>" id="tel">
      </label>
    </div>

      <label>
        <span>CPF:</span>
        <input type="text" name="cpf" value="<?php echo $cliente->cpf; ?>" id="cpf">
      </label>

    <div class="fix">
      <label>
        <span>Rua:</span>
        <input type="text" name="rua" value="<?php echo $cliente->rua; ?>">
      </label>

      <label>
        <span>Número:</span>
        <input type="text" name="numero" value="<?php echo $cliente->numero; ?>">
      </label>

      <label>
        <span>Complemento:</span>
        <input type="text" name="complemento" value="<?php echo $cliente->complemento; ?>">
      </label>
    </div>

      <label>
        <span>Bairro:</span>
        <input type="text" name="bairro" value="<?php echo $cliente->bairro; ?>">
      </label>

      <label>
        <span>Cidade:</span>
        <input type="text" name="cidade" value="<?php echo $cliente->cidade; ?>">
      </label>

    <div class="fix">
      <label>
        <span>UF:</span>
        <input type="text" name="uf" value="<?php echo $cliente->uf; ?>">
      </label>

      <label>
        <span>CEP:</span>
        <input type="text" name="cep" value="<?php echo $cliente->cep; ?>" id="cep">
      </label>
    </div>

      <label>
        <span>Email de Login:</span><br>
        <input type="text" name="email_log" value="<?php echo $cliente->email_log; ?>">
      </label><br>

      <label>
        <span>Senha de Login:</span><br>
        <input type="password" name="senha_log" value="<?php echo $cliente->senha_log; ?>">
      </label><br>

    <input type="hidden" name="acao" value="editar">
    <input type="submit" value="Atualizar Dados">
  </form>
</div>
</body>
