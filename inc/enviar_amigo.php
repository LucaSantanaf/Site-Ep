<?php
  session_start();
  include_once "../config.php";
  function __autoload($classe){
    if(!strstr($classe, 'PagSeguro')){
      require_once '../classes/'.$classe.'.class.php';
    }
  }
  BD::conn();
  $site = new Site();
  $val = new Validacao();
?>
<head>
<style>
  #enviar_amigo{
    background-color: #2196F3;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-bottom: 10px;
    width: 450px;
    height: 250px;
  }

  #enviar_amigo form{
    margin-left: 10px;
    margin-top: 15px;
  }

  #enviar_amigo input[type=text], [type=password] {
    width: 85%;
    padding: 8px 16px;
    font-size: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 8px;
    margin-bottom: 2px;
    margin-left: 0px;
    resize: vertical;
  }

  .btn-enviar-amigo{
    background-color: #4CAF50;
    color: white;
    padding: 10px 0;
    width: 375px;
    font-size: 17px;
    border: none;
    border-radius: 4px;
    margin-left: 0px;
    margin-top: 8px;
    cursor: pointer;
  }

  .warning {
    background-color: #ff9800;
    font-size: 18px;
    padding: 8px;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }

  .success {
    padding: 4px;
    background-color: #4CAF50;
    color: white;
    width: 100%;
    margin-bottom: 0;
  }
</style>
<body>
<div id="enviar_amigo">
<div class="aviso">Informe os dados do seu amigo, para que possamos enviar o email</div>
<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'enviar'){
    $id_produto = (int)$_GET['produto_id'];
    $nome_amigo = strip_tags(filter_input(INPUT_POST, 'nome'));
    $email_amigo = strip_tags(filter_input(INPUT_POST, 'email'));

    $val->set($nome_amigo, 'Nome do Amigo')->obrigatorio();
    $val->set($email_amigo, 'Email do Amigo')->isEmail();

    if(!$val->validar()){
      $erro = $val->getErro();
      echo '<div class="warning">Preencha os dados corretamente</div>';
    }
    else{
      $pegar_dados_produto = BD::conn()->prepare("SELECT * FROM `loja_produtos` WHERE id = ?");
      $pegar_dados_produto->execute(array($id_produto));
      $dados_produto = $pegar_dados_produto->fetchObject();

      $imagens_produto = BD::conn()->prepare("SELECT * FROM `loja_imgProd` WHERE id_produto = ?");
      $imagens_produto->execute(array($id_produto));

      if($imagens_produto->rowCount() > 0){
        $mensagem = '<p>Olá Senhor(a), '.$nome_amigo.', venha conferir em nossa loja este excelente produto!</p>
                     <h1>'.$dados_produto->titulo.'</h1><img src="'.PATH.'/produtos/'.$dados_produto->img_padrao.'">
                     <p>Por Apenas: '.number_format((float)$dados_produto->valor_atual,2,',','.').'
                        <a href="'.PATH.'/produto/'.$dados_produto->slug.'">Confira</a></p>';
        $mensagem .= '<ul>';
        while($imagem = $imagens_produto->fetchObject()){
          $mensagem .= '<li><img src="'.PATH.'/produtos/'.$imagem->img.'" width="150"></li>';
        }
          $mensagem .= '</ul>';
          if($site->sendMail('Venha conferir nossa loja', $mensagem, 'lucassantanaf@gmail.com', 'Episeg', $email_amigo, $nome_amigo)){
            echo '<div class="success">O Email foi enviado com sucesso</div>';
          }
      }
      else{
        $mensagem = '<p>Olá Senhor(a), '.$nome_amigo.', venha conferir em nossa loja este excelente produto!</p>
                     <h1>'.$dados_produto->titulo.'</h1><img src="'.PATH.'/produtos/'.$dados_produto->img_padrao.'">
                     <p>Por Apenas: '.number_format((float)$dados_produto->valor_atual,2,',','.').'</p>';
        if($site->sendMail('Venha conferir nossa loja', $mensagem, 'lucassantanaf@gmail.com', 'Episeg', $email_amigo, $nome_amigo)){
          echo '<div class="success">O Email foi enviado com sucesso</div>';
        }
      }
    }
  }
?>
<form action="" method="post" enctype="multipart/form-data">
  <label>
    <span>Nome do Amigo:</span>
    <input type="text" name="nome">
  </label><br>

  <label>
    <span>Email do Amigo:</span>
    <input type="text" name="email">
  </label><br>

  <input type="hidden" name="acao" value="enviar">
  <input type="submit" value="Enviar Email" class="btn-enviar-amigo">
</form>
</div>
