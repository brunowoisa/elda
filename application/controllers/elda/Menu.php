<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

	public function administrativo()
	{
		$this->load->view('elda/administrativo/menu');
	}

}
