<?php
  $id_adm = (int)$_GET['adm'];
  $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_adm` WHERE id = ?");
  $pegar_dados->execute(array($id_adm));
  $fetchAdm = $pegar_dados->fetchObject();

  if(isset($_POST['acao']) && $_POST['acao'] == 'editar'):
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

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="alert">Erro: '.$erro[0].'</div>';
    }
    else{
      $atualizar = BD::conn()->prepare("UPDATE `loja_adm` SET nome = ?, sobrenome = ?, email_log = ?, senha_log = ?,
                                        tipo = ? WHERE id = ?");
      $dados = array($nome, $sobrenome, $email_log, $senha_log, $tipo, $id_adm);
      if($atualizar->execute($dados)){
        echo '<script>alert("Administrador editado!");location.href="?pagina=editarAdm&adm='.$id_adm.'"</script>';
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
<h1 class="title">Editar: <?php echo $fetchAdm->nome.' '.$fetchAdm->sobrenome; ?></h1>
<div id="formularios">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Nome:</span><br>
        <input type="text" name="nome" value="<?php echo $fetchAdm->nome; ?>">
      </label><br>

      <label>
        <span>Sobrenome:</span><br>
        <input type="text" name="sobrenome" value="<?php echo $fetchAdm->sobrenome; ?>">
      </label>
    </div>

    <label>
      <span>Email de Login:</span><br>
      <input type="text" name="email_log" value="<?php echo $fetchAdm->email_log; ?>">
    </label><br>

    <label>
      <span>Senha de Login:</span><br>
      <input type="password" name="senha_log" value="<?php echo $fetchAdm->senha_log; ?>">
    </label><br>

    <label>
      <span>Selecione o Tipo:</span><br>
      <input type="radio" name="tipo" value="1" <?php if($fetchAdm->tipo == '1'){echo 'checked';}?> >Admin<br>
      <input type="radio" name="tipo" value="2" <?php if($fetchAdm->tipo == '2'){echo 'checked';}?> >Editor
    </label><br>

    <input type="hidden" name="acao" value="editar">
    <input type="submit" value="Atualizar Dados">
  </form>
</div>
</body>
