<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class endereco extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('endereco_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

  public function ajax_get_estados()
  {
    $res = $this->endereco_mod->get_estados();
    echo json_encode($res);
  }

  public function ajax_get_cidades()
  {
    $uf = $this->input->post('uf');
    $res = $this->endereco_mod->get_cidades($uf);
    echo json_encode($res);
  }
}
