<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 14/01/2020
 * Time: 14:00
 */

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name", "email", "password"]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validateEmail() || !$this->validatePassword() || !parent::save()) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function validateEmail(): bool
    {
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->fail = new Exception('Informe um email valido!!');
            return false;
        }

        $userByEmail = null;
        if (!$this->id) {
            $userByEmail = $this->find("email = :email", "email={$this->email}")->count();
        } else {
            //BUSCA UMA EMAIL QUE JÁ ESTA NA BASE DE DADOS HAVENDO UM EMAIL QUER DIZER QUE VC QUER
            //ATUALIZAR O SEU EMAIL MAS ESSE EMAIL JA ÉSTA NA BASE!!!
            $userByEmail = $this->find("email = :email AND id != :id","email={$this->email}&id={$this->id}")->count();
        }

        if($userByEmail){
            $this->fail = new Exception("O email informado já está em uso!!");
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function validatePassword():bool
    {
        if(empty($this->password) || strlen($this->password) < 5){
            $this->fail = new Exception('Iforma uma senha com pelo menos 5 caracteres!!');
            return false;
        }

        if(password_get_info($this->password)['algo']){
            return true;
        }

        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        return true;
    }
}
