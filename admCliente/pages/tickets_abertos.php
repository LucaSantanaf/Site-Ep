<head>
<style>
	body{
		background-color: orange;
	}

	.cliente-ticket-ab{
		background-color: #f1f1f1;
		margin-left: 150px;
		width: 750px;
		height: auto;
	}

	#title-ticket-ab{
		background-color: #4c4cff;
		padding: 17px 15px;
		height: 60px;
		color: #fff;
		margin: 0;
	}

	#title-ticket-ab span{
		font-family: Verdana, sans-serif;
		font-weight: bold;
		font-size: 21px;
		margin-left: 10px;
	}

	.tb-ticket-aberto{
		margin-left: 14.5px;
		margin-right: 14.5px;
		margin-top: 5px;
	}

	thead{
		background-color: #ddd;
	}

	tbody{
		background-color: #fff;
	}

	tr{
		height: 35px;
	}

	td{
		text-align: center;
	}

	td a{
		color: #333;
	}

	td a:hover{
		text-decoration: none;
		color: #777;
	}

	#codigo-ticket-ab{
		text-align: center;
		width: 80px;
	}

	#perg-ticket-ab, #stat-ticket-ab, #data-ticket-ab, #modif-ticket-ab{
		text-align: center;
		width: 160px;
	}
</style>
</head>
<body>
<div class="cliente-ticket-ab">
<h1 id="title-ticket-ab"><span>Tickets Abertos</span></h1>
	<table border="1" class="tb-ticket-aberto">
		<thead>
			<tr>
				<th id="codigo-ticket-ab">Código</th>
				<th id="perg-ticket-ab">Pergunta</th>
				<th id="stat-ticket-ab">Status</th>
				<th id="data-ticket-ab">Data de Criação</th>
				<th id="modif-ticket-ab">Modificado</th>
			</tr>
		</thead>
		<tbody>
    <?php
      $pegar_tickets = BD::conn()->prepare("SELECT * FROM `loja_tickets` WHERE id_cliente = ? AND status = ? OR status = ?");
      $pegar_tickets->execute(array($usuarioLogado->id_cliente, 0, 1));

      if($pegar_tickets->rowCount() == 0){
        echo '<tr><td colspan="4">Não foram encontrados tickets abertos!</td></tr>';
      }
      else{
        while($ticket = $pegar_tickets->fetchObject()){
    ?>
      <tr>
				<td><a href="?pagina=view_ticket&ticket_id=<?php echo $ticket->id; ?>">#<?php echo $ticket->id; ?></a></td>
				<td><?php echo substr($ticket->pergunta,0,15).'...'; ?></td>
				<td>Aberto(pendente)</td>
				<td><?php echo date('d/m/Y', strtotime($ticket->data)); ?></td>
				<td><?php echo date('d/m/Y', strtotime($ticket->modificado)); ?></td>
			</tr>
    <?php } } ?>
		</tbody>
	</table>
</div>
</body>
