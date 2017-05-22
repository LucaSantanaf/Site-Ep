<?php
  class Carrinho{
    private $pref = 'media_';

    private function existe($id){
      if(!isset($_SESSION[$this->pref.'produto'])){
        $_SESSION[$this->pref.'produto'] = array();
      }
      if(!isset($_SESSION[$this->pref.'produto'][$id])){
        return false;
      }
      else{
        return true;
      }
    }//Verifica a existencia do produto e da session como um Array

    public function verificaAdiciona($id){
      if(!$this->existe($id)){
        $_SESSION[$this->pref.'produto'][$id] = 1;
      }
      else{
        $_SESSION[$this->pref.'produto'][$id] += 1;
      }
    }//Verifica e adiciona mais um produto ao carrinho

    private function prodExiste($id){
      if(isset($_SESSION[$this->pref.'produto'][$id])){
        return true;
      }
      else{
        return false;
      }
    }//Verifica se o produto existe

    public function deletarProduto($id){
      if(!$this->prodExiste($id)){
        return false;
      }
      else{
        unset($_SESSION[$this->pref.'produto'][$id]);
        return true;
      }
    }//Deleta produto do Carrinho de Compras

    private function isArray($post){
      if(is_array($post)){
        return true;
      }
      else{
        return false;
      }
    }//Verifica se o post passado passado pelo parametro é ou não um array

    public function atualizarQuantidades($post){
      if($this->isArray($post)){
        foreach($post as $id => $qtd){
          $id = (int)$id;
          $qtd = (int)$qtd;

          if($qtd != ''){
            $_SESSION[$this->pref.'produto'][$id] = $qtd;
          }
          else{
            unset($_SESSION[$this->pref.'produto'][$id]);
          }
        }
        return true;
      }
      else{
        return false;
      }//Se não for um array
    }//Deleta ou atualiza quantidades referente a um produto no carrinho de compras

    public function setarByPost($post){
      if($this->isArray($post)){
        foreach($post as $id => $qtd){
          $id = (int)$id;
          $qtd = (int)$qtd;

          if(!isset($_SESSION[$this->pref.'produto'][$id])){
            $_SESSION[$this->pref.'produto'][$id] = $qtd;
          }
          else{
            $_SESSION[$this->pref.'produto'][$id] += $qtd;
          }
        }
        return true;
      }
      else{
        return false;
      }//Se não for um array
    }

    public function qtdProdutos(){
      if(!isset($_SESSION[$this->pref.'produto'])){
        return 0;
      }
      else{
        return count($_SESSION[$this->pref.'produto']);
      }
    }

//Função para calculo do frete
/*  function calculaFrete($cep_origem, $cep_destino, $peso, $valor, $tipo_do_frete, $altura = 6,
    $largura = 20, $comprimento = 20){
      $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
      $url .= "nCdEmpresa=";
      $url .= "&nDsSenha=";
      $url .= "&sCepOrigem=" .$cep_origem;
      $url .= "&sCepDestino=" .$cep_destino;
      $url .= "&nVlPeso=" .$peso;
      $url .= "&nVlLargura=" .$largura;
      $url .= "&nVlAltura=" .$altura;
      $url .= "&nCdFormato=1";
      $url .= "&nVlComprimento=" .$comprimento;
      $url .= "&sCdMaoPropria=n";
      $url .= "&nVlValorDeclarado=" .$valor;
      $url .= "&sCdAvisoRecebimento=n";
      $url .= "&nCdServico=" .$tipo_de_frete;
      $url .= "&nVlDiametro=0";
      $url .= "&StrRetorno=xml";

      //Sedex: 40010
      //PAC: 41106

      $xml = simplexml_load_file($url);
      return $xml->cServico;

      $frete = (calculaFrete('45350000', '37500410' || '96825150', 2, 1000, '41106'));
      echo "Valor PAC: R$ ".$frete->Valor;
   } */

//Função para calculo do frete
  public function calculaFrete($cod_servico, $cep_origem, $cep_destino, $peso, $altura='2', $largura='11',
   $comprimento='16', $valor_declarado='0.50'){
     $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem="
     .$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento="
     .$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado="
     .$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";

    $xml = simplexml_load_file($correios);
      if($xml->cServico->Erro == '0'){
        return $xml->cServico->Valor;
      }
      else{
        return false;
      }
   }
}
?>
