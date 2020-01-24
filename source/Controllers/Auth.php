<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 14/01/2020
 * Time: 14:08
 */

namespace Source\Controllers;

use Source\Models\User;
use Source\Support\Email;

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

        if (!$user || !password_verify($passwd, $user->password)) {
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


    public function forget(array $data): void
    {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            echo $this->ajaxResponse('message', [
                "type" => "alert",
                "message" => "Informe o seu email para recuperar a senha!"
            ]);
            return;
        }

        $user = (new User())->find("email = :email", "email={$email}")->fetch();

        if (!$user) {
            echo $this->ajaxResponse('message', [
                "type" => "error",
                "message" => "O email informado nao esta cadastrado!!"
            ]);
            return;
        }

        $user->forget = md5(uniqid(rand(), true));
        $user->save();

        $_SESSION['forget'] = $user->id;

        $email = new Email();
        $email->add(
            "Recuper sua senha |" . site(),
            $this->view->render("emails/recover", [
                "user" => $user,
                "link" => $this->router->route("web.reset", [
                    "email" => $user->email,
                    "forget" => $user->forget
                ])
            ]),
            "{$user->frist_name} {$user->last_name}",
            $user->email
        )->send();

        flash("success", "Enviamos um link para o seu email,por favor acesse!!");
        echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route("web.forget")
        ]);
    }


    public function reset(array $data): void
    {
        if (empty($_SESSION['forget']) || !$user = (new User())->findById($_SESSION['forget'])) {
            flash("error", "O link de recuperaçao de senha expirou! tente novamente");
            echo $this->ajaxResponse("redirect", [
                "url" => $this->router->route("web.forget")
            ]);
            return;
        }

        if (empty($data['password']) || empty($data['password_re'])) {
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "Preencha todos os campos!!"
            ]);
            return;
        }

        if ($data['password'] != $data['password_re']) {
            echo $this->ajaxResponse("message", [
                "type" => "alert",
                "message" => "A informaçao dos dois campos nao coincidem!"
            ]);
            return;
        }

        $user->password = $data['password'];
        $user->forget = null;

        if (!$user->save()) {
            echo $this->ajaxResponse("message", [
                "type" => "error",
                "message" => $user->fail()->getMessage()
            ]);
            return;
        }

        unset($_SESSION['forget']);
        flash("success","Sua senha foi atualizada com sucesso!!");
        echo $this->ajaxResponse("redirect",[
            "url" => $this->router->route("web.login")
        ]);
    }
}
