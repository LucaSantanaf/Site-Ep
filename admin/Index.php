<?php
  session_start();
  function __autoload($classe){
    require_once "../classes/$classe".'.class.php';
  }
  include_once "../config.php";
  BD::conn();
  $login = new Login('adm_', 'loja_adm');
  if($login->isLogado()){
    header("location: painel/Index.php");
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Episeg</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?php echo PATH; ?>/images/favicon.png">
      <link rel="stylesheet" type="text/css" href="<?php echo PATH; ?>css/bootstrap.min.css">
<style>
  body{
    background-color: orange;
  }

  #box_log{
    margin-left: 10px;
  }

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

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width:100%;
  }

  .info {
    padding: 10px;
    background-color: #2196F3;
    color: white;
    width: 100%;
  }

  .info p{
    margin-bottom: 0;
  }

  .closebtn {
      margin-left: 15px;
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
</style>
</head>
<body>
<div id="box_log">
  <h1>Efetuar Login</h1>
<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'entrar'):
    $email = strip_tags(filter_input(INPUT_POST, 'email'));
    $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
    if($email == '' || $senha == ''){
      echo '<div class="warning">Preencha todos os campos por favor!</div>';
    }
    else{
      $login->setEmail($email);
      $login->setSenha($senha);
      if($login->logar()){
        header("location: painel/Index.php");
      }
      else{
        echo '<div class="alert">Erro, usuário não encontrado!</div>';
      }
    }
  endif;
?>
<?php if(!$login->isLogado()){ ?>
  <div class="info">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    <p>Para você acessar o painel, você deve ter acesso confirmado com o administrador do site!</p>
  </div>
<?php } ?>
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Email</span>
      <input type="text" name="email">
    </label><br>

    <label>
      <span>Senha</span>
      <input type="password" name="senha">
    </label><br>
    <input type="hidden" name="acao" value="entrar">
    <input type="submit" value="Logar">
  </form>
</div>

</body>
</html>
