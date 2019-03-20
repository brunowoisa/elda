var mostra_loading = true;

$(document).on({
  ajaxStart: function() {
    if (mostra_loading)
      $('body').addClass("loading");
    else
      mostra_loading = true;
  },
  ajaxComplete: function() { $('body').removeClass("loading"); }    
});

$(document).ready(function() {
  $('body').removeClass("loading");
});


/**
 + FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
 * função que verifica cada clique realizado dentro do documento
 */
$(document).on('click', 'a', function(e) {
    var href      = $(this).attr('href'),
        target    = $(this).attr('target'),
        disabled  = $(this).attr('disabled'),
        toogle    = $(this).attr('data-toggle');

    if (typeof toogle != 'undefined' && toogle == 'confirmation')
      return false;

    if (typeof disabled != 'undefined' && disabled)
      return false;

    var JS = href.substring(0, 10);
    if (JS == 'javascript')
      return true;

    var hashTag = href.substring(0, 1);
    if (hashTag != '#' && JS != 'javascript' && !target)
      ajax_html( href ); 
    else if (target)
      window.open(href, target).focus();
        
    e.preventDefault();
    return false;
});

/**
 + FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
 * função que verifica se a sessão é válida e está ativa
 */
function verifica_sessao(){
  mostra_loading = false;
  $.ajax({
    url: '../acesso/verifica_sessao_ajax/',
    type: 'POST',
    dataType: 'json',
  })
  .done(function(data) {
    if (!data) {
      swal({
        title: "",
        html: "Sessão encerrada por falta de atividade! <BR>",
        type: "info"
      }).then((result) => {
        if (result.value) {
          window.location= '../acesso/logoff/';
        }
      });
    }
  })
  .fail(function() {
    swal({
      title: "Erro!",
      html: "Erro ao verificar sessão!",
      type: "error"
    });
  });
}

/**
 * FUNÇÃO QUE RETIRA CARACTERES DOS NUMEROS INFORMADOS
 * @param  {string} pNum número informado
 * @return {string} número sem os caracteres
 */
function unformatNumber(pNum){
  exp = /\.|\-|_|\//g;
  pNum = pNum.toString();
  pNum = pNum.replace( exp, "" ); 
  return pNum;
}

/**
 * função que trata os envios de formulário
 */
$( document ).delegate($('input[type="submit"]') , 'click', function (event) {
  verifica_sessao();
  $('form').ajaxForm({
    beforeSubmit: function(arr, $form, options) {
      $('body').addClass("loading");
    },
    success: function(data){ 
      $('#html_ajax').html(data);
      $('body').removeClass("loading");
    },
    error:function(){
      swal({
        title: "Erro!",
        html: "Erro ao enviar formulário! Contate So suporte.",
        type: "error"
      });
    } 
  });
});

/**
 * função que faz a requisição ajax das mudanças de página e exibe o html na div especificada
 */
function ajax_html(destino, element){
  verifica_sessao();
  var verifica_home = destino.split("/");
  if (verifica_home[verifica_home.length-1] == 'home'){
    window.location = window.location
    return;
  }
  var loading;
  $.ajax({
    url: destino,
    type: 'POST',
    beforeSend: function(){

      loading = setTimeout(function(){
        $('body').addClass("loading");
      }, 200);

      // Não deixa exibir a modal para o primeiro nivel da hierarquia do MENU!
      if (element != 'undefined')
      {
        element=$(element);
        var element_parent = element.closest('li');
        if (element_parent.length > 0 && element_parent.hasClass('treeview'))
          clearTimeout(loading);
      }
    }
  })
  .done(function(data) {
      clearTimeout(loading);
      $('#html_ajax').html(data);    
      var uri = new Array(); 
      if(destino.length > 0){
        uri = destino.split('/');
      }
      // Ajusta a altura da sidebar, para nao ficar com espaço em branco
      $('.main-sidebar').css('height', $('body, html').height());
      $('body, html').animate({ scrollTop: 0 }, 400);
      $('body').removeClass("loading");
  })
  .fail(function(data) {
    clearTimeout(loading);
    swal({
      title: "Erro!",
      html: "Desculpe, houve um erro interno! Contate o suporte.",
      type: "error"
    });
    $('body').removeClass("loading");
    console.log(data);
  });
}

/**
 * verifica se o cpf informado é válido
 * @param  {string}  cpf contém o cpf
 * @return {Boolean} informa o resultado da verificação
 */
