<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-br" >
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>WoiSoft - Acesso</title>
		<meta name="description" content="WoiSoft Sistemas - Muito mais que sistemas de gestão.">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
		<link href="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(); ?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->

		<!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

		<style>
			.m-link {
	    	color: #7d7979;
			}
			.m-link:hover {
	    	color: #e98f1b;
			}
		</style>	
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default" style="min-height: 100%;">
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page" style="min-height: 100%;">
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login"  style="background-image: url(<?php echo base_url(); ?>assets/app/media/img//bg/gb8.jpg); background-position: center; background-repeat: no-repeat; background-size: cover; width: 100%; min-height: 100%;">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" style="background-color: #332201a6; width: 100%; min-height: 100%;">

          <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1  m-login__content m-grid-item--center" id="box_texto">
            <div class="m-grid__item">
              <h3 class="m-login__welcome">Todo Seu</h3>
              <p class="m-login__msg" style="font-size: 17px;">
                Nós sabemos que para gerenciar e expandir<br>
                você precisa de um sistema eficiente.<br>
                Fizemos o melhor deles pensando em você!
              </p>
            </div>
          </div>

          <style>
            @media only screen and (max-width: 1024px) {
              #box_texto {
                display: none;
              }
            }


            .m-input{
              background: rgba(233, 143, 27, 0.21);
            }
            .m-input:focus{
              background: rgba(233, 143, 27, 0.50);
              color: #ffffff;
            }
            .m-login.m-login--1 .m-login__wrapper .m-login__form  .form-control {
              padding: 10px;
              border-radius: 18px;
              border: none;
              margin-bottom: 10px;
              color: #ffffff;
            }

            ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
              color: #d6d6d6;
              opacity: 1; /* Firefox */
            }

            :-ms-input-placeholder { /* Internet Explorer 10-11 */
              color: #d6d6d6;
            }

            ::-ms-input-placeholder { /* Microsoft Edge */
              color: #d6d6d6;
            }

            .m-link {
              color: #ffffff;
            }

            .m-link:hover {
              color: #aad0ff;
            }
          </style>



  				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside ">
  					<div class="m-stack m-stack--hor m-stack--desktop">
  						<div class="m-stack__item m-stack__item--fluid">
  							<div class="m-login__wrapper" style="margin: auto; padding: 0;">
  								<div class="m-login__logo">
  									<a href="https://www.woisoft.com.br/">
  										<img src="<?php echo base_url(); ?>assets/app/media/img//logos/logo.png" style="width: 236px;">
  									</a>
  								</div>
  								<div class="m-login__signin">
  									<div class="m-login__head">
  										<h3 class="m-login__title" style="color: #ffffff;">
  											ACESSE O SISTEMA
  										</h3>
  									</div>
  									<form class="m-login__form m-form" style="margin-top: 10px;" action="<?php echo $form_action; ?>" method="POST">
  										<div class="form-group">
                        <input type="hidden" name="action" value="L">
                        <input class="form-control m-input" type="text" placeholder="CPF" name="cpf" autocomplete="off" data-inputmask="'mask': '999.999.999-99'">
                      </div>
                      <div class="form-group">
                        <input class="form-control m-input" type="password" placeholder="Senha" name="senha">
                      </div>
                      <div class="row m-login__form-sub">
                        <div class="col m--align-left"> </div>
                        <div class="col m--align-right">
                          <a href="#" id="m_login_forget_password" class="m-link">
                            Esqueci a Senha
                          </a>
                        </div>
                      </div>
                      <div class="m-login__form-action" style="margin-top: 5px;">
                        <button class="btn m-btn--square  btn-outline-accent m-btn m-btn--custom m-btn--outline-2x">
                          Acessar
                        </button>
                      </div>
                    </form>
                  </div>
                  <div class="m-login__forget-password">
                    <div class="m-login__head">
                      <h3 class="m-login__title" style="color: #ffffff;">
                        Esqueceu sua senha?
                      </h3>
                      <div class="m-login__desc" style="color: #ffffff; font-size: 15px;">
                        Insira seu CPF para recuperar a senha:
                      </div>
                    </div>
                    <form class="m-login__form m-form" action="<?php echo $form_action; ?>" method="POST">
                      <div class="form-group">
                        <input type="hidden" name="action" value="E">
                        <input class="form-control m-input" type="text" placeholder="CPF" name="cpf" autocomplete="off" data-inputmask="'mask': '999.999.999-99'">
                      </div>
                      <div class="m-login__form-action">
                        <style>
                          #botao_recuperar_senha {
                            color: #fff;
                          }
  											</style>
                        <button id="botao_recuperar_senha" class="btn m-btn--square btn-outline-warning m-btn m-btn--custom m-btn--outline-2x">
                          Recuperar
                        </button>
                        <button id="m_login_forget_password_cancel" class="btn m-btn--square btn-outline-danger m-btn m-btn--custom m-btn--outline-2x">
  												Cancelar
  											</button>
  										</div>
  									</form>
  								</div>
  							</div>
  						</div>
  					</div>
  				</div>
        </div>
        

			</div>
		</div>
		<!-- end:: Page -->
    	<!--begin::Base Scripts -->
		<script src="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
		<script src="<?php echo base_url(); ?>assets/snippets/pages/user/login.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/demo/default/custom/components/forms/widgets/input-mask.js" type="text/javascript"></script> -->
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
            html: 'Sua senha foi enviada para o e-mail <strong><?php echo $email_recuperacao_senha; ?></strong><br>Caso não tenha acesso à este e-mail, gentileza entrar em contato com nossa central de suporte.',
            showCloseButton: true,
            confirmButtonClass: "btn m-btn--square btn-info font-info"
          })
        });
      <?php endif ?>
      
    </script>
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>

