<script> 
  title('Administrativo');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "" },
  ];
  breadcrumbs(crumbs);
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">

    <div class="row">
      <div class="col-sm-4">  
        <h5 class="m--font-info">Cursos</h5>
        <div class="m-section__content" style=" border-left: 4px solid #f7f7fa; padding: 17px;">
          <p><a href="<?php echo base_url(); ?>elda/administrativo/Categoria/" class="m-link m-link--state m-link--info"><i class="fa fa-chevron-right"></i> Cadastro de Categorias</a></p>
          <p style="padding-bottom: 0; margin-bottom: 0;"><a href="<?php echo base_url(); ?>elda/administrativo/Curso/" class="m-link m-link--state m-link--info"><i class="fa fa-chevron-right"></i> Cadastro de Cursos</a></p>
        </div>
      </div>

      <div class="col-sm-4">  
        <h5 class="m--font-info">Usuários</h5>
        <div class="m-section__content" style=" border-left: 4px solid #f7f7fa; padding: 17px;">
          <p><a href="<?php echo base_url(); ?>elda/administrativo/Usuario/" class="m-link m-link--state m-link--info"><i class="fa fa-chevron-right"></i> Cadastro de Usuários</a></p>
          <p style="padding-bottom: 0; margin-bottom: 0;"><a href="<?php echo base_url(); ?>elda/administrativo/Usuario/relatorio/" class="m-link m-link--state m-link--info"><i class="fa fa-chevron-right"></i> Relatório de Desempenho</a></p>
        </div>
      </div>

    </div>
  </div>
</div>