<?php 
use \NFePHP\DA\NFe\Danfe;
use NFePHP\DA\NFe\Daevento;
use NFePHP\DA\NFe\Dacce;
Class email_mod extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->layout_email = '';
    $this->seta_layout_email_elda();
    $this->load->library('email');
  }

  public function envia_email($to,$subject,$message,$cc=null,$bcc=null){
    $config['charset'] = 'utf-8';
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->from('site@woisoft.com.br', 'Elda Treinamentos');
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


  private function seta_layout_email_elda(){
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
                              <img src="https://www.woisoft.com.br/email/topo_elda.jpg" width="705" height="200" border="0" style="display: block;">
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
}
  