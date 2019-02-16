<?php 
Class curso_mod extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('elda', TRUE);
  }

  public function get_cursos()
  {
    $this->db->select('curso.*
                      ,DATE_FORMAT(curso.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,categoria.nome as categoria
                      ')
             ->from('curso')
             ->join('categoria', 'categoria.id = curso.id_categoria');
    return $this->db->get()->result();
  }

  public function get_curso($id_curso)
  {
    $this->db->select('curso.*
                      ,DATE_FORMAT(curso.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,categoria.nome as categoria
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario
                      ')
             ->from('curso')
             ->join('categoria', 'categoria.id = curso.id_categoria')
             ->join('usuario as uc', 'uc.id = categoria.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = categoria.last_change_id_usuario')
             ->where('curso.id', $id_curso);
    return $this->db->get()->row();
  }

  public function count_ativos()
  {
    $this->db->where('ativo', '1')
             ->from('curso');
    return $this->db->count_all_results();
  }

  public function get_unidades($id_curso)
  {
    $this->db->select('curso_unidade.*')
             ->from('curso_unidade')
             ->where('curso_unidade.id_curso', $id_curso);
    $unidades = $this->db->get()->result();

    foreach ($unidades as $key => $unidade) {
      $unidades[$key]->videos = $this->get_unidade_videos($unidade->id);
      $unidades[$key]->materiais = $this->get_unidade_materiais($unidade->id);
      $unidades[$key]->atividades = $this->get_unidade_atividades($unidade->id);
    }
    // Fazer a busca dos conteúdos da unidade.
    return $unidades;
  }

  public function get_unidade($id_unidade)
  {
    $this->db->select('curso_unidade.*
                      ,DATE_FORMAT(curso_unidade.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade')
             ->join('usuario as uc', 'uc.id = curso_unidade.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade.last_change_id_usuario')
             ->where('curso_unidade.id', $id_unidade);
    return $this->db->get()->row();
  }

  public function get_unidade_videos($id_unidade)
  {
    $this->db->select('curso_unidade_video.*
                      ,DATE_FORMAT(curso_unidade_video.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_video.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_video')
             ->join('usuario as uc', 'uc.id = curso_unidade_video.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_video.last_change_id_usuario')
             ->where('curso_unidade_video.id_curso_unidade', $id_unidade);
    return $this->db->get()->result();
  }
  
  public function get_video($id_video)
  {
    $this->db->select('curso_unidade_video.*
                      ,DATE_FORMAT(curso_unidade_video.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_video.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_video')
             ->join('usuario as uc', 'uc.id = curso_unidade_video.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_video.last_change_id_usuario')
             ->where('curso_unidade_video.id', $id_video);
    return $this->db->get()->row();
  }

  public function get_unidade_materiais($id_unidade)
  {
    $this->db->select('curso_unidade_material.*
                      ,DATE_FORMAT(curso_unidade_material.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_material.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_material')
             ->join('usuario as uc', 'uc.id = curso_unidade_material.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_material.last_change_id_usuario')
             ->where('curso_unidade_material.id_curso_unidade', $id_unidade);
    return $this->db->get()->result();
  }

  public function get_material($id_material)
  {
    $this->db->select('curso_unidade_material.*
                      ,DATE_FORMAT(curso_unidade_material.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_material.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_material')
             ->join('usuario as uc', 'uc.id = curso_unidade_material.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_material.last_change_id_usuario')
             ->where('curso_unidade_material.id', $id_material);
    return $this->db->get()->row();
  }

  public function get_unidade_atividades($id_unidade)
  {
    $this->db->select('curso_unidade_atividade.*
                      ,DATE_FORMAT(curso_unidade_atividade.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_atividade.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_atividade')
             ->join('usuario as uc', 'uc.id = curso_unidade_atividade.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_atividade.last_change_id_usuario')
             ->where('curso_unidade_atividade.id_curso_unidade', $id_unidade);
    return $this->db->get()->result();
  }

  public function get_atividade($id_atividade)
  {
    $this->db->select('curso_unidade_atividade.*
                      ,DATE_FORMAT(curso_unidade_atividade.cadastro, "%d/%m/%Y %H:%i:%s") as cadastro
                      ,DATE_FORMAT(curso_unidade_atividade.last_change, "%d/%m/%Y %H:%i:%s") as last_change
                      ,uc.apelido as cadastro_usuario
                      ,ul.apelido as last_change_usuario')
             ->from('curso_unidade_atividade')
             ->join('usuario as uc', 'uc.id = curso_unidade_atividade.cadastro_id_usuario')
             ->join('usuario as ul', 'ul.id = curso_unidade_atividade.last_change_id_usuario')
             ->where('curso_unidade_atividade.id', $id_atividade);
    return $this->db->get()->row();
  }

  public function get_questoes($id_atividade)
  {
    $this->db->select('*')
             ->from('curso_unidade_atividade_questao')
             ->where('id_curso_unidade_atividade', $id_atividade);
    return $this->db->get()->result();
  }

  public function novo($form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'instrutor' => $form->instrutor,
        'id_categoria' => $form->id_categoria,
        'ativo' => $form->ativo,
        'palavras_chave' => $form->palavras_chave,
        'descricao' => $form->descricao,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->insert('curso', $data);
      $id_curso = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_curso;
  }

  public function editar($id_curso,$form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'instrutor' => $form->instrutor,
        'id_categoria' => $form->id_categoria,
        'ativo' => $form->ativo,
        'palavras_chave' => $form->palavras_chave,
        'descricao' => $form->descricao,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->where('id', $id_curso);
      $this->db->update('curso', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function novo_unidade($id_curso,$form)
  {
    $this->db->trans_start();
      $data = array(
        'id_curso' => $id_curso,
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->insert('curso_unidade', $data);
      $id_curso_unidade = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_curso_unidade;
  }

  public function editar_unidade($id_unidade,$form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->where('id', $id_unidade);
      $this->db->update('curso_unidade', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function novo_video($id_unidade,$form,$upload)
  {
    $this->db->trans_start();
      $data = array(
        'id_curso_unidade' => $id_unidade,
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'tipo' => $form->tipo,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      if ($form->tipo == 'I') 
        $data['video_incorporar'] = $form->video_incorporar;
      else {
        if($upload){
          foreach ($upload as $video) {
            $data['video'] = $video['file_name'];
          }
        }
      }
      $this->db->insert('curso_unidade_video', $data);
      $id_video = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_video;
  }

  public function editar_video($id_video,$form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      if ($form->tipo == 'I') 
        $data['video_incorporar'] = $form->video_incorporar;
      $this->db->where('id', $id_video);
      $this->db->update('curso_unidade_video', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function novo_material($id_unidade,$form,$upload)
  {
    $this->db->trans_start();
      $data = array(
        'id_curso_unidade' => $id_unidade,
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      if($upload){
        foreach ($upload as $material) {
          $data['material'] = $material['file_name'];
        }
      }
      $this->db->insert('curso_unidade_material', $data);
      $id_material = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_material;
  }

  public function editar_material($id_material,$form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'ativo' => $form->ativo,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->where('id', $id_material);
      $this->db->update('curso_unidade_material', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function novo_atividade($id_unidade,$form,$upload)
  {
    $this->db->trans_start();
      $data = array(
        'id_curso_unidade' => $id_unidade,
        'titulo' => $form->titulo,
        'obrigatoria' => $form->obrigatoria,
        'ativo' => $form->ativo,
        'cadastro' => date('Y-m-d H:i:s'),
        'cadastro_id_usuario' => $this->session->userdata('usuario')->id,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->insert('curso_unidade_atividade', $data);
      $id_atividade = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_atividade;
  }

  public function editar_atividade($id_atividade,$form)
  {
    $this->db->trans_start();
      $data = array(
        'titulo' => $form->titulo,
        'obrigatoria' => $form->obrigatoria,
        'ativo' => $form->ativo,
        'last_change' => date('Y-m-d H:i:s'),
        'last_change_id_usuario' => $this->session->userdata('usuario')->id,
      );
      $this->db->where('id', $id_atividade);
      $this->db->update('curso_unidade_atividade', $data);

      $this->db->where('id_curso_unidade_atividade', $id_atividade);
      $this->db->delete('curso_unidade_atividade_questao');

      if (isset($form->questao)) {
        foreach ($form->questao as $questao) {
          $data_questao = array(
            'id_curso_unidade_atividade' => $id_atividade,
            'enunciado' => $questao['enunciado'],
            'alternativa_correta' => $questao['alternativa']['c'],
            'alternativa_errada_1' => $questao['alternativa']['e1'],
            'alternativa_errada_2' => $questao['alternativa']['e2'],
            'alternativa_errada_3' => $questao['alternativa']['e3'],
            'alternativa_errada_4' => $questao['alternativa']['e4'],
          );
          $this->db->insert('curso_unidade_atividade_questao', $data_questao);
        }
      }
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

}
  