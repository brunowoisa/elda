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
             ->join('categoria', 'categoria.id = curso.id_categoria','left')
             ->join('usuario as uc', 'uc.id = categoria.cadastro_id_usuario','left')
             ->join('usuario as ul', 'ul.id = categoria.last_change_id_usuario','left')
             ->where('curso.id', $id_curso);
    return $this->db->get()->row();
  }

  public function get_catalogo()
  {
    $cursos = $this->db->select('id_curso')
                       ->from('inscricao')
                       ->where('id_usuario', $this->session->userdata('usuario')->id)
                       ->get()->result();
    $cursos_inscritos = array();
    foreach ($cursos as $curso)
      $cursos_inscritos[] = $curso->id_curso;

    $pesquisa = $this->session->userdata('pesquisa_catalogo');
    $this->db->select('curso.*
                      ,categoria.nome as categoria
                      ')
             ->from('curso')
             ->join('categoria', 'categoria.id = curso.id_categoria')
             ->where('curso.ativo', '1');
    if ($cursos_inscritos) 
      $this->db->where_not_in('curso.id', $cursos_inscritos);
    if ($pesquisa != '') {
      $this->db->group_start()
               ->like('curso.titulo', $pesquisa)
               ->or_like('curso.instrutor', $pesquisa)
               ->or_like('curso.palavras_chave', $pesquisa)
               ->or_like('curso.descricao', $pesquisa)
               ->or_like('categoria.nome', $pesquisa)
      ->group_end();
    }
    return $this->db->get()->result();
  }

  public function inscrever($id_curso)
  {
    $this->db->trans_start();
      $data = array(
        'id_usuario' => $this->session->userdata('usuario')->id,
        'id_curso' => $id_curso,
        'inscricao_datahora' => date('Y-m-d H:i:s'),
      );
      $this->db->insert('inscricao', $data);
      $id_inscricao = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_inscricao;
  }

  public function marca_video_assistido($id_inscricao,$id_video)
  {
    $res = $this->db->from('inscricao_video_assistido')
                    ->where('id_inscricao', $id_inscricao)
                    ->where('id_video', $id_video)
                    ->count_all_results();
    if (!$res) {
      $this->db->trans_start();
        $data = array(
          'id_inscricao' => $id_inscricao,
          'id_video' => $id_video,
          'datahora' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('inscricao_video_assistido', $data);
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
        return false;
      else
        return true;
    }
    return true;
  }
  
  public function marca_material_baixado($id_inscricao,$id_material)
  {
    $res = $this->db->from('inscricao_material_baixado')
                    ->where('id_inscricao', $id_inscricao)
                    ->where('id_material', $id_material)
                    ->count_all_results();
    if (!$res) {
      $this->db->trans_start();
        $data = array(
          'id_inscricao' => $id_inscricao,
          'id_material' => $id_material,
          'datahora' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('inscricao_material_baixado', $data);
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE)
        return false;
      else
        return true;
    }
    return true;
  }

  public function get_progresso_cursos($id_usuario)
  {
    $cursos = $this->db->select('curso.*, inscricao.id as id_inscricao')
                       ->from('inscricao')
                       ->join('curso', 'curso.id = inscricao.id_curso')
                       ->where('inscricao.id_usuario', $id_usuario)
                       ->order_by('inscricao.id', 'desc')
                       ->get()->result();
    $ret = array();
    foreach ($cursos as $key => $curso) {
      $ret[$key]['curso'] = $curso;
      
      // Vídeos
      $t_a = $this->db->from('inscricao_video_assistido')
                      ->join('inscricao', 'inscricao.id = inscricao_video_assistido.id_inscricao')
                      ->where('inscricao.id_curso', $curso->id)
                      ->where('inscricao.id_usuario', $id_usuario)
                      ->count_all_results();
      $t_c = $this->db->from('curso_unidade_video')
                      ->join('curso_unidade', 'curso_unidade.id = curso_unidade_video.id_curso_unidade')
                      ->where('curso_unidade.id_curso', $curso->id)
                      ->where('curso_unidade_video.ativo', '1')
                      ->count_all_results();
      if ($t_c == 0)
        $ret[$key]['progresso_videos'] = 0;
      else
        $ret[$key]['progresso_videos'] = round(($t_a * 100)/$t_c);

      // Atividades
      $total_atividades_aptas = count($this->get_array_atividades_concluidas($curso->id_inscricao));
      $total_atividades = $this->db->from('curso_unidade_atividade')
                                   ->join('curso_unidade', 'curso_unidade.id = curso_unidade_atividade.id_curso_unidade')
                                   ->where('curso_unidade.id_curso', $curso->id)
                                   ->where('curso_unidade_atividade.ativo', '1')
                                   ->where('curso_unidade_atividade.obrigatoria', '1')
                                   ->count_all_results();
      if ($total_atividades == 0)
        $ret[$key]['progresso_atividades'] = 0;
      else
        $ret[$key]['progresso_atividades'] = ($total_atividades_aptas * 100)/$total_atividades;

      // Progresso Geral
      $total_atingidas = $t_a + $total_atividades_aptas;
      $total_requisitos = $t_c + $total_atividades;
      if ($total_requisitos == 0) 
        $ret[$key]['progresso'] = 0;
      else 
        $ret[$key]['progresso'] = round(($total_atingidas * 100)/$total_requisitos);

      $ret[$key] = (object) $ret[$key];
    }
    return $ret;
  }

  public function get_progresso_curso($id_inscricao)
  {
    $curso_inscricao = $this->get_curso_incricao($id_inscricao);

    // Vídeos
    $t_a = count($this->get_array_videos_assistidos($id_inscricao));
    $t_c = $this->db->from('curso_unidade_video')
                    ->join('curso_unidade', 'curso_unidade.id = curso_unidade_video.id_curso_unidade')
                    ->where('curso_unidade.id_curso', $curso_inscricao->id_curso)
                    ->where('curso_unidade_video.ativo', '1')
                    ->count_all_results();
    if ($t_c == 0)
      $ret['progresso_videos'] = '--';
    else
      $ret['progresso_videos'] = round(($t_a * 100)/$t_c);

    // Atividades
    $total_atividades_aptas = count($this->get_array_atividades_concluidas($id_inscricao));
    $total_atividades = $this->db->from('curso_unidade_atividade')
                                 ->join('curso_unidade', 'curso_unidade.id = curso_unidade_atividade.id_curso_unidade')
                                 ->where('curso_unidade.id_curso', $curso_inscricao->id_curso)
                                 ->where('curso_unidade_atividade.ativo', '1')
                                 ->where('curso_unidade_atividade.obrigatoria', '1')
                                 ->count_all_results();
    if ($total_atividades == 0)
      $ret['progresso_atividades'] = '--';
    else
      $ret['progresso_atividades'] = round(($total_atividades_aptas * 100)/$total_atividades);

    // Materiais
    $total_materiais_baixados = count($this->get_array_materiais_baixados($id_inscricao));
    $total_materiais = $this->db->from('curso_unidade_material')
                                 ->join('curso_unidade', 'curso_unidade.id = curso_unidade_material.id_curso_unidade')
                                 ->where('curso_unidade.id_curso', $curso_inscricao->id_curso)
                                 ->where('curso_unidade_material.ativo', '1')
                                 ->count_all_results();
    if ($total_materiais == 0)
      $ret['progresso_materiais'] = '--';
    else
      $ret['progresso_materiais'] = round(($total_materiais_baixados * 100)/$total_materiais);

    // Progresso Geral
    $total_atingidas = $t_a + $total_atividades_aptas;
    $total_requisitos = $t_c + $total_atividades;
    if ($total_requisitos == 0)
      $ret['progresso'] = 0;
    else
      $ret['progresso'] = round(($total_atingidas * 100)/$total_requisitos);

    return (object) $ret;
  }

  public function get_array_videos_assistidos($id_inscricao)
  {
    $this->db->select('id_video')
             ->from('inscricao_video_assistido')
             ->where('id_inscricao', $id_inscricao);
    $videos = $this->db->get()->result();
    $res = array();
    foreach ($videos as $key)
      $res[] = $key->id_video;
    return $res;
  }

  public function get_array_materiais_baixados($id_inscricao)
  {
    $this->db->select('id_material')
             ->from('inscricao_material_baixado')
             ->where('id_inscricao', $id_inscricao);
    $materiais = $this->db->get()->result();
    $res = array();
    foreach ($materiais as $key)
      $res[] = $key->id_material;
    return $res;
  }

  public function get_array_atividades_concluidas($id_inscricao)
  {
    $this->db->select('inscricao_atividade.id_atividade')
             ->from('inscricao_atividade')
             ->join('curso_unidade_atividade', 'curso_unidade_atividade.id = inscricao_atividade.id_atividade')
             ->where('inscricao_atividade.id_inscricao', $id_inscricao)
             ->where('curso_unidade_atividade.obrigatoria', '1')
             ->group_by('inscricao_atividade.id_atividade');
    $tentativas = $this->db->get()->result();
    $res = array();
    foreach ($tentativas as $key) {
      $ultima_tentativa = $this->db->select('*')
                                   ->from('inscricao_atividade')
                                   ->where('id_atividade', $key->id_atividade)
                                   ->where('id_inscricao', $id_inscricao)
                                   ->order_by('id', 'desc')
                                   ->limit('1')
                                   ->get()->row();
      if ($ultima_tentativa->finalizada && $ultima_tentativa->nota >= 70)
        $res[] = $key->id_atividade;
    }
    return $res;
  }

  public function get_quadro_notas($id_inscricao)
  {
    $this->db->select('id_atividade')
             ->from('inscricao_atividade')
             ->where('id_inscricao', $id_inscricao)
             ->group_by('id_atividade');
    $tentativas = $this->db->get()->result();
    $res = array();
    foreach ($tentativas as $key) {
      $ultima_tentativa = $this->db->select('id
                                            ,DATE_FORMAT(datahora, "%d/%m/%Y %H:%i:%s") as datahora
                                            ,id_atividade
                                            ,finalizada
                                            ,DATE_FORMAT(finalizada_datahora, "%d/%m/%Y %H:%i:%s") as finalizada_datahora
                                            ,nota')
                                   ->from('inscricao_atividade')
                                   ->where('id_atividade', $key->id_atividade)
                                   ->where('id_inscricao', $id_inscricao)
                                   ->order_by('id', 'desc')
                                   ->limit('1')
                                   ->get()->row();
      $res[$ultima_tentativa->id_atividade] = $ultima_tentativa;
    }
    return $res;
  }

  public function get_atividades_curso($id_curso)
  {
    $this->db->select('curso_unidade_atividade.*')
             ->from('curso_unidade_atividade')
             ->join('curso_unidade', 'curso_unidade.id = curso_unidade_atividade.id_curso_unidade')
             ->where('curso_unidade.id_curso', $id_curso);
    return $this->db->get()->result();
  }

  public function get_inscricoes_usuario($id_usuario)
  {
    $this->db->select('inscricao.*
                      ,curso.titulo as curso
                      ,DATE_FORMAT(inscricao_datahora, "%d/%m/%Y %H:%i") as inscricao_datahora
                      ,DATE_FORMAT(concluido_datahora, "%d/%m/%Y %H:%i") as concluido_datahora
                      ,DATE_FORMAT(avaliacao_datahora, "%d/%m/%Y %H:%i") as avaliacao_datahora')
             ->from('inscricao')
             ->join('curso', 'curso.id = inscricao.id_curso')
             ->where('inscricao.id_usuario', $id_usuario)
             ->order_by('inscricao.id', 'desc');
    return $this->db->get()->result();
  }

  public function get_curso_incricao($id_inscricao)
  {
    $this->db->select('*, DATE_FORMAT(concluido_datahora, "%d/%m/%Y") as concluido_data')
             ->from('inscricao')
             ->where('id', $id_inscricao);
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

  public function grava_nova_tentativa_atividade($data)
  {
    $this->db->trans_start();
      $this->db->insert('inscricao_atividade', $data);
      $id_inscricao_atividade = $this->db->insert_id();
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return $id_inscricao_atividade;
  }

  public function update_inscricao_atividade($id,$data)
  {
    $this->db->trans_start();
      $this->db->where('id', $id);
      $this->db->update('inscricao_atividade', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function get_inscricao_atividade($id)
  {
    $this->db->select('*')
             ->from('inscricao_atividade')
             ->where('id', $id);
    return $this->db->get()->row();
  }
  
  public function get_inscricao_atividades($id_inscricao,$id_atividade)
  {
    $this->db->select('*
                      ,DATE_FORMAT(datahora, "%d/%m/%Y %H:%i:%s") as datahora
                      ,DATE_FORMAT(finalizada_datahora, "%d/%m/%Y %H:%i:%s") as finalizada_datahora
                      ')
             ->from('inscricao_atividade')
             ->where('id_inscricao', $id_inscricao)
             ->where('id_atividade', $id_atividade);
    return $this->db->get()->result();
  }

  public function finaliza_treinamento($id_inscricao)
  {
    $this->db->trans_start();
      $data = array(
        'concluido' => true,
        'concluido_datahora' => date('Y-m-d H:i:s'),
      );
      $this->db->where('id', $id_inscricao);
      $this->db->update('inscricao', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

  public function avaliar_curso($form,$id_inscricao)
  {
    $this->db->trans_start();
      $data = array(
        'avaliacao_nota' => $form->avaliacao_nota,
        'avaliacao_comentario' => $form->avaliacao_comentario,
        'avaliacao_datahora' => date('Y-m-d H:i:s'),
      );
      $this->db->where('id', $id_inscricao);
      $this->db->update('inscricao', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE)
      return false;
    else
      return true;
  }

}
  