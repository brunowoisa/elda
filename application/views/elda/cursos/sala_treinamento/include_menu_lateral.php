<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
  <div class="m-demo__preview">
    <ul class="m-nav">
      <?php if ((!isset($curso_nao_setado)) || (isset($curso_nao_setado) && !$curso_nao_setado)): ?>
        <li class="m-nav__section m-nav__section--first">
          <span class="m-nav__section-text"><?php echo $curso->titulo; ?>
        <li class="m-nav__item">
          <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/index/<?php echo $id_inscricao; ?>" class="m-nav__link">
            <i class="m-nav__link-icon flaticon-presentation-1"></i>
            <span class="m-nav__link-text">Treinamento</span>
          </a>
        </li>
        <li class="m-nav__item">
          <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/quadro_notas/<?php echo $id_inscricao; ?>" class="m-nav__link">
            <i class="m-nav__link-icon flaticon-list-2"></i>
            <span class="m-nav__link-text">Quadro de Notas</span>
          </a>
        </li>
        <li class="m-nav__item">
          <a href="<?php echo base_url(); ?>elda/cursos/sala_treinamento/certificado/<?php echo $id_inscricao; ?>" class="m-nav__link">
            <i class="m-nav__link-icon flaticon-medal"></i>
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
      <?php endif ?>
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