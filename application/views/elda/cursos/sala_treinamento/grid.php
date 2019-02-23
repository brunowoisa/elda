<script> 
  title('Sala de Treinamentos');
  <?php if ($curso_nao_setado): ?>
    var crumbs = [
      { nome: "Início", href: "home/" },
      { nome: "Sala de Treinamentos", href: "" },
    ];
  <?php else: ?>
    var crumbs = [
      { nome: "Início", href: "home/" },
      { nome: "Sala de Treinamentos", href: "elda/cursos/sala_treinamento/" },
      { nome: "<?php echo $curso->titulo; ?>", href: "" },
    ];
  <?php endif ?>
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
  });
</script>

<div class="row">
  <?php if (!$inscricoes): ?>
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="m-alert m-alert--icon m-alert--outline alert alert-info alert-dismissible fade show" role="alert">
        <div class="m-alert__icon">
          <i class="flaticon-exclamation"></i>
        </div>
        <div class="m-alert__text">
            <strong>Ops!</strong><br><br>
            Você ainda não se increveu em nenhum curso.<br><br>
            No <a style="color: #004377;" href="<?php echo base_url(); ?>elda/cursos/catalogo/">Catálogo de Cursos</a> você encontra os cursos disponíveis para inscrição.
        </div>  
      </div>
    </div>
  <?php else: ?>
    <div class="col-sm-3">
      <?php include('include_menu_lateral.php'); ?>
    </div>
    <div class="col-sm-9">
      <?php if ($curso_nao_setado): ?>
        <h2>Progressos</h2>
        <?php foreach ($progressos as $key): ?>
          <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
              <div class="row">
                <div class="col-sm-12">
                  <!--begin::Total Profit-->
                  <div class="m-widget24">           
                    <div class="m-widget24__item">
                      <h4 class="m-widget24__title">
                        <?php echo $key->curso->titulo; ?>
                      </h4><br>
                      <div class="m--space-10"></div>
                      <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $key->progresso; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $key->progresso; ?>%"></div>
                      </div>
                      <span class="m-widget24__change">
                        Progresso do Treinamento
                      </span>
                      <span class="m-widget24__number">
                        <?php echo $key->progresso; ?>%
                      </span>
                    </div>              
                  </div>
                  <!--end::Total Profit-->
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      <?php else: ?>
        <style>
          .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items {
            border-top: 1px solid #b9b9b9;
          }
          .m-invoice-1 .m-invoice__wrapper .m-invoice__body.m-invoice__body--centered {
            width: 90%;
            padding-top: 50px;
            padding-bottom: 30px;
          }
        </style>
        <div class="m-portlet">
          <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="m-invoice-1">
              <div class="m-invoice__wrapper">
                <div class="m-invoice__head" style="background-image: url(<?php echo base_url(); ?>assets/app/media/img/bg/bg-9.jpg);">
                  <div class="m-invoice__container m-invoice__container--centered">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="m-invoice__logo">
                          <h1 style="color: #ffffff;"><?php echo $curso->titulo; ?></h1>
                        </div>
                      </div>
                      <div class="col-sm-6" style="margin-top: 120px;">
                        <span class="m-invoice__desc">
                          <span style="color: #ffffff;">Instrutor: <?php echo $curso->instrutor; ?></span>
                          <span style="color: #ffffff;">Categoria: <?php echo $curso->categoria; ?></span>
                        </span>
                      </div>
                    </div>
                    <div class="m-invoice__items">
                      <div class="m-invoice__item">
                        <span style="color: #ffffff;" class="m-invoice__text"><?php echo line2br($curso->descricao); ?></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="m-invoice__body m-invoice__body--centered">
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
                        </div>
                        <div class="m-portlet__body">
                          <div class="m-list-search">
                            <div class="m-list-search__results">
                              <?php if ($unidade->videos): ?>
                                <div class="row">
                                  <div class="col-sm-12">
                                    <span class="m-list-search__result-category m-list-search__result-category--first">
                                      Vídeos
                                    </span>
                                    <?php foreach ($unidade->videos as $video): ?>
                                      <?php if ($video->ativo): ?>
                                        <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/assistir_video/<?php echo $id_inscricao; ?>/<?php echo $video->id; ?>/" class="m-list-search__result-item">
                                          <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-play-circle <?php echo (in_array($video->id, $videos_assistidos))?'m--font-success':''; ?>"></i></span>
                                          <span class="m-list-search__result-item-text"><?php echo $video->titulo; ?></span>
                                        </a>
                                      <?php endif ?>
                                    <?php endforeach ?>
                                  </div>
                                </div>
                              <?php endif ?>
                              <?php if ($unidade->videos && ($unidade->materiais || $unidade->atividades)): ?>
                                <hr>
                              <?php endif ?>
                              <?php if ($unidade->materiais): ?>
                                <div class="row">
                                  <div class="col-sm-12">
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
                                        <a onclick="javascript:marca_download('<?php echo $material->id; ?>');" href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/baixar_material_complementar/<?php echo $id_inscricao; ?>/<?php echo $material->id; ?>/" target="_blank" class="m-list-search__result-item">
                                          <span class="m-list-search__result-item-icon"><i id="material_<?php echo $material->id; ?>" style="font-size: 27px;" class="la la-cloud-download <?php echo (in_array($material->id, $materiais_baixados))?'m--font-success':''; ?>"></i></span>
                                          <span class="m-list-search__result-item-text"><?php echo $material->titulo; ?>.<?php echo $extensao; ?></span>
                                        </a>
                                      <?php endif ?>
                                    <?php endforeach ?>
                                  </div>
                                </div>
                              <?php endif ?>
                              <script>
                                function marca_download(id_material) {
                                  $('#material_'+id_material).addClass('m--font-success');
                                }
                              </script>
                              <?php if ($unidade->materiais && $unidade->atividades): ?>
                                <hr>
                              <?php endif ?>
                              <?php if ($unidade->atividades): ?>
                                <div class="row">
                                  <div class="col-sm-12">
                                    <span class="m-list-search__result-category m-list-search__result-category--first">
                                      Atividades
                                    </span>
                                    <?php foreach ($unidade->atividades as $atividade): ?>
                                      <?php if ($atividade->ativo): ?>
                                        <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/atividade/<?php echo $id_inscricao; ?>/<?php echo $atividade->id; ?>/" class="m-list-search__result-item">
                                          <?php if ($atividade->obrigatoria): ?>
                                            <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-puzzle-piece <?php echo (in_array($atividade->id, $atividades_concluidas))?'m--font-success':''; ?>"></i></span>
                                          <?php else: ?>
                                            <span class="m-list-search__result-item-icon"><i style="font-size: 27px;" class="la la-puzzle-piece m--font-accent"></i></span>
                                          <?php endif ?>
                                          <span class="m-list-search__result-item-text"><?php echo $atividade->titulo; ?></span>
                                        </a>
                                      <?php endif ?>
                                    <?php endforeach ?>
                                  </div>
                                </div>
                              <?php endif ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif ?>
                  <?php endforeach ?>
                </div>
                <div class="m-invoice__footer">
                  <div class="m-invoice__container m-invoice__container--centered">
                    <?php if ($curso_inscricao->avaliacao_nota): ?>
                      <h3>Avaliar o Curso</h3>
                      <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                        <div class="m-alert__icon">
                          <i class="flaticon-interface-2"></i>
                          <span></span>
                        </div>
                        <div class="m-alert__text">
                          Você já avaliou esse curso.
                        </div>
                      </div>
                    <?php else: ?>
                      <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
                        <h3>Avaliar o Curso</h3>
                        <div class="m-form__group form-group">
                          <label>Qual nota você atribui para esse curso?</label>
                          <div class="m-radio-inline" style="text-align: center;">
                            <label class="m-radio">
                              <input type="radio" name="avaliacao_nota" value="1"> 1
                              <span></span>
                            </label>
                            <label class="m-radio" style="margin-left: 50px;">
                              <input type="radio" name="avaliacao_nota" value="2"> 2
                              <span></span>
                            </label>
                            <label class="m-radio" style="margin-left: 50px;">
                              <input type="radio" name="avaliacao_nota" value="3"> 3
                              <span></span>
                            </label>
                            <label class="m-radio" style="margin-left: 50px;">
                              <input type="radio" name="avaliacao_nota" value="4"> 4
                              <span></span>
                            </label>
                            <label class="m-radio" style="margin-left: 50px;">
                              <input type="radio" name="avaliacao_nota" value="5"> 5
                              <span></span>
                            </label>
                          </div>
                        </div>
                        <div class="m-form__group form-group">
                          <label>Gostaria de deixar algum comentário?</label>
                          <textarea name="avaliacao_comentario" class="form-control m-input m-input--square" rows="4"><?php echo set_form_value(false,$form,'avaliacao_comentario'); ?></textarea>
                        </div>
                        <div class="m-form__group form-group" style="text-align: right;">
                          <button type="submit" class="btn m-btn--square  btn-outline-primary m-btn m-btn--custom">Enviar</button>
                        </div>
                      </form>
                    <?php endif ?>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      <?php endif ?>
    </div>
  <?php endif ?>
</div>
