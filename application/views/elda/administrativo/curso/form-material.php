<script> 
  title('<?php echo ($editar)?'Editar':'Novo'; ?> Material Complementar');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "elda/menu/administrativo/" },
    { nome: "Cadastro de Cursos", href: "elda/administrativo/curso/" },
    { nome: "Estruturação do Curso", href: "elda/administrativo/curso/estrutura_curso/<?php echo $curso->id; ?>" },
    { nome: "Editar Unidade", href: "elda/administrativo/curso/estrutura_curso/<?php echo $curso->id; ?>/<?php echo $unidade->id; ?>" },
    { nome: "<?php echo ($editar)?'Editar':'Novo'; ?> Material Complementar", href: "" },
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

      <div class="row" style="margin-bottom: 15px;">
        <?php if (!$editar): ?>
          <div class="col-sm-12">
            <div class="form-group m-form__group">
              <label for="arquivo">Arquivo</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="arquivo[]">
                <label class="custom-file-label" for="arquivo">Selecionar Arquivo</label>
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
          <?php 
          $info_file = pathinfo($diretorio.$form->material);
          $extensao = $info_file['extension'];
          ?>
          <div class="col-sm-12" style="text-align: center;">
            <br>
            <br>
            <a href="<?php echo $diretorio.$form->material; ?>" target="_blank" class="btn btn-outline-brand m-btn btn-lg m-btn--icon m-btn--outline-2x">
              <span>
                <i class="flaticon-download" style="font-size: 50px;"></i>
                <span><?php echo $form->titulo; ?>.<?php echo $extensao; ?></span>
              </span>
            </a>
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