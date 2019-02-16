<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

	public function index()
	{
    $this->load->model('elda/usuario_mod');
    $this->load->model('elda/categoria_mod');
    $this->load->model('elda/curso_mod');
    $data = array(
      'usuarios_ativos'           => $this->usuario_mod->count_ativos(),
      'categorias_ativas'         => $this->categoria_mod->count_ativos(),
      'cursos_ativos'             => $this->curso_mod->count_ativos(),
      'iscricoes_realizadas'      => 0,
      'treinamentos_em_andamento' => 0,
      'treinamentos_concluidos'   => 0,
    );
		$this->load->view('home', $data);
	}
}
