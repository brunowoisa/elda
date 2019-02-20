<script> 
  title('Sala de Treinamentos');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Sala de Treinamentos", href: "elda/cursos/sala_treinamento/" },
    { nome: "<?php echo $curso->titulo; ?>", href: "elda/cursos/sala_treinamento/index/<?php echo $curso->id; ?>" },
    { nome: "<?php echo $atividade->titulo; ?>", href: "elda/cursos/sala_treinamento/atividade/<?php echo $id_inscricao; ?>/<?php echo $id_atividade; ?>" },
    <?php if (!$bloqueado): ?>
      { nome: "Nova Tentativa", href: "" },
    <?php else: ?>
      { nome: "Revisão", href: "" },
    <?php endif ?>
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
    <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
      <div class="m-demo__preview">
        <ul class="m-nav">
          <li class="m-nav__section m-nav__section--first">
            <span class="m-nav__section-text"><?php echo $curso->titulo; ?>
          <li class="m-nav__item">
            <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/index/<?php echo $id_inscricao; ?>" class="m-nav__link">
              <i class="m-nav__link-icon flaticon-presentation-1"></i>
              <span class="m-nav__link-text">Treinamento</span>
            </a>
          </li>
          <li class="m-nav__item">
            <a href="" class="m-nav__link">
              <i class="m-nav__link-icon flaticon-list-2"></i>
              <span class="m-nav__link-text">Quadro de Notas</span>
            </a>
          </li>
          <li class="m-nav__item">
            <a href="" class="m-nav__link">
              <i class="m-nav__link-icon flaticon-interface-10"></i>
              <span class="m-nav__link-text">Certificado</span>
            </a>
          </li>
          <li class="m-nav__item">
            <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/" class="m-nav__link">
              <i class="m-nav__link-icon flaticon-logout"></i>
              <span class="m-nav__link-text">Sair do Treinamento</span>
            </a>
          </li>
          <li class="m-nav__separator m-nav__separator--fit"></li>
          <li class="m-nav__section">
            <span class="m-nav__section-text">Meus Cursos</span>
          </li>
          <?php foreach ($inscricoes as $key): ?>
            <li class="m-nav__item">
              <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/index/<?php echo $key->id; ?>" class="m-nav__link">
                <i class="m-nav__link-icon la la-long-arrow-right"></i>
                <span class="m-nav__link-text"><?php echo $key->curso; ?></span>
              </a>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-sm-9">
    <?php 
    //epre($curso);
    //epre($unidades);
    ?>
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

              <form id="form" class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
                <input type="hidden" name="id_inscricao_atividade" value="<?php echo $id_inscricao_atividade; ?>">
                <?php 
                $resp = array();
                foreach ($respostas as $key => $value) {
                  $resp[$key] = $value;
                }
                ?>
                <?php foreach ($questoes as $key => $questao): ?>
                  <div class="row">
                    <div class="col-sm-12">
                      <strong>Questão <?php echo $key+1; ?></strong><br>
                      <?php echo $questao->enunciado; ?>
                      <br>
                    </div>
                    <div class="col-sm-12" style="margin-top:25px;">
                      <p>
                        <label class="m-radio m-radio--bold m-radio--state-brand">
                          <input type="radio" id="q_<?php echo $questao->id_questao; ?>_a" name="questao[<?php echo $questao->id_questao; ?>]" value="a" <?php echo ($bloqueado && $resp[$questao->id_questao] == 'a')?'checked disabled':'disabled'; ?>> <strong>A - </strong><?php echo $questao->a; ?>
                          <span></span>
                        </label><br>
                        <label class="m-radio m-radio--bold m-radio--state-brand">
                          <input type="radio" id="q_<?php echo $questao->id_questao; ?>_b" name="questao[<?php echo $questao->id_questao; ?>]" value="b" <?php echo ($bloqueado && $resp[$questao->id_questao] == 'b')?'checked disabled':'disabled'; ?>> <strong>B - </strong><?php echo $questao->b; ?>
                          <span></span>
                        </label><br>
                        <label class="m-radio m-radio--bold m-radio--state-brand">
                          <input type="radio" id="q_<?php echo $questao->id_questao; ?>_c" name="questao[<?php echo $questao->id_questao; ?>]" value="c" <?php echo ($bloqueado && $resp[$questao->id_questao] == 'c')?'checked disabled':'disabled'; ?>> <strong>C - </strong><?php echo $questao->c; ?>
                          <span></span>
                        </label><br>
                        <label class="m-radio m-radio--bold m-radio--state-brand">
                          <input type="radio" id="q_<?php echo $questao->id_questao; ?>_d" name="questao[<?php echo $questao->id_questao; ?>]" value="d" <?php echo ($bloqueado && $resp[$questao->id_questao] == 'd')?'checked disabled':'disabled'; ?>> <strong>D - </strong><?php echo $questao->d; ?>
                          <span></span>
                        </label><br>
                        <label class="m-radio m-radio--bold m-radio--state-brand">
                          <input type="radio" id="q_<?php echo $questao->id_questao; ?>_e" name="questao[<?php echo $questao->id_questao; ?>]" value="e" <?php echo ($bloqueado && $resp[$questao->id_questao] == 'e')?'checked disabled':'disabled'; ?>> <strong>E - </strong><?php echo $questao->e; ?>
                          <span></span>
                        </label>
                      </p>
                      <?php if ($bloqueado): ?>
                        <?php if ($questao->alternativa_correta == $resp[$questao->id_questao]): ?>
                          <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                            <div class="m-alert__icon">
                              <i class="flaticon-exclamation-1"></i>
                              <span></span>
                            </div>
                            <div class="m-alert__text">
                              <strong>Correto!</strong> Sua resposta está certa.
                            </div>
                          </div>
                        <?php else: ?>
                          <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="m-alert__icon">
                              <i class="flaticon-exclamation-1"></i>
                              <span></span>
                            </div>
                            <div class="m-alert__text">
                              <strong>Errado!</strong> Resposta correta: <?php echo mb_strtoupper($questao->alternativa_correta); ?>.
                            </div>
                          </div>
                        <?php endif ?>
                      <?php endif ?>
                    </div>
                  </div>
                  <?php if (isset($questoes[$key+1])): ?>
                    <hr>
                  <?php endif ?>
                <?php endforeach ?>
                <?php if (!$bloqueado): ?>
                  <button id="bnt_submit" type="submit" style="display: none;"></button>
                <?php endif ?>
              </form>
              <?php if (!$bloqueado): ?>
                <div class="row">
                  <div class="col-sm-12" style="text-align: center; margin-top: 45px;">
                    <button type="button" onclick="javascript:verifica_questoes_em_branco();" class="btn btn-outline-success btn-lg m-btn m-btn--icon">
                      <span>
                        <i class="la la-check"></i>
                        <span>Finalizar Tentativa</span>
                      </span>
                    </button>
                  </div>
                </div>
                <script>
                  function verifica_questoes_em_branco() {
                    <?php foreach ($questoes as $key => $questao): ?>
                      if (
                          !$('#q_<?php echo $questao->id_questao; ?>_a').is(':checked') &&
                          !$('#q_<?php echo $questao->id_questao; ?>_b').is(':checked') &&
                          !$('#q_<?php echo $questao->id_questao; ?>_c').is(':checked') &&
                          !$('#q_<?php echo $questao->id_questao; ?>_d').is(':checked') &&
                          !$('#q_<?php echo $questao->id_questao; ?>_e').is(':checked')
                          ) {
                        alert_questao_em_branco('<?php echo $key+1; ?>');
                        return;
                      }
                    <?php endforeach ?>
                    Swal({
                      title: 'Finalizar a Tentativa?',
                      text: 'Após a finalização não será possível alterar as respostas informadas.',
                      type: 'question',
                      showCancelButton: true,
                      confirmButtonColor: '#f4516c',
                      cancelButtonColor: '#d33',
                      cancelButtonText: 'Não, voltar.',
                      confirmButtonText: 'Sim, finalizar!'
                    }).then((result) => {
                      if (result.value) {
                        $('#bnt_submit').click();
                      }
                    })
                  }

                  function alert_questao_em_branco(numero_questao) {
                    swal({
                      title: "Atenção!",
                      html: "Não foi possível finalizar a tentativa. A questão "+numero_questao+" não foi respondida.",
                      type: "warning"
                    });
                  }
                </script>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
