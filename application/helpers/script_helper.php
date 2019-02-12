<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function epre($arr){
  echo "<br><br><br><br><br><br><br>";
  echo "<pre>";
  print_r ($arr);
  echo "</pre>";
}

function line2br($string){ 
  return str_replace(array("\r\n", "\r", "\n"), "<br />", $string); 
}

function br2line($string, $separator = PHP_EOL ){
  $separator = in_array($separator, array("\n", "\r", "\r\n", "\n\r", chr(30), chr(155), PHP_EOL)) ? $separator : PHP_EOL;  // Checks if provided $separator is valid.
  return preg_replace('/\<br(\s*)?\/?\>/i', $separator, $string);
}

function formata_cpf($cpf){
  if ($cpf != '' && $cpf != null) {
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);
    $a = str_split($cpf);
    return $a[0].$a[1].$a[2].'.'.$a[3].$a[4].$a[5].'.'.$a[6].$a[7].$a[8].'-'.$a[9].$a[10]; 
  }
  return null;
}

function limpa_cpf($cpf){
  $cpf = str_replace('.', '', $cpf);
  $cpf = str_replace('-', '', $cpf);
  return $cpf;
}

function limpa_placa($placa){
  $placa = str_replace(' ', '', $placa);
  $placa = str_replace('-', '', $placa);
  return $placa;
}

function limpa_cnpj($cnpj){
  $cnpj = str_replace('.', '', $cnpj);
  $cnpj = str_replace('-', '', $cnpj);
  $cnpj = str_replace('_', '', $cnpj);
  $cnpj = str_replace('/', '', $cnpj);
  return $cnpj;
}

function limpa_telefone($telefone){
  $telefone = str_replace('(', '', $telefone);
  $telefone = str_replace(')', '', $telefone);
  $telefone = str_replace('-', '', $telefone);
  $telefone = str_replace('_', '', $telefone);
  $telefone = str_replace(' ', '', $telefone);
  return $telefone;
}

function formata_cnpj($cnpj){
  if ($cnpj != '' && $cnpj != null) {
    $cnpj = str_replace('.', '', $cnpj);
    $cnpj = str_replace('-', '', $cnpj);
    $cnpj = str_replace('/', '', $cnpj);
    $a = str_split($cnpj);
    return $a[0].$a[1].'.'.$a[2].$a[3].$a[4].'.'.$a[5].$a[6].$a[7].'/'.$a[8].$a[9].$a[10].$a[11].'-'.$a[12].$a[13]; 
  }
  return null;
}

function limpa_cep($cep){
  $cep = str_replace('-', '', $cep);
  return $cep;
}

function formata_cep($cep){
  $cep = str_replace('.', '', $cep);
  $cep = str_replace('-', '', $cep);
  $a = str_split($cep);
  return $a[0].$a[1].$a[2].$a[3].$a[4].'-'.$a[5].$a[6].$a[7]; 
}

function formata_placa($placa){
  if($placa != ''){
    $placa = str_replace('.', '', $placa);
    $placa = str_replace('-', '', $placa);
    $a = str_split($placa);
    return $a[0].$a[1].$a[2].'-'.$a[3].$a[4].$a[5].$a[6]; 
  }
  return null;
}

function data_to_date($data){
  if($data != null && $data != ''){
    $data = explode('/', $data);
    return $data[2].'-'.$data[1].'-'.$data[0];
  }
  else
    return null;
}

function formata_data($data){
  if ($data != '') {
    $data = explode(' ', $data);
    $data = explode('-', $data[0]);
    return $data[2].'/'.$data[1].'/'.$data[0];
  }
  else
    return null;
}

function numero_to_number($numero){
  if($numero != null){
    $numero = str_replace(' ', '', $numero);
    $numero = str_replace('.', '', $numero);
    $numero = str_replace(',', '.', $numero);
    return $numero;
  }
  else
    return null;
}

function formata_numero($numero){
  $numero = str_replace('.', ',', $numero);
  return $numero;
}

function removeacento($str){
  $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
  $to   = 'AAAAEEIOOOUUCaaaaeeiooouuc';
  return strtr($str, $from, $to);
}

function limpa_url($str){
  return urldecode($str);
}

function verifica_dia_util($data){
  $dia_semana = date('w', strtotime($data));
  $data = new DateTime($data);
  if ($dia_semana == '0') {
    $data->add(new DateInterval('P1D'));
  }
  elseif ($dia_semana == '6') {
    $data->add(new DateInterval('P2D'));
  }
  $data = $data->format('Y-m-d');
  return $data;
}


