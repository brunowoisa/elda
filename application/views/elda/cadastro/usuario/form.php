<script> 
  title('<?php echo ($editar)?'Editar':'Novo'; ?> Usuário');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Cadastros", href: "elda/menu/cadastro/" },
    { nome: "Cadastro de Usuários", href: "elda/cadastro/usuario/" },
    { nome: "<?php echo ($editar)?'Editar':'Novo'; ?> Usuário", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
    $('input[data-inputmask]').inputmask();
  });
  $('[data-toggle=confirmation]').confirmation({
    rootSelector: '[data-toggle=confirmation]',
  });
  $('input[name="cpf"]').blur(function() {
    var cpf = $(this).val().replace('_', '');
    if (cpf.length == 14) { // 999.999.999-99
      if (isCpf(cpf)) {
        $.ajax({
          url: '<?php echo base_url(); ?>elda/cadastro/usuario/ajax_verifica_usuario_pelo_cpf/',
          type: 'POST',
          dataType: 'json',
          data: {cpf: cpf},
        })
        .done(function(data) {
          if (data) {
            if (data.existente) {
              $('input[name="cpf"]').val('');
              swal({
                title: "Erro!",
                html: "O CPF "+cpf+" já se encontra em uso pelo usuário "+data['usuario'].nome+"!",
                type: "error"
              });
            }
            else {
              if (data['usuario'] != null) {
                $('input[name="nome"]').val(data['usuario'].nome);
              }
            }
          }
        })
        .fail(function() {
          swal({
            title: "Atenção!",
            html: "Houve um erro ao consultar o CPF (E_U01)!",
            type: "warning"
          });
        });
      }
      else {
        $(this).val('');
        swal({
          title: "Atenção!",
          html: "Informe o CPF '"+cpf+"' não é válido!",
          type: "warning"
        });
      }
    }
    else {
      if (cpf != '') {
        $(this).val('');
        swal({
          title: "Atenção!",
          html: "Informe um CPF válido!",
          type: "warning"
        });
      }
    }
  });
  <?php if ($editar): ?>
    function enviar_senha_email() {
      var id_usuario = '<?php echo $form->id; ?>';
      $.ajax({
        url: '<?php echo base_url(); ?>elda/cadastro/usuario/ajax_enviar_senha_email/',
        type: 'POST',
        dataType: 'json',
        data: {id_usuario: id_usuario},
      })
      .done(function(data) {
        if (data) {
          swal({
            title: "Sucesso!",
            html: "A Senha foi enviada por e-mail com sucesso!",
            type: "success"
          });
          $('#mensagem_email_enviado').html('<strong>E-mail com senha: </strong><br> <i class="fa fa-check-circle m--font-success"></i> Enviado.')
        }
        else {
          swal({
            title: "Atenção!",
            html: "Houve um erro ao enviar a senha por e-mail (E_U03)!",
            type: "warning"
          });
        }
      })
      .fail(function() {
        swal({
          title: "Atenção!",
          html: "Houve um erro ao enviar a senha por e-mail (E_U02)!",
          type: "warning"
        });
      });
    }
  <?php endif ?>
    
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">
    <?php $this->load->view('include/botoes',$links); ?>
    <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('cpf'); ?>">  
            <label for="cpf">CPF</label>
            <input type="text" class="form-control m-input m-input--square" name="cpf" data-inputmask="'mask': '999.999.999-99'" value="<?php echo set_form_value($editar,$form,'cpf'); ?>" autocomplete="off" <?php echo ($editar)?'disabled':''; ?>>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group <?php echo form_status('nome'); ?>">  
            <label for="nome">Nome</label>
            <input type="text" class="form-control m-input m-input--square" name="nome" maxlength="45" value="<?php echo set_form_value($editar,$form,'nome'); ?>" autocomplete="off">
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
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group <?php echo form_status('administrador'); ?>">  
            <label for="administrador">Tipo de Usuário</label>
            <select class="form-control m-select2 m-input--square" name="administrador">
              <option value="">-- Selecione --</option>
              <option value="1" <?php echo set_form_select($editar,$form,'administrador', '1'); ?>>Administrador</option>
              <option value="0" <?php echo set_form_select($editar,$form,'administrador', '0'); ?>>Usuário Comum</option>
            </select>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="form-group <?php echo form_status('email'); ?>">  
            <label for="email">E-mail</label>
            <input type="text" class="form-control m-input m-input--square" name="email" maxlength="250" value="<?php echo set_form_value($editar,$form,'email'); ?>" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="row">
        <?php if ($editar): ?>
          <div class="col-sm-6" style="text-align: left;">
            <a id="btn_enviar_senha" class="btn m-btn m-btn--custom m-btn--square  btn-info" data-toggle="confirmation" data-popout="true" data-title="Confirma o envio da senha?" data-btn-ok-label="Enviar" data-btn-ok-class="btn-success" data-btn-cancel-label="Cancelar" data-btn-cancel-class="btn-danger" data-content="A senha será enviada para o e-mail <?php echo $form->email; ?>." href="javascript:enviar_senha_email();" style="margin-bottom: 10px;"><i class="fa fa-envelope"></i> Enviar Senha</a>
          </div>
          <div class="col-sm-6" style="text-align: right;">
        <?php else: ?>
          <div class="col-sm-12" style="text-align: right;">
        <?php endif ?>
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
            <div class="m-alert__text" id="mensagem_email_enviado">
              <?php if ($form->senha_enviada_email == true): ?>
                <strong>E-mail com senha: </strong><br> <i class="fa fa-check-circle m--font-success"></i> Enviado em <?php echo $form->senha_enviada_email_datahora; ?>.
              <?php else: ?>
                <strong>E-mail com senha: </strong><br> <i class="fa fa-times-circle m--font-danger"></i> Não Enviado.
              <?php endif ?>
            </div>  
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>