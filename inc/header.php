<?php
ob_start();
  session_start();
  include_once "config.php";
  function __autoload($classe){
    if(!strstr($classe, 'PagSeguro')){
      require_once 'classes/'.$classe.'.class.php';
    }
  }
  BD::conn();
  $site = new Site();
  $carrinho = new Carrinho();
  $login = new Login('media_','loja_clientes');

$site->atualizarViews();
$pegar_modo = BD::conn()->prepare("SELECT `manutencao` FROM `loja_configs`");
$pegar_modo->execute();
$fetchModo = $pegar_modo->fetchObject();
if($fetchModo->manutencao == 1 && !isset($_SESSION['adm_emailLog'], $_SESSION['adm_senhaLog'])){
  include_once "pages/manutencao.php";
  exit;
}

if($login->isLogado()){
  $strSQL = "SELECT * FROM `loja_clientes` WHERE email_log = ? AND senha_log = ?";
  $stmt = BD::conn()->prepare($strSQL);
  $stmt->execute(array($_SESSION['media_emailLog'], $_SESSION['media_senhaLog']));
  $usuarioLogado = $stmt->fetchObject();
}

if(isset($_POST['acao']) && $_POST['acao'] == 'logar'){
  $email = strip_tags(filter_input(INPUT_POST, 'email'));
  $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
  if($email == '' || $senha == ''){
    echo '<script>alert("Preencha todos os campos")</script>';
  }
  else{
    $login->setEmail($email);
    $login->setSenha($senha);
    if($login->logar()){
      echo '<script>alert("Login efetuado!");location.href="'.PATH.'"</script>';
    }
    else{
      echo '<script>alert("Usuário não encontrado!");location.href="'.PATH.'"</script>';
    }
  }
}

if(isset($_GET['acao']) && $_GET['acao'] == 'sair'){
  if($login->deslogar()){
    echo '<script>alert("Você acaba de efutuar Logout!");location.href="'.PATH.'"</script>';
  }
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
  <script type="text/javascript" src="<?php echo PATH; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo PATH; ?>/js/cycle.js"></script>
  <script type="text/javascript" src="<?php echo PATH; ?>/js/mask.js"></script>
  <script type="text/javascript" src="<?php echo PATH; ?>/js/funcoes.js"></script>
<style>
  .topnav {
    background-color: #f1f1f1;
    overflow: hidden;
    height:60px;
  }

  /* Style the links inside the navigation bar */
  .topnav a {
    float: left;
    display: block;
    color: #333;
    text-align: center;
    padding: 20px 14px;
    text-decoration: none;
    font-size: 16px;
    font-family: Verdana, sans-serif;
  }

  /* Change the color of links on hover */
  .topnav a:hover {
    background-color: #ddd;
    color: black;
    text-decoration: none;
  }

  /* Hide the link that should open and close the topnav on small screens */
  .topnav .icon {
    display: none;
  }

  /* When the screen is less than 600 pixels wide, hide all links, except for the first one ("Home"). Show the link that contains should open and close the topnav (.icon) */
  @media screen and (max-width: 600px) {
    .topnav a:not(:first-child) {display: none;}
    .topnav a.icon {
      float: right;
      display: block;
    }
  }

  /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
  @media screen and (max-width: 600px) {
    .topnav.responsive {position: relative;}
    .topnav.responsive a.icon {
      position: absolute;
      right: 0;
      top: 0;
    }
    .topnav.responsive a {
      float: none;
      display: block;
      text-align: left;
    }
  }

  .img-responsive {
    max-width: 100%;
    height: auto;
    display: block;
  }

  #search{
    float:left;
  }

  #search-input{
    margin-top: 8px;
    padding: 8px;
  }

  #search-buscar{
    background-color: #007f00;
    padding: 10px;
    color: #fff;
    border: 0px;
    margin-left: -5px;
  }

  .info {
    padding: 4px;
    background-color: #2196F3;
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

  .N-logado{
    background-color:orange;
    height:0px;
    width:100%;
    clear:both;
  }

  #imagem-responsive{
    width:180px;
    display:inline-block;
    float:left;
    height:58.97;
  }

  #logo-imagem-responsive{
    padding:5px;
    width:180px;
  }

  .nav-right{
    float:right;
  }

  #index{
    margin-left:10px;
  }

  #cad-nav a:hover{
    text-decoration: none;
  }

  .logado{
    background-color:#777;
    overflow: hidden;
    height: 60px;
  }

  .logado a{
    float: left;
    display: block;
    color: #fff;
    text-align: center;
    padding: 20px 14px;
    text-decoration: none;
    font-size: 16px;
    font-family: Verdana, sans-serif;
  }
</style>
</head>
<body>
<header>
  <nav>
    <div class="topnav">
      <span href="#" class="img-responsive" id="imagem-responsive">
        <img src="<?php echo PATH; ?>images/episegLogo.png" id="logo-imagem-responsive"></img>
      </span>

      <div class="nav-right">
        <div id="search">
          <form action="<?php echo PATH;?>" method="get" enctype="multipart/form-data">
        	   <label>
                <input type="text" name="s" value="" placeholder="Pesquisar" id="search-input">
              </label>
              <input type="submit" value="buscar" id="search-buscar">
          </form>
        </div>

        <?php if(!$login->isLogado()){ ?>
        <div class="topnav">
          <a href="<?php echo PATH; ?>" id="index">Home</a>
          <a href="<?php echo PATH.'carrinho'; ?>">(<?php echo $carrinho->qtdProdutos(); ?>) Carrinho</a>
          <a href="<?php echo PATH; ?>login">Login</a>
          <a href="<?php echo PATH; ?>cadastre-se">Cadastro</a>
          <a href="<?php echo PATH; ?>localizacao">Localização</a>
        </div>
        <?php }else{ ?>
        <div class="topnav">
          <a href="Index.php" id="index">Home</a>
          <a href="<?php echo PATH.'carrinho'; ?>">(<?php echo $carrinho->qtdProdutos(); ?>) Carrinho</a>
          <a href="#">Meus pedidos</a>
          <a href="#">Atendimento</a>
          <a href="<?php echo PATH.'admCliente'; ?>">Painel</a>
          <a href="&acao=sair" id="logout">Sair</a>
          </div>
        <?php } ?>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
      </div>
    </div>

    <div id="cad-nav">
      <?php
        if($login->isLogado()){
          echo '<div class="info"><span class="closebtn">&times;</span><p>Olá Senhor(a): '.$usuarioLogado->nome.', <a href="'.PATH.'/admCliente">Ir para o painel</a></p></div>';
        }
        else{
          echo '<div class="info"><span class="closebtn">&times;</span><p class="info">Olá visitante, não é cadastrado? <a href="'.PATH.'/cadastre-se">Cadastre-se</a></p></div>';
        }
      ?>
    </div>
  </nav>
</header>

<script>
// Barra de Navegação Responsiva //
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

// Fechar Alerta do Topo //
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>

<script src="<?php echo PATH; ?>https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="<?php echo PATH; ?>https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
