<script> 
  title('Cadastro de Usuários');
  var crumbs = [
    { nome: "Início", href: "home/" },
    { nome: "Cadastros", href: "elda/menu/cadastro/" },
    { nome: "Cadastro de Usuários", href: "" },
  ];
  breadcrumbs(crumbs);
</script>
<div class="m-portlet m-portlet--bordered m-portlet--unair">
  <div class="m-portlet__body">
    <?php $this->load->view('include/botoes',$links); ?>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1" style="width: 100%;" data-order='[[ 1, "asc" ]]' data-page-length='25'>
          <thead>
            <tr>
              <th style="width: 58px;">Ações</th>
              <th>Nome</th>
              <th>CPF</th>
              <th>Tipo de Usuário</th>
              <th>E-mail</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($grid as $key): ?>
              <tr>
                <td>
                  <a href="<?php echo base_url(); ?>elda/cadastro/usuario/editar/<?php echo $key->id; ?>/" class="btn btn-outline-accent btn-sm  m-btn m-btn--icon">
                    <span>
                      <i class="fa fa-edit"></i>
                      <span>Editar</span>
                    </span>
                  </a>
                </td>
                <td><?php echo $key->nome; ?></td>
                <td><?php echo formata_cpf($key->cpf); ?></td>
                <?php if ($key->administrador): ?>
                  <td><i class="fa fa-user-shield"></i> Administrador</td>
                <?php else: ?>
                  <td>Usuário Comum</td>
                <?php endif ?>
                <td><?php echo $key->email; ?></td>
                <?php if ($key->ativo): ?>
                  <td> <i class="fa fa-check-circle m--font-success"></i> Ativo</td>
                <?php else: ?>
                  <td> <i class="fa fa-times-circle m--font-danger"></i> Inativo</td>
                <?php endif ?>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $("#m_table_1").DataTable({
    scrollX: true,
    language: {
      "sEmptyTable": "Nenhum registro encontrado",
      "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
      "sInfoFiltered": "(Filtrados de _MAX_ registros)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "_MENU_ resultados por página",
      "sLoadingRecords": "Carregando...",
      "sProcessing": "Processando...",
      "sZeroRecords": "Nenhum registro encontrado",
      "sSearch": "Pesquisar",
      "oPaginate": {
          "sFirst": "Primeiro",
          "sLast": "Último"
      },
      "oAria": {
          "sSortAscending": ": Ordenar colunas de forma ascendente",
          "sSortDescending": ": Ordenar colunas de forma descendente"
      }
    }
  });
</script>