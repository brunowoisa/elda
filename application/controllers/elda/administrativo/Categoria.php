<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class categoria extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/Categoria_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
    $this->links = array(
      'novo' => 'elda/administrativo/categoria/novo/',
      'atualizar' => '',
      'voltar' => 'elda/administrativo/categoria/',
      'fechar' => 'elda/menu/administrativo/'
    );
  }

	public function index()
	{
    $this->links['atualizar'] = 'elda/administrativo/categoria/';
    $this->links['voltar'] = '';
    $data = array(
      'links' => $this->links,
      'grid' => $this->Categoria_mod->get_categorias(),
    );
		$this->load->view('elda/administrativo/categoria/grid',$data);
	}

  public function novo()
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/categoria/novo/';
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/categoria/novo/',
      'form' => null,
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->Categoria_mod->novo($form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $this->session->set_flashdata('sucesso_cadastro', true);
          redirect(base_url().'elda/administrativo/categoria/editar/'.$res,'location');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/categoria/form',$data);
  }

  public function editar($id_categoria)
  {
    $mensagem = null;
    $this->links['atualizar'] = 'elda/administrativo/categoria/editar/'.$id_categoria;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/categoria/editar/'.$id_categoria,
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->Categoria_mod->editar($id_categoria,$form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao alterar registro! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Registro alterado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $data['form'] = $this->Categoria_mod->get_categoria($id_categoria);
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/categoria/form',$data);
  }

}
