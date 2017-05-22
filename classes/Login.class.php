<?php
  class Login extends BD{
    private $prefixo;
    private $tabela;
    private $email;
    private $senha;

    public function __construct($pref, $table){
      $this->prefixo = $pref;
      $this->tabela = $table;
    }

    public function setEmail($mail){
      $this->email = $mail;
    }

    private function getEmail(){
      return $this->email;
    }

    public function setSenha($pass){
      $this->senha = $pass;
    }

    public function getSenha(){
      return $this->senha;
    }

    private function validar(){
      $strSQL = "SELECT * FROM `".$this->tabela."` WHERE email_log = ? AND senha_log = ? ";
      $stmt = self::conn()->prepare($strSQL);
      $stmt->execute(array($this->getEmail(), $this->getSenha()));
      return ($stmt->rowCount() > 0) ? true : false;
    }

    public function logar(){
      if($this->validar()){
        $atualizar = self::conn()->prepare("UPDATE `".$this->tabela."` SET data_log = NOW()
        WHERE email_log = ? AND senha_log = ?");
        $atualizar->execute(array($this->getEmail(), $this->getSenha()));

        $_SESSION[$this->prefixo.'emailLog'] = $this->getEmail();
        $_SESSION[$this->prefixo.'senhaLog'] = $this->getSenha();
        return true;
      }
      else{
        return false;
      }
    }

    public function isLogado(){
      if(isset($_SESSION[$this->prefixo.'emailLog'], $_SESSION[$this->prefixo.'senhaLog'])){
        return true;
      }
      else{
        return false;
      }
    }

    public function deslogar(){
      if($this->isLogado()){
        unset($_SESSION[$this->prefixo.'emailLog']);
        unset($_SESSION[$this->prefixo.'senhaLog']);
        session_destroy();
        return true;
      }
      else{
        return false;
      }
    }
  }
?>
