<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>

  <!--Aqui enviamos para o template principal os estilos -->

  <link rel="stylesheet" href="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.css'); ?>" />

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
  
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="text-capitalize text-primary"><?php echo $titulo; ?></h4>

          <hr>

          <div class="ui-widget">
            <input id="query" name="query" placeholder="Pesquise por um usuário" class="form-control bg-light mb-5">
          </div>

          <a href="<?php echo site_url("admin/usuarios/criar"); ?>" class="btn btn-success float-right mb-5">
            <i class="mdi mdi-plus btn-icon-prepend">Cadastrar</i>
          </a>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="font-weight-bold">Nome</th>
                  <th class="font-weight-bold">E-mail</th>
                  <th class="font-weight-bold">CPF</th>
                  <th class="font-weight-bold">Status</th>
                  <th class="font-weight-bold">Situação</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($usuarios as $usuario): ?>

                  <tr>

                    <td>
                      <a href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>"><?php echo $usuario->nome; ?>
                        <i class="mdi mdi-arrow-right btn-icon-prepend"></i>
                      </a>
                    </td>
                    <td><?php echo $usuario->email; ?></td>
                    <td><?php echo $usuario->cpf; ?></td>
                    <td><?php echo ($usuario->ativo && $usuario->deletado_em == null ? '<label class="badge badge-primary">Ativo</label>' : '<label class="badge badge-danger">Inativo</label>'); ?></td>
                    <td>
                      <?php echo ($usuario->deletado_em == null ? '<label class="badge badge-primary">Disponível</label>' : '<label class="badge badge-danger">Excluído</label>'); ?>
                      
                      <?php if ($usuario->deletado_em != null): ?>

                        <a href="<?php echo site_url("admin/usuarios/desfazerexclusao/$usuario->id"); ?>" class="badge badge-dark ml-2">
                          <i class="mdi mdi-undo btn-icon-prepend">Desfazer</i>
                        </a>

                      <?php endif; ?>

                    </td>
                  
                  </tr>

                <?php endforeach; ?>

              </tbody>
            </table>

            <div class="mt-3">

              <?php echo $pager->links() ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>
  
   <!--Aqui enviamos para o template principal os scripts-->

   <script src="<?php echo site_url('admin/vendors/auto-complete/jquery-ui.js'); ?>"></script>

   <script>
   
      $(function () {

        $( "#query" ).autocomplete({
          source: function (request, response) {

            $.ajax({

              url: "<?php echo site_url('admin/usuarios/procurar'); ?>",
              dataType: "json",
              data:{
                term: request.term
              },

              success: function (data) {

                if(data.length < 1){

                  var data = [
                    {
                      label: 'Usuario não encontrado',
                      value: -1
                    }
                  ];

                }
                response(data); //aqui temos valor no data
              },

            }); // fim ajax

          },

          minLenght: 1, 
          select: function (event, ui){

            if(ui.item.value == -1){

              $(this).val("");
              return false;

            } else {

              window.location.href = '<?php echo site_url('admin/usuarios/show/'); ?>' + ui.item.id;
              
            }

          }

        }); //fim auto complete

      });
 
   </script>

<?php echo $this->endSection(); ?>