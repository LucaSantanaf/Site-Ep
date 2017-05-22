<?php
  class FretePrazo {
    public $dados;

    public function __construct($cdservico, $ceporigem, $cepdestino, $peso, $comprimento, $altura, $largura,
      $diametro, $formato = 1, $maopropria = 'N', $valordeclarado = 0, $avisorecebimento = 'N',
      $tiporetorno = 'xml', $indicacalculo = 3){

    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$ceporigem."&sCepDestino=".$cepdestino."&nVlPeso=".$peso."&nCdFormato=".$formato."&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=".$maopropria."&nVlValorDeclarado=".$valordeclarado."&sCdAvisoRecebimento=".$avisorecebimento."&nCdServico=".$cdservico."&nVlDiametro=".$diametro."&StrRetorno=".$tiporetorno."&nIndicaCalculo=".$indicacalculo;
    $this->dados = simplexml_load_string(file_get_contents($url));
    }
  }

  $frete = new FretePrazo("04510", "09960010", $cepdestino, $peso);
