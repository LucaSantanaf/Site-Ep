<?php ob_start(); ?>
<head>
<style>
	#content_painel{
		float:left;
		width:83%;
		height: auto;
		max-height: 1100px;
		margin:0px;
		background-color:#777;
	}

	.index-adm{
		background-color: #777;
	}

	.title{
		margin-left: 10px;
		color:#f1f1f1;
	}
</style>
</head>
<body class="index-adm">
<?php include_once "inc/sidebar.php"; ?>
<div id="content_painel">
<?php
	if(!isset($_GET['pagina']) || $_GET['pagina'] == ''){
    include_once "pages/home.php";
  }
  else{
    $pagina = strip_tags($_GET['pagina']);
    if(file_exists('pages/'.$pagina.'.php')){
      include_once "pages/$pagina".'.php';
    }
    else{
      echo '<p>Desculpe mas a página que você procura não existe</p>';
    }
  }
?>
</div>
<?php include_once "inc/footer.php"; ?>
</body>
