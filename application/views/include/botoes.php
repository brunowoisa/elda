<div class="row">
  <div class="col-sm-12" style="text-align: right; margin-top: -10px; margin-bottom: 20px;">
    <?php if (isset($links['novo']) && $links['novo'] != false && $links['novo'] != ''): ?>
      <a href="<?php echo base_url().$links['novo']; ?>" class="btn btn-outline-accent m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" data-toggle="tooltip" title="Novo">
        <i class="la la-plus"></i>
      </a>
    <?php endif ?>
    <?php if (isset($links['atualizar']) && $links['atualizar'] != false && $links['atualizar'] != ''): ?>
      <a href="<?php echo base_url().$links['atualizar']; ?>" class="btn btn-outline-warning m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" data-toggle="tooltip" title="Recarregar">
        <i class="la la-refresh"></i>
      </a>
    <?php endif ?>
    <?php if (isset($links['voltar']) && $links['voltar'] != false && $links['voltar'] != ''): ?>
      <a href="<?php echo base_url().$links['voltar']; ?>" class="btn btn-outline-brand m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" data-toggle="tooltip" title="Voltar">
        <i class="la la-arrow-left"></i>
      </a>
    <?php endif ?>
    <?php if (isset($links['fechar']) && $links['fechar'] != false && $links['fechar'] != ''): ?>
      <a href="<?php echo base_url().$links['fechar']; ?>" class="btn btn-outline-danger m-btn btn-sm m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air" data-toggle="tooltip" title="Fechar">
        <i class="la la-times"></i>
      </a>
    <?php endif ?>
  </div>
</div>
<script>
  $('[data-toggle="tooltip"]').tooltip({
    trigger : 'hover'
  });
  $('a').click(function() {
    $('[data-toggle="tooltip"]').tooltip('hide');
  });
</script>