<?php 
Class acesso_mod extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  /**
   * @param  [object()]
   * @return [boolean] false - Dados informados não foram encontrados
   * @return [boolean] true - login realizado com sucesso
   */
  public function login($form){
    $form->cpf = limpa_cpf($form->cpf);
    $this->db->select('*')
             ->from('usuario')
             ->where('usuario.cpf', $form->cpf)
             ->where('senha', md5($form->senha));
    $usuario = $this->db->get()->row();
    if ($usuario == null)
      return false;
    else 
    {
      $this->session->set_userdata('usuario', $usuario);
      return true;
    }
  }
  
  // /**
  //  * @param  [object()]
  //  * @return [sting] e_3 - CPF não encontrado
  //  * @return [sting] e_4 - E-mail não enviado
  //  * @return [sting] $email - E-mail enviado com sucesso
  //  */
  // public function recuperar_senha($form)
  // {
  //   $this->load->model('email_mod');
  //   $form->cpf = limpa_cpf($form->cpf);
  //   $this->db->select('*')
  //            ->from('usuario')
  //            ->where('usuario.cpf', $form->cpf);
  //   $usuario = $this->db->get()->row();
  //   if ($usuario == null)
  //     return 'e_3';
  //   else 
  //   {
  //     $msg = 'Olá!<br><br>Parece que você solictou a recuperação da sua senha de acesso ao sistema Elda:<br><br>CPF: '.$usuario->cpf.'<br>Senha: '.$usuario->senha.'<br><br>Caso você não tenha solicitado a recuperação, fique tranquilo, seus dados de acesso não serão alterados.<br>Este é um disparo automático do sistema, gentileza não responder.';
  //     $res = $this->email_mod->envia_email($usuario->email_recuperacao_senha,'Recuperação de Senha - WoiSoft Sistemas',$msg,null,'bruno@woisoft.com.br');
  //     if ($res) 
  //       return $usuario->email_recuperacao_senha;
  //     return 'e_4';
  //   }
  // }

  /**
   * @return [boolean] true - operação concluída
   */
  public function logoff()
  {
    $this->session->sess_destroy();
    foreach ($this->session->userdata() as $key => $value) 
    {
      $this->session->unset_userdata($key);
    }
    return true;
  }

  /**
   * @return [boolean] true - resultado da verificação, ou realiza o logoff em caso de falha.
   */
  public function verifica_sessao(){
    if($this->session->has_userdata('usuario')){
      $usuario = $this->session->userdata('usuario');
      $this->db->select('*');
      $this->db->from('usuario');
      $this->db->where('cpf', $usuario->cpf);
      $this->db->where('senha', $usuario->senha);
      $total = $this->db->count_all_results();
      if($total == 1)
        return true;
    }
    $this->logoff();
    redirect(base_url().'acesso','refresh');
    exit();
  }

  /**
   * @return boolean - resultado da verificação
   */
  public function verifica_sessao_ajax(){
    if($this->session->has_userdata('usuario')){
      $usuario = $this->session->userdata('usuario');
      $this->db->select('*');
      $this->db->from('usuario');
      $this->db->where('cpf', $usuario->cpf);
      $this->db->where('senha', $usuario->senha);
      $total = $this->db->count_all_results();
      if($total == 1)
        return true;
    }
    $this->logoff();
    return false;
  }

  // public function get_usuario_logado()
  // {
  //   $this->db->select('*')
  //            ->from('usuario')
  //            ->where('usuario.id', $this->session->userdata('usuario')->id);
  //   return $this->db->get()->row();
  // }

  // public function editar_usuario_logado($form,$upload)
  // {
  //   $this->db->trans_start();
  //     $data = array(
  //       'telefone1' => $form->telefone1,
  //       'telefone2' => $form->telefone2,
  //       'email' => $form->email,
  //     );
  //     $this->db->where('id_usuario', $this->session->userdata('usuario')->id);
  //     $this->db->where('id_empresa_contrato', $form->id_empresa_contrato);
  //     $this->db->update('empresa_contrato_usuario', $data);
  //     if($upload){
  //       foreach ($upload as $key => $foto) {
  //         $data_u['foto'] = $foto['file_name'];
  //         $this->db->where('id', $this->session->userdata('usuario')->id);
  //         $this->db->update('usuario', $data_u);
  //       }
  //     }
  //   $this->db->trans_complete();
  //   if ($this->db->trans_status() === FALSE)
  //     return false;
  //   else
  //     return true;
  // }

  // public function alterar_senha($form)
  // {
  //   $this->db->trans_start();
  //     $data = array(
  //       'senha' => $form->senha_nova_1,
  //     );
  //     $this->db->where('id', $this->session->userdata('usuario')->id);
  //     $this->db->update('usuario', $data);
  //   $this->db->trans_complete();
  //   if ($this->db->trans_status() === FALSE)
  //     return false;
  //   else
  //     return true;
  // }

}
  