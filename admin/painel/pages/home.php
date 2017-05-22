<?php if(!isset($_GET['pagina'])){ ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
        <?php
          $sqlVendas = BD::conn()->prepare("SELECT *, SUM(valor_total) AS total_venda FROM `loja_pedidos`
            WHERE TO_DAYS(NOW()) - TO_DAYS(criado) <= 120 GROUP BY MONTH(criado)");
          $sqlVendas->execute();
          while($fetchVendas = $sqlVendas->fetchObject()){
        ?>
          ['<?php echo date('m/Y', strtotime($fetchVendas->criado)); ?>', <?php echo $fetchVendas->total_venda; ?>],
        <?php } ?>
        ]);

        var options = {
          title: 'Ganho Trimestral de vendas em R$',
        };

        var chart = new google.visualization.PieChart(document.getElementById('grafico'));

        chart.draw(data, options);
      }
    </script>
  <?php } ?>
<head>
<style>
  #inc_conteudo{
    width: 100%;
  }

  th, td{
    color:#fff;
  }

  #outras-est{
    float:right;
    margin-right: 220px;
    width:250px;
  }

  #outras-estat{
    float:left;
    width:230px;
    margin-left:100px;
  }

  #outras-est h1{
    font-size:20px;
    color:#fff;
    width: 240px;
    margin-right:10px;
  }

  #outras-estat h1{
    font-size:20px;
    color:#fff;
    width: 240px;
  }

  #last-vendas{
    margin-left:230px;
  }

  #last-vendas h1{
    font-size:20px;
    color:#fff;
    margin-left:10px;
    width:640px;
  }

  #last-tickets{
    float:left;
    width:400px;
    margin-left:230px;
    display:inline-block;
  }

  #last-tickets h1{
    font-size:20px;
    color:#fff;
    margin-left:10px;
    width: 400px;
  }

  .list-tickets{
    border-color:#fff;
    margin-left:10px;
    text-align: center;
    width:390px;
  }

  .list-est{
    border-color:#fff;
    text-align: center;
    width:240px;
  }

  .list-vendas{
    border-color:#fff;
    margin-left:10px;
    text-align:center;
    width:640px;
  }

  #grafico{
    width:75%;
    margin-left:170px;
    margin-right:170px;
  }
