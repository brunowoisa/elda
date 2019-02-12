<script> 
  title('Configurações do Usuário');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Configurações do Usuário", href: "" },
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
    <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="id_empresa_contrato" value="<?php echo $form->id_empresa_contrato; ?>">
      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Geral</h5> </div> </div>
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

      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Contato</h5> </div> </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('telefone1'); ?>">  
            <label for="telefone1">Telefones</label>
            <input type="text" class="form-control m-input m-input--square telefone" name="telefone1" maxlength="15" value="<?php echo set_form_value($editar,$form,'telefone1'); ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('telefone2'); ?>">  
            <label for="telefone2"><br></label>
            <input type="text" class="form-control m-input m-input--square telefone" name="telefone2" maxlength="15" value="<?php echo set_form_value($editar,$form,'telefone2'); ?>" autocomplete="off">
          </div>
        </div>
        <script>
          jQuery("input.telefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {  
                var target, phone, element;  
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
                phone = target.value.replace(/\D/g, '');
                element = $(target);  
                element.unmask();  
                if(phone.length > 10) {  
                    element.mask("(99) 99999-999?9");  
                } else {  
                    element.mask("(99) 9999-9999?9");  
                }  
            });
        </script>
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('email'); ?>">  
            <label for="email">E-mail</label>
            <input type="text" class="form-control m-input m-input--square" name="email" maxlength="100" value="<?php echo set_form_value($editar,$form,'email'); ?>" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Foto</h5> </div> </div>
      <div class="row">
        <div class="col-sm-4" style="text-align: center;">
          <?php if ($form->foto != ''): ?>
            <img src="<?php echo $diretorio.$form->foto; ?>" alt="foto" style="width: 100%;">
          <?php else: ?>
            <img src="<?php echo base_url(); ?>assets/_IMAGES/sem_foto.png" alt="Sem foto" style="width: 50%;">
          <?php endif ?>
        </div>
        <div class="col-sm-8">
          <div class="form-group m-form__group">
            <label for="foto">Foto</label>
            <div></div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="foto[]" accept=".jpg">
              <label class="custom-file-label" for="foto">Selecionar Arquivo</label>
            </div>
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

      <div class="row">
        <div class="col-sm-12" style="text-align: right;">
          <button type="submit" class="btn m-btn--square  btn-outline-success m-btn m-btn--custom"><i class="la la-check"></i> Salvar</button>
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
</script>