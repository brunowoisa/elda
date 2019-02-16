<?php 
Class categoria_mod extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('elda', TRUE);
  }

  public function get_categorias()
  {
    $this->db->select('*
                      ,DATE_FORMAT(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ')
             ->from('categoria')
             ->order_by('nome', 'ASC');
    return $this->db->get()->result();
  }

  public function get_categorias_ativas()
  {
    $this->db->select('*
                      ,DATE_FORMAT(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ')
             ->from('categoria')
             ->where('ativo', true)
             ->order_by('nome', 'ASC');
    return $this->db->get()->result();
  }

  public function count_ativos()
  {
    $this->db->where('ativo', '1')
             ->from('categoria');
    return $this->db->count_all_results();
  }

  public function get_categoria($id_categoria)
  {
    $this->db->select('categoria.*
                      ,DATE_FORMAT(categoria.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(categoria.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario
                      ')
             ->from('categoria')
             ->where('categoria.id', $id_categoria)
             ->join('usuario as uc', 'uc.id = categoria.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = categoria.last_change_id_usuario');
    return $this->db->get()->row();
  }

  public function novo($form)
  {
    $this->db->trans_start();
      $data = array(
        'nome' => $form->nome,
        'descricao' => $form->descricao,
        'ativo' => $form->ativo,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->insert('categoria', $data);
      $id_categoria = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_categoria;
  }

  public function editar($id_categoria,$form)
  {
    $this->db->trans_start();
      $data = array(
        'nome' => $form->nome,
        'descricao' => $form->descricao,
        'ativo' => $form->ativo,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->where('id', $id_categoria);
      $this->db->update('categoria', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }
}
  