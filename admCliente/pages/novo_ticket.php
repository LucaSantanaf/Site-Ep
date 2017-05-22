<head>
<style>
  body{
    background-color: orange;
  }

  #title-novo-ticket{
    background-color: #4c4cff;
    margin-top: 0;
    margin-bottom: 5px;
    padding: 17px 15px;
    height: 60px;
    color: #fff;
  }

  #title-novo-ticket span{
    font-family: Verdana, sans-serif;
    font-weight: bold;
    font-size: 21px;
    margin-left: 10px;
  }

  #formularios{
    background-color: #f1f1f1;
    width: 620px;
    margin-left: 243.5px;
    margin-right: 243.5px;
  }

  form{
    margin: 10px;
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
    margin-bottom: 10px;
  }

  .alert {
    padding: 10px;
    background-color: #f44336;
    color: white;
    width: 100%;
  }

  .success {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    width: 100%;
  }

  .info {
    padding: 10px;
    background-color: #2196F3;
    color: white;
    width: 100%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width: 100%;
  }

  .closebtn {
    margin-left: 15px;
    margin-top: 2px;
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
<div id="formularios">
  <h1 id="title-novo-ticket"><span>Criar novo ticket</span></h1>
  <div class="warning">Certifique-se de que sua pergunta é objetiva, deixe o mais claro possível o seu problema!
    <span class="closebtn">&times;</span></div>
  <?php
    if(isset($_POST['acao']) && $_POST['acao'] == 'criar'):
      $pergunta = strip_tags(filter_input(INPUT_POST, 'pergunta', FILTER_SANITIZE_STRING));

      if($pergunta == ''){
        echo '<div class="erro">Você não informou a sua pergunta!</div>';
      }
      else{
        $data = date('Y-m-d H:i:s');
        $dados_inserir = array('id_cliente' => $usuarioLogado->id_cliente, 'pergunta' => $pergunta,
                               'status' => '0', 'data' => $data, 'modificado' => $data);
        $msg = '<p>Um novo ticket foi aberto no sistema de sua loja virtual, o senhor(a):
               '.$usuarioLogado->nome.' '.$usuarioLogado->sobrenome.', abriu um ticket como o seguinte titulo:</p>
               <p>'.$pergunta.'<br> Para respondê-lo, visite o painel administrativo</p>';

        if($site->inserir('loja_tickets', $dados_inserir)){
          $site->sendMail('Novo ticket Aberto', $msg, 'lucassantanaf@gmail.com', 'Episeg', 'lucassantanaf@gmail.com', 'Administração Episeg');
          echo '<div class="erro verde">Seu ticket foi aberto com sucesso, aguerde o nosso contato!</div>';
        }
      }
    endif;
  ?>
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span>Informe sua pergunta:</span>
      <input type="text" name="pergunta">
    </label>
    <input type="hidden" name="acao" value="criar">
    <input type="submit" value="Criar Ticket">
  </form>
<script>
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
</div>
</body>
