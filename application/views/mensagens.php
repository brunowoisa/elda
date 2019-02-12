<!-- 
$mensagem = array(
  'texto' => 'Exemplo de Mensagem',

  'tipo'  => 'SweetAlert',
  'class' => 'warning, error, success, info, question',

  'tipo'  => 'Alert',
  'class' => 'default, success, info, warning, danger, brand, primary',
);
-->
<?php if (isset($texto) && $texto != ''): ?>
  <?php if ($tipo == 'SweetAlert'): ?>
    <?php 
    $titulos = array(
      'warning' => 'Atenção!',
      'error' => 'Erro!',
      'success' => 'Sucesso!',
      'info' => 'Informação!',
      'question' => '',
    );
    $titulo = (array_key_exists($class, $titulos))?$titulos[$class]:$titulos['info'];
    $classe = (array_key_exists($class, $titulos))?$class:'info';
    ?>
    <script>
      swal({
        title: "<?php echo $titulo; ?>",
        html: "<?php echo line2br($texto); ?>",
        type: "<?php echo $classe; ?>"
      });
    </script>
  <?php elseif ($tipo == 'Alert'): ?>
    <?php
    $classes = array(
      'default' => 'm-alert--default',
      'success' => 'alert-success',
      'info' => 'alert-info',
      'warning' => 'alert-warning',
      'danger' => 'alert-danger',
      'brand' => 'alert-brand',
      'primary' => 'alert-primary',
    ); 
    $classe = (array_key_exists($class, $classes))?$classes[$class]:$classes['info'];
    ?>
    <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert <?php echo $classe; ?> alert-dismissible fade show" role="alert">
      <div class="m-alert__icon">
        <i class="flaticon-exclamation-1"></i>
        <span></span>
      </div>
      <div class="m-alert__text">
        <?php echo $texto; ?>
      </div>  
      <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"></button>
      </div>          
    </div>
  <?php endif ?>  
<?php endif ?>
<script> $('html, body').animate({scrollTop:0}, 'slow'); </script>