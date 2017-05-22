<head>
<style>
	body{
		background-color: orange;
	}

	.cliente-ticket-fe{
		background-color: #f1f1f1;
		margin-left: 246px;
		width: 600px;
		height: auto;
	}

	#title-ticket-fe{
		background-color: #4c4cff;
		padding: 17px 15px;
		height: 60px;
		color: #fff;
		margin: 0;
	}

	#title-ticket-fe span{
		font-family: Verdana, sans-serif;
		font-weight: bold;
		font-size: 21px;
		margin-left: 10px;
	}

	.tb-ticket-fechado{
		margin-left: 35.5px;
		margin-right: 35.5px;
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

	#codigo-ticket-fe{
		text-align: center;
		width: 80px;
	}

	#th-ticket-fe{
		text-align: center;
		width: 150px;
	}
</style>
</head>
<body>
<div class="cliente-ticket-fe">
<h1 id="title-ticket-fe"><span>Tickets Fechados</span></h1>
	<table border="1" class="tb-ticket-fechado">
		<thead>
			<tr>
				<th id="codigo-ticket-fe">Código</th>
				<th id="th-ticket-fe">Status</th>
				<th id="th-ticket-fe">Data de Criação</th>
				<th id="th-ticket-fe">Modificado</th>
			</tr>
		</thead>
		<tbody>
    <?php
      $pegar_tickets = BD::conn()->prepare("SELECT * FROM `loja_tickets` WHERE id_cliente = ? AND status = ?");
      $pegar_tickets->execute(array($usuarioLogado->id_cliente, 2));

      if($pegar_tickets->rowCount() == 0){
        echo '<tr><td colspan="4">Não foram encontrados tickets fechados!</td></tr>';
      }
      else{
        while($ticket = $pegar_tickets->fetchObject()){
    ?>
      <tr>
				<td><a href="?pagina=view_ticket&ticket_id=<?php echo $ticket->id; ?>">#<?php echo $ticket->id; ?></a></td>
				<td>Aberto(pendente)</td>
				<td><?php echo date('d/m/Y', strtotime($ticket->data)); ?></td>
				<td><?php echo date('d/m/Y', strtotime($ticket->modificado)); ?></td>
			</tr>
    <?php } } ?>
		</tbody>
	</table>
</div>
</body>
