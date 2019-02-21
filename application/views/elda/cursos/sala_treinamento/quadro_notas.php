<script> 
  title('Sala de Treinamentos');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Sala de Treinamentos", href: "elda/cursos/sala_treinamento/" },
    { nome: "<?php echo $curso->titulo; ?>", href: "elda/cursos/sala_treinamento/index/<?php echo $curso->id; ?>" },
    { nome: "Quadro de Notas", href: "" },
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
              <h3 style="margin-top: -10px;">Quadro de Notas</h3>
            </div>
            <div class="row" style="padding:0 25px 25px 25px;">
              <div class="col-sm-12">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Atividade</th>
                      <th>Tipo</th>
                      <th>Realizada</th>
                      <th>Finalizada</th>
                      <th>Nota</th>
                      <th>Situação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($atividades as $key => $atividade): ?>
                      <tr>
                        <th><?php echo $atividade->titulo; ?></th>
                        <th><?php echo ($atividade->obrigatoria)?'Obrigatória':'Optativa'; ?></th>
                        <?php if (isset($quadro_notas[$atividade->id])): ?>
                          <td>Sim</td>
                          <?php if ($quadro_notas[$atividade->id]->finalizada): ?>
                            <td>Sim, em <?php echo $quadro_notas[$atividade->id]->finalizada_datahora; ?></td>
                            <td style="text-align: center;"><?php echo $quadro_notas[$atividade->id]->nota; ?></td>
                            <td><?php echo ($quadro_notas[$atividade->id]->nota >= 70)?'Aprovado':'Reprovado'; ?></td>
                          <?php else: ?>
                            <td>Não</td>
                            <td style="text-align: center;">--</td>
                            <td>Aguardando Finalização</td>
                          <?php endif ?>
                        <?php else: ?>
                          <td>Não</td>
                          <td>Não</td>
                          <td style="text-align: center;">--</td>
                          <td>Não Realizada</td>
                        <?php endif ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
