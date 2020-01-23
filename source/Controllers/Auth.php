<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 14/01/2020
 * Time: 14:08
 */

namespace Source\Controllers;

use Source\Models\User;

class Auth extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);
    }

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

        if ($user->save()) {
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
