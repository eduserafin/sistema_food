<?php

namespace App\Libraries;

/*
    @descrição essa biblioteca/classe cuidará da parte de autenticação na nossa aplicação
*/

class Autenticacao {

    private $usuario;

    /**
     * @param string $email
     * @param string $password
     * @return boolean
     */

    public function login(string $email, string $password) {

        $usuarioModel = new \App\Models\UsuarioModel();

        $usuario = $usuarioModel->buscaUsuarioPorEmail($email);

        /*Se não encontrar o usuario por email, retorna false */

        if ($usuario === null) {

            return false;

        }

        /*Se a senha não for encontrada, retorna false */

        if (!$usuario->verificaPassword($password)) {

            return false;

        }

         /*Só permite login usuarios ativos */

        if (!$usuario->ativo) {

            return false;

        }

        /*Aqui podemos logar o usuario na nossa aplicação, invocando o método abaixo */

        $this->logaUsuario($usuario);

        return true;

    }

    public function logout() {

        session()->destroy();

    }

    public function pegaUsuarioLogado () {

        /* Não esquecer de compartilhar a intancia com services */

        if($this->usuario === null){

            $this->usuario = $this->pegaUsuarioDaSessao();

        }

        /* Retornamos o usuario que foi defenido no inicio da classe */

        return $this->usuario;

    }

    public function estaLogado() {

        return $this->pegaUsuarioLogado() !== null;

    }

    private function pegaUsuarioDaSessao() {

        if (!session()->has('usuario_id')) {

            return null;

        }

        /* Instanciamos o Model Usuario */

        $usuarioModel = new \App\Models\UsuarioModel();

        /* Recupero o usuario de acordo com a chave da sessão 'usuario_id' */

        $usuario = $usuarioModel->find(session()->get('usuario_id'));

        /* Só retorno o objeto $usuario se o mesmo for encontrado e estiver ativo */

        if ($usuario && $usuario->ativo) {

            return $usuario;

        }

    }

    private function logaUsuario(object $usuario) {

        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario->id);

    }
}

?>