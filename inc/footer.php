<?php if($url != ''); ?>
  <div style="clear:both;"></div>
  </div>
<head>
<style>
  footer{
    background-color: #ddd;
  }

  .pagamentos, .atendimento{
    display: inline-block;
    margin-left: 40px;
  }

  .emails{
    display: inline-block;
    margin-right: 0px;
  }

  .facebook{
    display: inline-block;
    margin-left: 40px;
    margin-top: 20px;
  }

  .facebook img{
    margin-bottom: 10;
  }

  .facebook span{
    margin-left: 20px;
  }
</style>
</head>
<body>
<footer>
  <div class="emails">
    <span>E-mails</span>
      <p>site@site.com.br</p>
      <p>atendimento@site.com.br</p>
  </div>

  <div class="atendimento">
  	<span>Atendimento</span>
    <p>(11) 2311-6502</p>
  </div>

  <div class="pagamentos">
  	<span>Pagamentos</span><br>
      <img src="<?php echo PATH;?>/images/pagamentos.png" border="0" alt="" title="Formas de pagamento" />
  </div>

  <div class="facebook">
		<a href="https://www.facebook.com/EPISEG-1540155772890279/">
      <img src="images/like.png" alt="" width="90px">
    </a>
  </div>
</footer>
</body>
