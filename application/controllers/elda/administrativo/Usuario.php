<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuario extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/usuario_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
    $this->links = array(
      'novo' => 'elda/administrativo/usuario/novo/',
      'atualizar' => '',
      'voltar' => 'elda/administrativo/usuario/',
      'fechar' => 'elda/menu/administrativo/'
    );
  }

	public function index()
	{
    $this->links['atualizar'] = 'elda/administrativo/usuario/';
    $this->links['voltar'] = '';
    $data = array(
      'links' => $this->links,
      'grid' => $this->usuario_mod->get_usuarios(),
    );
		$this->load->view('elda/administrativo/usuario/grid',$data);
	}

  public function novo()
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/usuario/novo/';
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/usuario/novo/',
      'form' => null,
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('cpf', 'CPF', 'required');
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      $this->form_validation->set_rules('administrador', 'Tipo de Usuário', 'required');
      $this->form_validation->set_rules('email', 'E-mail', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->usuario_mod->novo($form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $this->session->set_flashdata('sucesso_cadastro', true);
          redirect(base_url().'elda/administrativo/usuario/editar/'.$res,'location');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/usuario/form',$data);
  }

  public function editar($id_usuario)
  {
    $mensagem = null;
    $this->links['atualizar'] = 'elda/administrativo/usuario/editar/'.$id_usuario;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/usuario/editar/'.$id_usuario,
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      $this->form_validation->set_rules('administrador', 'Tipo de Usuário', 'required');
      $this->form_validation->set_rules('email', 'E-mail', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->usuario_mod->editar($id_usuario,$form);
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
    $data['form'] = $this->usuario_mod->get_usuario($id_usuario);
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/usuario/form',$data);
  }

  public function ajax_verifica_usuario_pelo_cpf()
  {
    $cpf = $this->input->post('cpf');
    echo json_encode($this->usuario_mod->verifica_usuario_pelo_cpf($cpf));
  }

  public function ajax_enviar_senha_email()
  {
    $id_usuario = $this->input->post('id_usuario');
    echo json_encode($this->usuario_mod->enviar_senha_email($id_usuario));
  }

}
