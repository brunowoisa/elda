<?php
use Com\Tecnick\Barcode\Barcode;
defined('BASEPATH') OR exit('No direct script access allowed');

class sala_treinamento extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('elda/curso_mod');
    $this->load->model('acesso_mod');
  }

	public function index($id_inscricao=false)
	{
    $this->acesso_mod->verifica_sessao();
    $mensagem = null;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    if ($id_inscricao) {
      $data['form'] = null;
      $data['url_form'] = 'elda/cursos/sala_treinamento/index/'.$id_inscricao;
      $form = $this->input->post();
      if (!empty($form)) {
        $form = (object) $form;
        $this->form_validation->set_rules('avaliacao_nota', 'Nota', 'required');
        if ($this->form_validation->run() == TRUE){
          $res = $this->curso_mod->avaliar_curso($form,$id_inscricao);
          if(!$res){
            $mensagem = array('texto' => 'Houve um erro ao registrar a avaliação. Tente novamente!', 'tipo'  => 'SweetAlert', 'class' => 'error');
            $data['form'] = $form;
          }
          else{
            $mensagem = array('texto' => 'Avaliação registrada com sucesso!', 'tipo'  => 'SweetAlert', 'class' => 'success');
          }
        }
        else{
          $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
          $data['form'] = $form;
        }
      }
      $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
      $data['curso_inscricao'] = $curso_inscricao;
      $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
      $data['unidades'] = $this->curso_mod->get_unidades($curso_inscricao->id_curso);
      $data['videos_assistidos'] = $this->curso_mod->get_array_videos_assistidos($id_inscricao);
      $data['materiais_baixados'] = $this->curso_mod->get_array_materiais_baixados($id_inscricao);
      $data['atividades_concluidas'] = $this->curso_mod->get_array_atividades_concluidas($id_inscricao);
      $data['curso_nao_setado'] = false;
      $data['id_inscricao'] = $id_inscricao;
    }
    else{
      $data['progressos'] = $this->curso_mod->get_progresso_cursos($this->session->userdata('usuario')->id);
      $data['curso_nao_setado'] = true;
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/cursos/sala_treinamento/grid',$data);
  }

  public function assistir_video($id_inscricao,$id_video)
  {
    $this->acesso_mod->verifica_sessao();
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
    $this->acesso_mod->verifica_sessao();
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
    $this->acesso_mod->verifica_sessao();
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/index/'.$id_inscricao);
    $data['diretorio'] = base_url().'assets/_UPLOADS/CURSOS/'.$curso_inscricao->id_curso.'/VIDEOS/';
    $data['id_inscricao'] = $id_inscricao;
    $data['id_atividade'] = $id_atividade;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['atividade'] = $this->curso_mod->get_atividade($id_atividade);
    $data['tentativas'] = $this->curso_mod->get_inscricao_atividades($id_inscricao,$id_atividade);
    $data['curso_inscricao'] = $curso_inscricao;
    $this->load->view('elda/cursos/sala_treinamento/atividade_grid',$data);
  }

  public function realizar_atividade($id_inscricao,$id_atividade,$id_inscricao_atividade=false)
  {
    $this->acesso_mod->verifica_sessao();
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
    $this->acesso_mod->verifica_sessao();
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

  public function quadro_notas($id_inscricao)
  {
    $this->acesso_mod->verifica_sessao();
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/index/'.$id_inscricao);
    $data['id_inscricao'] = $id_inscricao;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['quadro_notas'] = $this->curso_mod->get_quadro_notas($id_inscricao);
    $data['atividades'] = $this->curso_mod->get_atividades_curso($curso_inscricao->id_curso);
    $this->load->view('elda/cursos/sala_treinamento/quadro_notas',$data);
  }

  public function certificado($id_inscricao)
  {
    $this->acesso_mod->verifica_sessao();
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $data['links'] = array('voltar' => 'elda/cursos/sala_treinamento/index/'.$id_inscricao);
    $data['id_inscricao'] = $id_inscricao;
    $data['inscricoes'] = $this->curso_mod->get_inscricoes_usuario($this->session->userdata('usuario')->id);
    $data['curso'] = $this->curso_mod->get_curso($curso_inscricao->id_curso);
    $data['progresso'] = $this->curso_mod->get_progresso_curso($id_inscricao);
    $this->load->view('elda/cursos/sala_treinamento/certificado',$data);
  }

  public function emitir_certificado($id_inscricao)
  {
    $this->acesso_mod->verifica_sessao();
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    if ($curso_inscricao->concluido) {
      $this->imprimir_certificado($id_inscricao);
    }
    else {
      $progresso = $this->curso_mod->get_progresso_curso($id_inscricao);
      if ($progresso->progresso != 100)
        echo "Você não está apto à emitir esse certificado.";
      else {
        $this->curso_mod->finaliza_treinamento($id_inscricao);
        $this->imprimir_certificado($id_inscricao);
      }
    }
  }

  public function imprimir_certificado($id_inscricao)
  {
    $curso_inscricao = $this->curso_mod->get_curso_incricao($id_inscricao);
    $curso = $this->curso_mod->get_curso($curso_inscricao->id_curso);

    $barcode = new Barcode();
    $bobj = $barcode->getBarcodeObj(
        'QRCODE,M',
        'https://www.woisoft.com.br/elda/cursos/sala_treinamento/imprimir_certificado/'.$id_inscricao,
        0,
        0,
        'black',
        array(-1, -1, -1, -1)
    )->setBackgroundColor('white');
    $qrcode = $bobj->getPngData();

    $pic = 'data://text/plain;base64,' . base64_encode($qrcode);
    $info = getimagesize($pic);

    $this->load->library('fpdf/fpdf');
    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(5, 5, 5);
    $pdf->Image(base_url().'assets/_IMAGES/Certificado.jpg', 0, 0, 0, 0, 'JPG');
    $pdf->SetFont('Courier','',27);
    $pdf->SetXY(25, 95);
    $pdf->Cell(272,15,utf8_decode($this->session->userdata('usuario')->nome),0,1,'C');
    $pdf->SetXY(25, 130);
    $pdf->Cell(272,15,utf8_decode($curso->titulo),0,1,'C');
    $pdf->SetFont('Courier','',14);
    $pdf->SetXY(25, 155);
    $pdf->Cell(272,15,utf8_decode($curso_inscricao->concluido_data),0,1,'C');

    $pdf->image($pic, 277, 0, 20, 20, 'PNG');
    $pdf->image($pic, 277, 190, 20, 20, 'PNG');
    $pdf->image($pic, 22, 165, 43, 43, 'PNG');

    $pdf->Output();
  }
}
