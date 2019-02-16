<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class catalogo extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    // $this->load->model('elda/Categoria_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

	public function index()
	{
    $data = array(
      // 'grid' => $this->Categoria_mod->get_categorias(),
    );
		$this->load->view('elda/cursos/catalogo/grid',$data);
	}

}
