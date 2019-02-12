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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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
 * FUNÇÃO VERIFICADA E UTILIZADA EM WOISOFT
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


//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
/// FUNÇÕES AINDA NÃO VERIFICADAS (MAS PODEM ESTAR SENDO UTILIZADAS //////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
$( document ).on( "click", ".cancelar", function(e) {
  //alert('b');
  e.preventDefault();
  ajax_html($(this).attr('href'), $(this));     
});

$( document ).on( "click", ".excluir", function(e) {
   //alert('v');
  e.preventDefault();
  ajax_html($(this).attr('href'), $(this));     
});

  function Result(vCabecalho,vTexto, tipo){
    if (tipo != 'undefined')
      switch(tipo) {
        case 'error':
          $('#myModalWarning #CabecalhoDiv').html(vCabecalho);
          $('#myModalWarning #MensagemDiv').html(vTexto);
          $('#myModalWarning').modal('show');  
        break;
        case 'success':
          $('#myModalSuccess #CabecalhoDiv').html(vCabecalho);
          $('#myModalSuccess #MensagemDiv').html(vTexto);
          $('#myModalSuccess').modal('show');  
        break;
      }
  }
  function Informar(vCabecalho,vTexto, tipo){
    $('#myModalMensagem #CabecalhoDiv').html(vCabecalho);
    $('#myModalMensagem #MensagemDiv').html(vTexto);

    if (tipo != 'undefined')
      switch(tipo) {
        case 'error':
          $('#myModalMensagem .custom-modal-icon.error').show();
        break;
        case 'success':
          $('#myModalMensagem .custom-modal-icon.success').show();
        break;
      }
    $('#myModalMensagem').modal('show');   
  }


  function Confirmar(vTipo,vId,vAux){
    
    var url= "Ajax/confirmar/"+vTipo+"/"+vId+"/"+vAux;
    //alert(url);
    
    var request = $.ajax({
      url: url,
      type: "GET",
      dataType: "json"
    });
     
    //alert('2');
    request.done(function(data) {
    //alert('3');

        $.each(data, function(i, c) { 
          $('#myModalConfirma #CabecalhoDiv').html(c.cabecalho);
          $('#myModalConfirma #MensagemDiv').html(c.mensagem);
          $('#myModalConfirma #RunDiv').html(c.run);
          $('#myModalConfirma').modal('show');   
                });
    });   
  }

  function ConfirmarRun(){
    var vEndereco = $(".RunDiv").text();
    //var RetData = $('#myModalConfirma input[name="campoderetorno"]').val();
    var RetData = $('#campoderetorno').val();
    
    //alert(vEndereco);
    //alert(RetData);
    
    if(RetData !== undefined){
      if(RetData !== ''){
          //alert(RetData);
        vEndereco = vEndereco +'/'+ RetData;
      } 
    }
    //alert(vEndereco);
    
    ajax_html(vEndereco);
  }
  
  function SatReabre(pId,pTipo){
    //alert(pTipo);
    var url= "tccliente/Sat/Reabertura/"+pId+"/"+pTipo;
    $.ajax({ url: url, type: "GET", dataType: "json" });
    //alert(url);   
  }
  
  
  function SelecionaEmpresa(){
    $('#myModalSelectEmp').modal('show');  
  }
  
  function Relatorios(pForm,pLink,pdiv){
    //alert(pForm);
    //alert(pLink);
    //alert(pdiv);
    
    $('#'+pForm).ajaxSubmit({
        url : pLink, 
        dataType: 'json',
        beforeSubmit: function(formData, jqForm, options){
                                      $("#"+pdiv).html("<img src='assets/img/aguarde.gif'/>");
                                      //var queryString = $.param(formData);
                                      //console.log('About to submit: \n' + queryString + '\n');
                                      return true;                   
                                     }, 
        success: function(data){
                                 $("#"+pdiv).html("");
                                 //console.log("respose: " + data);
                                //alert(data.arquivo);
                  livs = data.baseurl+"Arquivo/DownloadArquivo/"+data.arquivo;
                  //alert(livs);
                  window.open(livs);
                
                  //echo '<td><button class="btn btn-success btn-xs" data-toggle="tooltip" title="" data-original-title="Baixar Arquivo..." onclick=""
                  livs = data.baseurl+"Arquivo/ExcluirArquivo/";
                  //alert(livs);
                /*
                $('form').ajaxForm({ url: livs,
                  data: { opath: data.arquivo
                                }, 
                  success: function(data){
                     
                  },
                        error:function(){
                mensagem('Ajax','Não foi possível executar Excluir !'+error);
                        } 
                      }).submit();
                  */                                                              
                          
                                 
                               },
        error: function(data){
                               $("#"+pdiv).html("");

                 //var resultado="";
                 //for (propriedade in data) {
                 //resultado += propriedade + ": " + data[propriedade] + "\n"; 
                 //};
                 
                               Informar('Erro na requisição','Não foi possível executar ação :( '+"<br><br>responseText:"+data['responseText']+'<br>StatusText:'+data['statusText']+'<br>Status:'+data['status']);
                             }
    });
    return false;
    
    
  } 


  function SubSubmit(pForm,pLink){
    $('#'+pForm).ajaxSubmit({
        url : pLink, 
        type: "POST",
        beforeSubmit: function(formData, jqForm, options){
                                      //var queryString = $.param(formData);
                                      //console.log('About to submit: \n' + queryString + '\n');
                                      return true;                   
                                     }, //showRequest,
        success: function(data){ 
                $('#html_ajax').html(data);
                //console.log("respose: " + data);
          },                                     
        error: function(data){
                                Informar('Erro na requisição','Não foi possível executar ação :( '+"<br><br>responseText:"+data['responseText']+'<br>StatusText:'+data['statusText']+'<br>Status:'+data['status']);        
                             } //errorJson
    });
    return false;
    
  } 
  

  // function ValidaCpf() {
  //    var retorno = false;
  //    var numero  = $('.isCpf').val();
  //    numero = unformatNumber(numero);
  //    if(numero==""){ return false; };
  //    if (isCpf(numero)) {
  //        retorno = true;
  //    } else {
  //     Informar('Validação','CPF informado é inválido !  <br><br><b>' + $('.isCpf').val());
  //     $('.isCpf').val('');
  //    }
  //    return retorno;
  // }
  // function ValidaCnpj() {
  //    var retorno = false;
  //    var numero  = $('.isCnpj').val();
  //    numero = unformatNumber(numero);
  //    if(numero==""){ return false; };
  //    if (isCnpj(numero)) {
  //        retorno = true;
  //    } else {
  //     Informar('Validação','CNPJ informado é inválido !  <br><br><b>' + $('.isCnpj').val());
  //     $('.isCnpj').val('');
  //    }
  //    return retorno;
  // }
   
   
  function validameupai(pField){
    //$('#'+pForm).ajaxSubmit({
        var id = $(pField).attr('id');
        var nome = $(pField).attr('name');
        var menu = nome.substr(0,12);
        var menuid = nome.substr(12,1);
        var menupai = menuid-1;
        var procurar = menu+menupai+'_'+id;
        
  
        if(id>0){
            if ( myform.elements[nome].checked ) {
                if ( ! myform.elements[procurar].checked ) {
                    //alert( $("label[for='"+procurar+"']").text() );
                    Informar('Nível Superior','<div class="info-box"><span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span><div class="info-box-content"><span class="info-box-text">Por favor marque o nivel superior</span><span class="info-box-number">'+$("label[for='"+procurar+"']").text()+'</span></div></div> ' );
                    myform.elements[nome].checked = 0; 
                    //mensagem('Erro','Por favor marque o nivel superior !'); // +'\n'+  $("label[for='"+procurar+"']").text());
                }    
            }
        }
       
      
  } 
   


try {xmlhttp = new XMLHttpRequest();} catch(ee) { 
        try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");} catch(e) { 
                try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");} catch(E) 
{xmlhttp = false;} 
        } 
} 

  function carrega(_idContainer, _endereco){ 
        var tag_container = document.getElementById(_idContainer); 
        tag_container.innerHTML = ''; 
         
        xmlhttp.open('GET',_endereco,true); 
        xmlhttp.onreadystatechange = function() { 
                if (xmlhttp.readyState == 4){ 
                        retorno = xmlhttp.responseText; 
                        tag_container.innerHTML = retorno; 
                } 
        } 
        xmlhttp.send(null) 
    } 

//Função que formata uma string Jquery em número
Number.prototype.formatMoney = function(c, d, t){
  var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};