<script> 
  title('Catálogo de Cursos');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Catálogo de Cursos", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
  });
</script>

<form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="row">
        <div class="col-sm-10">
          <div class="form-group">  
            <input type="text" class="form-control m-input m-input--square form-control-sm" name="pesquisa" value="<?php echo $this->session->userdata('pesquisa_catalogo'); ?>" autocomplete="off" placeholder="Pesquisar">
          </div>
        </div>
        <div class="col-sm-2">
          <button type="submit" id="btn_submit" class="btn m-btn--square btn-block btn-outline-info btn-sm"><i class="fa fa-search"></i></button>
        </div>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>
  <script>
    $('input[name="pesquisa"]').keyup(function(e) {
      if ((e.which == 13 || e.keyCode == 13) ) { // Enter
        $('#btn_submit').trigger('click');
      }
    });
    $(document).ready(function() {
      $('input[name="pesquisa"]').focus();
    });
  </script>
</form>
<?php if ($grid): ?>
  <?php foreach ($grid as $curso): ?>
    <div class="m-portlet m-portlet--creative m-portlet--bordered-semi">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="flaticon-statistics"></i>
            </span>
            <h3 class="m-portlet__head-text">
              <b>Categoria:&nbsp;</b> <?php echo $curso->categoria; ?>&nbsp;&nbsp;&nbsp;<b>Instrutor:&nbsp;</b> <?php echo $curso->instrutor; ?>
            </h3>
            <h2 class="m-portlet__head-label m-portlet__head-label--success">
              <span><?php echo $curso->titulo; ?></span>
            </h2>
          </div>      
        </div>
      </div>
      <div class="m-portlet__body">
        <p>
          <?php echo line2br($curso->descricao); ?>
        </p>
        <p style="text-align: center; margin-bottom: 0; padding-bottom: 0;">
          <button onclick="javascript:confirma_inscricao('<?php echo $curso->titulo; ?>','<?php echo $curso->id; ?>')" class="btn m-btn--square btn-outline-success m-btn m-btn--outline-2x"><i class="flaticon-edit"></i> Inscrever-me</button>
        </p>
      </div>
    </div>
  <?php endforeach ?>
<?php else: ?>
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
      <div class="m-alert m-alert--icon m-alert--outline alert alert-warning alert-dismissible fade show" role="alert">
        <div class="m-alert__icon">
          <i class="flaticon-exclamation"></i>
        </div>
        <div class="m-alert__text">
            <strong>Ops!</strong><br>Não foram encontrados cursos disponíveis para inscrição.
        </div>  
      </div>
    </div>
    <div class="col-sm-2"></div>
  </div>
<?php endif ?>
<script>
  function confirma_inscricao(titulo,id_curso) {
    Swal({
      title: titulo,
      text: 'Deseja se increver nesse curso?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#f4516c',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Não, voltar.',
      confirmButtonText: 'Sim, inscrever-me!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url(); ?>elda/cursos/catalogo/ajax_incricao/',
          type: 'POST',
          dataType: 'json',
          data: {id_curso: id_curso},
        })
        .done(function(id_inscricao) {
          if (id_inscricao)
            ajax_html('<?php echo base_url(); ?>elda/cursos/sala_treinamento/index/'+id_inscricao);
          else 
            swal(
              'Atenção!',
              'Houve uma falha ao realizar a inscrição. Tente novamente.',
              'warning'
            );
        })
        .fail(function() {
          swal(
            'Atenção!',
            'Houve uma falha ao realizar a inscrição. Tente novamente.',
            'warning'
          );
        });
      }
    })
  }
</script>