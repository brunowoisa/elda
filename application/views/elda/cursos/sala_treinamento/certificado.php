<script> 
  title('Sala de Treinamentos');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Sala de Treinamentos", href: "elda/cursos/sala_treinamento/" },
    { nome: "<?php echo $curso->titulo; ?>", href: "elda/cursos/sala_treinamento/index/<?php echo $curso->id; ?>" },
    { nome: "Certificado", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
  });
</script>

<div class="row">
  <div class="col-sm-3">
    <?php include('include_menu_lateral.php'); ?>
  </div>
  <div class="col-sm-9">
    <style>
      .m-invoice-1 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items {
        border-top: 1px solid #b9b9b9;
      }
      .m-invoice-1 .m-invoice__wrapper .m-invoice__body.m-invoice__body--centered {
        width: 90%;
        padding-top: 50px;
        padding-bottom: 30px;
      }
    </style>
    <div class="m-portlet">
      <div class="m-portlet__body m-portlet__body--no-padding">
        <div class="m-invoice-1">
          <div class="m-invoice__wrapper">
            <div class="m-invoice__head" style="background-image: url(<?php echo base_url(); ?>assets/app/media/img/bg/bg-9.jpg);">
              <div class="m-invoice__container m-invoice__container--centered">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="m-invoice__logo">
                      <h1 style="color: #ffffff;"><?php echo $curso->titulo; ?></h1>
                    </div>
                  </div>
                  <div class="col-sm-6" style="margin-top: 120px;">
                    <span class="m-invoice__desc">
                      <span style="color: #ffffff;">Instrutor: <?php echo $curso->instrutor; ?></span>
                      <span style="color: #ffffff;">Categoria: <?php echo $curso->categoria; ?></span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="m-invoice__body m-invoice__body--centered">
              <?php $this->load->view('include/botoes',$links); ?>
              <h3 style="margin-top: -10px;">Certificado</h3>
              <br>
              <br>
              <h5 class="m--font-primary">Você assistiu <?php echo $progresso->progresso_videos; ?>% dos Vídeos.</h5>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $progresso->progresso_videos; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progresso->progresso_videos; ?>%"></div>
              </div>
              <br>
              <br>
              <h5 class="m--font-primary">Você foi aprovado em <?php echo $progresso->progresso_atividades; ?>% das Atividades Obrigatórias.</h5>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $progresso->progresso_atividades; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progresso->progresso_atividades; ?>%"></div>
              </div>
              <br>
              <br>
              <h5 class="m--font-primary">Seu Progresso Geral está em <?php echo $progresso->progresso; ?>%</h5>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?php echo $progresso->progresso; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progresso->progresso; ?>%"></div>
              </div>
              <br>
              <br>
              <?php if ($progresso->progresso == 100): ?>
                <div class="col-sm-12" style="text-align: center;">
                  <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/emitir_certificado/<?php echo $id_inscricao; ?>" target="_blank" class="btn btn-outline-success m-btn btn-lg m-btn--icon m-btn--outline-2x">
                    <span>
                      <i class="flaticon-medal" style="font-size: 50px;"></i>
                      <span>Emitir Certificado</span>
                    </span>
                  </a>
                </div>
              <?php else: ?>
                <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                  <div class="m-alert__icon">
                    <i class="flaticon-exclamation-1"></i>
                    <span></span>
                  </div>
                  <div class="m-alert__text">
                    <strong>Atenção!</strong>
                    <br>
                    Para obter o certificado de conclusão, você deve assistir todos os vídeos e ser aprovado em todas as atividades obrigatórias do curso.
                  </div>
                </div>
              <?php endif ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