function isCpf(cpf) {
  cpf = unformatNumber(cpf)
  var soma;
  var resto;
  var i;
  if ( (cpf.length != 11) ||
       (cpf == "00000000000") || (cpf == "11111111111") ||
       (cpf == "22222222222") || (cpf == "33333333333") ||
       (cpf == "44444444444") || (cpf == "55555555555") ||
       (cpf == "66666666666") || (cpf == "77777777777") ||
       (cpf == "88888888888") || (cpf == "99999999999") ) {
    return false;
  }
  soma = 0;
  for (i = 1; i <= 9; i++) {
    soma += Math.floor(cpf.charAt(i-1)) * (11 - i);
  } 
  resto = 11 - (soma - (Math.floor(soma / 11) * 11));
  if ( (resto == 10) || (resto == 11) ) {
    resto = 0;
  }
  if ( resto != Math.floor(cpf.charAt(9)) ) {
    return false;
  }
  soma = 0;
  for (i = 1; i<=10; i++) {
    soma += cpf.charAt(i-1) * (12 - i);
  } 
  resto = 11 - (soma - (Math.floor(soma / 11) * 11));
  if ( (resto == 10) || (resto == 11) ) {
    resto = 0;
  }
  if (resto != Math.floor(cpf.charAt(10)) ) {
    return false;
  }
  return true;
}

/**
 * verifica se o cnpj informado é válido
 * @param  {string}  s contém o cnpj
 * @return {Boolean} informa o resultado da verificação
 */
function isCnpj(s){
  var i;
  var c = s.substr(0,12);
  var dv = s.substr(12,2);
  var d1 = 0;
  for (i = 0; i < 12; i++){
    d1 += c.charAt(11-i)*(2+(i % 8));
  }
  if (d1 == 0)
    return false;
  d1 = 11 - (d1 % 11);
  if (d1 > 9)
    d1 = 0;
  if (dv.charAt(0) != d1)
    return false;
  d1 *= 2;
  for (i = 0; i < 12; i++){
    d1 += c.charAt(11-i)*(2+((i+1) % 8));
  } 
  d1 = 11 - (d1 % 11); 
  if (d1 > 9)
    d1 = 0;
  if (dv.charAt(1) != d1)
    return false;   
  return true;
}

/**
 * verifica se o documento informado é válido
 * @param  {string}  documento contém os numeros do documento
 * @return {Boolean} informa o resultado da verificação
 */
function valida_cpf_cnpj(documento) {
  var retorno = false;
  documento = unformatNumber(documento);
  if(documento=="")
    return false;
   if (documento.length > 11){
    if (isCnpj(documento)) {
      retorno = true;
    } else {
      swal({
        title: "Validação de CNPJ",
        html: "CNPJ informado é inválido.",
        type: "error"
      });
    }
  } else {
    if (isCpf(documento)) {
      retorno = true;
    } else {
      swal({
        title: "Validação de CPF",
        html: "CPF informado é inválido.",
        type: "error"
      });
    }
  }
  return retorno;
}

/**
 * função que faz a requisição ajax para o webservice viacep.com.br e retorna os dados referente ao cep informado
 */
function busca_cep(cep){
  cep = cep.replace("-", "");
  if(cep != '' && cep != '________'){
    $.ajax({
      url: 'https://viacep.com.br/ws/'+cep+'/json/',
      type: 'POST',
      dataType: 'jsonp',
    })
    .done(function(data) {
      if (data) {
        return data;
      }
      else {
        return false;
      }
    })
    .fail(function() {
      return false;
    });
  }
  else {
    return false;
  }
}

/**
 * função que verifica se o PIS informado é válido
 */
function valida_pis(numero) {
  var retorno = false;
  numero = unformatNumber(numero);
  if(numero==""){ return false; };
  if (isPis(numero)) {
    retorno = true;
  } 
  else {
    swal({
      title: "Validação de PIS",
      html: "PIS informado é inválido.",
      type: "error"
    });
  }
  return retorno;
}

/**
 * função que verifica se o PIS informado é válido
 */
function isPis(pis) {
  var ftap="3298765432";
  var total=0;
  var i;
  var resto=0;
  var numPIS=0;
  var strResto="";
 
  total=0;
  resto=0;
  numPIS=0;
  strResto="";

  numPIS=pis;
      
  if (numPIS=="" || numPIS==null)
    return false;
    
  for(i=0;i<=9;i++) {
    resultado = (numPIS.slice(i,i+1))*(ftap.slice(i,i+1));
    total=total+resultado;
  }
  
  resto = (total % 11)
  
  if (resto != 0)
    resto=11-resto;
  
  if (resto==10 || resto==11) {
    strResto=resto+"";
    resto = strResto.slice(1,2);
  }
  
  if (resto!=(numPIS.slice(10,11)))
    return false;
  return true;
}

/**
 * função que verifica o valor informado é percentual válido (entre 0 e 100)
 */
function valida_porcentagem(input) {
  // O numero deve ser informado no seguinte padrão:
  // 56,96 || 2225,65 || 25225,65 || 0,00
  valor = input.val();
  valor = valor.replace(',','.');
  if (valor > 100) {
    input.val('100,00');
  }
  else if(valor < 0) {
    input.val('0,00');
  }
}