<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		require_once "../classe/Site.class.php";
		$site = new Site();

		//recebe o post com o tipo de notificação
		$tipoNotificacao = $_POST['notificationType'];
		//recebe o código de notificação
		$codigoNotificacao = $_POST['notificacaoCode'];

		if($tipoNotificacao == 'transaction'){
			//requer a classe da biblioteca
			require_once "../classes/pagseguro/PagSeguroLibrary.php";

			//insere as credenciais
			$credencial = new PagSeguroAccountCredentials('fimoculosgordox@gmail.com','FE7800015E444134BE0141342B86A5CD');
			//o objeto trasaction	com todas as informações
			$transacao = PagSeguroNotificationService::checkTransaction($credencial, $codigoNotificacao);
			//status da transação
			$status = $transacao->getStatus();

			if($status->getValue() == 3){
				//o status é pago e posso continuar com o código
				$idPedido = $transacao->getReference();

				//incluo o arquivo de conexão
				include_once "../config.php";
				require_once "../classes/BD.class.php";
				BD::conn();

				$sql = "UPDATE `loja_pedidos` SET status = '1', modificado = NOW() WHERE id = ?";
				$executarSql = BD::conn()->prepare($sql);
				$executarSql->execute(array($idPedido));

				$pegar_id_cliente = BD::conn()->prepare("SELECT id_cliente FROM `loja_pedidos` WHERE id = ?");
				$pegar_id_cliente->execute(array($idPedido));
				$fetchCliente = $pegar_id_cliente->fetchObject();

				$pegar_dados_cliente = BD::conn()->prepare("SELECT nome, sobrenome, email FROM `loja_clientes` WHERE id = ?");
				$pegar_dados_cliente->execute(array($fetchCliente->id));
				$dadosCliente = $pegar_dados_cliente->FetchObject();

				//manda email para o cliente
				$msg = '<p>Olá senhor(a): '.$dadosCliente->nome.' '.$dadosCliente->sobrenome.' recebemos a confirmação de
				 pagamento da sua compra em nossa loja referente a compra do id: <strong>'.$idPedido.'</strong></p>
								<p>Em breve seu produto será enviado para o endereço informado no seu cadastro, desde já
									agradecemos dua compra</p>
								<p>Para melhor acompanhamento do seu pedido acesse o seu painel administrativo</p>';
				$destino = $dadosCliente->email;
				$site->sendMail('Informações de seu produto', $msg, 'lucassantanaf@gmail.com', 'Episeg', $destino, $dadosCliente->nome);

				//manda o email para o admin
				$mensagemAdmin = '<p>Uma nova compra foi aprovada para o envio na sua loja virtual, para encontrar este pedido
					em seu painel pesquise pelo seguinte id: '.$idPedido.'</p>';
				$site->sendMail('Compra aprovada para o envio' $mensagemAdmin, 'lucassantanaf@gmail.com',
					'Sistema Episeg', 'lucassantanaf@gmail.com', 'Administração da Episeg');
			}
		}//se for transação
	}//se receber o request post
?>
