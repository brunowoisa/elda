<script> 
  title('Estruturação do Curso');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Cadastros", href: "elda/menu/cadastro/" },
    { nome: "Cadastro de Cursos", href: "elda/cadastro/curso/" },
    { nome: "Estruturação do Curso", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
  });
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">
    <?php $this->load->view('include/botoes',$links); ?>

    <div class="row">
      <div class="col-sm-6">
        <a  style="margin-top: -80px;" href="<?php echo base_url(); ?>elda/cadastro/curso/editar/<?php echo $curso->id; ?>" class="btn m-btn--square  btn-outline-primary m-btn m-btn--custom"><i class="fa fa-edit"></i> Editar Curso</a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <b>Curso: </b><?php echo $curso->titulo; ?>
      </div>
      <div class="col-sm-3">
        <b>Categoria:</b> <?php echo $curso->categoria; ?>
      </div>
      <div class="col-sm-3">
        <b>Instrutor:</b> <?php echo $curso->instrutor; ?>
      </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-sm-9">
        <b>Palavras-Chave:</b> <?php echo $curso->palavras_chave; ?>
      </div>
      <div class="col-sm-3">
        <b>Status: </b><?php echo ($curso->ativo == 1)?'<i class="fa fa-check-circle m--font-success"></i> Ativo':'<i class="fa fa-times-circle"></i> Inativo'; ?>
      </div>
    </div>

    <?php foreach ($unidades as $unidade): ?>
      <?php if ($unidade->ativo): ?>
        <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--bordered">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                  <i class="la la-chevron-right"></i>
                </span>
                <h3 class="m-portlet__head-text">
                  <?php echo $unidade->titulo; ?>
                </h3>
              </div>      
            </div>
            <div class="m-portlet__head-tools">
              <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_unidade/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>" class="m-btn btn btn-outline-light"><i class="la la-edit"></i> Editar</a>
            </div>
          </div>
          <div class="m-portlet__body">
            <div class="m-list-search">
              <div class="m-list-search__results">
                <div class="row">
                  <div class="col-sm-6">
                    <span class="m-list-search__result-category m-list-search__result-category--first">
                      Vídeos
                    </span>
                    <?php foreach ($unidade->videos as $video): ?>
                      <?php if ($video->ativo): ?>
                        <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_video/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>/<?php echo $video->id; ?>/" class="m-list-search__result-item">
                          <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-play-circle"></i></span>
                          <span class="m-list-search__result-item-text"><?php echo $video->titulo; ?></span>
                        </a>
                      <?php else: ?>
                        <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_video/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>/<?php echo $video->id; ?>/" class="m-list-search__result-item">
                          <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-play-circle m--font-danger"></i></i></span>
                          <span class="m-list-search__result-item-text" style="text-decoration: line-through;"><?php echo $video->titulo; ?></span>
                        </a>
                      <?php endif ?>
                    <?php endforeach ?>
                  </div>
                  <div class="col-sm-6">
                    <span class="m-list-search__result-category m-list-search__result-category--first">
                      Material Complementar
                    </span>
                    <?php foreach ($unidade->materiais as $material): ?>
                      <?php 
                      $diretorio = base_url().'assets/_UPLOADS/CURSOS/'.$curso->id.'/MATERIAIS/';
                      $info_file = pathinfo($diretorio.$material->material);
                      $extensao = $info_file['extension'];
                      ?>
                      <?php if ($material->ativo): ?>
                        <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_material/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>/<?php echo $material->id; ?>/" class="m-list-search__result-item">
                          <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-cloud-download"></i></span>
                          <span class="m-list-search__result-item-text"><?php echo $material->titulo; ?>.<?php echo $extensao; ?></span>
                        </a>
                      <?php else: ?>
                        <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_material/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>/<?php echo $material->id; ?>/" class="m-list-search__result-item">
                          <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-cloud-download m--font-danger"></i></span>
                          <span class="m-list-search__result-item-text" style="text-decoration: line-through;"><?php echo $material->titulo; ?>.<?php echo $extensao; ?></span>
                        </a>
                      <?php endif ?>
                    <?php endforeach ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-12">
                    <span class="m-list-search__result-category m-list-search__result-category--first">
                      Atividades
                    </span>
                    <a href="#" class="m-list-search__result-item">
                      <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-puzzle-piece"></i></span>
                      <span class="m-list-search__result-item-text">Revisão da Unidade 1</span>
                    </a>
                    <a href="#" class="m-list-search__result-item">
                      <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-puzzle-piece m--font-danger"></i></i></span>
                      <span class="m-list-search__result-item-text" style="text-decoration: line-through;">Revisão Geral</span>
                    </a>
                    <a href="#" class="m-list-search__result-item">
                      <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-puzzle-piece"></i></i></span>
                      <span class="m-list-search__result-item-text">Atividade de Conclusão da Unidade 1</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="m-portlet m-portlet--danger m-portlet--head-solid-bg m-portlet--bordered">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <span class="m-portlet__head-icon">
                  <i class="la la-chevron-right"></i>
                </span>
                <h3 class="m-portlet__head-text" style="text-decoration: line-through;">
                  <?php echo $unidade->titulo; ?>
                </h3>
              </div>      
            </div>
            <div class="m-portlet__head-tools">
              <a href="<?php echo base_url(); ?>elda/cadastro/curso/editar_unidade/<?php echo $curso->id; ?>/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>" class="m-btn btn btn-outline-light"><i class="la la-edit"></i> Editar</a>
            </div>
          </div>
        </div>
      <?php endif ?>
    <?php endforeach ?>

    <div class="row" style="margin-bottom: 20px; margin-top: 20px;">
      <div class="col-sm-12" style="text-align: center;">
        <a href="<?php echo base_url(); ?>elda/cadastro/curso/novo_unidade/<?php echo $curso->id; ?>" class="btn m-btn--square  btn-primary m-btn m-btn--custom"><i class="la la-plus"></i> Nova Unidade</a>
      </div>
    </div>

  </div>
</div>