</style>
</head>
<body>
  <div id="grafico"></div>

  <div id="last-vendas">
    <h1>Últimas Vendas</h1>
    <table class="list-vendas" border="2">
      <thead>
        <tr>
          <th valign="middle">#id</th>
          <th valign="middle">Tipo de Envio</th>
          <th valign="middle">Valor Total</th>
          <th valign="middle">Data de criação</th>
          <th valign="middle">Detalhes</th>
          <th valign="middle">Status</th>
        </tr>
      </thead>

      <tbody>
  <?php
    $dados = array('id', 'valor_total', 'status', 'criado', 'tipo_frete');
    $site->selecionar('loja_pedidos', $dados, false, 'id DESC LIMIT 7');

    foreach($site->listar() as $campos){

      if($campos['status'] == 0){
        $status = 'Pendente';
      }
      elseif($campos['status'] == '1'){
        $status = 'Aguardando Envio';
      }
      elseif($campos['status'] == '2'){
        $status = 'Produto Enviado';
      }
  ?>
       <tr>
         <td valign="middle">#<?php echo $campos['id']; ?></td>
         <td valign="middle"><?php echo $campos['tipo_frete']; ?></td>
         <td valign="middle">R$ <?php echo number_format($campos['valor_total'],2,',','.'); ?></td>
         <td valign="middle"><?php echo date('d/m/Y', strtotime($campos['criado'])); ?></td>
         <td valign="middle">
           <a href="?pagina=detalhes_compra&compra_id=<?php echo $campos['id']; ?>">
             <img src="images/detalhes.png"></td>
         <td valign="middle"><?php echo $status; ?></td>
       </tr>
  <?php } ?>
      </tbody>
    </table>
  </div>
    <?php
      if($usuarioLogado->tipo == '1'){
        echo '<div id="outras-est">';
      }
      else{
        echo '<div id="outras-estat">';
      }
    ?>
    <?php
      $selConfigs = BD::conn()->prepare("SELECT * FROM `loja_configs`");
      $selConfigs->execute();
      $fetchConf = $selConfigs->fetchObject();
      $manutencao = ($fetchConf->manutencao == 0) ? 'Não' : 'Sim';
      //clientes
      $clientesCad = BD::conn()->prepare("SELECT id_cliente FROM `loja_clientes`");
      $clientesCad->execute();
      //catSubcat
      $cats = BD::conn()->prepare("SELECT id FROM `loja_categorias`");
      $cats->execute();

      $subcats = BD::conn()->prepare("SELECT id FROM `loja_subcategorias`");
      $subcats->execute();
    ?>
      <?php if($usuarioLogado->tipo == '1'){
        echo '<h1 id="outras-est">Outras Estatísticas</h1>';
      }
      else{
        echo '<h1 id="outras-estat">Outras Estatísticas</h1>';
      }
      ?>
      <table class="list-est" border="2">
        <tbody>
          <tr>
            <td width="160px">Visitas</td>
            <td width="80px" align="center" valign="middle">
              <?php echo $fetchConf->visitas; ?>
            </td>
          </tr>

          <tr>
            <td width="160px">Manutenção</td>
            <td width="80px" valign="middle">
              <?php echo $manutencao; ?>
            </td>
          </tr>

          <tr>
            <td width="160px">Clientes Cadastrados</td>
            <td width="80px" valign="middle">
              <?php echo $clientesCad->rowCount(); ?>
            </td>
          </tr>

          <tr>
            <td width="160px">Categorias</td>
            <td width="80px" valign="middle">
              <?php echo $cats->rowCount(); ?>
            </td>
          </tr>

          <tr>
            <td>Subcategorias</td>
            <td valign="middle">
              <?php echo $subcats->rowCount(); ?>
            </td>
          </tr>
        </tbody>
      </table>
    <?php if($usuarioLogado->tipo == '1'){ ?>
    </div>
  <div id="last-tickets">
    <h1>Últimos tickets abertos</h1>
    <table class="list-tickets" border="2">
      <thead>
        <tr>
          <td valign="middle">Por</td>
          <td valign="middle">Descrição</td>
          <td valign="middle">Data</td>
          <td valign="middle">Ver</td>
        </tr>
      </thead>

      <tbody>
      <?php
				$pegar_tickets = BD::conn()->prepare("SELECT * FROM `loja_tickets` ORDER BY id DESC LIMIT 10");
				$pegar_tickets->execute();
				if($pegar_tickets->rowCount() == 0){
					echo '<tr><td colspan="4">Não foram encontrados tickets</td></tr>';
				}
        else{
				  while($ticket = $pegar_tickets->fetchObject()){
    				$pegar_user = BD::conn()->prepare("SELECT `nome` FROM `loja_clientes` WHERE id_cliente = ?");
    				$pegar_user->execute(array($ticket->id_cliente));
    				$fetchCli = $pegar_user->fetchObject();
  		?>
      	<tr>
        	<td valign="middle"><?php echo $fetchCli->nome;?></td>
          <td valign="middle"><?php echo substr($ticket->pergunta, 0, 15).'...';?></td>
          <td valign="middle"><?php echo date('d/m/Y', strtotime($ticket->data));?></td>
          <td valign="middle">
            <a href="?pagina=ver_ticket&ticket_id=<?php echo $ticket->id;?>" title="Ver">
              <img src="images/editar.png" border="0"/></a></td>
        </tr>
  		<?php }}?>
      </tbody>
    </table>
  </div>
  <?php } ?>
</div>
</body>
