<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 23/01/2020
 * Time: 11:49
 */

namespace Source\Controllers;


use Source\Models\User;

class App extends Controller
{
    /** @var  User */
    protected $user;

    public function __construct($router)
    {
        parent::__construct($router);
        if (empty($_SESSION['user']) || !$this->user = (new User())->findById($_SESSION['user'])) {
            unset($_SESSION['user']);
            flash("info", "Acesso restrito nao logado!!");
            $this->router->redirect('web.login');
        }
    }

    public function home(): void
    {
        echo $this->view->render('theme/dashboard', [
            'head' => $this->seo->optimize(
                "Bem vindo {$this->user->first_name}" . site('name'),
                site(SITE['desc']),
                $this->router->route("app.home"),
                routeImage('Login')
            )->render(),
            "user" => $this->user
        ]);
    }

    public function logoff(): void
    {
        unset($_SESSION['user']);
        flash("info", "Voce saiu com sucesso {$this->user->first_name}!!");
        $this->router->redirect('web.login');
    }


}
