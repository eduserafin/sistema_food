<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function novo() {
        
        $data = [

            'titulo' => 'Realizar Login',
        ];

        return view('Login/novo', $data);

    }

    public function criar() {
        
        
        if ($this->request->getMethod() === 'post') {

            //dd($this->request->getPost());

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $autenticacao = service('autenticacao');

            //dd($autenticacao);
 
            if($autenticacao->login($email, $password)) {

                $usuario = $autenticacao->pegaUsuarioLogado();

                //dd($usuario);
            
                 if(!$usuario->is_admin){

                     return redirect()->to(site_url('/'));

                }

                return redirect()->to(site_url('admin/home'))->with('sucesso', "Olá $usuario->nome, que bom que está de volta");
           
            } else {

                return redirect()->back()->with('atencao', 'Não encontramos suas credenciais de acesso');
            }

        } else {

            return redirect()->back();

        }

    }

    public function logout() {

        service('autenticacao')->logout();

        return redirect()->to(site_url('login/mostraMensagemLogout'));
    }

    public function mostraMensagemLogout() {

        return redirect()->to(site_url("login"))->with('info', 'Esperamos ver você novamente');

    }


}
