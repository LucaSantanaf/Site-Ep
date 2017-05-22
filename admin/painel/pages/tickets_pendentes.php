<head>
<style>
  th, td{
    color:#fff;
    text-align:center;
  }

  .list{
    border-color:#fff;
    margin-left:10px;
    width:640px;
  }
</style>
</head>
<body>
<h1 class="title">Tickets Pendentes</h1>
<table class="list" border="2">
  <thead>
    <tr>
      <td valign="middle">#id</td>
      <td valign="middle">Criado por:</td>
      <td valign="middle">Pergunta</td>
      <td valign="middle">Detalhes</td>
    </tr>
  </thead>
  <tbody>
  <?php
    $pegar_pendentes = BD::conn()->prepare("SELECT * FROM `loja_tickets` WHERE status = ? OR status = ?");
    $pegar_pendentes->execute(array(0,1));
    if($pegar_pendentes->rowCount() == 0){
      echo '<tr><td colspan="4">Não foram encontrados tickets em andamento ou pendentes!</td></tr>';
    }
    else{
      while($ticket = $pegar_pendentes->fetchObject()){
        $dados_cliente = BD::conn()->prepare("SELECT `nome` FROM `loja_clientes` WHERE id_cliente = ?");
        $dados_cliente->execute(array($ticket->id_cliente));
        $nomeCli = $dados_cliente->fetchObject();
  ?>
    <tr>
      <td valign="middle">
        <?php echo $ticket->id; ?></td>
      <td valign="middle">
        <?php echo $nomeCli->nome; ?></td>
      <td valign="middle">
        <?php echo substr($ticket->pergunta,0,15).'...'; ?></td>
      <td valign="middle">
        <a href="?pagina=ver_ticket&ticket_id=<?php echo $ticket->id; ?>">
          <img src="images/detalhes.png"></a></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>
</body>
