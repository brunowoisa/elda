<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sala_treinamento extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/curso_mod');
    $this->load->model('acesso_mod');
    $this->acesso_mod->verifica_sessao();
  }

	public function index($id_inscricao=false)
	{
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    if ($id_inscricao) {
      $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
      $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
      $data['unidades'] = $this->curso_mod->get_unidades($curso_inscricao->id_curso);
      $data['videos_assistidos'] = $this->curso_mod->get_array_videos_assistidos($id_inscricao);
      $data['materiais_baixados'] = $this->curso_mod->get_array_materiais_baixados($id_inscricao);
      $data['curso_nao_setado'] = false;
      $data['id_inscricao'] = $id_inscricao;
    }
    else{
      $data['progressos'] = $this->curso_mod->get_progresso_cursos($this->session->userdata('usuario')->id);
      $data['curso_nao_setado'] = true;
    }
    $this->load->view('elda/cursos/sala_treinamento/grid',$data);
  }

  public function assistir_video($id_inscricao,$id_video)
  {
    $this->curso_mod->marca_video_assistido($id_inscricao,$id_video);
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/index/'.$id_inscricao);
    $data['diretorio'] = base_url().'assets/_UPLOADS/CURSOS/'.$curso_inscricao->id_curso.'/VIDEOS/';
    $data['id_inscricao'] = $id_inscricao;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['video'] = $this->curso_mod->get_video($id_video);
    $this->load->view('elda/cursos/sala_treinamento/assistir_video',$data);
  }

  public function baixar_material_complementar($id_inscricao,$id_material)
  {
    $this->curso_mod->marca_material_baixado($id_inscricao,$id_material);
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $material = $this->curso_mod->get_material($id_material);
    $arquivo = './assets/_UPLOADS/CURSOS/'.$curso_inscricao->id_curso.'/MATERIAIS/'.$material->material;
    $info_file = pathinfo($arquivo);
    $extensao = $info_file['extension'];
    header("Content-Length: ".filesize($arquivo));
    header("Content-Disposition: attachment; filename=".basename($material->titulo.'.'.$extensao));
    readfile($arquivo);
    exit();
  }

  // public function ajax_incricao()
  // {
  //   $id_curso = $this->input->post('id_curso');
  //   echo json_encode($this->curso_mod->inscrever($id_curso));
  // }

}
