<script> 
  title('<?php echo ($editar)?'Editar':'Novo'; ?> Curso');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Cadastros", href: "elda/menu/cadastro/" },
    { nome: "Cadastro de Cursos", href: "elda/cadastro/curso/" },
    <?php if ($editar): ?>
      { nome: "Estruturação do Curso", href: "elda/cadastro/curso/estrutura_curso/<?php echo $form->id; ?>" },
    <?php endif ?>
    { nome: "<?php echo ($editar)?'Editar':'Novo'; ?> Curso", href: "" },
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
        <div class="col-sm-12">
          <div class="form-group <?php echo form_status('titulo'); ?>">  
            <label for="titulo">Título</label>
            <input type="text" class="form-control m-input m-input--square" name="titulo" maxlength="255" value="<?php echo set_form_value($editar,$form,'titulo'); ?>" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group <?php echo form_status('id_categoria'); ?>">  
            <label for="id_categoria">Categoria</label>
            <select class="form-control m-select2 m-input--square" name="id_categoria">
              <option value="">-- Selecione --</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?php echo $categoria->id; ?>" <?php echo set_form_select($editar,$form,'id_categoria', $categoria->id); ?>><?php echo $categoria->nome; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="form-group <?php echo form_status('instrutor'); ?>">  
            <label for="instrutor">Instrutor</label>
            <input type="text" class="form-control m-input m-input--square" name="instrutor" maxlength="55" value="<?php echo set_form_value($editar,$form,'instrutor'); ?>" autocomplete="off">
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
          <div class="form-group <?php echo form_status('palavras_chave'); ?>">  
            <label for="palavras_chave">Palavras-Chave</label>
            <textarea class="form-control m-input" name="palavras_chave" rows="5" maxlength="500"><?php echo set_form_value($editar,$form,'palavras_chave'); ?></textarea>
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