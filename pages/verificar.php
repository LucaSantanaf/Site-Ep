<?php
  if($login->isLogado()){
    header("location: ".PATH."finalizar");
  }
  else{
    if(isset($_POST['acao']) && $_POST['acao'] == 'logar'):
      $email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
      $senha = strip_tags(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));

      if($email == '' || $senha == ''){
        echo '<script>alert("Por favor, preencha o formulário!");location.href="'.PATH.'verificar"</script>';
      }
      else{
        $login->setEmail($email);
        $login->setSenha($senha);
        if($login->logar()){
          header("location: ".PATH."finalizar");
        }
        else{
          echo '<script>alert("Desculpe, mas o usuário não foi encontrado!");location.href="'.PATH.'verificar"</script>';
        }
      }
    endif;
  }
?>
<head>
<style>
  body{
    background-color: orange;
  }

  .logar{
     background-color: #f1f1f1;
     border-radius: 4px;
     width: 30%;
     height: 44%;
     margin-top: 50px;
     margin-left: 400px;
     margin-bottom: 50px;
   }

   .logar span{
     font-size: 30px;
     margin-left: 160px;
   }

   #label-logar span{
     font-size: 16px;
     margin-left: 20px;
   }

   #h1-logar{
     background-color: #4c4cff;
     color: #fff;
     padding-top: 10px;
     height: 60px;
   }

   #label-logar input[type=text], #label-logar input[type=password] {
     width: 365px;
     padding: 8px 16px;
     font-size: 15px;
     border: 1px solid #ccc;
     border-radius: 4px;
     box-sizing: border-box;
     margin-top: 8px;
     margin-bottom: 2px;
     margin-left: 22px;
     resize: vertical;
   }

   .btn-logar{
     background-color: #4CAF50;
     color: white;
     padding: 10px 0;
     width: 365px;
     font-size: 17px;
     border: none;
     border-radius: 4px;
     margin-left: 22px;
     cursor: pointer;
   }

   .text-verification{
     background-color: #f1f1f1;
     width: 100%;
     font-size: 18px;
     height: 13.4%;
     padding: 5px 15px;
   }

   #verif-text{
     margin-left: 0px;
     margin-bottom: 0px;
   }

   #verif-text a:hover{
     text-decoration: none;
   }

   #esqueceu-senha{
     padding-left: 5px;
     padding-bottom: 5px;
   }

   #esqueceu-senha:hover{
     text-decoration: none;
   }
</style>
</head>
<body>
<div id="verification">
  <div class="text-verification">
    <p id="verif-text">Se ainda não é cadastrado em nossa loja, cadastre-se para prosseguir com o processo de
      compra do produto</p>
    <p id="verif-text"><a href="<?php echo PATH; ?>cadastre-se">Clique Aqui</a></p>
    <span>Já é cadastrado? Faça Login!</span>
  </div>

  <div class="logar">
    <form action="" method="post" enctype="multipart/form-data">
      <h1 id="h1-logar"><span>Login</span></h1>
      <label id="label-logar">
        <span>E-mail</span><br>
        <input type="text" name="email">
      </label><br>

      <label id="label-logar">
        <span>Senha</span><br>
        <input type="password" name="senha">
      </label><br>

      <input type="hidden" name="acao" value="logar">
      <input type="submit" value="Logar" class="btn-logar"><br>
      <a href="#" id="esqueceu-senha">Esqueceu sua senha?</a>
    </form>
  </div>
</div>
</body>
