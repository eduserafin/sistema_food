<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function email() {

        $email = \Config\Services::email();

        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo('luiz-serafin@hotmail.com');
       // $email->setCC('another@another-example.com');
       // $email->setBCC('them@their-example.com');

        $email->setSubject('Teste de envio de e-mail');
        $email->setMessage('Teste');

       if ($email->send()) {

        echo 'Email enviado';

        } else {

          echo $email->printDebugger();
        }

    }
}
