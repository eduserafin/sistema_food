<div class="form-row">

    <div class="form-group col-md-4">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo old('nome', esc($usuario->nome)); ?>">
    </div>

    <div class="form-group col-md-2">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?php echo old('cpf', esc($usuario->cpf)); ?>">
    </div>

    <div class="form-group col-md-2">
        <label for="telefone">Telefone:</label>
        <input type="text" class="form-control sp_celphones" name="telefone" id="telefone" value="<?php echo old('telefone', esc($usuario->telefone)); ?>">
    </div>

    <div class="form-group col-md-4">
        <label for="email">E-mail:</label>
        <input type="text" class="form-control" name="email" id="email" value="<?php echo old('email', esc($usuario->email)); ?>">
    </div>

</div>

<div class="form-row">

    <div class="form-group col-md-3">
        <label for="password">Senha:</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>

    <div class="form-group col-md-3">
        <label for="password_confirmation">Confirmação de senha:</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>

    <div class="form-group col-md-3">
        <label for="is_admin">Perfil de acesso:</label>

        <select class="form-control" name="is_admin">

            <?php if ($usuario->id): ?>

                <option value="1" <?php echo ($usuario->is_admin ? 'selected' : ''); ?>>Administrador</option>
                <option value="0" <?php echo (!$usuario->is_admin ? 'selected' : ''); ?>>Cliente</option>

            <?php else: ?>

                <option value="1">Administrador</option>
                <option value="0" selected="">Cliente</option>

            <?php endif; ?>

        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="ativo">Ativo:</label>

        <select class="form-control" name="ativo">

            <?php if ($usuario->id): ?>

                <option value="1" <?php echo ($usuario->ativo ? 'selected' : ''); ?>>Sim</option>
                <option value="0" <?php echo (!$usuario->ativo ? 'selected' : ''); ?>>Não</option>

            <?php else: ?>

                <option value="1">Sim</option>
                <option value="0" selected="">Não</option>

            <?php endif; ?>

        </select>
    </div>

</div>


<button type="submit" class="btn btn-primary mr-2 btn-sm">
    <i class="mdi mdi-checkbox-marked-circle btn-icon-prepend">Salvar</i>
</button>


           
