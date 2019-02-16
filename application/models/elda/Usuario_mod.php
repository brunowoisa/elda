<?php 
Class usuario_mod extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    // $this->db = $this->load->database('elda', TRUE);
  }

  public function get_usuarios()
  {
    $this->db->select('usuario.*')
             ->from('usuario');
    return $this->db->get()->result();
  }

  public function count_ativos()
  {
    $this->db->where('ativo', '1')
             ->from('usuario');
    return $this->db->count_all_results();
  }

  // public function verifica_usuario_pelo_cpf($cpf)
  // {
  //   $this->db->select('usuario.id, usuario.nome, usuario.apelido, usuario.cpf')
  //            ->from('empresa_contrato_usuario')
  //            ->join('usuario', 'usuario.id = empresa_contrato_usuario.id_usuario')
  //            ->join('empresa_contrato', 'empresa_contrato.id = empresa_contrato_usuario.id_empresa_contrato')
  //            ->where('empresa_contrato.id_sistema', $this->session->userdata('sistema')->id)
  //            ->where('empresa_contrato.id_empresa', $this->session->userdata('empresa')->id)
  //            ->where('usuario.cpf', limpa_cpf($cpf));
  //   $res = $this->db->get()->row();
  //   if (!$res) {
  //     $this->db->select('id, nome, apelido, cpf')
  //              ->from('usuario')
  //              ->where('usuario.cpf', limpa_cpf($cpf));
  //     $res = $this->db->get()->row();
  //     if (!$res) {
  //       return (object)['existente' => false, 'usuario' => null];
  //     }
  //     return (object)['existente' => false, 'usuario' => $res];
  //   }
  //   return (object)['existente' => true, 'usuario' => $res];
  // }

  public function get_usuario($id_usuario)
  {
    $this->db->select('usuario.*
                      ,usuario.senha_enviada_email
                      ,DATE_FORMAT(usuario.senha_enviada_email_datahora, "%d/%m/%Y %H:%i:%s") as senha_enviada_email_datahora
                      ')
             ->from('usuario')
             ->where('usuario.id', $id_usuario);
    $res = $this->db->get()->row();
    return $res;
  }

  public function novo($form)
  {
    $this->db->trans_start();
      $apelido = explode(' ', $form->nome);
      $tamanho = count($apelido);
      if ($tamanho == 1) {
        $apelido = $form->nome;
      }
      else {
        $apelido = $apelido[0].' '.$apelido[$tamanho-1];
      }
      $senha = substr(md5(uniqid(rand(), true)),0,5);
      // usuario
      $data = array(
        'nome' => $form->nome,
        'apelido' => $apelido,
        'administrador' => $form->administrador,
        'ativo' => $form->ativo,
        'email' => $form->email,
        'senha' => $senha,
        'cpf' => limpa_cpf($form->cpf),
      );
      $this->db->insert('usuario', $data);
      $id_usuario = $this->db->insert_id();
      // enviar e-mail com senha
      $this->enviar_senha_email($id_usuario);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_usuario;
  }

  public function editar($id_usuario,$form)
  {
    $this->db->trans_start();
      $apelido = explode(' ', $form->nome);
      $tamanho = count($apelido);
      if ($tamanho == 1) {
        $apelido = $form->nome;
      }
      else {
        $apelido = $apelido[0].' '.$apelido[$tamanho-1];
      }
      // usuario
      $data = array(
        'cpf' => limpa_cpf($form->cpf),
        'nome' => $form->nome,
        'apelido' => $apelido,
        'administrador' => $form->administrador,
        'ativo' => $form->ativo,
        'email' => $form->email,
      );
      $this->db->where('id', $id_usuario);
      $this->db->update('usuario', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }
  
  public function enviar_senha_email($id_usuario)
  {
    $usuario = $this->get_usuario($id_usuario);
    $this->load->model('email_mod');
    $message = 'Olá, '.$usuario->apelido.'!<br>Você acaba de receber os dados para acesso ao sistema Elda.<br><br><b>Acesso: </b><a href="https://www.woisoft.com.br/elda/">www.woisoft.com.br/elda/</a><br><b>CPF:</b> '.formata_cpf($usuario->cpf).'<br><b>Senha: </b>'.$usuario->senha;
    if($this->email_mod->envia_email($usuario->email,'Acesso ao Sistema Elda',$message)) {
      $data = array(
          'senha_enviada_email' => true,
          'senha_enviada_email_datahora' => date('Y-m-d H:i:s'),
          'senha_enviada_email_id_usuario' => $this->session->userdata('usuario')->id,
        );
        $this->db->where('id', $id_usuario);
        $this->db->update('usuario', $data);
    }
    if ($this->db->affected_rows())
      return true;
    return false;
  }
}
  