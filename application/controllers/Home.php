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
		$this->load->view('home');
	}
}
