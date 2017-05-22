<?php
  if(isset($_POST['categoria'])){
    include_once "../../config.php";
    function __autoload($classe){
      require_once "../../classes/".$classe.'.class.php';
    }
    BD::conn();

    $slugCategoria = $_POST['categoria'];
    $selecionar_id = BD::conn()->prepare("SELECT id FROM `loja_categorias` WHERE slug = ?");
    $selecionar_id->execute(array($slugCategoria));
    $fetchId = $selecionar_id->fetchObject();

    $selecionar_subcategoria = BD::conn()->prepare("SELECT id, titulo, slug FROM `loja_subcategorias` WHERE id_cat = ?");
    $selecionar_subcategoria->execute(array($fetchId->id));
    echo '<option value="" selected="selected">Escolha a subcategoria</option>';

    while($subcat = $selecionar_subcategoria->fetchObject()){
      echo '<option value="'.$subcat->slug.'">'.$subcat->titulo.'</option>';
    }
  }
?>
