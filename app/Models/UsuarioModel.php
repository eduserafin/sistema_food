<?php

namespace App\Models;

use CodeIgniter\Model;

use App\Libraries\Token;

class UsuarioModel extends Model {

    protected $table = 'usuarios';
    protected $returnType = 'App\Entities\Usuario';
    protected $alloweFields = ['nome', 'email', 'cpf', 'telefone', 'password', 'reset_hash', 'reset_expira_em'];

    //Datas
    protected $useTimestamps = true;
    protected $createdField = 'criado_em';
    protected $updatedField = 'atualizado_em';
    protected $dataFormat = 'datetime'; // Para uso com  $useSoftDeletes
    protected $useSoftDeletes = true;
    protected $deletedField = 'deletado_em';

    //Validações
    protected $validationRules    = [
        'nome' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'cpf' => 'required|exact_length[14]|validaCpf|is_unique[usuarios.cpf]',
        'telefone' => 'required',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [

        'nome'        => [
            'required' => 'Esse campo é obrigatório, informe o nome!',
        ],

        'email'        => [
            'required' => 'Esse campo é obrigatório, informe um email!',
            'is_unique' => 'Desculpe. Esse email já existe!',
        ],

        'cpf'        => [
            'required' => 'Esse campo é obrigatório, informe o CPF!',
            'is_unique' => 'Desculpe. Esse CPF já existe!',
        ],
    ];

    //Eventos callback
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data) {

        if (isset($data['data']['password'])){

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);

        }
        return $data;
    }

    /**
     * @uso Controller usarios no método procurar com o autocomplete
     * @param string $term
     * @return array usuarios
     */

    public function procurar($term)  {

        if ($term === null) {

            return [];
        }

        return $this->select('id, nome')
            -> like('nome', $term)
            ->get()
            ->getResult();
    }

    public function desabilitaValidacaoSenha()  {

        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);

    }

    public function desfazerExclusao(int $id) {

        return $this->protect(false)
            ->where('id', $id)
            ->set('deletado_em', null)
            ->update();

    }

    /**
     * @uso Classe Autenticacao
     * @param string $email
     * @return objeto $usuario
     */
    
    public function buscaUsuarioPorEmail(string $email){

        return $this->where('email', $email)->first();
    }

    public function BuscaUsuarioParaResetarSenha(string $token) {

        $token = new Token($token);

        $tokenHash = $token->getHash();

        $usuario = $this->where('reset_hash', $tokenHash) ->first();

        if ($usuario != null) {

            /**
             * Vereficamos se o token não está expirado de acordo com a data e hora atuais 
             */

            if ($usuario->reset_expira_em < date('Y-m-d H:i:s')) {

                /**
                 * Token está expirado, então setamos o $usuario = null;
                 */

                $usuario = null;

            }

            return $usuario;
        }
    }
   
}
