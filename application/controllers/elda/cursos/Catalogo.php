<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class catalogo extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/curso_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

	public function index()
	{
    $this->session->set_userdata('pesquisa_catalogo', '');
    $form = $this->input->post();
    if ($form)
      $this->session->set_userdata('pesquisa_catalogo', $form['pesquisa']);
    $data = array(
      'grid' => $this->curso_mod->get_catalogo(),
      'url_form' => 'elda/cursos/catalogo/'
    );
		$this->load->view('elda/cursos/catalogo/grid',$data);
	}

  public function ajax_incricao()
  {
    $id_curso = $this->input->post('id_curso');
    echo json_encode($this->curso_mod->inscrever($id_curso));
  }

}
