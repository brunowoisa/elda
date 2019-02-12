<?php 
use \NFePHP\DA\NFe\Danfe;
use NFePHP\DA\NFe\Daevento;
use NFePHP\DA\NFe\Dacce;
Class email_mod extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->layout_email = '';
    $this->seta_layout_email_woisoft();
    $this->load->library('email');
  }

  public function envia_email($to,$subject,$message,$cc=null,$bcc=null){
    $config['charset'] = 'utf-8';
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->from('site@woisoft.com.br', 'WoiSoft Sistemas');
    $this->email->to($to);
    if ($cc != null) 
    {
      if (is_array($cc)) 
      {
        foreach ($cc as $kcc) {
          $this->email->cc($kcc);
        }
      }
      else 
      {
        $this->email->cc($cc);
      }
    }
    if ($bcc != null) 
    {
      if (is_array($bcc)) 
      {
        foreach ($bcc as $kbcc) {
          $this->email->bcc($kbcc);
        }
      }
      else 
      {
        $this->email->bcc($bcc);
      }
    }
    $this->email->subject($subject);

    $corpo = str_replace('#TITULO#', $subject, $this->layout_email);
    $corpo = str_replace('#TEXTO#', $message, $corpo);

    $this->email->message($corpo);
    if (! $this->email->send())
      return false;
    return true;
  }


  private function seta_layout_email_woisoft(){
    $this->layout_email = '
    <body style="border: 0; padding: 0;" bgcolor="#cccccc">
      <table class="full-width-container" border="0" padding="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#cccccc" style="width: 100%; height: 100%; padding: 30px 0 30px 0; border: 0px;">
        <tr>
          <td align="center" valign="top">
            <table class="container" border="0" cellpadding="0" cellspacing="0" width="700" bgcolor="#ffffff" style="width: 700px;">
              <tr>
                <td align="center" valign="top">
                  <table class="container projects-list" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top: 0px;">
                    <tr>
                      <td>
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td align="left">
                              <img src="https://www.woisoft.com.br/email/topo.jpg" width="705" height="200" border="0" style="display: block;">
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table class="container title-block" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td align="center" valign="top">
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
                          <tr>
                            <td style="border-bottom: solid 1px #eeeeee; padding: 35px 0 18px 0; font-size: 26px; font-family: arial;" align="left">#TITULO#</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table class="container paragraph-block" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td align="center" valign="top">
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" style="width: 620px;">
                          <tr>
                            <td class="paragraph-block__content" style="padding: 25px 0 5px 0; font-size: 16px; font-family: arial; line-height: 27px; color: #555555;" align="left"> #TEXTO# </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top: 5px;" align="center">
                    <tr>
                      <td align="center">
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" align="center" style="border-bottom: solid 1px #eeeeee; width: 620px;">
                          <tr>
                            <td align="center">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                  <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-bottom: 20px;">
                    <tr>
                      <td align="center">
                        <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" align="center" style="border-top: 1px solid #eeeeee; width: 620px;">
                          <tr>
                            <td style="text-align: right; padding: 10px 0 10px 0; color: #fb9c2c; font-family: arial; font-size: 12px;"> E-mail enviado automaticamente pelo sistema, por favor não responder. </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </body>';
  }

  public function envia_email_nf($xml='')
  {
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xml);
    $root = $dom->documentElement;
    $name = $root->tagName;
    $dest = $dom->getElementsByTagName('dest')->item(0);
    $ide = $dom->getElementsByTagName('ide')->item(0);
    switch ($name) {
      case 'nfeProc':
      case 'NFe':
        $type = 'NFe';
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $id = substr($infNFe->getAttribute('Id'), 3) . '-' . strtolower($name);
        $numero = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $valor = $dom->getElementsByTagName('vNF')->item(0)->nodeValue;
        $data = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $subject = "NFe n. " . $numero . " - " . $this->session->userdata('empresa')->nome;
        break;
      // case 'cteProc':
      // case 'CTe':
      //     $type = 'CTe';
      //     $infCte = $dom->getElementsByTagName('infCte')->item(0);
      //     $this->fields->id = substr($infNFe->getAttribute('Id'), 3) . '-' . strtolower($name);
      //     $this->fields->numero = $ide->getElementsByTagName('nCT')->item(0)->nodeValue;
      //     $this->fields->valor = $dom->getElementsByTagName('vRec')->item(0)->nodeValue;
      //     $this->fields->data = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
      //     $this->subject = "CTe n. " . $this->fields->numero . " - " . $this->config->fantasy;
      //     break;
      // case 'procEventoNFe':
      // case 'procEventoCTe':
      //     $type = 'CCe';
      //     $this->fields->chave = $dom->getElementsByTagName('chNFe')->item(0)->nodeValue;
      //     $this->fields->id = $this->fields->chave.'-procCCe-'.strtolower(substr($name, -3));
      //     $this->fields->data = $dom->getElementsByTagName('dhEvento')->item(0)->nodeValue;
      //     $this->fields->correcao = $dom->getElementsByTagName('xCorrecao')->item(0)->nodeValue;
      //     $this->fields->conduso = $dom->getElementsByTagName('xCondUso')->item(0)->nodeValue;
      //     if (empty($this->fields->chave)) {
      //         $this->fields->chave = $dom->getElementsByTagName('chCTe')->item(0)->nodeValue;
      //     }
      //     $this->subject = "Carta de Correção " . $this->config->fantasy;
      //     break;
    }
    //get email adresses from xml, if exists
    //may have one address in <dest><email>
    if (!empty($dest)) {
        $destinatario_nome = $dest->getElementsByTagName('xNome')->item(0)->nodeValue;
        $email = !empty($dest->getElementsByTagName('email')->item(0)->nodeValue) ?
            $dest->getElementsByTagName('email')->item(0)->nodeValue : '';
    }
    if (!empty($email)) {
        // if recieve more than one e-mail address.
        if (strpos($email, ';')) {
            $emails = explode(';', $email);

            $emails = array_map(function ($item) {
                return trim($item);
            }, $emails);

            $destinatarios = array_merge($this->addresses, $emails);
        } else {
            $destinatarios[] = $email;
        }
    }
    //may have others in <obsCont xCampo="email"><xTexto>fulano@yahoo.com.br</xTexto>
    $obs = $dom->getElementsByTagName('obsCont');
    foreach ($obs as $ob) {
        if (strtoupper($ob->getAttribute('xCampo')) === 'EMAIL') {
            $destinatarios[] = $ob->getElementsByTagName('xTexto')->item(0)->nodeValue;
        }
    }
    //xml may be a NFe or a CTe or a CCe nothing else
    if ($type != 'NFe' && $type != 'CTe' && $type != 'CCe') {
        $msg = "Você deve passar apenas uma NFe ou um CTe ou um CCe. "
                . "Esse documento não foi reconhecido.";
        throw new \InvalidArgumentException($msg);
    }
    // $this->type = $type;

    // epre($type); 
    // epre($infNFe);
    // epre($id);
    // epre($numero);
    // epre($valor);
    // epre($data);
    // epre($subject);
    // epre($destinatario_nome);
    // epre($destinatarios);
    
    if (isset($destinatarios)) {
      $config['charset'] = 'utf-8';
      $config['mailtype'] = 'html';
      $this->email->initialize($config);
      $this->email->from('site@woisoft.com.br', 'Risa Shop - Envio de NF-e');
      foreach ($destinatarios as $dest) {
        $this->email->to($dest);
      }
      $this->email->bcc('bruno@woisoft.com.br');

      $this->email->subject($subject);

      $message = "" .
                  "<p><b>Prezados {destinatario},</b></p>" .
                  "<p>Você está recebendo a Nota Fiscal Eletrônica emitida em {data} com o número " .
                  "{numero}, de {emitente}, no valor de R$ {valor} e com a chave de acesso {chave}. " .
                  "Junto com a mercadoria, você receberá também um DANFE (Documento " .
                  "Auxiliar da Nota Fiscal Eletrônica), que acompanha o trânsito das mercadorias.</p>" .
                  "<p><i>Podemos conceituar a Nota Fiscal Eletrônica como um documento " .
                  "de existência apenas digital, emitido e armazenado eletronicamente, " .
                  "com o intuito de documentar, para fins fiscais, uma operação de " .
                  "circulação de mercadorias, ocorrida entre as partes. Sua validade " .
                  "jurídica garantida pela assinatura digital do remetente (garantia " .
                  "de autoria e de integridade) e recepção, pelo Fisco, do documento " .
                  "eletrônico, antes da ocorrência do Fato Gerador.</i></p>" .
                  "<p><i>Os registros fiscais e contábeis devem ser feitos, a partir " .
                  "do próprio arquivo da NF-e, anexo neste e-mail, ou utilizando o " .
                  "DANFE, que representa graficamente a Nota Fiscal Eletrônica. " .
                  "A validade e autenticidade deste documento eletrônico pode ser " .
                  "verificada no site nacional do projeto (www.nfe.fazenda.gov.br), " .
                  "através da chave de acesso contida no DANFE.</i></p>" .
                  "<p><i>Para poder utilizar os dados descritos do DANFE na " .
                  "escrituração da NF-e, tanto o contribuinte destinatário, " .
                  "como o contribuinte emitente, terão de verificar a validade da NF-e. " .
                  "Esta validade está vinculada à efetiva existência da NF-e nos " .
                  "arquivos da SEFAZ, e comprovada através da emissão da Autorização de Uso.</i></p>" .
                  "<p><b>O DANFE não é uma nota fiscal, nem substitui uma nota fiscal, " .
                  "servindo apenas como instrumento auxiliar para consulta da NF-e no " .
                  "Ambiente Nacional.</b></p>" .
                  "<p>Para mais detalhes, consulte: <a href=\"http://www.nfe.fazenda.gov.br/\">" .
                  "www.nfe.fazenda.gov.br</a></p>" .
                  "<br>" .
                  "<p>Atenciosamente,</p>" .
                  "<p>{emitente}</p>";

      $chave = str_replace('-nfeproc', '', $id);

      $dt = new \DateTime(str_replace('T', ' ', $data));
      $search = array(
        '{destinatario}',
        '{data}',
        '{numero}',
        '{valor}',
        '{emitente}',
        '{chave}'
      );
      $replace = array(
        $destinatario_nome,
        $dt->format('d/m/Y'),
        $numero,
        number_format($valor, 2, ',', '.'),
        $this->session->userdata('empresa')->nome,
        $chave
      );
      $message = str_replace($search, $replace, $message);

      $corpo = str_replace('#TITULO#', $subject, $this->layout_email);
      $corpo = str_replace('#TEXTO#', $message, $corpo);

      $this->email->message($corpo);

      // Anexos
      $pathLogo = realpath($this->diretorio_logo.$this->session->userdata('empresa')->logo);//use somente imagens JPEG
        $danfe = new Danfe($xml, 'P', 'A4', $pathLogo, 'I', '');
        $danfe->montaDANFE();
        $pdf = $danfe->render();
      $this->email->attach($pdf, 'attachment', $chave.'.pdf', 'application/pdf');
      $this->email->attach($xml, 'attachment', $chave.'.xml', 'application/xml');

      if (! $this->email->send())
        return false;
      return true;
    }
    else
      return false;
  }

  public function envia_email_nf_cancelamento($xml,$xml_c)
  {
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xml);
    $root = $dom->documentElement;
    $name = $root->tagName;
    $dest = $dom->getElementsByTagName('dest')->item(0);
    $ide = $dom->getElementsByTagName('ide')->item(0);
    switch ($name) {
      case 'nfeProc':
      case 'NFe':
        $type = 'NFe';
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $id = substr($infNFe->getAttribute('Id'), 3) . '-' . strtolower($name);
        $numero = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $valor = $dom->getElementsByTagName('vNF')->item(0)->nodeValue;
        $data = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $subject = "CANCELAMENTO - NFe n. " . $numero . " - " . $this->session->userdata('empresa')->nome;
        break;
    }
    //get email adresses from xml, if exists
    //may have one address in <dest><email>
    if (!empty($dest)) {
        $destinatario_nome = $dest->getElementsByTagName('xNome')->item(0)->nodeValue;
        $email = !empty($dest->getElementsByTagName('email')->item(0)->nodeValue) ?
            $dest->getElementsByTagName('email')->item(0)->nodeValue : '';
    }
    if (!empty($email)) {
        // if recieve more than one e-mail address.
        if (strpos($email, ';')) {
            $emails = explode(';', $email);

            $emails = array_map(function ($item) {
                return trim($item);
            }, $emails);

            $destinatarios = array_merge($this->addresses, $emails);
        } else {
            $destinatarios[] = $email;
        }
    }
    //may have others in <obsCont xCampo="email"><xTexto>fulano@yahoo.com.br</xTexto>
    $obs = $dom->getElementsByTagName('obsCont');
    foreach ($obs as $ob) {
        if (strtoupper($ob->getAttribute('xCampo')) === 'EMAIL') {
            $destinatarios[] = $ob->getElementsByTagName('xTexto')->item(0)->nodeValue;
        }
    }
    //xml may be a NFe or a CTe or a CCe nothing else
    if ($type != 'NFe' && $type != 'CTe' && $type != 'CCe') {
        $msg = "Você deve passar apenas uma NFe."
                . "Esse documento não foi reconhecido.";
        throw new \InvalidArgumentException($msg);
    }

    if (isset($destinatarios)) {
      $config['charset'] = 'utf-8';
      $config['mailtype'] = 'html';
      $this->email->initialize($config);
      $this->email->from('site@woisoft.com.br', 'Risa Shop - Envio de NF-e');
      foreach ($destinatarios as $dest) {
        $this->email->to($dest);
      }
      $this->email->bcc('bruno@woisoft.com.br');

      $this->email->subject($subject);

      $message = "" .
                  "<p><b>Prezados {destinatario},</b></p>" .
                  "<p>De acordo com as determinações legais vigentes, vimos por meio desta comunicar-lhe que a Nota Fiscal Eletrônica emitida em {data} com o número " .
                  "{numero}, de {emitente}, no valor de R$ {valor} e com a chave de acesso {chave} está cancelada, solicitamos que sejam aplicadas essas correções ao executar seus lançamentos fiscais. </p>" .
                  "<p><b>O DANFE não é uma nota fiscal, nem substitui uma nota fiscal, " .
                  "servindo apenas como instrumento auxiliar para consulta da NF-e no " .
                  "Ambiente Nacional.</b></p>" .
                  "<p>Para mais detalhes, consulte: <a href=\"http://www.nfe.fazenda.gov.br/\">" .
                  "www.nfe.fazenda.gov.br</a></p>" .
                  "<br>" .
                  "<p>Atenciosamente,</p>" .
                  "<p>{emitente}</p>";

      $chave = str_replace('-nfeproc', '', $id);

      $dt = new \DateTime(str_replace('T', ' ', $data));
      $search = array(
        '{destinatario}',
        '{data}',
        '{numero}',
        '{valor}',
        '{emitente}',
        '{chave}'
      );
      $replace = array(
        $destinatario_nome,
        $dt->format('d/m/Y'),
        $numero,
        number_format($valor, 2, ',', '.'),
        $this->session->userdata('empresa')->nome,
        $chave
      );
      $message = str_replace($search, $replace, $message);

      $corpo = str_replace('#TITULO#', $subject, $this->layout_email);
      $corpo = str_replace('#TEXTO#', $message, $corpo);

      $this->email->message($corpo);

      // Anexos
      $pathLogo = realpath($this->diretorio_logo.$this->session->userdata('empresa')->logo);//use somente imagens JPEG
        $danfe = new Danfe($xml, 'P', 'A4', $pathLogo, 'I', '');
        $danfe->montaDANFE();
        $pdf = $danfe->render();
      $this->email->attach($pdf, 'attachment', $chave.'.pdf', 'application/pdf');
      $this->email->attach($xml, 'attachment', $chave.'.xml', 'application/xml');
      
      $empresa = $this->session->userdata('empresa');
      $xml = $xml_c;
      $aEnd = array(
        'razao' => $empresa->nome,
        'logradouro' => $empresa->endereco,
        'numero' => $empresa->numero,
        'complemento' => $empresa->complemento,
        'bairro' => $empresa->bairro,
        'CEP' => $empresa->cep,
        'municipio' => $empresa->cidade,
        'UF' => $empresa->uf,
        'telefone' => limpa_telefone($empresa->telefone1),
        'email' => $empresa->email
      );
      $docxml = $xml;
      $daevento = new Daevento($docxml, 'P', 'A4', $pathLogo, 'I', '', '', $aEnd);
      $id = $daevento->chNFe . '';
      $cancelamento = $daevento->printDocument($id.'.pdf', 'S');
      $this->email->attach($cancelamento, 'attachment', 'cancelamento_'.$chave.'.pdf', 'application/pdf');
      $this->email->attach($xml, 'attachment', 'cancelamento_'.$chave.'.xml', 'application/xml');

      if (! $this->email->send())
        return false;
      return true;
    }
    else
      return false;
  }

  public function envia_email_nf_carta_correcao($xml, $xml_c)
  {
    $dom = new \DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xml);
    $root = $dom->documentElement;
    $name = $root->tagName;
    $dest = $dom->getElementsByTagName('dest')->item(0);
    $ide = $dom->getElementsByTagName('ide')->item(0);
    switch ($name) {
      case 'nfeProc':
      case 'NFe':
        $type = 'NFe';
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $id = substr($infNFe->getAttribute('Id'), 3) . '-' . strtolower($name);
        $numero = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $valor = $dom->getElementsByTagName('vNF')->item(0)->nodeValue;
        $data = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $subject = "CARTA DE CORREÇÃO - NFe n. " . $numero . " - " . $this->session->userdata('empresa')->nome;
        break;
    }
    //get email adresses from xml, if exists
    //may have one address in <dest><email>
    if (!empty($dest)) {
        $destinatario_nome = $dest->getElementsByTagName('xNome')->item(0)->nodeValue;
        $email = !empty($dest->getElementsByTagName('email')->item(0)->nodeValue) ?
            $dest->getElementsByTagName('email')->item(0)->nodeValue : '';
    }
    if (!empty($email)) {
        // if recieve more than one e-mail address.
        if (strpos($email, ';')) {
            $emails = explode(';', $email);

            $emails = array_map(function ($item) {
                return trim($item);
            }, $emails);

            $destinatarios = array_merge($this->addresses, $emails);
        } else {
            $destinatarios[] = $email;
        }
    }
    //may have others in <obsCont xCampo="email"><xTexto>fulano@yahoo.com.br</xTexto>
    $obs = $dom->getElementsByTagName('obsCont');
    foreach ($obs as $ob) {
        if (strtoupper($ob->getAttribute('xCampo')) === 'EMAIL') {
            $destinatarios[] = $ob->getElementsByTagName('xTexto')->item(0)->nodeValue;
        }
    }
    //xml may be a NFe or a CTe or a CCe nothing else
    if ($type != 'NFe' && $type != 'CTe' && $type != 'CCe') {
        $msg = "Você deve passar apenas uma NFe."
                . "Esse documento não foi reconhecido.";
        throw new \InvalidArgumentException($msg);
    }

    if (isset($destinatarios)) {
      $config['charset'] = 'utf-8';
      $config['mailtype'] = 'html';
      $this->email->initialize($config);
      $this->email->from('site@woisoft.com.br', 'Risa Shop - Envio de NF-e');
      foreach ($destinatarios as $dest) {
        $this->email->to($dest);
      }
      $this->email->bcc('bruno@woisoft.com.br');

      $this->email->subject($subject);

      $message = "" .
                  "<p><b>Prezados {destinatario},</b></p>" .
                  "<p>De acordo com as determinações legais vigentes, vimos por meio desta comunicar-lhe que a Nota Fiscal Eletrônica emitida em {data} com o número " .
                  "{numero}, de {emitente}, no valor de R$ {valor} e com a chave de acesso {chave} contêm irregularidades que estão destacadas e suas respectivas correções, solicitamos que sejam aplicadas essas correções ao executar seus lançamentos fiscais. </p>" .
                  "<p><b>O DANFE não é uma nota fiscal, nem substitui uma nota fiscal, " .
                  "servindo apenas como instrumento auxiliar para consulta da NF-e no " .
                  "Ambiente Nacional.</b></p>" .
                  "<p>Para mais detalhes, consulte: <a href=\"http://www.nfe.fazenda.gov.br/\">" .
                  "www.nfe.fazenda.gov.br</a></p>" .
                  "<br>" .
                  "<p>Atenciosamente,</p>" .
                  "<p>{emitente}</p>";

      $chave = str_replace('-nfeproc', '', $id);

      $dt = new \DateTime(str_replace('T', ' ', $data));
      $search = array(
        '{destinatario}',
        '{data}',
        '{numero}',
        '{valor}',
        '{emitente}',
        '{chave}'
      );
      $replace = array(
        $destinatario_nome,
        $dt->format('d/m/Y'),
        $numero,
        number_format($valor, 2, ',', '.'),
        $this->session->userdata('empresa')->nome,
        $chave
      );
      $message = str_replace($search, $replace, $message);

      $corpo = str_replace('#TITULO#', $subject, $this->layout_email);
      $corpo = str_replace('#TEXTO#', $message, $corpo);

      $this->email->message($corpo);

      // Anexos
      $pathLogo = realpath($this->diretorio_logo.$this->session->userdata('empresa')->logo);//use somente imagens JPEG
        $danfe = new Danfe($xml, 'P', 'A4', $pathLogo, 'I', '');
        $danfe->montaDANFE();
        $pdf = $danfe->render();
      $this->email->attach($pdf, 'attachment', $chave.'.pdf', 'application/pdf');
      $this->email->attach($xml, 'attachment', $chave.'.xml', 'application/xml');
      
      $empresa = $this->session->userdata('empresa');
      $xml = $xml_c;
      $aEnd = array(
        'razao' => $empresa->nome,
        'logradouro' => $empresa->endereco,
        'numero' => $empresa->numero,
        'complemento' => $empresa->complemento,
        'bairro' => $empresa->bairro,
        'CEP' => $empresa->cep,
        'municipio' => $empresa->cidade,
        'UF' => $empresa->uf,
        'telefone' => limpa_telefone($empresa->telefone1),
        'email' => $empresa->email
      );
      $docxml = $xml;
      $dacce = new Dacce($docxml, 'P', 'A4', $pathLogo, 'S', $aEnd);
      $id = $dacce->chNFe . '-CCE';
      $pdf = $dacce->render();
      $this->email->attach($pdf, 'attachment', 'CCe_'.$chave.'.pdf', 'application/pdf');
      $this->email->attach($xml, 'attachment', 'CCe_'.$chave.'.xml', 'application/xml');

      if (! $this->email->send())
        return false;
      return true;
    }
    else
      return false;
  }
}
  