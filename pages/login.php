<head>
<style>
  body{
    background-color: orange;
  }

  .login-nav{
    background-color: #f1f1f1;
    border-radius: 4px;
    width: 30%;
    height: 36%;
    margin-top: 121px;
    margin-left: 478px;
    margin-right: 478px;
    margin-bottom: 121px;
  }

  .login-nav form{
    padding: 0;
    margin: 0;
  }

  .login-nav span{
    font-size: 30px;
    margin-left: 160px;
  }

  #h1-login{
    background-color: #4c4cff;
    color: #fff;
    padding-top: 15px;
    height: 60px;
  }

  #input-login input[type=text], [type=password] {
    width: 100%;
    padding: 8px 16px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 8px;
    margin-bottom: 5px;
    margin-left: 22px;
    resize: vertical;
  }

  .btn-login{
    background-color: #4CAF50;
    color: white;
    padding: 10px 0;
    width: 365px;
    font-size: 17px;
    border: none;
    border-radius: 4px;
    margin-left: 22px;
    cursor: pointer;
  }
</style>
</head>
<body>
<div class="login-nav">
  <?php if(!$login->isLogado()){ ?>
  <form action="" method="post" enctype="multipart/form-data">
    <h1 id="h1-login"><span>Login</span></h1>
    <label id="input-login"><input type="text" name="email" size="35" placeholder="Email"></label><br>
    <label id="input-login"><input type="password" name="senha" size="35" placeholder="Senha"></label><br>
    <label id="input-login">
      <input type="hidden" name="acao" value="logar">
      <input type="submit" value="Entrar" class="btn-login">
    </label>
  </form>
  <?php }else{ ?>
    <a href="&acao=sair" id="logout">Sair</a>
    <a href="#">Meus pedidos</a>
    <a href="#">Atendimento</a>
  <?php } ?>
</div>
</body>
