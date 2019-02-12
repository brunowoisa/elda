<?php 
Class usuario_mod extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    // $this->db = $this->load->database('elda', TRUE);
  }

  public function get_usuarios()
  {
    $this->db->select('usuario.id
                      ,usuario.nome
                      ,usuario.cpf
                      ,empresa_contrato_usuario.administrador
                      ,empresa_contrato_usuario.ativo
                      ,empresa_contrato_usuario.email')
             ->from('empresa_contrato_usuario')
             ->join('empresa_contrato', 'empresa_contrato.id = empresa_contrato_usuario.id_empresa_contrato')
             ->join('usuario', 'usuario.id = empresa_contrato_usuario.id_usuario')
             ->where('empresa_contrato.id_sistema', $this->session->userdata('sistema')->id)
             ->where('empresa_contrato.id_empresa', $this->session->userdata('empresa')->id);
    return $this->db->get()->result();
  }

  public function verifica_usuario_pelo_cpf($cpf)
  {
    $this->db->select('usuario.id, usuario.nome, usuario.apelido, usuario.cpf')
             ->from('empresa_contrato_usuario')
             ->join('usuario', 'usuario.id = empresa_contrato_usuario.id_usuario')
             ->join('empresa_contrato', 'empresa_contrato.id = empresa_contrato_usuario.id_empresa_contrato')
             ->where('empresa_contrato.id_sistema', $this->session->userdata('sistema')->id)
             ->where('empresa_contrato.id_empresa', $this->session->userdata('empresa')->id)
             ->where('usuario.cpf', limpa_cpf($cpf));
    $res = $this->db->get()->row();
    if (!$res) {
      $this->db->select('id, nome, apelido, cpf')
               ->from('usuario')
               ->where('usuario.cpf', limpa_cpf($cpf));
      $res = $this->db->get()->row();
      if (!$res) {
        return (object)['existente' => false, 'usuario' => null];
      }
      return (object)['existente' => false, 'usuario' => $res];
    }
    return (object)['existente' => true, 'usuario' => $res];
  }

  public function get_usuario($id_usuario)
  {
    $this->db->select('usuario.id
                      ,usuario.nome
                      ,usuario.apelido
                      ,usuario.cpf
                      ,usuario.senha
                      ,empresa_contrato_usuario.administrador
                      ,empresa_contrato_usuario.ativo
                      ,empresa_contrato_usuario.email
                      ,empresa_contrato.id as id_empresa_contrato
                      ,empresa_contrato_usuario.senha_enviada_email
                      ,DATE_FORMAT(empresa_contrato_usuario.senha_enviada_email_datahora, "%d/%m/%Y %H:%i:%s") as senha_enviada_email_datahora
                      ')
             ->from('empresa_contrato_usuario')
             ->join('usuario', 'usuario.id = empresa_contrato_usuario.id_usuario')
             ->join('empresa_contrato', 'empresa_contrato.id = empresa_contrato_usuario.id_empresa_contrato')
             ->where('empresa_contrato.id_sistema', $this->session->userdata('sistema')->id)
             ->where('empresa_contrato.id_empresa', $this->session->userdata('empresa')->id)
             ->where('usuario.id', $id_usuario);
    $res = $this->db->get()->row();
    return $res;
  }

  public function novo($form)
  {
    $this->db->trans_start();
      $existente = $this->verifica_usuario_pelo_cpf($form->cpf);
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
        'nome' => $form->nome,
        'apelido' => $apelido,
      );
      if ($existente->usuario == null) {
        //insert
        $senha = substr(md5(uniqid(rand(), true)),0,5);
        $data['senha'] = $senha;
        $data['cpf'] = limpa_cpf($form->cpf);
        $this->db->insert('usuario', $data);
        $id_usuario = $this->db->insert_id();
      }
      else {
        // update
        $this->db->where('cpf', limpa_cpf($form->cpf));
        $this->db->update('usuario', $data);
        $id_usuario = $existente->usuario->id;
      }
      // empresa_contrato_usuario
      $id_empresa_contrato = $this->db->select('id')
                                      ->from('empresa_contrato')
                                      ->where('id_empresa', $this->session->userdata('empresa')->id)
                                      ->where('id_sistema', $this->session->userdata('sistema')->id)
                                      ->get()->row()->id;
      $data = array(
        'id_empresa_contrato' => $id_empresa_contrato,
        'id_usuario' => $id_usuario,
        'administrador' => $form->administrador,
        'ativo' => $form->ativo,
        'email' => $form->email,
      );
      $this->db->insert('empresa_contrato_usuario', $data);
      // enviar e-mail com senha
      $this->enviar_senha_email($id_usuario);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_usuario;
  }

  public function enviar_senha_email($id_usuario)
  {
    $usuario = $this->get_usuario($id_usuario);
    $this->load->model('email_mod');
    $message = 'Olá, '.$usuario->apelido.'!<br>Você acaba de receber os dados para acesso ao sistema Elda.<br><br><b>Acesso: </b><a href="https://www.woisoft.com.br/woisoft/">www.woisoft.com.br/woisoft/</a><br><b>CPF:</b> '.formata_cpf($usuario->cpf).'<br><b>Senha: </b>'.$usuario->senha.'<br><br>Este é um disparo automático do sistema, gentileza não responder.';
    if($this->email_mod->envia_email($usuario->email,'Acesso ao Sistema Elda',$message)) {
      $data = array(
          'senha_enviada_email' => true,
          'senha_enviada_email_datahora' => date('Y-m-d H:i:s'),
          'senha_enviada_email_id_usuario' => $this->session->userdata('usuario')->id,
        );
        $this->db->where('id_empresa_contrato', $usuario->id_empresa_contrato);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('empresa_contrato_usuario', $data);
    }
    if ($this->db->affected_rows())
      return true;
    return false;
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
        'nome' => $form->nome,
        'apelido' => $apelido,
      );
      $this->db->where('id', $id_usuario);
      $this->db->update('usuario', $data);
      // empresa_contrato_usuario
      $id_empresa_contrato = $this->db->select('id')
                                      ->from('empresa_contrato')
                                      ->where('id_empresa', $this->session->userdata('empresa')->id)
                                      ->where('id_sistema', $this->session->userdata('sistema')->id)
                                      ->get()->row()->id;
      $data = array(
        'administrador' => $form->administrador,
        'ativo' => $form->ativo,
        'email' => $form->email,
      );
      $this->db->where('id_usuario', $id_usuario);
      $this->db->where('id_empresa_contrato', $id_empresa_contrato);
      $this->db->update('empresa_contrato_usuario', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }
}
  