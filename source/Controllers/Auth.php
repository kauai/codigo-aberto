<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 14/01/2020
 * Time: 14:08
 */

namespace Source\Controllers;

use Source\Models\User;

/**
 * Class Auth
 * @package Source\Controllers
 */
class Auth extends Controller
{
    /**
     * Auth constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @param array $data
     */
    public function login(array $data): void
    {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $passwd = filter_var($data['passwd'], FILTER_DEFAULT);

        if (!$email || !$passwd) {
            echo $this->ajaxResponse('message', [
                "type" => "alert",
                "message" => "Informe seu email e senha para login"
            ]);
            return;
        }

        $user = (new User())->find('email = :email', "email={$email}")->fetch();

        if (!$user || !password_verify($passwd,$user->password)) {
            echo $this->ajaxResponse('message', [
                "type" => "alert",
                "message" => "Usuario ou senha invalidos!"
            ]);
            return;
        }

        $_SESSION['user'] = $user->id;

        echo $this->ajaxResponse('redirect', [
            "url" => "{$this->router->route('app.home')}"
        ]);
    }

    /**
     * @param $data
     */
    public function register($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (in_array('', $data)) {
            echo $this->ajaxResponse('message', [
                "type" => "error",
                "message" => "Preencha todos os campos!!!"
            ]);
            return;
        }

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);

        if (!$user->save()) {
            echo $this->ajaxResponse('message', [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return;
        };

        $_SESSION['user'] = $user->id;
        echo $this->ajaxResponse('redirect', [
            "url" => $this->router->route("app.home")
        ]);
    }
}
