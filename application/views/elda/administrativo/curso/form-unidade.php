<script> 
  title('<?php echo ($editar)?'Editar':'Nova'; ?> Unidade');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Administrativo", href: "elda/menu/administrativo/" },
    { nome: "Cadastro de Cursos", href: "elda/administrativo/curso/" },
    { nome: "Estruturação do Curso", href: "elda/administrativo/curso/estrutura_curso/<?php echo $curso->id; ?>" },
    { nome: "<?php echo ($editar)?'Editar':'Nova'; ?> Unidade", href: "" },
  ];
  breadcrumbs(crumbs);
  $(document).ready(function() {
    $(".m-select2").select2({
      placeholder:"-- Selecione --"
    });
  });
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">
    <?php $this->load->view('include/botoes',$links); ?>
    <div class="row">
      <div class="col-sm-12">
        <h4 class="m--font-primary">Geral</h4>
      </div>
      <div class="col-sm-12">
        <form class="m-form m-form--state" action="<?php echo base_url().$url_form; ?>" method="POST">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group <?php echo form_status('titulo'); ?>">  
                <label for="titulo">Título</label>
                <input type="text" class="form-control m-input m-input--square" name="titulo" maxlength="45" value="<?php echo set_form_value($editar,$form,'titulo'); ?>" autocomplete="off">
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group <?php echo form_status('ativo'); ?>">  
                <label for="ativo">Status</label>
                <select class="form-control m-select2 m-input--square" name="ativo">
                  <option value="">-- Selecione --</option>
                  <option value="1" <?php echo set_form_select($editar,$form,'ativo', '1'); ?>>Ativo</option>
                  <option value="0" <?php echo set_form_select($editar,$form,'ativo', '0'); ?>>Inativo</option>
                </select>
              </div>
            </div>
            <div class="col-sm-2" style="margin-top: 25px;">
              <button type="submit" class="btn m-btn--square btn-block btn-outline-success m-btn m-btn--custom"><i class="la la-check"></i> Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php if ($editar): ?>
      
      <div class="row" style="margin-top: 75px;">
        <div class="col-sm-6">
          <h4 class="m--font-primary">Vídeos da Unidade</h4>
        </div>
        <div class="col-sm-6" style="text-align: right; margin-bottom: 15px;">
          <a href="<?php echo base_url(); ?>elda/administrativo/curso/novo_video/<?php echo $curso->id; ?>/<?php echo $form->id; ?>" class="btn m-btn--square btn-outline-primary m-btn m-btn--custom"><i class="flaticon-add-circular-button"></i> Adicionar Vídeo</a>
        </div>
        <div class="col-sm-12">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Editar</th>
                <th>Título</th>
                <th>Status</th>
                <th>Cadastro</th>
                <th>Última Alteração</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($videos as $video): ?>
                <tr>
                  <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>elda/administrativo/curso/editar_video/<?php echo $curso->id; ?>/<?php echo $form->id; ?>/<?php echo $video->id; ?>/" class="btn btn-outline-accent btn-sm  m-btn m-btn--icon"><i class="fa fa-edit"></i></a>
                  </td>
                  <td><?php echo $video->titulo; ?></td>
                  <td><?php echo ($video->ativo)?'<i class="fa fa-check-circle m--font-success"></i> Ativo':'<i class="fa fa-times-circle m--font-danger"></i> Inativo'; ?></td>
                  <td><?php echo $video->cadastro_usuario.' em '.$video->cadastro; ?></td>
                  <td><?php echo $video->last_change_usuario.' em '.$video->last_change; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row" style="margin-top: 75px;">
        <div class="col-sm-6">
          <h4 class="m--font-primary">Materiais Complementares da Unidade</h4>
        </div>
        <div class="col-sm-6" style="text-align: right; margin-bottom: 15px;">
          <a href="<?php echo base_url(); ?>elda/administrativo/curso/novo_material/<?php echo $curso->id; ?>/<?php echo $form->id; ?>" class="btn m-btn--square btn-outline-primary m-btn m-btn--custom"><i class="flaticon-add-circular-button"></i> Adicionar Material</a>
        </div>
        <div class="col-sm-12">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Editar</th>
                <th>Título</th>
                <th>Status</th>
                <th>Cadastro</th>
                <th>Última Alteração</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($materiais as $material): ?>
                <tr>
                  <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>elda/administrativo/curso/editar_material/<?php echo $curso->id; ?>/<?php echo $form->id; ?>/<?php echo $material->id; ?>/" class="btn btn-outline-accent btn-sm  m-btn m-btn--icon"><i class="fa fa-edit"></i></a>
                  </td>
                  <td><?php echo $material->titulo; ?></td>
                  <td><?php echo ($material->ativo)?'<i class="fa fa-check-circle m--font-success"></i> Ativo':'<i class="fa fa-times-circle m--font-danger"></i> Inativo'; ?></td>
                  <td><?php echo $material->cadastro_usuario.' em '.$material->cadastro; ?></td>
                  <td><?php echo $material->last_change_usuario.' em '.$material->last_change; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row" style="margin-top: 75px;">
        <div class="col-sm-6">
          <h4 class="m--font-primary">Atividades da Unidade</h4>
        </div>
        <div class="col-sm-6" style="text-align: right; margin-bottom: 15px;">
          <a href="<?php echo base_url(); ?>elda/administrativo/curso/novo_atividade/<?php echo $curso->id; ?>/<?php echo $form->id; ?>" class="btn m-btn--square btn-outline-primary m-btn m-btn--custom"><i class="flaticon-add-circular-button"></i> Adicionar Atividade</a>
        </div>
        <div class="col-sm-12">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th></th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Cadastro</th>
                <th>Última Alteração</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($atividades as $atividade): ?>
                <tr>
                  <td style="text-align: center;">
                    <a href="<?php echo base_url(); ?>elda/administrativo/curso/editar_atividade/<?php echo $curso->id; ?>/<?php echo $form->id; ?>/<?php echo $atividade->id; ?>/" class="btn btn-outline-accent btn-sm  m-btn m-btn--icon"><i class="fa fa-edit"></i></a>
                  </td>
                  <td><?php echo $atividade->titulo; ?></td>
                  <td><?php echo ($atividade->obrigatoria)?'Obrigatória':'Optativa'; ?></td>
                  <td><?php echo ($atividade->ativo)?'<i class="fa fa-check-circle m--font-success"></i> Ativo':'<i class="fa fa-times-circle m--font-danger"></i> Inativo'; ?></td>
                  <td><?php echo $atividade->cadastro_usuario.' em '.$atividade->cadastro; ?></td>
                  <td><?php echo $atividade->last_change_usuario.' em '.$atividade->last_change; ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row" style="margin-top: 0px;">
        <div class="col-sm-12">
          <div class="m-alert m-alert--icon m-alert--outline alert" role="alert">
            <div class="m-alert__icon">
              <i class="la la-info"></i>
            </div>
            <div class="m-alert__text">
              <strong>Cadastro:</strong> <?php echo $form->cadastro_usuario; ?> em <?php echo $form->cadastro; ?><br>
              <strong>Última Alteração:</strong> <?php echo $form->last_change_usuario; ?> em <?php echo $form->last_change; ?>
            </div>  
          </div>
        </div>
      </div>
    <?php endif ?>
  </div>
</div>