function extenso($valor = 0, $maiusculas = false) {
  // verifica se tem virgula decimal
  if (strpos($valor, ",") > 0) {
    // retira o ponto de milhar, se tiver
    $valor = str_replace(".", "", $valor);

    // troca a virgula decimal por ponto decimal
    $valor = str_replace(",", ".", $valor);
  }
  $singular = array("centavo", "real", "mil", "milhÃƒÂ£o", "bilhÃƒÂ£o", "trilhÃƒÂ£o", "quatrilhÃƒÂ£o");
  $plural = array("centavos", "reais", "mil", "milhÃƒÂµes", "bilhÃƒÂµes", "trilhÃƒÂµes",
    "quatrilhÃƒÂµes");

  $c = array("", "cem", "duzentos", "trezentos", "quatrocentos",
    "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
  $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta",
    "sessenta", "setenta", "oitenta", "noventa");
  $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze",
    "dezesseis", "dezesete", "dezoito", "dezenove");
  $u = array("", "um", "dois", "trÃƒÂªs", "quatro", "cinco", "seis",
    "sete", "oito", "nove");

  $z = 0;

  $valor = number_format($valor, 2, ".", ".");
  $inteiro = explode(".", $valor);
  $cont = count($inteiro);
  for ($i = 0; $i < $cont; $i++)
    for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
      $inteiro[$i] = "0" . $inteiro[$i];

  $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
  $rt = '';

  for ($i = 0; $i < $cont; $i++) {
    $valor = $inteiro[$i];
    $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
    $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
    $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

    $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
        $ru) ? " e " : "") . $ru;
    $t = $cont - 1 - $i;
    $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
    if ($valor == "000")
      $z++; elseif ($z > 0)
      $z--;
    if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
      $r .= (($z > 1) ? " de " : "") . $plural[$t];
    if ($r)
      $rt = $rt . ((($i > 0) && ($i <= $fim) &&
          ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
  }

  if (!$maiusculas) {
    return($rt ? $rt : "zero");
  } elseif ($maiusculas == "2") {
    return (strtoupper($rt) ? strtoupper($rt) : "Zero");
  } else {
    return (ucwords($rt) ? ucwords($rt) : "Zero");
  }
}

function set_form_value($editar,$form,$nome_campo){
  if ($editar) {
    $form = (array)$form;
    if(isset($form[$nome_campo])){
      return $form[$nome_campo];
    }
    return '';
  }
  else{
    return set_value($nome_campo);
  }
}

function set_form_value_array($editar,$form,$nome_campo){
  if ($editar) {
    $nome_array = explode('[', $nome_campo);
    $indice_array = str_replace(']', '', $nome_array[1]);
    $nome_array = $nome_array[0];
    $form = (array)$form;
    if(isset($form[$nome_array][$indice_array])){
      return $form[$nome_array][$indice_array];
    }
    return '';
  }
  else{
    return set_value($nome_campo);
  }
}

function set_form_select($editar,$form,$nome_campo,$option){
  if ($editar) {
    $form = (array)$form;
    if (isset($form[$nome_campo])) {
      $form = $form[$nome_campo];
      if($form == $option)
        return 'selected="selected"';
    }
    return '';
  }
  else{
    return set_select($nome_campo,$option);
  }
}

function set_form_checkbox_simples($editar,$form,$value,$nome_campo){
  if ($editar) {
    $form = (array)$form;
    $form = $form[$nome_campo];
    if($form == $value)
      return 'checked="checked"';
  }
  else{
    return set_checkbox($nome_campo, $value);
  }
  return '';
}

function set_form_checkbox($editar,$form,$nome_campo,$value){
  if ($editar) {
    $nome_campo = str_replace('[]', '', $nome_campo);
    $form = (array)$form;
    $form = (array)$form[$nome_campo];
    if(in_array($value, $form))
      return 'checked="checked"';
  }
  else{
    return set_checkbox($nome_campo, $value);
  }
  return '';
}

function set_form_checkbox_boolean($editar,$form,$nome_campo,$nome_campo_array){
  if ($editar) {
    $form = (array)$form;
    if(isset($form[$nome_campo]) && $form[$nome_campo]){
      return 'checked="checked"';
    }
    return '';
  }
  else{
    return set_checkbox($nome_campo_array, $nome_campo);
  }
}

function set_form_select_boolean($editar,$form,$nome_campo,$value){
  if ($editar) {
    $form = (array)$form;
    if(isset($form[$nome_campo]) && $form[$nome_campo]){
      return 'selected';
    }
    return '';
  }
  else{
    return set_select($nome_campo, $value);
  }
}

function set_form_radio($editar,$form,$nome_campo,$value){
  if ($editar) {
    $form = (array)$form;
    if(isset($form[$nome_campo]) && $form[$nome_campo] == $value){
      return 'checked="checked"';
    }
    return '';
  }
  else{
    return set_checkbox($nome_campo, $value);
  }
}

function set_tab_head($tab1,$tab2){
  if($tab1 == $tab2)
    return 'active';
  return '';
}

function set_tab_body($tab1,$tab2){
  if($tab1 == $tab2)
    return 'active in';
  return '';
}

function form_status($field){
  if (validation_errors() == null)
      return '';
  else{
    $res = form_error($field);
    if (empty($res))
        return 'has-success';
    else
        return 'has-danger';
  }
}