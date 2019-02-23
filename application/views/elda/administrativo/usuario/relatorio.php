<script> 
  title('Relatório de Desempenho');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "elda/menu/administrativo/" },
    { nome: "Relatório de Desempenho", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
    $('input[data-inputmask]').inputmask();
  });
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">
    <?php $this->load->view('include/botoes',$links); ?>
    <form target="_blank" class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group <?php echo form_status('id_usuario'); ?>">  
            <label for="id_usuario">Usuário</label>
            <select class="form-control m-select2 m-input--square" name="id_usuario">
              <option value="">-- Selecione --</option>
              <?php foreach ($usuarios as $key): ?>
                <option value="<?php echo $key->id; ?>" <?php echo set_form_select($editar,$form,'id_usuario', $key->id); ?>><?php echo $key->nome; ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12" style="text-align: center;">
          <button type="submit" class="btn m-btn--square  btn-outline-warning m-btn m-btn--custom"><i class="flaticon-file-2"></i> Gerar Relatório</button>
        </div>
      </div>
      <script>
        <?php if (isset($relatorio_id_usuario)): ?>
          $(document).ready(function() {
            var id_usuario = '<?php echo $relatorio_id_usuario; ?>';
            var Window = window.open (
              '<?php echo base_url(); ?>elda/administrativo/usuario/imprimir_relatorio/'+id_usuario,
              '_blank' );
          });
        <?php endif ?>
      </script>
    </form>
  </div>
</div>