<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class acesso extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('acesso_mod');
  }

	public function index()
	{
    $data = array(
      'form_action' => base_url().'acesso/',
      'form_recupera_senha_action' => base_url().'acesso/recupera_senha/'
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('cpf', 'CPF', 'required');
      if ($form->action == 'L') {
        $this->form_validation->set_rules('senha', 'Senha', 'required');
        if ($this->form_validation->run() == TRUE){
          $logou = $this->acesso_mod->login($form);
          if ($logou === TRUE) 
          {
            redirect(base_url().'home/','refresh');
            exit();
          }
          else
          {
            if ($logou == 'e_1') 
              $data['erro'] = 'CPF não encontrado.';
            elseif ($logou == 'e_2') 
              $data['erro'] = 'Seu usuário está inativado. Solicite ao administrador a ativação.';
            $data['form'] = $form;
          }
        }
        else
          $data['erro_validacao'] = validation_errors();
      }
      else{
        if ($this->form_validation->run() == TRUE){
          $res = $this->acesso_mod->recuperar_senha($form);
          if ($res == 'e_1') 
            $data['erro'] = 'CPF não encontrado.';
          elseif ($res == 'e_3') 
            $data['erro'] = 'Houve um erro ao enviar o e-mail. Contate o Administrador do Sistema.';
          else
            $data['email_recuperacao_senha'] = $res;
        }
        else
          $data['erro_validacao'] = validation_errors();
      }
    }
		$this->load->view('acesso/login', $data);
	}

  public function logoff() 
  {
    $this->acesso_mod->logoff();
    redirect(base_url().'acesso/','refresh');
  }

  public function verifica_sessao()
  {
    $this->acesso_mod->verifica_sessao();
  }

  public function verifica_sessao_ajax()
  {
    echo json_encode($this->acesso_mod->verifica_sessao_ajax());
  }

  public function configuracao_usuario()
  {
    $this->verifica_sessao();
    $diretorio = './assets/_UPLOADS/USUARIOS/'.$this->session->userdata('usuario')->id.'/FOTO/';
    $diretorio_pagina = base_url().'assets/_UPLOADS/USUARIOS/'.$this->session->userdata('usuario')->id.'/FOTO/';
    $mensagem = null;
    $data = array(
      'editar' => true,
      'url_form' => 'acesso/configuracao_usuario',
      'diretorio' => $diretorio_pagina,
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('email', 'E-mail', 'required');
      if ($this->form_validation->run() == TRUE){
        $erro_upload = false;
        $upload = array();
        if(isset($_FILES['foto']) && $_FILES['foto']['name'][0] != null){
          if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, TRUE);
          }
          $filesCount = count($_FILES['foto']['name']);
          for($i = 0; $i < $filesCount; $i++){
            $_FILES['arq']['name'] = $_FILES['foto']['name'][$i];
            $_FILES['arq']['type'] = $_FILES['foto']['type'][$i];
            $_FILES['arq']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
            $_FILES['arq']['error'] = $_FILES['foto']['error'][$i];
            $_FILES['arq']['size'] = $_FILES['foto']['size'][$i];

            $config['upload_path']          = $diretorio;
            $config['allowed_types']        = 'jpg|jpeg';
            $config['file_name']            = time();
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('arq')){
              $data['error'] = $this->upload->display_errors();
              $erro_upload = true;
              $data['form'] = $form;
            }
            else{
              $upload[] = $this->upload->data();
            }
          }
        }
        $res = $this->acesso_mod->editar_usuario_logado($form,$upload);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao alterar registro! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Registro alterado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          $this->acesso_mod->atualiza_sessao_usuario();
          if ($upload)
            $this->load->view('acesso/script_atualiza_foto_usuario');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $data['form'] = $this->acesso_mod->get_usuario_logado();
    $this->load->view('mensagens',$mensagem);
    $this->load->view('acesso/configuracao_usuario',$data);
  }

  public function alterar_senha()
  {
    $this->verifica_sessao();
    $mensagem = null;
    $data = array(
      'editar' => true,
      'url_form' => 'acesso/alterar_senha',
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('senha_atual', 'Senha Atual', 'required');
      $this->form_validation->set_rules('senha_nova_1', 'Nova Senha', 'required');
      $this->form_validation->set_rules('senha_nova_2', 'Confirmar Nova Senha', 'required');
      if ($this->form_validation->run() == TRUE && $form->senha_atual == $this->session->userdata('usuario')->senha){
        $res = $this->acesso_mod->alterar_senha($form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao alterar registro! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Registro alterado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          $this->acesso_mod->atualiza_sessao_usuario();
        }
      }
      elseif ($form->senha_atual != $this->session->userdata('usuario')->senha)
        $mensagem = array('texto' => 'A senha digitada não é igual à senha atual!', 'tipo'  => 'SweetAlert', 'class' => 'warning');
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $data['form'] = $this->acesso_mod->get_usuario_logado();
    $this->load->view('mensagens',$mensagem);
    $this->load->view('acesso/alterar_senha',$data);
  }
}
