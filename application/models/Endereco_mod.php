<?php 
Class endereco_mod extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    // $this->db = $this->load->database('risa_shop', TRUE);
  }

  public function get_estados()
  {
    $this->db->select('estado.nome_estado as estado
                      ,estado.uf_estado as uf
                      ,estado.codigo_estado as ibge_estado')
             ->from('estado')
             ->order_by('nome_estado', 'ASC');
    return $this->db->get()->result();
  }

  public function get_cidades($uf)
  {
    $this->db->select('cidade.nome_cidade as cidade
                      ,cidade.ibge_cidade')
             ->from('cidade')
             ->join('estado', 'estado.id_estado = cidade.id_estado')
             ->where('estado.uf_estado', $uf)
             ->order_by('cidade.nome_cidade', 'ASC');
    return $this->db->get()->result();
  }

  // public function get_categorias_ativas()
  // {
  //   $this->db->select('*
  //                     ,DATE_FORMAT(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
  //                     ,DATE_FORMAT(last_change, "%d/%m/%Y %H:%i:%s") as last_change
  //                     ')
  //            ->from('categoria')
  //            ->where('ativo', true)
  //            ->where('id_empresa', $this->session->userdata('empresa')->id)
  //            ->order_by('nome', 'ASC');
  //   return $this->db->get()->result();
  // }

  // public function get_categoria($id_categoria)
  // {
  //   $this->db->select('*
  //                     ,DATE_FORMAT(cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
  //                     ,DATE_FORMAT(last_change, "%d/%m/%Y %H:%i:%s") as last_change
  //                     ')
  //            ->from('categoria')
  //            ->where('id', $id_categoria);
  //   $categoria = $this->db->get()->row();

  //   // Buscando dados do cadastro e last_change
  //   $db_w = $this->load->database('woisoft', TRUE);
  //   $categoria->cadastro_usuario = $db_w->select('nome')
  //                                       ->from('usuario')
  //                                       ->where('id', $categoria->cadastro_id_usuario)
  //                                       ->get()->row()->nome;
  //   $categoria->last_change_usuario = $db_w->select('nome')
  //                                          ->from('usuario')
  //                                          ->where('id', $categoria->last_change_id_usuario)
  //                                          ->get()->row()->nome;
  //   return $categoria;
  // }

  // public function novo($form)
  // {
  //   $this->db->trans_start();
  //     $data = array(
  //       'nome' => $form->nome,
  //       'descricao' => $form->descricao,
  //       'ativo' => $form->ativo,
  //       'cadastro' => date('Y-m-d H:i:s'),
  //       'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
  //       'last_change' => date('Y-m-d H:i:s'),
  //       'last_change_id_usuario' => $this->session->userdata('usuario')->id,
  //       'id_empresa' => $this->session->userdata('empresa')->id,
  //     );
  //     $this->db->insert('categoria', $data);
  //     $id_categoria = $this->db->insert_id();
  //   $this->db->trans_complete();
  //   if ($this->db->trans_status() === FALSE)
  //     return false;
  //   else
  //     return $id_categoria;
  // }

  // public function editar($id_categoria,$form)
  // {
  //   $this->db->trans_start();
  //     $data = array(
  //       'nome' => $form->nome,
  //       'descricao' => $form->descricao,
  //       'ativo' => $form->ativo,
  //       'last_change' => date('Y-m-d H:i:s'),
  //       'last_change_id_usuario' => $this->session->userdata('usuario')->id,
  //     );
  //     $this->db->where('id', $id_categoria);
  //     $this->db->update('categoria', $data);
  //   $this->db->trans_complete();
  //   if ($this->db->trans_status() === FALSE)
  //     return false;
  //   else
  //     return true;
  // }
}
  