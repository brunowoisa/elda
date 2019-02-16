<script> 
  title('<?php echo ($editar)?'Editar':'Nova'; ?> Atividade');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "elda/menu/administrativo/" },
    { nome: "Cadastro de Cursos", href: "elda/administrativo/curso/" },
    { nome: "Estruturação do Curso", href: "elda/administrativo/curso/estrutura_curso/<?php echo $curso->id; ?>" },
    { nome: "Editar Unidade", href: "elda/administrativo/curso/estrutura_curso/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>" },
    { nome: "<?php echo ($editar)?'Editar':'Nova'; ?> Atividade", href: "" },
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
    <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('titulo'); ?>">  
            <label for="titulo">Título</label>
            <input type="text" class="form-control m-input m-input--square" name="titulo" maxlength="200" value="<?php echo set_form_value($editar,$form,'titulo'); ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('obrigatoria'); ?>">  
            <label for="obrigatoria">Tipo</label>
            <select class="form-control m-select2 m-input--square" name="obrigatoria">
              <option value="">-- Selecione --</option>
              <option value="1" <?php echo set_form_select($editar,$form,'obrigatoria', '1'); ?>>Obrigatória</option>
              <option value="0" <?php echo set_form_select($editar,$form,'obrigatoria', '0'); ?>>Optativa</option>
            </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('ativo'); ?>">  
            <label for="ativo">Status</label>
            <select class="form-control m-select2 m-input--square" name="ativo">
              <option value="">-- Selecione --</option>
              <option value="1" <?php echo set_form_select($editar,$form,'ativo', '1'); ?>>Ativo</option>
              <option value="0" <?php echo set_form_select($editar,$form,'ativo', '0'); ?>>Inativo</option>
            </select>
          </div>
        </div>
      </div>

      <?php if ($editar): ?>
        <hr>
        <div class="row">
          <div class="col-sm-12" id="bloco_questoes">
            <?php foreach ($questoes as $key => $questao): ?>
              <div id="questao_<?php echo $key; ?>" class="questao m-portlet m-portlet--info m-portlet--head-solid-bg m-portlet--bordered">
                <div class="m-portlet__head">
                  <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                      <span class="m-portlet__head-icon">
                        <i class="la la-chevron-right"></i>
                      </span>
                      <h3 class="m-portlet__head-text">
                        Questao <?php echo $key+1; ?>
                      </h3>
                    </div>
                  </div>
                  <div class="m-portlet__head-tools">
                    <button type="button" onclick="javascript:remove_questao('<?php echo $key; ?>');" class="m-btn btn btn-outline-light"><i class="fa fa-times"></i> Remover Questão</button>
                  </div>
                </div>
                <div class="m-portlet__body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h5 class="m--font-primary">Enunciado</h5>
                      <textarea class="summernote_enunciado" name="questao[<?php echo $key+1; ?>][enunciado]"><?php echo $questao->enunciado; ?></textarea>
                      <h5 class="m--font-success">Alternativa Correta</h5>
                      <input type="text" class="form-control m-input m-input--square" name="questao[<?php echo $key+1; ?>][alternativa][c]" value="<?php echo $questao->alternativa_correta; ?>" autocomplete="off">
                      <h5 class="m--font-danger">Alternativa Errada 1</h5>
                      <input type="text" class="form-control m-input m-input--square" name="questao[<?php echo $key+1; ?>][alternativa][e1]" value="<?php echo $questao->alternativa_errada_1; ?>" autocomplete="off">
                      <h5 class="m--font-danger">Alternativa Errada 2</h5>
                      <input type="text" class="form-control m-input m-input--square" name="questao[<?php echo $key+1; ?>][alternativa][e2]" value="<?php echo $questao->alternativa_errada_2; ?>" autocomplete="off">
                      <h5 class="m--font-danger">Alternativa Errada 3</h5>
                      <input type="text" class="form-control m-input m-input--square" name="questao[<?php echo $key+1; ?>][alternativa][e3]" value="<?php echo $questao->alternativa_errada_3; ?>" autocomplete="off">
                      <h5 class="m--font-danger">Alternativa Errada 4</h5>
                      <input type="text" class="form-control m-input m-input--square" name="questao[<?php echo $key+1; ?>][alternativa][e4]" value="<?php echo $questao->alternativa_errada_4; ?>" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>

        <script>
          var Summernote={init:function(){
            $(".summernote_enunciado").summernote({
              height:250,
              toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline']],
                ['fontname', ['fontname']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'style']],
                ['table', ['table']]
              ],
              callbacks: {
                onInit: function() {
                  $('#modal_loading_1').modal('hide');
                }
              }
            })}
          };

          <?php if ($questoes): ?>
            jQuery(document).ready(function(){
              $('#modal_loading_1').modal('show');
            });
          <?php endif ?>


          $('#modal_loading_1').on('shown.bs.modal', function (e) {
            Summernote.init();
          })

          function remove_questao(bloco) {
            $('#questao_'+bloco).remove();
          }
        
          function prepara_adiciona_questao() {
            $('#modal_loading').modal('show');
          }

          $('#modal_loading').on('shown.bs.modal', function (e) {
            adiciona_questao();
          })

          function adiciona_questao() {
            var numero_questao = $("#bloco_questoes .questao").length + 1;
            var app = ''+
              '<div id="questao_'+numero_questao+'" class="questao m-portlet m-portlet--info m-portlet--head-solid-bg m-portlet--bordered">'+
                '<div class="m-portlet__head">'+
                  '<div class="m-portlet__head-caption">'+
                    '<div class="m-portlet__head-title">'+
                      '<span class="m-portlet__head-icon">'+
                        '<i class="la la-chevron-right"></i>'+
                      '</span>'+
                      '<h3 class="m-portlet__head-text">'+
                        'Questao '+numero_questao+
                      '</h3>'+
                    '</div>'+
                  '</div>'+
                  '<div class="m-portlet__head-tools">'+
                    '<button type="button" onclick="javascript:remove_questao('+numero_questao+');" class="m-btn btn btn-outline-light"><i class="fa fa-times"></i> Remover Questão</button>'+
                  '</div>'+
                '</div>'+
                '<div class="m-portlet__body">'+
                  '<div class="row">'+
                    '<div class="col-sm-12">'+
                      '<h5 class="m--font-primary">Enunciado</h5>'+
                      '<textarea class="summernote_enunciado_'+numero_questao+'" name="questao['+numero_questao+'][enunciado]"></textarea>'+
                      '<h5 class="m--font-success">Alternativa Correta</h5>'+
                      '<input type="text" class="form-control m-input m-input--square" name="questao['+numero_questao+'][alternativa][c]" autocomplete="off">'+
                      '<h5 class="m--font-danger">Alternativa Errada 1</h5>'+
                      '<input type="text" class="form-control m-input m-input--square" name="questao['+numero_questao+'][alternativa][e1]" autocomplete="off">'+
                      '<h5 class="m--font-danger">Alternativa Errada 2</h5>'+
                      '<input type="text" class="form-control m-input m-input--square" name="questao['+numero_questao+'][alternativa][e2]" autocomplete="off">'+
                      '<h5 class="m--font-danger">Alternativa Errada 3</h5>'+
                      '<input type="text" class="form-control m-input m-input--square" name="questao['+numero_questao+'][alternativa][e3]" autocomplete="off">'+
                      '<h5 class="m--font-danger">Alternativa Errada 4</h5>'+
                      '<input type="text" class="form-control m-input m-input--square" name="questao['+numero_questao+'][alternativa][e4]" autocomplete="off">'+
                    '</div>'+
                  '</div>'+
                '</div>'+
              '</div>';
            $('#bloco_questoes').append(app);
            $(".summernote_enunciado_"+numero_questao).summernote({
              height:250,
              toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline']],
                ['fontname', ['fontname']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph', 'style']],
                ['table', ['table']]
              ],
              callbacks: {
                onInit: function() {
                  $('#modal_loading').modal('hide');
                }
              }
            });
          }
        </script>

        <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
          <div class="col-sm-12" style="text-align: center;">
            <button onclick="javascript:prepara_adiciona_questao();" type="button" class="btn m-btn--square btn-outline-primary m-btn m-btn--custom"><i class="flaticon-add-circular-button"></i> Adicionar Questão</button>
          </div>
        </div>
      <?php endif ?>

      <div class="row">
        <div class="col-sm-12" style="text-align: right;">
          <button type="submit" class="btn m-btn--square btn-outline-success m-btn m-btn--custom"><i class="la la-check"></i> Salvar</button>
          <?php if (isset($links['voltar'])): ?>
            <a href="<?php echo base_url().$links['voltar']; ?>" class="btn m-btn--square  btn-outline-danger m-btn m-btn--custom"><i class="la la-rotate-left"></i> Cancelar</a>
          <?php endif ?>
        </div>
      </div>
    </form>

    <?php if ($editar): ?>
      <div class="row" style="margin-top: 0px;">
        <div class="col-sm-12">
          <div class="m-alert m-alert--icon m-alert--outline alert" role="alert">
            <div class="m-alert__icon">
              <i class="la la-info"></i>
            </div>
            <div class="m-alert__text">
              <strong>Cadastro:</strong> <?php echo $form->cadastro_usuario; ?> em <?php echo $form->cadastro; ?><br>
              <strong>Última Alteração:</strong> <?php echo $form->last_change_usuario; ?> em <?php echo $form->last_change; ?>
            </div>  
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>

<div class="modal fade" id="modal_loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; margin-top: 50px;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
       <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size: 60px;"></i></p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_loading_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; margin-top: 50px;" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p style="text-align: center; height: 100%; vertical-align: center;">
          <i class="fa fa-spinner fa-spin" style="font-size: 60px;"></i>
          <br>Carregando recursos da tela...
        </p>
      </div>
    </div>
  </div>
</div>