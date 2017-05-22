<?php
  class Site extends BD{

    private $conexao;

/* Função para exibir as horas em tempo real
    public function getData(){
      $data = getdate();
      $diaHoje = date('d');
      $array_meses = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio",
        6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro",
        12 => "Dezembro");
      $horaAgora = date('H:i');
      $mesgetdate = $data['mon'];
      $anoAtual = date('Y');

      return 'Hoje, '.$diaHoje.' de '.$array_meses[$mesgetdate].' de '.$anoAtual.', ás '.$horaAgora.'';
    } */

    public function produtosFaltando(){
      $verificar = self::conn()->prepare("SELECT id FROM `loja_produtos` WHERE estoque = '0'");
      $verificar->execute();
      $numero = $verificar->rowCount();

      if($numero == 0){
        echo '<span>0</span>';
      }else{
        echo '<span>'.$numero.'</span>';
      }
    }//Produtos em falta

    public function atualizarViews(){
		$selecionar = self::conn()->prepare("SELECT visitas FROM `loja_configs`");
		$selecionar->execute();
		$views = $selecionar->fetchObject();

  		if($views->visitas >= 999){
  			$atualizar = self::conn()->prepare("UPDATE `loja_configs` SET visitas = '0'");
  			$atualizar->execute();
  		}
      else{
  			$atualizar = self::conn()->prepare("UPDATE `loja_configs` SET visitas = visitas+1");
  			$atualizar->execute();
  		}
  	}

    public function getMenu(){
      $pegar_categorias = "SELECT * FROM `loja_categorias` ORDER BY id DESC";
      $executar = self::conn()->prepare($pegar_categorias);
      $executar->execute();

      if($executar->rowCount() == 0){}
        else{
          while($categoria = $executar->FetchObject()){
            echo '<li><p class="accordion"><a href="'.PATH.'categoria/'.$categoria->slug.'">'.$categoria->titulo.'</a></p>';
              $pegar_subcategorias = "SELECT * FROM `loja_subcategorias` WHERE id_cat = ?";
              $executar_sub = self::conn()->prepare($pegar_subcategorias);
              $executar_sub->execute(array($categoria->id));

          if($executar_sub->rowCount() == 0){
            echo '</li>';
          }
          else {
            echo '<ul>';
            while($subcategoria = $executar_sub->FetchObject()){
              echo '<li><p class="accordion"><a href="'.PATH.'categoria/'.$categoria->slug.'/'.$subcategoria->slug.'">'.$subcategoria->titulo.'</a></p></li>';
            }//Termina while da subcategoria
            echo '</ul></li>';
          }//Termina else dos resultados da subcategoria

        }//Termina while das CATEGORIAS
      }//Termina else
    }//Termina getMenu

  public function getBanners(){
    $sqlBanners = "SELECT * FROM `loja_banners` ORDER BY id DESC LIMIT 4";
    return self::conn()->query($sqlBanners);
  }//Pega os banners do slide principal

  public function getProdutosHome($limit = false){
    if($limit == false){
      $query = "SELECT * FROM `loja_produtos` ORDER BY id DESC";
    }
    else{
      $query = "SELECT * FROM `loja_produtos` ORDER BY id DESC LIMIT $limit";
    }
    return self::conn()->query($query);
  }//Pegar os produtos da Home

  public function atualizarViewCat($slug){
    $strSQL = "UPDATE `loja_categorias` SET views = views+1 WHERE slug = ? ";
    $executar_view = self::conn()->prepare($strSQL);
    $executar_view->execute(array($slug));
  }//Atualiza views da categoria

  public function atualizarViewSub($slug){
    $strSQL = "UPDATE `loja_subcategorias` SET views = views+1 WHERE slug = ? ";
    $executar_view = self::conn()->prepare($strSQL);
    $executar_view->execute(array($slug));
  }//Atualiza views da subcategoria

  public function inserir($tabela, $dados){
		$pegarCampos = array_keys($dados);
		$contarCampos = count($pegarCampos);
		$pegarValores = array_values($dados);
		$contarValores = count($pegarValores);

		$sql = "INSERT INTO $tabela (";
		if($contarCampos == $contarValores){
			foreach($pegarCampos as $campo){
				$sql .= $campo.', ';
			}
			$sql = substr_replace($sql, ")", -2, 1);
			$sql .= "VALUES (";

			for($i = 0; $i <$contarValores; $i++){
				$sql .= "?, ";
				$i;
			}

			$sql = substr_replace($sql, ")", -2, 1);
		}
    else{
			return false;
		}

		try{
			$inserir = self::conn()->prepare($sql);
			if($inserir->execute($pegarValores)){
				return true;
			}
      else{
				return false;
			}
		}
    catch(PDOException $e){
			return false;
		}
	}

  //seleção dinâmica
  public function selecionar($tabela, $dados, $condicao = false, $order = false){
    $pegarValores = implode(', ', $dados);
    $contarValores = count($pegarValores);

    if($condicao == false){
      if($contarValores > 0){
        if($order != false){
          $sql = "SELECT $pegarValores FROM $tabela ORDER BY $order";
        }
        else{
          $sql = "SELECT $pegarValores FROM $tabela";
        }
        $this->conexao = self::conn()->prepare($sql);
        $this->conexao->execute();
        return $this->conexao;
      }
    }
    else{
        //existe condição para selecionar
        $pegarCondCampos = array_keys($condicao);
        $contarCondCampos = count($pegarCondCampos);
        $pegarCondValores = array_values($condicao);

        $sql = "SELECT $pegarValores FROM $tabela WHERE";
        foreach($pegarCondCampos as $campoCondicao){
          $sql .= $campoCondicao." = ? AND ";
        }
        $sql = substr_replace($sql, "", -5, 5);

        foreach($pegarCondValores as $condValores){
          $dadosExec[] = $condValores;
        }
        if($order){$sql .= "ORDER BY $order";}
        $this->conexao = self::conn()->prepare($sql);
        $this->conexao->execute($dadosExec);
        return $this->conexao;
      }
    }

    public function listar(){
      $lista = $this->conexao->fetchAll();
      return $lista;
    }

    //metodo para um envio de emails junto ao phpmailer
    public function sendMail($subject , $msg, $from, $nomefrom, $destino, $nomedestino){
      require_once "mailer/class.phpmailer.php";
      $mail = new PHPMailer();//instancia a classe PHPMailer

      $mail->isSMTP();//habilita envio smtp
      $mail->SMTPAuth = true;//autentico o envio smtp
      $mail->Host = 'mail.episeg.com';
      $mail->Port = '25';

      //começar o envio do email
      $mail->Username = 'lucassantanaf@gmail.com';
      $mail->Password = '12345678';

      $mail->From = $from;//email de quem envia
      $mail->FromName = $nomefrom;//nome de quem envia

      $mail->isHTML(true);//seta que é html o email
      $mail->Subject = utf8_decode($subject);
      $mail->Body = utf8_decode($msg);//corpo da mensagem
      $mail->AddAdress($destino, utf8_decode($nomedestino));//seto o destino do email

      if($mail->Send()){
        return true;
      }
      else{
        return false;
      }
    }

    function upload($tmp, $name, $nome, $larguraP, $pasta){

    	$ext = end(explode('.', $name));
    	if($ext=='jpg' || $ext == 'JPG' || $ext == 'jpeg' || $ext == 'JPEG'){
    			$img = imagecreatefromjpeg($tmp);
    	}elseif($ext == 'png'){
    			$img = imagecreatefrompng($tmp);
    	}elseif($ext == 'gif'){
    			$img = imagecreatefromgif($tmp);
    	}
       	list($larg, $alt) = getimagesize($tmp);
    	$x = $larg;
    	$y = $alt;
    	$largura = ($x>$larguraP) ? $larguraP : $x;
    	$altura = ($largura*$y)/$x;

    	if($altura>$larguraP){
    			$altura = $larguraP;
    			$largura = ($altura*$x)/$y;
    	}
    	$nova = imagecreatetruecolor($largura, $altura);
    	imagecopyresampled($nova, $img, 0,0,0,0, $largura, $altura, $x, $y);

    	imagejpeg($nova, $pasta.$nome);
    	imagedestroy($img);
    	imagedestroy($nova);
    	return (file_exists($pasta.$nome)) ? true : false;
    }

}
?>
<head>
<style>
  p.accordion {
    cursor: pointer;
    padding: 14px;
    width: 100%;
    margin-bottom: 0;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
  }

  p.accordion.active, p.accordion:hover {
    background-color: #f1f1f1;
  }

  p.accordion a{
    text-decoration: none;
    margin: 0;
  }
</style>
</head>
