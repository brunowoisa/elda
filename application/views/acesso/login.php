<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <title>Elda Treinamentos</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
      WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
      });
    </script>
    <link href="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/demo/demo5/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/_IMAGES/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/_IMAGES/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/_IMAGES/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url(<?php echo base_url(); ?>assets/app/media/img/bg/gb8_3.png);">
        <div class="m-grid__item m-grid__item--fluid  m-login__wrapper">
          <div class="m-login__container">
            <div class="m-login__logo">
              <a href="#">
                <img src="<?php echo base_url(); ?>assets/app/media/img/logos/Elda2.png" style="max-width: 100%;">
              </a>
            </div>
            <div class="m-login__signin">
              <div class="m-login__head">
                <h3 class="m-login__title" style="color: #34bfa3;">Acesso</h3>
              </div>
              <style>
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control {
                  color: #dedede;
                  background: #50777cbf; 
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control:focus {
                  color: #dedede; 
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control::-moz-placeholder {
                  color: #d6d6d6;
                  opacity: 1; 
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control:-ms-input-placeholder {
                  color: #d6d6d6; 
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control::-webkit-input-placeholder {
                  color: #d6d6d6; 
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control:focus::-moz-placeholder {
                  color: #d6d6d6;
                }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control:focus:-ms-input-placeholder {
                  color: #d6d6d6; }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .form-control:focus::-webkit-input-placeholder {
                  color: #d6d6d6; }
                .m-login.m-login--2.m-login-2--skin-3 .m-login__container .m-login__form .m-login__form-sub .m-link:hover:after {
                  border-bottom: 1px solid #34bfa3;
                }
              </style>
              <form class="m-login__form m-form" action="<?php echo $form_action; ?>" method="POST">
                <div class="form-group m-form__group">
                  <input type="hidden" name="action" value="L">
                  <input class="form-control m-input" type="text" placeholder="CPF" name="cpf" autocomplete="off" data-inputmask="'mask': '999.999.999-99'">
                </div>
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="password" placeholder="Senha" name="senha">
                </div>
                <div class="row m-login__form-sub">
                  <div class="col m--align-right m-login__form-right">
                    <a href="javascript:;" id="m_login_forget_password" class="m-link" style="color: #34bfa3;">Recuperar Senha</a>
                  </div>
                </div>
                <div class="m-login__form-action">
                  <button type="submit" class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Acessar</button>
                </div>
              </form>
            </div>
            <div class="m-login__forget-password">
              <div class="m-login__head">
                <h3 class="m-login__title" style="color: #34bfa3;">Esqueceu sua senha?</h3>
                <div class="m-login__desc" style="color: #34bfa3;">Informe seu CPF para recuperar seu acesso.</div>
              </div>
              <form class="m-login__form m-form" action="<?php echo $form_action; ?>" method="POST">
                <div class="form-group m-form__group">
                  <input type="hidden" name="action" value="E">
                  <input class="form-control m-input" type="text" placeholder="CPF" name="cpf" autocomplete="off" data-inputmask="'mask': '999.999.999-99'">
                </div>
                <div class="m-login__form-action">
                  <button type="submit" class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Recuperar</button>&nbsp;&nbsp;
                  <button id="m_login_forget_password_cancel" class="btn btn-outline-success m-btn m-btn--pill m-btn--custom  m-login__btn">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/demo/default/custom/components/base/sweetalert2.js" type="text/javascript"></script>
    <script>
      $('input[data-inputmask]').inputmask();    
      <?php if (isset($erro)): ?>
        $(document).ready(function() {
          swal({
            title: "Erro!",
            text: "<?php echo $erro; ?>",
            type: "error",
            confirmButtonClass: "btn m-btn--square btn-danger font-danger",
            showCloseButton: true,
          });
        });
      <?php endif ?>
      <?php if (isset($erro_validacao)): ?>
        $(document).ready(function() {
          swal({
            title: 'Atenção',
            type: 'info',
            html: '<?php echo str_replace("\n", "", $erro_validacao); ?>',
            showCloseButton: true,
            confirmButtonClass: "btn m-btn--square btn-info font-info"
          })
        });
      <?php endif ?>
      <?php if (isset($email_recuperacao_senha)): ?>
        $(document).ready(function() {
          swal({
            title: 'Sucesso!',
            type: 'success',
            html: 'Sua senha foi enviada para o e-mail <strong><?php echo $email_recuperacao_senha; ?></strong>',
            showCloseButton: true,
            confirmButtonClass: "btn m-btn--square btn-info font-info"
          })
        });
      <?php endif ?>
    </script>
  </body>
</html>