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

  public function relatorio()
  {
    $mensagem = null;
    $this->links['novo'] = '';
    $this->links['atualizar'] = 'elda/administrativo/usuario/relatorio/';
    $data = array(
      'links' => $this->links,
      'editar' => false,
      'url_form' => 'elda/administrativo/usuario/relatorio/',
      'form' => null,
      'usuarios' => $this->usuario_mod->get_usuarios_ativos(),
    );
    $form = $this->input->post();
    if (!empty($form)) {
      $form = (object) $form;
      $this->form_validation->set_rules('id_usuario', 'Usuário', 'required');
      if ($this->form_validation->run() == TRUE){
        $data['relatorio_id_usuario'] = $form->id_usuario;
        $data['form'] = $form;
      }
      else
        $mensagem = array('texto' => validation_errors(), 'tipo'  => 'SweetAlert', 'class' => 'warning');
    }
    $this->load->view('mensagens',$mensagem);
    $this->load->view('elda/administrativo/usuario/relatorio',$data);
  }

  public function imprimir_relatorio($id_usuario)
  {
    $this->load->model('elda/curso_mod');
    $usuario = $this->usuario_mod->get_usuario($id_usuario);
    $this->load->library('fpdf/fpdf');
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetMargins(5, 5, 5);
    $pdf->Image(base_url().'assets/app/media/img/logos/Elda.png', 59, 5, 90, 0, 'PNG');
    $pdf->SetFont('Arial','B',19);
    $pdf->SetXY(5, 40);
    $pdf->Cell(200,10,utf8_decode('RELATÓRIO DE DESEMPENHO'),'TB',1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->SetXY(5, 55);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,5,utf8_decode('Usuário: '),'',0,'L');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(180,5,utf8_decode($usuario->nome),'',1,'L');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,5,utf8_decode('CPF: '),'',0,'L');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(110,5,utf8_decode(formata_cpf($usuario->cpf)),'',0,'L');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(30,5,utf8_decode('Emitido em: '),'',0,'L');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(40,5,utf8_decode(date('d/m/Y H:i:s')),'',0,'L');

    $inscricoes = $this->curso_mod->get_inscricoes_usuario($id_usuario);

    $pdf->SetXY(5, 75);

    foreach ($inscricoes as $inscricao) {
      $curso = $this->curso_mod->get_curso($inscricao->id_curso);
      $progresso = $this->curso_mod->get_progresso_curso($inscricao->id);

      $pdf->SetFont('Arial','B',5);
      $pdf->Cell(200,3,utf8_decode('NOME DO CURSO'),'LTR',1,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(200,5,utf8_decode($curso->titulo),'LR',1,'L');
      $pdf->SetFont('Arial','B',5);
      $pdf->Cell(100,3,utf8_decode('Categoria'),'LTR',0,'L');
      $pdf->Cell(34,3,utf8_decode('Data de Inscrição'),'TR',0,'L');
      $pdf->Cell(34,3,utf8_decode('Data de Conclusão'),'TR',0,'L');
      $pdf->Cell(32,3,utf8_decode('Progresso Geral'),'TR',1,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(100,5,utf8_decode($curso->categoria),'LR',0,'L');
      $pdf->Cell(34,5,utf8_decode($inscricao->inscricao_datahora),'LR',0,'L');
      $pdf->Cell(34,5,utf8_decode($inscricao->concluido_datahora),'LR',0,'L');
      $pdf->Cell(32,5,utf8_decode($progresso->progresso.'%'),'LR',1,'L');
      $pdf->SetFont('Arial','B',5);
      $pdf->Cell(67,3,utf8_decode('Vídeos Assistidos'),'LTR',0,'L');
      $pdf->Cell(67,3,utf8_decode('Materiais Baixados'),'TR',0,'L');
      $pdf->Cell(66,3,utf8_decode('Atividades Obrigatórias Realizadas'),'TR',1,'L');
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(67,5,utf8_decode($progresso->progresso_videos.'%'),'LR',0,'L');
      $pdf->Cell(67,5,utf8_decode($progresso->progresso_materiais.'%'),'LR',0,'L');
      $pdf->Cell(66,5,utf8_decode($progresso->progresso_atividades.'%'),'LR',1,'L');

      $quadro_notas = $this->curso_mod->get_quadro_notas($inscricao->id);
      $atividades = $this->curso_mod->get_atividades_curso($inscricao->id_curso);

      if ($atividades) {
        $pdf->SetFont('Arial','B',5);
        $pdf->Cell(110,3,utf8_decode('Atividade'),'LTR',0,'L');
        $pdf->Cell(30,3,utf8_decode('Tipo'),'LTR',0,'L');
        $pdf->Cell(20,3,utf8_decode('Realizada'),'LTR',0,'L');
        $pdf->Cell(20,3,utf8_decode('Finalizada'),'LTR',0,'L');
        $pdf->Cell(20,3,utf8_decode('Nota'),'LTR',1,'L');
        $pdf->SetFont('Arial','',10);
        foreach ($atividades as $atividade) {
          $tipo = ($atividade->obrigatoria)?'Obrigatória':'Optativa';
          $realizada = (isset($quadro_notas[$atividade->id]))?'Sim':'Não';
          $finalizada = (isset($quadro_notas[$atividade->id]) && $quadro_notas[$atividade->id]->finalizada)?'Sim':'Não';
          $nota = (isset($quadro_notas[$atividade->id]) && $quadro_notas[$atividade->id]->nota > 0)?$quadro_notas[$atividade->id]->nota:'0.00';
          $pdf->Cell(110,5,utf8_decode($atividade->titulo),'LR',0,'L');
          $pdf->Cell(30,5,utf8_decode($tipo),'LR',0,'L');
          $pdf->Cell(20,5,utf8_decode($realizada),'LR',0,'L');
          $pdf->Cell(20,5,utf8_decode($finalizada),'LR',0,'L');
          $pdf->Cell(20,5,utf8_decode($nota),'LR',1,'R');
        }
      }

      if ($inscricao->avaliacao_nota) {
        $pdf->SetFont('Arial','B',5);
        $pdf->Cell(200,3,utf8_decode('Avaliação do Curso'),'LTR',1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,utf8_decode('Nota '.$inscricao->avaliacao_nota.' de 5.'),'LR',1,'L');
        $pdf->MultiCell(200, 5, utf8_decode('Em '.$inscricao->avaliacao_datahora.', o usuário escreveu: '.$inscricao->avaliacao_comentario), 'LR', 'L', 0);
      }
      $pdf->SetFont('Arial','B',5);
      $pdf->Cell(200,3,utf8_decode('Indicador de Aprovação'),'LTR',1,'C');
      $pdf->SetFont('Arial','B',10);

      $indicador = 'NÃO aprovado';
      if ($progresso->progresso == 100)
        $indicador = 'APROVADO';

      $pdf->Cell(200,5,utf8_decode('======= '.$indicador.' ======='),'LRB',1,'C');
      $pdf->Ln(15);
    }
    $pdf->Output();
  }
}
