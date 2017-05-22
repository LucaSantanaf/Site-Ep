<head>
<style>
	body{
		background-color: orange;
	}

	thead{
		background-color: #ddd;
	}

	tbody{
		background-color: #fff;
	}

	.home-cliente{
		background-color: #f1f1f1;
		margin-left: 150px;
		width: 750px;
		height: auto;
	}

	.list-cliente{
		background-color: #d3d3d3;
		margin: 10px;
	}

	#compras-home{
		background-color: #4c4cff;
		padding: 17px 15px;
		height: 60px;
		color: #fff;
		margin: 0;
	}

	#compras-home span{
		font-family: Verdana, sans-serif;
		font-weight: bold;
		font-size: 21px;
		margin-left: 10px;
	}

	table{
		margin: 0;
	}

	tr{
		height: 35px;
	}

	#home-codigo{
		width: 100px;

	}

	#tb-home-cliente{
		width: 170px;
	}

	.codigo a{
		color: #333;
	}

	.codigo a:hover{
		text-decoration: none;
		color: #777;
	}

	.codigo, .status, .valor-total, .data-criacao, .modificado{
		text-align: center;
	}
</style>
</head>
<body>
<div class="home-cliente">
<h1 id="compras-home"><span>Minhas compras</span></h1>
	<table border="1" class="list-cliente">
		<thead>
			<tr>
				<th id="home-codigo" class="codigo">Código</th>
				<th id="tb-home-cliente" class="status">Status</th>
				<th id="tb-home-cliente" class="valor-total">Valor Total</th>
				<th id="tb-home-cliente" class="data-criacao">Data de Criação</th>
				<th id="tb-home-cliente" class="modificado">Modificado</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$selecionar_pedidos = BD::conn()->prepare("SELECT * FROM `loja_pedidos` WHERE id_cliente = ?");
			$selecionar_pedidos->execute(array($usuarioLogado->id_cliente));
			if($selecionar_pedidos->rowCount() == 0){
				echo '<tr><td colspan="5">Não existem pedidos recentes</td></tr>';
			}
			else{
				while($pedido = $selecionar_pedidos->fetchObject()){
				if($pedido->status == 0){
					$status = 'Pendente';
				}
				elseif($pedido->status == 1){
					$status = 'Aguardando Envio';
				}
				elseif($pedido->status == 2){
					$status = 'Pedido Enviado';
				}
		?>
		<tr>
			<td align="center" valign="middle" class="codigo"><a href="Index.php?pagina=detalhes_compra&id=<?php echo $pedido->id;?>">#<?php echo $pedido->id;?></a></td>
			<td align="center" valign="middle"><?php echo $status;?></td>
			<td align="center" valign="middle">R$ <?php echo number_format($pedido->valor_total, 2,',','.');?></td>
			<td align="center" valign="middle"><?php echo date('d/m/Y', strtotime($pedido->criado));?></td>
			<td align="center" valign="middle"><?php echo date('d/m/Y', strtotime($pedido->modificado));?></td>
		</tr>
		<?php } } ?>
		</tbody>
	</table>
</div>
</body>
