<head>
<style>
  .active{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 100%;
    padding: 8px 8px;
  }

  #sidebar_menu {
    background-color: #f1f1f1;
    float: left;
    width: 200px;
    margin: 0px;
    margin-top: 20px;
    margin-left: 3px;
  }

  #sidebar_menu ul{
    background-color: #f1f1f1;
    list-style-type: none;
    margin:0;
    padding:0;
  }

  #sidebar_menu ul li p:hover {
    background-color: #939393;
    width: 200px;
    color: #fff;
  }

  #sidebar_menu ul li p{
    background-color: #f1f1f1;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  #sidebar_menu ul li p.active{
    background-color: #777;
    display: block;
    color: #fff;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  #sidebar_menu ul ul{
    display: none;
  }

  #sidebar_menu ul ul p{
    background-color: #ddd;
  }

  #marcas_menu {
    background-color: #f1f1f1;
    float: left;
    width: 200px;
    margin: 0px;
    margin-top: 20px;
    margin-left: 3px;
  }

  #marcas_menu ul{
    background-color: #f1f1f1;
    list-style-type: none;
    margin:0;
    padding:0;
  }

  #marcas_menu ul li a{
    background-color: #f1f1f1;
    display: block;
    color: #000;
    padding: 8px 8px;
    text-decoration: none;
    width: 200px;
  }

  .marcas{
    color: #fff;
    font-size: 18px;
    background-color: #777;
    width: 200px;
    padding: 8px 8px;
  }

  .imagem-banner{
    margin-left:10px;
  }

  .img{
    width: 160px;
    height: 120px;
    margin-bottom: 0px;
    margin-left: 10px;
  }
</style>
</head>
<body>
  <div id="sidebar_menu">
    <ul>
      <li class="active"><span>Categorias</span></li>
      <?php $site->getMenu(); ?>
    </ul>
  </div>
<br>
  <div id="marcas_menu">
    <div class="marcas"><span>Nossas Marcas</span></div>
    <?php
      $data = array('id', 'titulo', 'link', 'imagem');
      $site->selecionar('loja_marcas', $data, false, 'id DESC');

      $count = 0;
      foreach($site->listar() as $campos){
        $count++;
    ?>
    <ul class="imagem-banner">
      <li><a href="<?php echo $campos['link'];?>"><img src="marcas/<?php echo $campos['imagem']; ?>" alt="" class="img"></a></li>
    </ul>
    <?php } ?>
  </div>
</body>
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
