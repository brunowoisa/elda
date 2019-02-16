<script> 
  title('<?php echo ($editar)?'Editar':'Nova'; ?> Categoria');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "elda/menu/administrativo/" },
    { nome: "Cadastro de Categorias", href: "elda/administrativo/categoria/" },
    { nome: "<?php echo ($editar)?'Editar':'Nova'; ?> Categoria", href: "" },
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
    <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group <?php echo form_status('nome'); ?>">  
            <label for="nome">Nome</label>
            <input type="text" class="form-control m-input m-input--square" name="nome" maxlength="45" value="<?php echo set_form_value($editar,$form,'nome'); ?>" autocomplete="off">
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
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group <?php echo form_status('descricao'); ?>">  
            <label for="descricao">Descrição</label>
            <textarea class="form-control m-input" name="descricao" rows="8"><?php echo set_form_value($editar,$form,'descricao'); ?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12" style="text-align: right;">
          <button type="submit" class="btn m-btn--square  btn-outline-success m-btn m-btn--custom"><i class="la la-check"></i> Salvar</button>
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