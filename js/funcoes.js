$(function(){
  $("div#imagens_slide ul").cycle({
    fx: 'fade',
    speed: '2000',
    timeout: '9000',
    pager: 'span#paginator'
  })
});

$(function(){
  $("#tel").mask("(99)9999-9999");
  $("#cpf").mask("999.999.999-99");
  $("#cep").mask("99999-999")
});
