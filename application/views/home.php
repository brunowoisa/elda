<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
  	<meta charset="utf-8" />
  	<title>Elda</title>
    <meta name="description" content="Elda - Sistema de Treinamentos">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
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
    <link href="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/demo/demo5/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />


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
      /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
      .modal_loading {
          display:    none;
          position:   fixed;
          z-index:    1000;
          top:        0;
          left:       0;
          height:     100%;
          width:      100%;
          background: rgba( 255, 255, 255, 0.85 ) 
                      url('<?php echo base_url(); ?>assets/loading.gif') 
                      50% 50% 
                      no-repeat;
      }

      /* When the body has the loading class, we turn
         the scrollbar off with overflow:hidden */
      body.loading .modal_loading {
        overflow: hidden;   
      }

      /* Anytime the body has the loading class, our
         modal element will be visible */
      body.loading .modal_loading {
        display: block;
      }

      .note-editing-area {
        margin-top: 15px;
      }

    </style>

	  <script>
      window.onload = function(){
        $('.m-menu__item').click(function() {
          $('.m-menu__item').removeClass('m-menu__item--active');
          $(this).addClass('m-menu__item--active');
        });
      }
    </script>

    <script src="<?php echo base_url(); ?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/demo/demo5/base/scripts.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/app/js/dashboard.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/bootstrap-confirmation.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/demo/default/custom/crud/forms/widgets/input-mask.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/jquery.maskMoney.min.js" type="text/javascript"></script>
    <!-- Ajax -->
    <script src="<?php echo base_url(); ?>assets/ajax.js" type="text/javascript"></script>
    <script>
      popover=function(t){var e=t.data("skin")?"m-popover--skin-"+t.data("skin"):"",a=t.data("trigger")?t.data("trigger"):"hover";t.popover({trigger:a,template:'            <div class="m-popover '+e+' popover" role="tooltip">                <div class="arrow"></div>                <h3 class="popover-header"></h3>                <div class="popover-body"></div>            </div>'})}
    </script>
  </head>
  <!-- end::Head -->
  <!-- begin::Body -->
  <body  class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
  	<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
	    <!-- begin::Header -->
			<header id="m_header" class="m-grid__item   m-header "  m-minimize="minimize" m-minimize-offset="200" m-minimize-mobile-offset="200" >
  			<div class="m-header__top">
    			<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
      			<div class="m-stack m-stack--ver m-stack--desktop">   
        			<!-- begin::Brand -->
							<div class="m-stack__item m-brand">
							  <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
							    <div class="m-stack__item m-stack__item--middle m-brand__logo">
							      <a href="index.html" class="m-brand__logo-wrapper">
							        <img alt="<?php //echo $this->session->userdata('sistema')->nome; ?>" style="height: 50px;" src="<?php echo base_url(); ?>assets/app/media/img/logos/Elda.png"/>
							      </a>  
							    </div>
							    <div class="m-stack__item m-stack__item--middle m-brand__tools">
				            <!-- begin::Responsive Header Menu Toggler-->
							      <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
							        <span></span>
							      </a>
							      <!-- end::Responsive Header Menu Toggler-->
							      <!-- begin::Topbar Toggler-->
							      <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
							        <i class="flaticon-more"></i>
							      </a>
							      <!--end::Topbar Toggler-->
							    </div>
							  </div>
							</div>
							<!-- end::Brand -->   
        			<!-- begin::Topbar -->
							<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
							  <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
							    <div class="m-stack__item m-topbar__nav-wrapper">
							      <ul class="m-topbar__nav m-nav m-nav--inline">
							        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
												  <a href="#" class="m-nav__link m-dropdown__toggle">
												    <span class="m-topbar__username" style="color: #54a17c;">
												    	<?php echo $this->session->userdata('usuario')->apelido; ?> &nbsp;&nbsp;
												    </span>  
												    <span class="m-topbar__userpic">
                              <?php if ($this->session->userdata('usuario')->foto != ''): ?>
												        <img src="<?php echo base_url().'assets/_UPLOADS/USUARIOS/'.$this->session->userdata('usuario')->id.'/FOTO/'.$this->session->userdata('usuario')->foto ?>" class="m--img-rounded m--marginless m--img-centered" alt="Foto"/>
                              <?php else: ?>
                                <img src="<?php echo base_url(); ?>assets/_IMAGES/sem_foto.png" class="m--img-rounded m--marginless m--img-centered" alt="Sem Foto"/>
                              <?php endif ?>
												    </span>
												  </a>
												  <div class="m-dropdown__wrapper">
												    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												    <div class="m-dropdown__inner">
												      <div class="m-dropdown__header m--align-center" style="background: url(<?php echo base_url(); ?>assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
												        <div class="m-card-user m-card-user--skin-dark">
												          <div class="m-card-user__pic">
                                    <?php if ($this->session->userdata('usuario')->foto != ''): ?>
												              <img src="<?php echo base_url().'assets/_UPLOADS/USUARIOS/'.$this->session->userdata('usuario')->id.'/FOTO/'.$this->session->userdata('usuario')->foto ?>" class="m--img-rounded m--marginless" alt="Foto"/>
                                    <?php else: ?>
                                      <img src="<?php echo base_url(); ?>assets/_IMAGES/sem_foto.png" class="m--img-rounded m--marginless" alt="Sem Foto"/>
                                    <?php endif ?>
												          </div>
												          <div class="m-card-user__details">
												            <span class="m-card-user__name m--font-weight-500">
												            	<?php echo $this->session->userdata('usuario')->apelido; ?>
												            </span>
												          </div>
												        </div>
												      </div>
												      <div class="m-dropdown__body">
												        <div class="m-dropdown__content">
												          <ul class="m-nav m-nav--skin-light">
												            <li class="m-nav__section m--hide">
												              <span class="m-nav__section-text">
												              	Seção
												              </span>
												            </li>
												            <li class="m-nav__item">
												              <a href="<?php echo base_url(); ?>acesso/configuracao_usuario/" class="m-nav__link">
												                <i class="m-nav__link-icon flaticon-profile-1"></i>
												                <span class="m-nav__link-title">  
												                  <span class="m-nav__link-wrap">      
												                    <span class="m-nav__link-text">Configurações do Usuário</span>      
												                  </span>
												                </span>
												              </a>
												            </li>
                                    <li class="m-nav__item">
                                      <a href="<?php echo base_url(); ?>acesso/alterar_senha/" class="m-nav__link">
                                        <i class="m-nav__link-icon flaticon-security"></i>
                                        <span class="m-nav__link-title">  
                                          <span class="m-nav__link-wrap">      
                                            <span class="m-nav__link-text">Alterar Senha</span>      
                                          </span>
                                        </span>
                                      </a>
                                    </li>
												            <li class="m-nav__separator m-nav__separator--fit"></li>
												            <li class="m-nav__item">
												              <a href="<?php echo base_url(); ?>acesso/logoff/" target="_self" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Sair do Sistema</a>
												            </li>
												          </ul>
												        </div>
												      </div>
												    </div>
												  </div>
												</li>   
							        </ul>
							    </div>
							  </div>
							</div>
							<!-- end::Topbar -->      
						</div>
    			</div>
  			</div>
  			<div class="m-header__bottom" style="background-color: #54a17c;">
			    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
			      <div class="m-stack m-stack--ver m-stack--desktop">   
			        <!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
	  						<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
	  
	  						<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >    
	    						<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
	    							<style>
                      #m_header_menu
                      {
                        background-color: #54a17c;
                      }
	                    .m-header-menu.m-header-menu--skin-dark .m-menu__nav > .m-menu__item > .m-menu__link .m-menu__link-text
	                    {
	                      color: #ffffff;
	                    }
	                    .m-header-menu.m-header-menu--skin-dark .m-menu__nav > .m-menu__item > .m-menu__link .m-menu__link-text:hover
	                    {
	                      color: #01582e;
	                    }
                      .m-topbar .m-topbar__nav.m-nav > .m-nav__item.m-topbar__user-profile.m-topbar__user-profile--img.m-dropdown--arrow .m-dropdown__arrow {
                          color: #76bd3d;
                      }
	                  </style>
                      <li class="m-menu__item  m-menu__item--active"  aria-haspopup="true">
                        <a  href="home" class="m-menu__link">
                          <span class="m-menu__item-here" style="color: #54a17c;"></span>
                          <span class="m-menu__link-text" style="text-align: center;">
                            <i class="flaticon-home-1" style="font-size: 30px;"></i><br>Início
                          </span>
                        </a>
                      </li>
                      <li class="m-menu__item"  aria-haspopup="true">
	                      <a  href="<?php echo base_url(); ?>elda/menu/administrativo/" class="m-menu__link">
	                        <span class="m-menu__item-here" style="color: #54a17c;"></span>
	                        <span class="m-menu__link-text" style="text-align: center;">
	                          <i class="flaticon-globe" style="font-size: 30px;"></i><br>Administrativo
	                        </span>
	                      </a>
	                    </li>
                      <li class="m-menu__item"  aria-haspopup="true">
                        <a  href="<?php echo base_url(); ?>elda/cursos/catalogo/" class="m-menu__link">
                          <span class="m-menu__item-here" style="color: #54a17c;"></span>
                          <span class="m-menu__link-text" style="text-align: center;">
                            <i class="flaticon-folder" style="font-size: 30px;"></i><br>Catálogo de Cursos
                          </span>
                        </a>
                      </li>
                      <li class="m-menu__item"  aria-haspopup="true">
                        <a  href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/" class="m-menu__link">
                          <span class="m-menu__item-here" style="color: #54a17c;"></span>
                          <span class="m-menu__link-text" style="text-align: center;">
                            <i class="flaticon-presentation-1" style="font-size: 30px;"></i><br>Sala de Treinamentos
                          </span>
                        </a>
                      </li>

	                  <script>
	                    function hide_subheader(hide) {
	                    	if (hide) {
	                    		$('#subheader').hide();
	                    	}
	                    	else {
	                    		$('#subheader').show();
	                    	}
	                    }
	                    function title(title){
                    		$('#subheader').show();
	                      $('#titulo_pagina').text(title);
	                      $('title').text(title);
	                    }
	                    function breadcrumbs(crumbs){
                    		$('#subheader').show();
	                    	if (crumbs != null) {
	                    		$('#breadcrumbs').show();
		                    	var app = '';
		                    	for (var i = 0; i < crumbs.length; i++) {
		                    		var target = '';
		                    		if (crumbs[i].href == 'home' || crumbs[i].href == 'home/' || crumbs[i].href == 'Home/' || crumbs[i].href == 'Home') {
		                    			target = 'target="_self"';
		                    		}
	                    			var link = '<?php echo base_url(); ?>'+crumbs[i].href; 
		                    		if (crumbs[i].href == '') {
		                    			link = '#'; 
		                    		}
			                    	app += ''+
				                    	'<li class="m-nav__item">'+
																'<a href="'+link+'" '+target+' class="m-nav__link">'+
																	'<span class="m-nav__link-text">'+crumbs[i].nome+'</span>'+
																'</a>'+
															'</li>';
															if (i < (crumbs.length - 1)) {
																app += '<li class="m-nav__separator"><i class="la	la-angle-right"></i></li>';
															}
		                    	}
													$('#breadcrumbs').html(app);
	                    	}
	                    }
	                  </script>
	      				  </ul>
							  </div>
							</div>
							<!-- end::Horizontal Menu --> 
	        		<!--begin::Search-->
		    		</div>
	    		</div>
  			</div>
			</header>
			<!-- end::Header -->    
    	<!-- begin::Body -->
      <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop  m-container m-container--responsive m-container--xxl m-page__container m-body"> 
      	<div class="m-grid__item m-grid__item--fluid m-wrapper">   
          <div class="m-content">
						<div class="m-subheader" style="margin-top: -40px; margin-bottom: 25px;" id="subheader">
							<div class="d-flex align-items-center">
								<div class="mr-auto">
									<h3 id="titulo_pagina" class="m-subheader__title m-subheader__title--separator"></h3>			
									<ul class="m-subheader__breadcrumbs m-nav m-nav--inline" id="breadcrumbs"></ul>
								</div>
							</div>
						</div>
          	<div id="html_ajax">
              <?php include('elda/home.php'); ?>
            </div>
         	</div>
        </div>
      </div>
      <!-- end::Body -->      
			<!-- begin::Footer -->
			<footer class="m-grid__item m-footer ">
			  <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
			    <div class="m-footer__wrapper">
			      <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
			        <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
			          <span class="m-footer__copyright">
			            <?php echo date('Y') ?> &copy; Solução desenvolvida por
                  <a href="https://www.woisoft.com.br/" target="_blank" class="m-link">
                    Bruno Henrique Woisa
                  </a>
			          </span>
			        </div>
			      </div>
			    </div>
			  </div>
			</footer>
			<!-- end::Footer -->    
		</div>
		<!-- end:: Page -->       
    <!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
		  <i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top --> 

    <div class="modal_loading"><!-- Place at bottom of page --></div>

    <script>
      $(document).ready(function() {
        $(window).keydown(function(event){
          if((event.keyCode == 13 || event.which == 13) && event.target.localName != 'textarea') {
            event.preventDefault();
            return false;
          }
        });
      });
    </script>

  </body>
	<!-- end::Body -->
</html>
