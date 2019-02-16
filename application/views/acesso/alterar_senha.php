<script> 
  title('Alterar Senha');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Alterar Senha", href: "" },
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
    <form id="form_senhas" class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">

      <div class="row">
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('cpf'); ?>">  
            <label for="cpf">CPF</label>
            <input type="text" class="form-control m-input m-input--square" name="cpf" data-inputmask="'mask': '999.999.999-99'" maxlength="14" value="<?php echo set_form_value($editar,$form,'cpf'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="form-group <?php echo form_status('nome'); ?>">  
            <label for="nome">Nome</label>
            <input type="text" class="form-control m-input m-input--square" name="nome" maxlength="95" value="<?php echo set_form_value($editar,$form,'nome'); ?>" autocomplete="off" disabled>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <div class="form-group <?php echo form_status('senha_atual'); ?>">  
            <label for="senha_atual">Senha Atual</label>
            <input type="password" class="form-control m-input m-input--square" name="senha_atual" maxlength="15" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group <?php echo form_status('senha_nova_1'); ?>">  
            <label for="senha_nova_1">Nova Senha</label>
            <input type="password" class="form-control m-input m-input--square" name="senha_nova_1" maxlength="15" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group <?php echo form_status('senha_nova_2'); ?>">  
            <label for="senha_nova_2">Confirmar Nova Senha</label>
            <input type="password" class="form-control m-input m-input--square" name="senha_nova_2" maxlength="15" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12" style="text-align: right;">
          <button type="button" onclick="javascript:validar_senhas();" class="btn m-btn--square  btn-outline-success m-btn m-btn--custom"><i class="la la-check"></i> Salvar</button>
          <?php if (isset($links['voltar'])): ?>
            <a href="<?php echo base_url().$links['voltar']; ?>" class="btn m-btn--square  btn-outline-danger m-btn m-btn--custom"><i class="la la-rotate-left"></i> Cancelar</a>
          <?php endif ?>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $('input[data-inputmask]').inputmask();

  function validar_senhas() {
    // var saa = '<?php echo $this->session->userdata('usuario')->senha; ?>';
    var sa = $('input[name="senha_atual"]').val();
    var s1 = $('input[name="senha_nova_1"]').val();
    var s2 = $('input[name="senha_nova_2"]').val();
    if (s1 == s2 && s1.length >= 5) {
      $('#form_senhas').submit();
    }
    else {
      $('input[name="senha_atual"]').val('');
      if (s1 != s2) {
        swal(
          'Atenção!',
          'A nova senha não é igual à confirmação da nova senha!',
          'warning'
        );
      }
      else {
        swal(
          'Atenção!',
          'A nova senha deve possuir 5 ou mais caracteres!',
          'warning'
        );
      }
    }
  }
</script>