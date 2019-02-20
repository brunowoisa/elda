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

  public function atividade($id_inscricao,$id_atividade)
  {
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/index/'.$id_inscricao);
    $data['diretorio'] = base_url().'assets/_UPLOADS/CURSOS/'.$curso_inscricao->id_curso.'/VIDEOS/';
    $data['id_inscricao'] = $id_inscricao;
    $data['id_atividade'] = $id_atividade;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['atividade'] = $this->curso_mod->get_atividade($id_atividade);
    $data['tentativas'] = $this->curso_mod->get_inscricao_atividades($id_inscricao,$id_atividade);
    $this->load->view('elda/cursos/sala_treinamento/atividade_grid',$data);
  }

  public function realizar_atividade($id_inscricao,$id_atividade,$id_inscricao_atividade=false)
  {
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['bloqueado'] = false;
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/atividade/'.$id_inscricao.'/'.$id_atividade);
    $data['diretorio'] = base_url().'assets/_UPLOADS/CURSOS/'.$curso_inscricao->id_curso.'/VIDEOS/';
    $data['id_inscricao'] = $id_inscricao;
    $data['id_atividade'] = $id_atividade;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['atividade'] = $this->curso_mod->get_atividade($id_atividade);

    if (!$id_inscricao_atividade) {
      $questoes = $this->curso_mod->get_questoes($id_atividade);
      // Gera a prova unica e peresonalizada para o usuario
      shuffle($questoes);
      $atividade_questoes = array();
      foreach ($questoes as $questao) {
        $alternativas = array('a','b','c','d','e');
        shuffle($alternativas);
        $atividade_questoes[] = (object) array(
          'id_questao' => $questao->id,
          'enunciado' => $questao->enunciado,
          'alternativa_correta' => $alternativas[0],
          'alternativa_errada_1' => $alternativas[1],
          'alternativa_errada_2' => $alternativas[2],
          'alternativa_errada_3' => $alternativas[3],
          'alternativa_errada_4' => $alternativas[4],
          $alternativas[0] => $questao->alternativa_correta,
          $alternativas[1] => $questao->alternativa_errada_1,
          $alternativas[2] => $questao->alternativa_errada_2,
          $alternativas[3] => $questao->alternativa_errada_3,
          $alternativas[4] => $questao->alternativa_errada_4,
        );
      }
      $json = json_encode($atividade_questoes);
      // Gera o array para gravar no banco de dados
      $data_atividade = array(
        'id_inscricao' => $id_inscricao,
        'id_atividade' => $id_atividade,
        'atividade' => $json,
        'finalizada' => false,
        'datahora' => date('Y-m-d H:i:s'),
      );
      $data['id_inscricao_atividade'] = $this->curso_mod->grava_nova_tentativa_atividade($data_atividade);
      $data['questoes'] = json_decode($json);
    }
    else {
      // Busca os dados da tentativa iniciada anteriormente
      $inscricao_atividade = $this->curso_mod->get_inscricao_atividade($id_inscricao_atividade);
      $data['id_inscricao_atividade'] = $id_inscricao_atividade;
      $data['questoes'] = json_decode($inscricao_atividade->atividade);
      if ($inscricao_atividade->finalizada) {
        $data['bloqueado'] = true;
        $data['respostas'] = (array) json_decode($inscricao_atividade->respostas);
      }
    }
    $data['url_form'] = 'elda/cursos/sala_treinamento/grava_respostas_atividade/';
    $this->load->view('elda/cursos/sala_treinamento/atividade_form',$data);
  }

  public function grava_respostas_atividade()
  {
    $form = $this->input->post();
    $respostas = $form['questao'];
    $json_respostas = json_encode($respostas);
    $id_inscricao_atividade = $form['id_inscricao_atividade'];
    $inscricao_atividade = $this->curso_mod->get_inscricao_atividade($id_inscricao_atividade);
    // Corrigir
    $questoes = json_decode($inscricao_atividade->atividade);
    $acertos = 0;
    $total_questoes = count($questoes);
    foreach ($questoes as $key) {
      if ($key->alternativa_correta == $respostas[$key->id_questao])
        $acertos ++;
    }
    $nota = round((($acertos*100)/$total_questoes), 2);

    $data_atividade = array(
      'finalizada' => true,
      'respostas' => $json_respostas,
      'finalizada_datahora' => date('Y-m-d H:i:s'),
      'nota' => $nota,
    );
    $this->curso_mod->update_inscricao_atividade($id_inscricao_atividade,$data_atividade);
    $this->atividade($inscricao_atividade->id_inscricao,$inscricao_atividade->id_atividade);
  }


  // public function ajax_incricao()
  // {
  //   $id_curso = $this->input->post('id_curso');
  //   echo json_encode($this->curso_mod->inscrever($id_curso));
  // }

}
