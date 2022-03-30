<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>   

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
  
  <div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <h4 class="text-capitalize text-primary"><?php echo esc($titulo); ?></h4>
        <div class="card-body">
         
          <?php if(session()->has('errors_model')): ?>

            <ul>

              <?php foreach (session('errors_model') as $error): ?>

                <li class="text_danger"><?php echo esc($error); ?></li>

                <?php endforeach; ?>

            </ul>

          <?php endif; ?>
          
            <?php echo form_open("admin/usuarios/excluir/$usuario->id"); ?>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Atenção!</strong> Deseja realmente excluir o usuário <strong><?php echo esc($usuario->nome); ?>?</strong>
            </div>

            <button type="submit" class="btn btn-primary mr-2 btn-sm">
                <i class="mdi mdi-trash-can btn-icon-prepend">Excluir</i>
            </button>

            <a href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>" class="btn btn-light text-dark btn-sm">
              <i class="mdi mdi-arrow-left btn-icon-prepend">Voltar</i>
            </a>

            <?php echo form_close(); ?>

        </div>
      </div>
    </div>
  </div>

<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>

  <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js'); ?>"></script>
  <script src="<?php echo site_url('admin/vendors/mask/app.js'); ?>"></script>
  
<?php echo $this->endSection(); ?>