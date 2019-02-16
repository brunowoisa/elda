<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class curso extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/curso_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
    $this->links = array(
      'novo' => 'elda/administrativo/curso/novo/',
      'atualizar' => '',
      'voltar' => 'elda/administrativo/curso/',
      'fechar' => 'elda/menu/administrativo/'
    );
  }

	public function index()
	{
    $this->links['atualizar'] = 'elda/administrativo/curso/';
    $this->links['voltar'] = '';
    $data = array(
      'links' => $this->links,
      'grid' => $this->curso_mod->get_cursos(),
    );
		$this->load->view('elda/administrativo/curso/grid',$data);
	}

  public function novo()
  {
    $this->load->model('elda/categoria_mod');
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/novo/';
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/curso/novo/',
      'form' => null,
      'categorias' => $this->categoria_mod->get_categorias_ativas(),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('id_categoria', 'Categoria', 'required');
      $this->form_validation->set_rules('instrutor', 'Instrutor', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->novo($form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          $this->session->set_flashdata('sucesso_cadastro', true);
          redirect(base_url().'elda/administrativo/curso/estrutura_curso/'.$res,'location');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form',$data);
  }

  public function editar($id_curso)
  {
    $mensagem = null;
    $this->links['atualizar'] = 'elda/administrativo/curso/editar/'.$id_curso;
    $this->links['voltar'] = 'elda/administrativo/curso/estrutura_curso/'.$id_curso;
    $this->links['novo'] = '';
    $this->load->model('elda/categoria_mod');
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/editar/'.$id_curso,
      'categorias' => $this->categoria_mod->get_categorias_ativas(),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('id_categoria', 'Categoria', 'required');
      $this->form_validation->set_rules('instrutor', 'Instrutor', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->editar($id_curso,$form);
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
    $data['form'] = $this->curso_mod->get_curso($id_curso);
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form',$data);
  }
   
  public function estrutura_curso($id_curso)
  {
    $mensagem = null;
    $this->links['atualizar'] = 'elda/administrativo/curso/estrutura_curso/'.$id_curso;
    $this->links['novo'] = '';
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/estrutura_curso/'.$id_curso,
    );
    
    $data['curso'] = $this->curso_mod->get_curso($id_curso);
    $data['unidades'] = $this->curso_mod->get_unidades($id_curso);
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-estrutura',$data);
  }

  public function novo_unidade($id_curso)
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/novo_unidade/'.$id_curso;
    $this->links['voltar'] = 'elda/administrativo/curso/estrutura_curso/'.$id_curso;
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/curso/novo_unidade/'.$id_curso,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->novo_unidade($id_curso,$form);
        if(!$res){
          $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          $this->session->set_flashdata('sucesso_cadastro', true);
          redirect(base_url().'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$res,'location');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-unidade',$data);
  }

  public function editar_unidade($id_curso,$id_unidade)
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $this->links['voltar'] = 'elda/administrativo/curso/estrutura_curso/'.$id_curso;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'videos' => $this->curso_mod->get_unidade_videos($id_unidade),
      'materiais' => $this->curso_mod->get_unidade_materiais($id_unidade),
      'atividades' => $this->curso_mod->get_unidade_atividades($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->editar_unidade($id_unidade,$form);
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
    $data['form'] = $this->curso_mod->get_unidade($id_unidade);
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-unidade',$data);
  }

  public function novo_video($id_curso,$id_unidade)
  {
    $diretorio = './assets/_UPLOADS/CURSOS/'.$id_curso.'/VIDEOS/';
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/novo_video/'.$id_curso.'/'.$id_unidade;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/curso/novo_video/'.$id_curso.'/'.$id_unidade,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      $this->form_validation->set_rules('tipo', 'Tipo de Envio', 'required');
      if ($form->tipo == 'I') 
        $this->form_validation->set_rules('video_incorporar', 'Vídeo', 'required');
      if ($this->form_validation->run() == TRUE){
        if ($form->tipo == 'U') {
          $erro_upload = false;
          $upload = array();
          if(isset($_FILES['video']) && $_FILES['video']['name'][0] != null){
            if (!is_dir($diretorio)) {
              mkdir($diretorio, 0777, TRUE);
            }
            $filesCount = count($_FILES['video']['name']);
            for($i = 0; $i < $filesCount; $i++){
              $_FILES['arq']['name'] = $_FILES['video']['name'][$i];
              $_FILES['arq']['type'] = $_FILES['video']['type'][$i];
              $_FILES['arq']['tmp_name'] = $_FILES['video']['tmp_name'][$i];
              $_FILES['arq']['error'] = $_FILES['video']['error'][$i];
              $_FILES['arq']['size'] = $_FILES['video']['size'][$i];

              $config['upload_path']          = $diretorio;
              $config['allowed_types']        = 'rv|jp2|j2k|jpf|jpg2|jpx|jpm|mj2|mjp2|mpeg|mpg|mpe|qt|mov|avi|movie|3g2|3gp|mp4|f4v|flv|webm|wmv|ogg|wma';
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
            if (!$erro_upload) {
              $res_novo_video = $this->curso_mod->novo_video($id_unidade,$form,$upload);
            }
            else {
              $mensagem = array('texto' => 'Houve um erro inesperado ao enviar o vídeo. Tente novamente.', 'tipo'  => 'SweetAlert', 'class' => 'error');
              $data['form'] = $form;
            }
          }
          else {
            $mensagem = array('texto' => 'O campo Vídeo é obrigatório.', 'tipo'  => 'SweetAlert', 'class' => 'error');
            $data['form'] = $form;
          }
        }
        else {
          $res_novo_video = $this->curso_mod->novo_video($id_unidade,$form,false);
        }

        if(!$res_novo_video){
          $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
        }
        else{
          $mensagem = array('texto' => 'Sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          $this->session->set_flashdata('sucesso_cadastro', true);
          redirect(base_url().'elda/administrativo/curso/editar_video/'.$id_curso.'/'.$id_unidade.'/'.$res_novo_video,'location');
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-video',$data);
  }

  public function editar_video($id_curso,$id_unidade,$id_video)
  {
    $diretorio_pagina = base_url().'assets/_UPLOADS/CURSOS/'.$id_curso.'/VIDEOS/';
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/editar_video/'.$id_curso.'/'.$id_unidade.'/'.$id_video;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/editar_video/'.$id_curso.'/'.$id_unidade.'/'.$id_video,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'diretorio' => $diretorio_pagina,
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      $this->form_validation->set_rules('tipo', 'Tipo de Envio', 'required');
      if ($form->tipo == 'I') 
        $this->form_validation->set_rules('video_incorporar', 'Vídeo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->editar_video($id_video,$form);
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
    $data['form'] = $this->curso_mod->get_video($id_video);
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-video',$data);
  }

  public function novo_material($id_curso,$id_unidade)
  {
    $diretorio = './assets/_UPLOADS/CURSOS/'.$id_curso.'/MATERIAIS/';
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/novo_material/'.$id_curso.'/'.$id_unidade;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/curso/novo_material/'.$id_curso.'/'.$id_unidade,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $erro_upload = false;
        $upload = array();
        if(isset($_FILES['arquivo']) && $_FILES['arquivo']['name'][0] != null){
          if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, TRUE);
          }
          $filesCount = count($_FILES['arquivo']['name']);
          for($i = 0; $i < $filesCount; $i++){
            $_FILES['arq']['name'] = $_FILES['arquivo']['name'][$i];
            $_FILES['arq']['type'] = $_FILES['arquivo']['type'][$i];
            $_FILES['arq']['tmp_name'] = $_FILES['arquivo']['tmp_name'][$i];
            $_FILES['arq']['error'] = $_FILES['arquivo']['error'][$i];
            $_FILES['arq']['size'] = $_FILES['arquivo']['size'][$i];

            $config['upload_path']          = $diretorio;
            $config['allowed_types']        = '*';
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
          if (!$erro_upload) {
            $res = $this->curso_mod->novo_material($id_unidade,$form,$upload);
            if(!$res){
              $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
            }
            else{
              $mensagem = array('texto' => 'Sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
              $this->session->set_flashdata('sucesso_cadastro', true);
              redirect(base_url().'elda/administrativo/curso/editar_material/'.$id_curso.'/'.$id_unidade.'/'.$res,'location');
            }
          }
          else {
            $mensagem = array('texto' => 'Houve um erro inesperado ao enviar o arquivo. Tente novamente.', 'tipo'  => 'SweetAlert', 'class' => 'error');
            $data['form'] = $form;
          }
        }
        else {
          $mensagem = array('texto' => 'O campo Arquivo é obrigatório.', 'tipo'  => 'SweetAlert', 'class' => 'error');
          $data['form'] = $form;
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-material',$data);
  }

  public function editar_material($id_curso,$id_unidade,$id_material)
  {
    $diretorio_pagina = base_url().'assets/_UPLOADS/CURSOS/'.$id_curso.'/MATERIAIS/';
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/editar_material/'.$id_curso.'/'.$id_unidade.'/'.$id_material;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/editar_material/'.$id_curso.'/'.$id_unidade.'/'.$id_material,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'diretorio' => $diretorio_pagina,
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        $res = $this->curso_mod->editar_material($id_material,$form);
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
    $data['form'] = $this->curso_mod->get_material($id_material);
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-material',$data);
  }

  public function novo_atividade($id_curso,$id_unidade)
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/novo_atividade/'.$id_curso.'/'.$id_unidade;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/curso/novo_atividade/'.$id_curso.'/'.$id_unidade,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('obrigatoria', 'Tipo', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        if (!$erro_upload) {
          $res = $this->curso_mod->novo_atividade($id_unidade,$form,$upload);
          if(!$res){
            $mensagem = array('texto' => 'Erro ao cadastrar! Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
          }
          else{
            $mensagem = array('texto' => 'Sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
            $this->session->set_flashdata('sucesso_cadastro', true);
            redirect(base_url().'elda/administrativo/curso/editar_atividade/'.$id_curso.'/'.$id_unidade.'/'.$res,'location');
          }
        }
        else {
          $mensagem = array('texto' => 'Houve um erro inesperado ao enviar o arquivo. Tente novamente.', 'tipo'  => 'SweetAlert', 'class' => 'error');
          $data['form'] = $form;
        }
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-atividade',$data);
  }

  public function editar_atividade($id_curso,$id_unidade,$id_atividade)
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/curso/editar_atividade/'.$id_curso.'/'.$id_unidade.'/'.$id_atividade;
    $this->links['voltar'] = 'elda/administrativo/curso/editar_unidade/'.$id_curso.'/'.$id_unidade;
    $data = array(
      'links' => $this->links,
      'editar' => true,
      'url_form' => 'elda/administrativo/curso/editar_atividade/'.$id_curso.'/'.$id_unidade.'/'.$id_atividade,
      'form' => null,
      'curso' => $this->curso_mod->get_curso($id_curso),
      'unidade' => $this->curso_mod->get_unidade($id_unidade),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('titulo', 'Título', 'required');
      $this->form_validation->set_rules('obrigatoria', 'Tipo', 'required');
      $this->form_validation->set_rules('ativo', 'Ativo', 'required');
      if ($this->form_validation->run() == TRUE){
        // epre($form);
        $res = $this->curso_mod->editar_atividade($id_atividade,$form);
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
    $data['form'] = $this->curso_mod->get_atividade($id_atividade);
    $data['questoes'] = $this->curso_mod->get_questoes($id_atividade);
    if($this->session->flashdata('sucesso_cadastro'))
      $mensagem = array('texto' => 'Cadastro realizado com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/curso/form-atividade',$data);
  }

}
