<?php
  session_start();
  include_once "../../config.php";
  function __autoload($classe){
    require_once "../../classes/".$classe.'.class.php';
  }
  BD::conn();
  $login = new Login('adm_','loja_adm');
  $site = new Site;
  $val = new Validacao;

  $pegar_modo = BD::conn()->prepare("SELECT `manutencao` FROM `loja_configs`");
  $pegar_modo->execute();
  $fetchModo = $pegar_modo->fetchObject();
  if($fetchModo->manutencao == 1 && !isset($_SESSION['adm_emailLog'], $_SESSION['adm_senhaLog'])){
    include_once "pages/manutencao.php";
    exit;
  }

  if(!$login->isLogado()){
    header("location: ../");
    exit;
  }
  else{
    $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_adm` WHERE email_log = ? AND senha_log = ?");
    $pegar_dados->execute(array($_SESSION['adm_emailLog'], $_SESSION['adm_senhaLog']));
    $usuarioLogado = $pegar_dados->fetchObject();
  }
  if(isset($_GET['acao']) && $_GET['acao'] == 'sair'):
    if($login->deslogar()){
      header("location: ../");
    }
  endif;
?>
<head>
  <title>Episeg - Painel de Administração</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="<?php echo PATH; ?>/images/favicon.png">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <script type="text/javascript" src="js/tinymce/js/jquery.min.js"></script>
  <script type="text/javascript" src="js/tinymce/plugin/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="../../js/jquery.js"></script>
  <script type="text/javascript" src="js/botoes.js"></script>
  <script type="text/javascript" src="../../js/price.js"></script>
  <script type="text/javascript" src="js/functions.js"></script>
<style>
  .active{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 100%;
    padding: 8px 8px;
  }

  #sidebar{
    background-color: #f1f1f1;
    float: left;
    width: 17%;
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

  #sidebar ul li:hover {
    background-color: #939393;
    width: 102%;
    color: #fff;
  }

  #sidebar ul li a{
    background-color: #ddd;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    margin-left: 10px;
    width: 100%;
  }

  #sidebar ul li p.active{
    background-color: #777;
    display: block;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    padding: 14px;
    width: 100%;
  }

  #sidebar ul ul{
    background-color: #ddd;
    display: none;
  }

  #sidebar ul ul li a{
    background-color: #ddd;
    width: 99.5%;
  }

  #sidebar ul ul li a:hover {
    background-color: #939393;
    width: 98%;
    color: #fff;
  }

  p.accordion {
    background-color: #f1f1f1;
    cursor: pointer;
    padding: 14px;
    width: 100%;
    margin-bottom: 0;
    border: none;
    text-align: left;
    outline: none;
    font-size: 16px;
    transition: 0.4s;
  }

  p.accordion.active, p.accordion:hover {
    background-color: #939393;
  }

  p.accordion a{
    text-decoration: none;
    margin: 0;
  }

/*  #logout{
    background-color: #ff0000;
    padding: 11px;
    font-size: 11px bold;
    color: #fff;
    text-decoration: none;
    float: right;
  }
*/
  #badge{
    background-color: #ff0000;
    padding: 8px;
    border-radius: 4px;
    color: #fff;
    font-size: 14px;
  }

  #ul{
    height: auto;
    max-height: 1000px;
    text-decoration:none;
    list-style-type:none;
  }

  #ul-ul{
    width: 96.5%;
  }

  #link-ul{
    color:#000;
    text-decoration:none;
  }

  #ul .home{
    background-color:#777;
    color:#fff;
    font-size:18px;
    list-style-type:none;
    margin-left: 5px;
    width: 98%;
  }

  #ul #logout{
    background-color: #ff0000;
    display: block;
    color: #fff;
    padding: 8px 8px;
    font-size: 16px;
    list-style-type:none;
    margin-left: 5px;
    width: 98%;
  }

  .logo{
    background-color:#f1f1f1;
    width:180px;
    padding: 5px;
  }

  .logo img{
    width:180px;
  }

  .sidebar-info{
    margin-top: 15px;
    margin-bottom: 15px;
  }

  .sidebar-info p{
    font-size: 15px;
    margin-left: 3px;
    margin-top: 3px;
  }

  hr{
    color: #000;
    margin: 10px;
  }
</style>
</head>
<div id="sidebar">
  <div class="logo">
    <img src="images/episegLogo.png">
  </div>

  <div class="sidebar-info">
    <p>Olá, <?php echo $usuarioLogado->nome;?></p>
  </div>

  <ul id="ul">
    <li><a href="Index.php" class="home">Home</a></li>
    <li><p class="accordion">Produtos</p>
      <ul id="ul-ul">
        <li><a href="?pagina=cadProdutos" id="link-ul">Cadastrar Produtos</a></li>
        <li><a href="?pagina=editarProdutos" id="link-ul">Editar Produtos</a></li>
        <li><a href="?pagina=produtosFaltam" id="link-ul">Produtos em Falta
          <span id="badge"><?php $site->produtosFaltando(); ?></span></a></li>
      </ul>
    </li>

    <li><p class="accordion">Clientes</p>
      <ul id="ul-ul">
        <li><a href="?pagina=listarClientes" id="link-ul">Listar Clientes</a></li>
        <li><a href="?pagina=cadastrarCliente" id="link-ul">Cadastrar Clientes</a></li>
      </ul>
    </li>
    <?php if($usuarioLogado->tipo == '1'){ ?>
    <li><p class="accordion">Administradores</p>
      <ul id="ul-ul">
        <li><a href="?pagina=cadastrarAdm" id="link-ul">Cadastrar Novo</a></li>
        <li><a href="?pagina=listarAdms" id="link-ul">Editar Cadastrados</a></li>
      </ul>
    </li>

    <li><p class="accordion">Categorias</p>
      <ul id="ul-ul">
        <li><a href="?pagina=cadastrarCategoria" id="link-ul">Cadastrar Categoria</a></li>
        <li><a href="?pagina=editarCategorias" id="link-ul">Editar Categorias</a></li>
      </ul>
    </li>

    <li><p class="accordion">Subcategorias</p>
      <ul id="ul-ul">
        <li><a href="?pagina=cadastrarSubcategoria" id="link-ul">Cadastrar Subcategorias</a></li>
        <li><a href="?pagina=listarSubcategorias" id="link-ul">Editar Subcategorias</a></li>
      </ul>
    </li>

    <li><p class="accordion">Site</p>
      <ul id="ul-ul">
        <li><a href="?pagina=configuracoes" id="link-ul">Configurações</a></li>
        <li><a href="?pagina=banners" id="link-ul">Banner Principal</a></li>
      </ul>
    </li>

    <li><p class="accordion">Tickets</p>
      <ul id="ul-ul">
        <li><a href="?pagina=tickets_pendentes" id="link-ul">Tickets Pendentes</a></li>
        <li><a href="?pagina=tickets_fechados" id="link-ul">Tickets Fechados</a></li>
      </ul>
    </li>
    <?php } ?>
    <li><a href="?acao=sair" id="logout">Sair</a></li>
  </ul>
</div>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function(){
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
        panel.style.display = "none";
    } else {
        panel.style.display = "block";
    }
  }
}
</script>
</body>
