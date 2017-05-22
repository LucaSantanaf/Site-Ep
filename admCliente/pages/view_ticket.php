<?php
  $id_ticket = (int)$_GET['ticket_id'];
  $dados_ticket = BD::conn()->prepare("SELECT * FROM `loja_tickets` WHERE id = ?");
  $dados_ticket->execute(array($id_ticket));
  $fetch = $dados_ticket->fetchObject();

  if($fetch->status == 0){
    $status = 'Em Aberto(Pendente)';
  }
  elseif($fetch->status == 1){
    $status = 'Em Andamento';
  }
  else{
    $status = 'Ticket Fechado';
  }
?>
<head>
<style>
  body{
    background-color: orange;
  }

  table{
    font-size: 17px;
    margin-left: 10px;
    margin-top: 10px;
    margin-bottom: 30px;
  }

  #td-left-view-ticket{
    background-color: #ddd;
  }

  #td-right-view-ticket{
    background-color: #fff;
  }

  .home-view-ticket{
    background-color: #f1f1f1;
    margin-left: 188.5px;
    margin-right: 188.5px;
    width: 730px;
    height: auto;
  }

  .msg, form{
    margin-left: 10px;
  }

  .title-view-ticket{
    background-color: #4c4cff;
    padding: 17px 15px;
    height: 60px;
    color: #fff;
    margin: 0;
  }

  .title-view-ticket span{
    font-family: Verdana, sans-serif;
    font-weight: bold;
    font-size: 21px;
    margin-left: 10px;
  }

  .mensagem-ticket{
    width:730px;
    height:auto;
    margin-top:-20px;
    margin-bottom:20px;
  }

  #formularios{
    width:730px;
    margin-top:0px;
    margin-bottom:20px;
  }

  input[type=text], [type=password] {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-top: 2px;
      margin-bottom: 2px;
      margin-left: 10px;
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
    width:50%;
  }

  .success {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    width:50%;
  }

  .info {
    padding: 10px;
    background-color: #2196F3;
    color: white;
    width:50%;
  }

  .warning {
    padding: 10px;
    background-color: #ff9800;
    color: white;
    width:50%;
  }

  .bottom{
    clear:both;
    width: 100%;
    margin-top: 90px;
  }

  .msg {
    border: 2px solid #ccc;
    background-color: #eee;
    border-radius: 5px;
    padding: 16px;
    margin: 16px 0;
  }

  .msg::after {
    content: "";
    clear: both;
    display: table;
  }

  .msg img {
    float: left;
    margin-right: 20px;
    border-radius: 50%;
  }

  .msg span {
    font-size: 20px;
    margin-right: 15px;
  }

  @media (max-width: 500px) {
    .msg {
      text-align: center;
    }
    .msg img {
      margin: auto;
      float: none;
      display: block;
    }
  }
</style>
</head>
<body>
<div class="home-view-ticket">
<h1 class="title-view-ticket"><span>Visualizar Ticket</span></h1>
<table border='1'>
  <tr>
    <td id="td-left-view-ticket">Titulo do Ticket:</td>
    <td id="td-right-view-ticket"><?php echo $fetch->pergunta; ?></td>
  </tr>

  <tr>
    <td id="td-left-view-ticket">Status do ticket:</td>
    <td id="td-right-view-ticket"><?php echo $status; ?></td>
  </tr>

  <tr>
    <td id="td-left-view-ticket">Data de criação:</td>
    <td id="td-right-view-ticket"><?php echo date('d/m/Y H:i', strtotime($fetch->data)); ?></td>
  </tr>

  <tr>
    <td id="td-left-view-ticket">Última Atualização:</td>
    <td id="td-right-view-ticket"><?php echo date('d/m/Y H:i', strtotime($fetch->modificado)); ?></td>
  </tr>
</table>

  <div class="mensagem-ticket">
  <h1 class="title-view-ticket"><span>Mensagens desse Ticket</span></h1>
  <?php
  	$selecionar_respostas = BD::conn()->prepare("SELECT * FROM `loja_ticketresposta` WHERE idTicket = ? ORDER BY id DESC");
  	$selecionar_respostas->execute(array($id_ticket));
  	if($selecionar_respostas->rowCount() == 0){
  		echo '<p align="center">Não há respostas para este ticket no momento</p>';
  	}
    else{
  	 while($resposta = $selecionar_respostas->fetchObject()){
  		($resposta->de == 'adm') ? $de = 'Administração' : $de = $resposta->de;

  		if($resposta->de == 'adm'){
  			$class = $resposta->de;
  		}
      else{
  			$class = '';
  		}
  ?>
    <div class="msg <?php echo $class; ?>">
      <?php
        if($usuarioLogado->imagem == ''){
          echo '<img src="../clientes/default.jpg" alt="avatar" width="90px">';
        }
        else{
          echo '<img src="../clientes/'.$usuarioLogado->imagem.'" alt="avatar" width="90px">';
        }
      ?>
      <span><?php echo $de; ?> - <?php echo date('d/m/Y H:i', strtotime($resposta->data)); ?></span>
      <p><?php echo $resposta->resposta; ?></p>
    </div>
  <?php } } ?>

  <?php if($fetch->status == 1){
    if(isset($_POST['acao']) && $_POST['acao'] == 'responder'){
  	$resposta = strip_tags(filter_input(INPUT_POST, 'resposta', FILTER_SANITIZE_STRING));

  	if($resposta == ''){
  		echo '<script>alert("Informe a sua resposta")</script>';
  	}
    else{
  		$responder = BD::conn()->prepare("INSERT INTO `loja_ticketresposta` (de, idTicket, data, resposta) VALUES(?,?,?,?)");
  		$from = $usuarioLogado->nome.' '.$usuarioLogado->sobrenome;
  		$data = date('Y-m-d H:i:s');
  		$dados = array($from, $id_ticket, $data, $resposta);

  		if($responder->execute($dados)){
  			$msg = 'O senhor(a): '.$from.', enviou uma nova resposta para o ticket: '.$fetch->pergunta.' na data: '.$data.'<br>
                Para responde-lo acesse o painel administrativo de sua loja!';
  			$site->sendMail('Nova resposta em ticket', $msg, 'lucassantanaf@gmail.com', 'Episeg', 'lucassantanaf@gmail.com', 'Administração Episeg');
  			echo '<script>alert("Resposta foi enviada com sucesso!");location.href="?pagina=view_ticket&ticket_id='.$id_ticket.'"</script>';
  		}
  	}
  }
  ?>
    <div id="formularios">
      <form action="" method="post" enctype="multipart/form-data">
        <label>
          <span>Digite sua resposta</span><br>
          <textarea name="resposta" cols="30" rows="5"></textarea>
        </label><br>

        <input type="hidden" name="acao" value="responder">
        <input type="submit" value="Responder Ticket">
      </form>
    </div>
  <?php } ?>
  </div>
</div>
<div class="bottom"></div>
</body>
