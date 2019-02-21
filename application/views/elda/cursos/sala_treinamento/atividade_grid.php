<script> 
  title('Sala de Treinamentos');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Sala de Treinamentos", href: "elda/cursos/sala_treinamento/" },
    { nome: "<?php echo $curso->titulo; ?>", href: "elda/cursos/sala_treinamento/index/<?php echo $curso->id; ?>" },
    { nome: "<?php echo $atividade->titulo; ?>", href: "" },
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
              <h3 style="margin-top: -10px;"><?php echo $atividade->titulo; ?></h3>
              <div class="row">
                <div class="col-sm-4">
                  <strong>Tipo: </strong><?php echo ($atividade->obrigatoria)?'Obrigatória':'Optativa'; ?>
                </div>
                <div class="col-sm-4" style="text-align: center;">
                  <?php
                  $status = 'Não Realizada';
                  $nota = '--';
                  if ($tentativas){
                    $status = ($tentativas[count($tentativas)-1]->finalizada == '1')?'Realizada':'Não Realizada';
                    $nota = $tentativas[count($tentativas)-1]->nota;
                  }
                  ?>
                  <strong>Status: </strong><?php echo $status; ?>
                </div>
                <div class="col-sm-4" style="text-align: right;">
                  <strong>Nota: </strong><?php echo $nota; ?>
                </div>
              </div>
              <?php if (!$curso_inscricao->concluido): ?>
                <div class="row">
                  <div class="col-sm-12" style="text-align: center; margin-top: 45px;">
                    <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/realizar_atividade/<?php echo $id_inscricao; ?>/<?php echo $id_atividade; ?>" class="btn btn-outline-primary btn-lg m-btn m-btn--icon">
                      <span>
                        <i class="flaticon-list"></i>
                        <span>Nova Tentativa</span>
                      </span>
                    </a>
                  </div>
                </div>
              <?php endif ?>
            </div>
            <?php if ($tentativas): ?>
              <div class="row" style="padding:25px;">
                <div class="col-sm-12">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Ações</th>
                        <th>Tentativa</th>
                        <th>Criação</th>
                        <th>Finalizada</th>
                        <th>Nota</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php krsort($tentativas); ?>
                      <?php foreach ($tentativas as $key => $tentativa): ?>
                        <tr>
                          <th>
                            <?php if ($tentativa->finalizada): ?>
                              <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/realizar_atividade/<?php echo $id_inscricao; ?>/<?php echo $id_atividade; ?>/<?php echo $tentativa->id; ?>/" class="btn btn-outline-success btn-sm  m-btn m-btn--icon">
                                <span>
                                  <i class="fa fa-search"></i>
                                  <span>Revisão</span>
                                </span>
                              </a>
                            <?php elseif (!$curso_inscricao->concluido): ?>
                              <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/realizar_atividade/<?php echo $id_inscricao; ?>/<?php echo $id_atividade; ?>/<?php echo $tentativa->id; ?>/" class="btn btn-outline-primary btn-sm  m-btn m-btn--icon">
                                <span>
                                  <i class="fa fa-edit"></i>
                                  <span>Continuar</span>
                                </span>
                              </a>
                            <?php endif ?>
                          </th>
                          <th><?php echo $key+1; ?></th>
                          <td><?php echo $tentativa->datahora; ?></td>
                          <td><?php echo ($tentativa->finalizada)?'Sim, em '.$tentativa->finalizada_datahora:'Não'; ?></td>
                          <td><?php echo $tentativa->nota; ?></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
            <?php endif ?>


          </div>
        </div>
      </div>
    </div>
  </div>
</div>
