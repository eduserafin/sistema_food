<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController
{

    private $usuarioModel;

    public function __construct() {
        
        $this->usuarioModel = new \App\Models\UsuarioModel();

    }

    public function esqueci() {

        $data = [

            'titulo' => 'Esqueci a minha senha',

        ];

        return view('Password/esqueci', $data);

    }

    public function processaEsqueci() {

        if($this->request->getMethod() === 'post') {

            $usuario = $this->usuarioModel->buscaUsuarioPorEmail($this->request->getPost('email'));

            if($usuario === null || !$usuario->ativo) {

                return redirect()->to(site_url('password/esqueci'))
                                 ->with('atencao', 'Não encontramos uma conta válida m esse email')
                                 ->withInput();

            }

            $usuario->iniciaPasswordReset();

            //dd($usuario);

            $this->usuarioModel->save($usuario);

             $this->enviaEmailRedefinicaoSenha($usuario);

             return redirect()->to(site_url('login'))->with('sucesso', 'E-mail de redefinição de senha enviado para sua caixa de entrada');

        } else {

            /* Não é Post */
            return redirect()->back();
        }
    }

    public function reset ($token = null) {

        if ($token === null) {

            return redirect()->to(site_url('password/esqueci')) ->with('atencao', 'Link invalido ou expirado');

        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token);

        //dd($usuario);

        if($usuario != null) {

            $data = [
                'titulo' => 'Redefina a sua senha',
                'Token' => $token,
            ];

            return view('Password/reset', $data);

        } else {

            return redirect()->to(site_url('Password/esqueci'))->with('atencao', 'Link inválido ou expirado');

        }

    }

    public function processaReset($token = null) {

        if ($token === null) {

            return redirect()->to(site_url('password/esqueci')) ->with('atencao', 'Link invalido ou expirado');

        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token);

        //dd($usuario);

        if($usuario != null) {

           //dd($this->request->getPost());

           $usuario->fill($this->request->getPost());

           if($this->usuarioModel->save($usuario)) {

                /**
                 * Setando a coluna 'reset_hash' e 'reset_expira_em' com null ao invocar o metado abaixo que foi defenido na entidade Usuario.php
                 * Invalidamos o link antigo enviado por email para ninguem ter acesso
                 */

                $usuario->completaPasswordReset();

                /** Atualizamos novamente o usuario com os novos valores defenidos acima */

                $this->usuarioModel->save($usuario);

                return redirect()->to(site_url("login"))->with('sucesso', 'Nova senha cadastrada com sucesso!');

           } else {

                return redirect()->to(site_url("password/reset/$token"))
                ->with('errors_model', $this->usuarioModel->errors())
                ->with('atencao', 'Por favor verefique os erros abaixo!')
                ->withInput();

           }

        } else {

            return redirect()->to(site_url('Password/esqueci'))->with('atencao', 'Link inválido ou expirado');

        }

    }

    private function enviaEmailRedefinicaoSenha(object $usuario) {

        $email = service('email');

        $email->setFrom('no-reply@fooddelivery.com.br', 'Food Delivery');

        $email->setTo($usuario->email);
       
        $email->setSubject('Redefinição de senha');

        $mensagem = view('Password/reset_email', ['token' => $usuario->reset_token]);

        $email->setMessage($mensagem);

        $email->send();

    }
}
