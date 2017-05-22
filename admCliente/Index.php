<?php
  session_start();
  include_once "../config.php";
  function __autoload($classe){
    require_once '../classes/'.$classe.'.class.php';
  }
  BD::conn();
  $login = new Login('media_', 'loja_clientes');
  $site = new Site();
  $val = new Validacao();

  if(!$login->isLogado()){
    header("location: ".PATH."");
    exit;
  }
  else{
    $strSQL = "SELECT * FROM `loja_clientes` WHERE email_log = ? AND senha_log = ?";
    $stmt = BD::conn()->prepare($strSQL);
    $stmt->execute(array($_SESSION['media_emailLog'], $_SESSION['media_senhaLog']));
    $usuarioLogado = $stmt->fetchObject();
  }

  if(isset($_GET['acao']) && $_GET['acao'] == 'sair'){
    if($login->deslogar()){
      header("location: ".PATH."");
      exit;
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
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/mask.js"></script>
<script type="text/javascript">
  $(function(){
    $("#tel").mask("(99)9999-9999");
    $("#cpf").mask("999.999.999-99");
    $("#cep").mask("99999-999");
  })
</script>
<style>
  .imagem{
    background-color: #ddd;
    margin-bottom: 10px;
    float:left;
    width:100%;
    height:180px;
  }

  .active{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 100%;
    padding: 8px 8px;
  }

  .logo{
    background-color:#fff;
    width:100%;
    padding: 5px;
  }

  .logo img{
    width:180px;
  }

  .sidebar-info{
    margin-bottom: 10px;
    margin-left: 5px;
  }

  .sidebar-info span{
    font-size: 15px;
    margin-top: 3px;
    margin-left: 0;
  }

  .compras{
    float: left;
    width: 82%;
  }

  #mudar{
    background-color: #4CAF50;
    color: white;
    padding: 8px 14px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 51px;
  }

  #mudar:hover{
    text-decoration: none;
  }

  #img-cliente{
    margin-left: 51px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: solid 1px #000;
    border-radius: 50%;
  }

  #footer{
    background-color:#9975b9;
    clear:both;
    width:100%;
  }

  #sidebar{
    background-color: #ddd;
    float: left;
    width: 18%;
    height: 100%;
    max-height: 1100px;
    margin: 0px;
  }

  #sidebar ul{
    background-color: #f1f1f1;
    list-style-type: none;
    margin:0;
    padding:0;
  }

  #sidebar ul li{
    margin-left: -5px;
  }

  #sidebar ul li a{
    background-color: #ddd;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    width: 100%;
  }

  #sidebar ul li a:hover {
    background-color: #939393;
    width: 100%;
    color: #fff;
  }

  #ul{
    height: auto;
    max-height: 1000px;
    text-decoration:none;
    list-style-type:none;
  }

  #ul .home{
    background-color:#777;
    color:#fff;
    font-size:18px;
    list-style-type:none;
    width: 100%;
  }
</style>
</head>
<body>
<div id="sidebar">
	<div class="logo">
		<a href="<?php echo PATH;?>"><img src="images/episegLogo.png"> </a>
	</div>

  <div class="imagem">
    <?php
      if($usuarioLogado->imagem == ''){
        echo '<img src="../clientes/default.jpg" id="img-cliente">';
      }
      else{
        echo '<img src="../clientes/'.$usuarioLogado->imagem.'" width="140px" id="img-cliente">';
      }
    ?><br>
    <a href="?pagina=mudar_imagem" id="mudar">Mudar Imagem</a>
  </div><!-- imagem left -->

  <div class="sidebar-info">
    <span>Olá Senhor(a), <?php echo $usuarioLogado->nome.' '.$usuarioLogado->sobrenome;?></span>
  </div>

	<div id="ul">
		<div id="dados_top">
			<ul id="ul">
        <li><a href="Index.php" class="home">Home</a></li>
        <li><a href="Index.php?pagina=novo_ticket">Novo Ticket</a></li>
				<li><a href="Index.php?pagina=tickets_abertos">Tickets em Aberto</a></li>
				<li><a href="Index.php?pagina=tickets_fechados">Tickets Fechados</a></li>
        <li><a href="Index.php?pagina=perfil" id="data">Seus dados</a></li>
        <li><a href="../">Voltar para Página Inicial</a></li>
  			<li><a href="?acao=sair" id="logout">Sair</a></li>
      </ul>
    </div>
  </div>
</div>

  <div class="compras">
    <?php
			if(!isset($_GET['pagina']) || $_GET['pagina'] == ''){
				include_once "pages/home.php";
			}
      else{
				if(file_exists('pages/'.$_GET['pagina'].'.php')){
					include_once "pages/".$_GET['pagina'].".php";
				}
        else{
					echo '<p align="center">Desculpe mas esta pagina não existe!</p>';
				}
			}
		?>
  </div>

	<div id="footer">
		<span class="right">Desenvolvido por: Lucas</span>
		<span><br>
			Todos os direitos Reservados<br>
			Episeg
		</span>
	</div>
</div><!-- box -->
</body>
</html>
