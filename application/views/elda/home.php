<script>
  title('Elda Treinamentos');
  hide_subheader(true);
</script>
<div class="row">
  <?php if ($this->session->userdata('usuario')->administrador): ?>
    <div class="col-sm-4" style="margin-top: 25px;">
      <div class="m-portlet m-portlet--full-height ">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Indicadores Administrativos
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet__body">
          <div class="m-widget4">
            <div class="m-widget4__item">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                  <i class="flaticon-user-ok"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Usuários Ativos
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $usuarios_ativos; ?>
                </span>
              </div>
            </div>
            <div class="m-widget4__item">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                <i class="flaticon-interface-3"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Categorias Ativas
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $categorias_ativas; ?>
                </span>
              </div>
            </div>
            <div class="m-widget4__item">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                <i class="flaticon-line-graph"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Cursos Ativos
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $cursos_ativos; ?>
                </span>
              </div>
            </div>
            <div class="m-widget4__item">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                <i class="flaticon-edit"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Inscrições Realizadas
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $iscricoes_realizadas; ?>
                </span>
              </div>
            </div>
            <div class="m-widget4__item m-widget4__item-border">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                <i class="flaticon-presentation-1"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Treinamentos em Andamento
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $treinamentos_em_andamento; ?>
                </span>
              </div>
            </div>
            <div class="m-widget4__item m-widget4__item-border">
              <div class="m-widget4__ext">               
                <span class="m-widget4__icon m--font-brand">
                <i class="flaticon-medal"></i>
                </span>
              </div>
              <div class="m-widget4__info">
                <span class="m-widget4__text">
                Treinamentos Concluídos
                </span>                    
              </div>
              <div class="m-widget4__ext">
                <span class="m-widget4__number m--font-info">
                <?php echo $treinamentos_concluidos; ?>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <div class="<?php echo ($this->session->userdata('usuario')->administrador)?'col-sm-8':'col-sm-12'; ?>" style="text-align: center; margin: auto 0 auto 0;">
    <img alt="Elda Treinamentos" style="max-width: 80%; <?php echo ($this->session->userdata('usuario')->administrador)?'':'margin-top: 100px;'; ?>" src="<?php echo base_url(); ?>assets/app/media/img/logos/Elda.png"/>
  </div>
</div>