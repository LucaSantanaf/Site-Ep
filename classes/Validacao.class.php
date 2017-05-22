<?php
  class Validacao{
    private $dados;
    private $erro = array();

    //Seta o valor de cada campo
    public function set($valor, $nome){
      $this->dados = array("valor" => strip_tags(trim($valor)), "nome" => $nome);
      return $this;
    }

    //Valida Campos Obrigatórios
    public function obrigatorio(){
      if(empty($this->dados['valor'])){
        $this->erro[] = sprintf("O campo %s é obrigatório", $this->dados['nome']);
      }
      return $this;
    }

    //Valida um E-mail valido
    public function isEmail(){
      //nome@servidor.com
      if(!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]+\.[a-z]{2,4}$/i", $this->dados['valor'])){
        $this->erro[] = sprintf("O campo %s só acerta emails validos", $this->dados['nome']);
      }
      return $this;
    }

    //Valida um telefone
    public function isTel(){
      //(99)9999-9999
      if(!preg_match("/^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$/", $this->dados['valor'])){
        $this->erro[] = sprintf("O campo %s só aceita no formato (99)9999-9999", $this->dados['nome']);
      }
      return $this;
    }

    //Valida CPF
    private function cpf($cpf){
      //111444777XX
      $cpf = preg_replace("/[^0-9]/", "", $cpf);
      $digitoUm = 0;
      $digitoDois = 0;
      if($cpf == ''){
        return false;
      }

      for($i = 0, $x = 10; $i <= 8; $i++, $x--){
        $digitoUm += $cpf[$i]*$x;
      }

      for($i = 0, $x = 11; $i <= 9; $i++, $x--){
        if(str_repeat($i, 11) == $cpf){
          return false;
        }
        $digitoDois += $cpf[$i]*$x;
      }

      $calculoUm = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
      $calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);

      if($calculoUm != $cpf[9] || $calculoDois != $cpf[10]){
        return false;
      }
      return true;
    }

    public function isCpf(){
      if(!$this->cpf($this->dados['valor'])){
        $this->erro[] = sprintf("O campo %s só aceita cpfs válidos", $this->dados['nome']);
      }
      return $this;
    }

    //Função para validar os demais métodos
    public function validar(){
      if(count($this->erro) > 0){
        return false;
      }
      else{
        return true;
      }
    }

    //Retorna os erros encontrados
    public function getErro(){
      return $this->erro;
    }

  }
?>
