<script> 
  title('<?php echo ($editar)?'Editar':'Novo'; ?> Vídeo');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Cadastros", href: "elda/menu/cadastro/" },
    { nome: "Cadastro de Cursos", href: "elda/cadastro/curso/" },
    { nome: "Estruturação do Curso", href: "elda/cadastro/curso/estrutura_curso/<?php echo $curso->id; ?>" },
    { nome: "Editar Unidade", href: "elda/cadastro/curso/estrutura_curso/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>" },
    { nome: "<?php echo ($editar)?'Editar':'Novo'; ?> Vídeo", href: "" },
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
        <div class="col-sm-8">
          <div class="form-group <?php echo form_status('titulo'); ?>">  
            <label for="titulo">Título</label>
            <input type="text" class="form-control m-input m-input--square" name="titulo" maxlength="200" value="<?php echo set_form_value($editar,$form,'titulo'); ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-4">
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

      <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12">
          <div class="m-form__group form-group <?php echo form_status('tipo'); ?>">
            <label for="tipo">Tipo de Envio</label>
            <div class="m-radio-inline">
              <label class="m-radio">
                <input type="radio" name="tipo" value="I" id="radio_i" <?php echo ($editar)?'disabled':''; ?>> Código de Incorporação<span></span>
              </label>
              <label class="m-radio">
                <input type="radio" name="tipo" value="U" id="radio_u" <?php echo ($editar)?'disabled':''; ?>> Upload de Arquivo <span></span>
              </label>
            </div>
          </div>
        </div>
      </div>

      <script>
        $('input[name="tipo"]').change(function() {
          verifica_tipo($(this).val());
        });
        
        $(document).ready(function() {
          <?php if ($editar && $form->tipo == 'U'): ?>
            $('#radio_u').prop('checked', true).trigger('change');
          <?php else: // Tanto o else da verificação do tipo, quanto o padrão da tela de cadastro cairão em incorporação (I) ?>
            $('#radio_i').prop('checked', true).trigger('change');
          <?php endif ?>
        });

        function verifica_tipo(tipo) {
          if (tipo == 'I') {
            $('#incorporacao').show();
            $('#upload').hide();
          }
          else {
            $('#upload').show();
            $('#incorporacao').hide();
          }
        }
      </script>

      <?php if ($editar): ?>
        <input type="hidden" name="tipo" value="<?php echo $form->tipo; ?>">
      <?php endif ?>

      <div class="row" id="incorporacao" style="display: none;">
        <div class="col-sm-12">
          <div class="form-group <?php echo form_status('video_incorporar'); ?>">  
            <label for="video_incorporar">Código de Incorporação</label>
            <textarea name="video_incorporar" class="form-control m-input m-input--square" rows="7"><?php echo set_form_value($editar,$form,'video_incorporar'); ?></textarea>
          </div>
        </div>
        <script>
          $('textarea[name="video_incorporar"]').blur(function() {
            exibe_incorporacao();
          });

          $(document).ready(function() {
            exibe_incorporacao();
          });

          function exibe_incorporacao() {
            $('#exibir_incorporacao').html($('textarea[name="video_incorporar"]').val());
          }
        </script>
        <div class="col-sm-12" style="text-align: center;" id="exibir_incorporacao">
          
        </div>
      </div>

      <div class="row" id="upload" style="margin-bottom: 15px; display: none;">
        <?php if (!$editar): ?>
          <div class="col-sm-12">
            <div class="form-group m-form__group">
              <label for="video">Vídeo</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="video[]" accept="video/mp4,video/x-m4v,video/*">
                <label class="custom-file-label" for="video">Selecionar Vídeo</label>
              </div>
            </div>
          </div>
        <script>
          $(document).ready(function() {
            $('.custom-file-input').on('change',function(){
              var fileName = $(this).val();
              $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
          });
        </script>
        <?php else: ?>
          <div class="col-sm-12">
            <video width="100%" controls>
              <?php 
              $link = $diretorio.$form->video;
              $mime = mime_content_type($link);
              ?>
              <source src="<?php echo $link; ?>" type="<?php echo $mime; ?>">
              Seu navegador não suporta Vídeos. Por favor atualize para a versão mais recente.
            </video>
          </div>
        <?php endif ?>
      </div>

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