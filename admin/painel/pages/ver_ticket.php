<?php
  $pegar_id = (int)$_GET['ticket_id'];
  $pegar_dados = BD::conn()->prepare("SELECT * FROM `loja_tickets` WHERE id = ?");
  $pegar_dados->execute(array($pegar_id));
  $fetch_dados = $pegar_dados->fetchObject();

  $cliente = BD::conn()->prepare("SELECT `nome`, `sobrenome` FROM `loja_clientes` WHERE id_cliente = ?");
  $cliente->execute(array($fetch_dados->id_cliente));
  $cliente_dados = $cliente->fetchObject();

  if($fetch_dados->status == '0'){
    $stats = 'Em aberto(pendente)';
  }
  elseif($fetch_dados->status == '1'){
    $stats = 'Em Andamento';
  }
  else{
    $stats = 'Fechado';
  }
?>
<head>
<style>
  .list{
    border-color: #fff;
    margin-left:10px;
  }

  ul{
    list-style-type:none;
  }

  td{
    color:#fff;
  }

  form{
    margin-left:10px;
  }

  input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #deletar{
    background-color: #ff0000;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-top: 15px;
    margin-bottom: 15px;
    margin-right: 10px;
    float: right;
  }

  #fechar{
    background-color: #1919ff;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    margin-left: 10px;
  }

  #ul-ver-ticket{
    padding: 0 10px;
  }

  .adm {
    border: 2px solid #ccc;
    background-color: #eee;
    border-radius: 5px;
    padding: 16px;
    margin: 16px 0;
  }

  .adm::after {
    content: "";
    clear: both;
    display: table;
  }

  .adm img {
    float: left;
    margin-right: 20px;
    border-radius: 50%;
  }

  .adm span {
    font-size: 20px;
    margin-right: 15px;
  }

  @media (max-width: 500px) {
    .adm {
      text-align: center;
    }
    .adm img {
      margin: auto;
      float: none;
      display: block;
    }
  }
</style>
</head>
<body>
<h1 class="title">Dados deste Ticket</h1>
<table border="1" class="list">
  <tr>
    <td>id do ticket:</td>
    <td>#<?php echo $fetch_dados->id; ?></td>
  </tr>

  <tr>
    <td>Criado por:</td>
    <td><?php echo $cliente_dados->nome.' '.$cliente_dados->sobrenome; ?></td>
  </tr>

  <tr>
    <td>Status:</td>
    <td><?php echo $stats; ?></td>

  </tr>

  <tr>
    <td>Data de criação:</td>
    <td><?php echo date('d/m/Y', strtotime($fetch_dados->data)); ?></td>
  </tr>
</table>

<h1 class="title">Mensagens para este ticket</h1>
<ul id="ul-ver-ticket">
<?php
  $pegar_mensagens = BD::conn()->prepare("SELECT * FROM `loja_ticketresposta` WHERE idTicket = ?");
  $pegar_mensagens->execute(array($pegar_id));
  if($pegar_mensagens->rowCount() == 0){
    echo '<p>Não existem respostas para este ticket ainda!</p>';
  }
  else{
    while($mensagem = $pegar_mensagens->fetchObject()){
      if($mensagem->de == 'adm'){
        echo '<li class="adm">
                <img src="../../images/adm.png" alt="avatar" width="90px">
                <span>Administração disse em '.date('d/m/Y', strtotime($mensagem->data)).':</span>
                <p>'.$mensagem->resposta.'</p>
              </li>';
      }
      else{
        echo '<li class="adm">
                <img src="../../images/cliente.png" alt="avatar" width="90px">
                <span>'.$mensagem->de.' disse em '.date('d/m/Y', strtotime($mensagem->data)).':</span>
                <p>'.$mensagem->resposta.'</p>
              </li>';
      }
    }
  }
?>
</ul>

<div id="formularios">
<?php
  if(isset($_POST['acao']) && $_POST['acao'] == 'resp'):
    $resposta = strip_tags(filter_input(INPUT_POST, 'resposta'));
    if($resposta == ''){
      echo '<script>alert("Por favor, escreva uma resposta!");location.href="?pagina=ver_ticket&ticket_id='.$pegar_id.'"</script>';
    }
    else{
      $atualizar_ticket = BD::conn()->prepare("UPDATE `loja_tickets` SET status = '1', modificado = NOW() WHERE id = ?");
      $atualizar_ticket->execute(array($pegar_id));

      $inserir_resposta = BD::conn()->prepare("INSERT INTO `loja_ticketresposta` (de, idTicket, data, resposta) VALUES('adm',?,NOW(),?)");
      $array = array($pegar_id, $resposta);
      if($inserir_resposta->execute($array)){
        echo '<script>alert("Sua resposta foi enviada com sucesso!");location.href="?pagina=ver_ticket&ticket_id='.$pegar_id.'"</script>';
      }
    }
  endif;
?>
  <form action="" method="post" enctype="multipart/form-data">
    <label>
      <span class="title">Responda esse ticket:</span>
      <textarea name="resposta" class="tinymce" cols="30" rows="5"></textarea>
    </label><br>

    <input type="hidden" name="acao" value="resp">
    <a href="#" id="deletar" onClick="javascript:confirmTicket(<?php echo $pegar_id; ?>);">Deletar Ticket</a>
    <input type="submit" value="Responder Ticket">
  </form>
</div>
<?php if($fetch_dados->status != '2'): ?>
  <a href="?pagina=ver_ticket&ticket_id=<?php echo $pegar_id; ?>&fechar=sim" id="fechar">Fechar Ticket</a>
<?php endif; ?>

<?php
  if(isset($_GET['fechar']) && $_GET['fechar'] == 'sim'):
    $set_ticket = BD::conn()->prepare("UPDATE `loja_tickets` SET status = '2', modificado = NOW() WHERE id = ?");
    if($set_ticket->execute(array($pegar_id))){
      echo '<script>alert("O ticket foi fechado com sucesso!");location.href="?pagina=ver_ticket&ticket_id='.$pegar_id.'"</script>';
    }
  endif;

  if(isset($_GET['deletar']) && $_GET['deletar'] == 'sim'):
		if($pegar_mensagens->rowCount() == 0){
			$deletar_ticket = BD::conn()->prepare("DELETE FROM `loja_tickets` WHERE id = ?");
			if($deletar_ticket->execute(array($pegar_id))){
				echo '<script>alert("O ticket foi deletado com sucesso!");location.href="Index.php"</script>';
			}
		}
    else{
			$deletar_resposta = BD::conn()->prepare("DELETE FROM `loja_ticketresposta` WHERE idTicket = ?");
			if($deletar_resposta->execute(array($pegar_id))){
				$deletar_ticket = BD::conn()->prepare("DELETE FROM `loja_tickets` WHERE id = ?");
				if($deletar_ticket->execute(array($pegar_id))){
					echo '<script>alert("O ticket foi deletado com sucesso!");location.href="Index.php"</script>';
				}
			}
		}
	endif;
?>
</body>
