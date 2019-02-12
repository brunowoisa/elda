<script> 
  title('Configurações da Empresa');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Configurações da Empresa", href: "" },
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
      
      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Geral</h5> </div> </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('nome'); ?>">  
            <label for="nome">Nome</label>
            <input type="text" class="form-control m-input m-input--square" name="nome" maxlength="95" value="<?php echo set_form_value($editar,$form,'nome'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('fantasia'); ?>">  
            <label for="fantasia">Fantasia</label>
            <input type="text" class="form-control m-input m-input--square" name="fantasia" maxlength="95" value="<?php echo set_form_value($editar,$form,'fantasia'); ?>" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Endereço</h5> </div> </div>
      <div class="row">
        <div class="col-sm-2">
          <div class="form-group <?php echo form_status('cep'); ?>">  
            <label for="cep">CEP</label>
            <input type="text" class="form-control m-input m-input--square" onblur="busca_cep();" name="cep" data-inputmask="'mask': '99999-999'" maxlength="9" value="<?php echo set_form_value($editar,$form,'cep'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="form-group <?php echo form_status('endereco'); ?>">  
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control m-input m-input--square" name="endereco" maxlength="75" value="<?php echo set_form_value($editar,$form,'endereco'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group <?php echo form_status('numero'); ?>">  
            <label for="numero">Número</label>
            <input type="text" class="form-control m-input m-input--square" name="numero" maxlength="10" value="<?php echo set_form_value($editar,$form,'numero'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('complemento'); ?>">  
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control m-input m-input--square" name="complemento" maxlength="25" value="<?php echo set_form_value($editar,$form,'complemento'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('bairro'); ?>">  
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control m-input m-input--square" name="bairro" maxlength="45" value="<?php echo set_form_value($editar,$form,'bairro'); ?>" autocomplete="off" disabled>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('uf'); ?>">  
            <label for="uf">Estado</label>
            <select class="form-control m-select2 m-input--square" name="uf" disabled>
              <option value="">-- Selecione --</option>
            </select>
            <script>
              $('select[name="uf"]').change(function (e) {
                get_cidades($(this).val(), '');
              });

              $(document).ready(function() {
                get_estados();
              });

              function get_estados() {
                var uf = '<?php echo $this->session->userdata('empresa')->uf; ?>';
                var ibge_cidade = '<?php echo $this->session->userdata('empresa')->ibge_cidade; ?>';

                $.ajax({
                  url: '<?php echo base_url(); ?>Endereco/ajax_get_estados/',
                  type: 'POST',
                  dataType: 'json',
                })
                .done(function(data) {
                  for (var i = data.length - 1; i >= 0; i--) {
                    app = '<option value="'+data[i].uf+'">'+data[i].uf+' - '+data[i].estado+'</option>';
                    $('select[name="uf"]').prepend(app);
                  }
                  $('select[name="uf"]').val(uf).select2();
                  get_cidades(uf,ibge_cidade);
                })
                .fail(function() {
                  swal(
                    'Erro!',
                    'Houve um erro ao buscar os Estados, para continuar reabra a página E27002',
                    'error'
                  );
                });
              }
            </script>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('ibge_cidade'); ?>">  
            <label for="ibge_cidade">Cidade</label>
            <select class="form-control m-select2 m-input--square" name="ibge_cidade" disabled>
              <option value="">-- Selecione --</option>
            </select>
            <script>
              function get_cidades(uf,ibge_cidade) {
                $.ajax({
                  url: '<?php echo base_url(); ?>Endereco/ajax_get_cidades/',
                  type: 'POST',
                  dataType: 'json',
                  data: {uf: uf},
                })
                .done(function(data) {
                  for (var i = data.length - 1; i >= 0; i--) {
                    app = '<option value="'+data[i].ibge_cidade+'">'+data[i].cidade+'</option>';
                    $('select[name="ibge_cidade"]').prepend(app);
                  }
                  $('select[name="ibge_cidade"]').val(ibge_cidade).select2();
                })
                .fail(function() {
                  swal(
                    'Erro!',
                    'Houve um erro ao buscar as Cidades, para continuar reabra a página E27003',
                    'error'
                  );
                });
              }
            </script>
          </div>
        </div>
        <script>
          function busca_cep() {
            var cep = $('input[name="cep"]').val();
            cep = cep.replace("-", "");
            if(cep != '' && cep != '________'){
              $.ajax({
                url: 'https://viacep.com.br/ws/'+cep+'/json/',
                type: 'POST',
                dataType: 'jsonp',
              })
              .done(function(data) {
                if (data) {
                  $('input[name="endereco"]').val(data.logradouro+' '+data.complemento);
                  $('input[name="bairro"]').val(data.bairro);
                  $('select[name="uf"]').val(data.uf).select2();
                  get_cidades(data.uf,data.ibge);
                }
                else {
                  swal(
                    'Atenção!',
                    'CEP não encontrado.',
                    'warning'
                  );
                }
              })
              .fail(function() {
                swal(
                  'Erro!',
                  'Houve um erro ao buscar o CEP, contate o suporte e informe o código E27001',
                  'error'
                );
              });
            }
          }
        </script>
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
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('telefone3'); ?>">  
            <label for="telefone3"><br></label>
            <input type="text" class="form-control m-input m-input--square telefone" name="telefone3" maxlength="15" value="<?php echo set_form_value($editar,$form,'telefone3'); ?>" autocomplete="off">
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('telefone4'); ?>">  
            <label for="telefone4"><br></label>
            <input type="text" class="form-control m-input m-input--square telefone" name="telefone4" maxlength="15" value="<?php echo set_form_value($editar,$form,'telefone4'); ?>" autocomplete="off">
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
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('site'); ?>">  
            <label for="site">Site</label>
            <input type="text" class="form-control m-input m-input--square" name="site" maxlength="100" value="<?php echo set_form_value($editar,$form,'site'); ?>" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="row"> <div class="col-sm-12"> <h5 class="m--font-primary">Logo</h5> </div> </div>
      <div class="row">
        <div class="col-sm-4" style="text-align: center;">
          <?php if ($form->logo != ''): ?>
            <img src="<?php echo $diretorio.$form->logo; ?>" alt="Logo" style="width: 100%;">
          <?php else: ?>
            <img src="<?php echo base_url(); ?>assets/_IMAGES/sem_logo.png" alt="Sem Logo">
          <?php endif ?>
        </div>
        <div class="col-sm-8">
          <div class="form-group m-form__group">
            <label for="logo">Logo</label>
            <div></div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="logo[]" accept=".jpg">
              <label class="custom-file-label" for="logo">Selecionar Arquivo</label>
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