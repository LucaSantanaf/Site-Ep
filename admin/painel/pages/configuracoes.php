<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'editar_perfil'){
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $sobrenome = strip_tags(filter_input(INPUT_POST, 'sobrenome'));
    $emailLog = strip_tags(filter_input(INPUT_POST, 'emailLog'));
    $senhaLog = strip_tags(filter_input(INPUT_POST, 'senhaLog'));

    $val->set($nome, 'Nome')->obrigatorio();
    $val->set($sobrenome, 'Sobrenome')->obrigatorio();
    $val->set($emailLog, 'Email de Login')->obrigatorio();
    $val->set($senhaLog, 'Senha de Login')->obrigatorio();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="alert">Erro: '.$erro[0].' </div>';
    }
    else{
      $_SESSION['adm_emailLog'] = $emailLog;
      $_SESSION['adm_senhaLog'] = $senhaLog;

      $atualizar_dados = BD::conn()->prepare("UPDATE `loja_adm` SET `nome` = ?, `sobrenome` = ?, `email_log` = ?,
                                             `senha_log` = ? WHERE `id` = ?");
      $dados_atualizar = array($nome, $sobrenome, $emailLog, $senhaLog, $usuarioLogado->id);
      if($atualizar_dados->execute($dados_atualizar)){
        echo '<script>alert("Dados atualizados com sucesso!");location.href="?pagina=configuracoes"</script>';
      }
    }
  }

  if(isset($_POST['acao']) && $_POST['acao'] == 'manutencao'):
  	$valor = $_POST['manu'];
  	$atualizar = BD::conn()->prepare("UPDATE `loja_configs` SET `manutencao` = ?");
  	if($atualizar->execute(array($valor))){
  		echo '<script>alert("Modo de manutenção foi modificado");location.href="?pagina=configuracoes"</script>';
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
<h1 class="title">Configurações - Perfil</h1>
<div id="formularios" style="margin-left:10px;">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="fix">
      <label>
        <span>Nome</span>
        <input type="text" name="nome" value="<?php echo $usuarioLogado->nome; ?>">
      </label><br>

      <label>
        <span>Sobrenome</span>
        <input type="text" name="sobrenome" value="<?php echo $usuarioLogado->sobrenome; ?>">
      </label><br>
    </div>

    <label>
      <span>Email de Login</span>
      <input type="text" name="emailLog" value="<?php echo $usuarioLogado->email_log; ?>">
    </label><br>

    <label>
      <span>Senha de Login</span>
      <input type="password" name="senhaLog" value="<?php echo $usuarioLogado->senha_log; ?>">
    </label><br>

    <input type="hidden" name="acao" value="editar_perfil">
    <input type="submit" value="Editar Perfil">
  </form>
</div>

<h1 class="title">Configurações - Manutenção Site</h1>
<div id="formularios">
<?php
  $pegar_modo = BD::conn()->prepare("SELECT `manutencao` FROM `loja_configs`");
  $pegar_modo->execute();
  $fetchModo = $pegar_modo->fetchObject();
?>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="radio" name="manu" value="1" <?php if($fetchModo->manutencao == 1){echo 'checked';} ?> >Sim
    <input type="radio" name="manu" value="0" <?php if($fetchModo->manutencao == 0){echo 'checked';} ?> >Não
<br>
    <input type="hidden" name="acao" value="manutencao">
    <input type="submit" value="Mudar">
  </form>
</div>
</body>
