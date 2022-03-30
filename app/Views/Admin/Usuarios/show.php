<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>

<?php echo $this->endSection(); ?>


<?php echo $this->section('conteudo'); ?>
  
  <div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h3 class="text-capitalize text-primary"><?php echo esc($titulo); ?></h3>

          <hr>
    
           <p class="card_text">
            <span class="font-weight-bold">Nome:</span>
            <?php echo esc($usuario->nome); ?>
           </p>

           <p class="card_text">
            <span class="font-weight-bold">E-mail:</span>
            <?php echo esc($usuario->email); ?>
           </p>

           <p class="card_text">
            <span class="font-weight-bold">Ativo:</span>
            <?php echo esc($usuario->ativo ? 'Sim' : 'Não'); ?>
           </p>

           <p class="card_text">
            <span class="font-weight-bold">Perfil:</span>
            <?php echo esc($usuario->is_admin ? 'Administrador' : 'Cliente'); ?>
           </p>

           <p class="card_text">
            <span class="font-weight-bold">Criado:</span>
            <?php echo $usuario->criado_em->humanize(); ?>
           </p>

            <div class="mt-4">

            <?php if($usuario->deletado_em == null): ?>

                <a href="<?php echo site_url("admin/usuarios/editar/$usuario->id"); ?>" class="btn btn-dark btn-sm mr-2">
                  <i class="mdi mdi-pencil btn-icon-prepend">Editar</i>
                </a>

                <a href="<?php echo site_url("admin/usuarios/excluir/$usuario->id"); ?>" class="btn btn-danger btn-sm">
                  <i class="mdi mdi-trash-can btn-icon-prepend">Excluir</i>
                </a>

                <a href="<?php echo site_url("admin/usuarios"); ?>" class="btn btn-light text-dark btn-sm">
                  <i class="mdi mdi-arrow-left btn-icon-prepend">Voltar</i>
                </a>

              <?php else: ?>

                <a href="<?php echo site_url("admin/usuarios/desfazerexclusao/$usuario->id"); ?>" class="btn btn-dark btn-sm">
                  <i class="mdi mdi-undo btn-icon-prepend">Desfazer</i>
                </a>

                <a href="<?php echo site_url("admin/usuarios"); ?>" class="btn btn-light text-dark btn-sm">
                  <i class="mdi mdi-arrow-left btn-icon-prepend">Voltar</i>
                </a>

              <?php endif; ?>

            </div>
           
        </div>
      </div>
    </div>
  </div>

<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection(); ?>