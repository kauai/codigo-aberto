<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 03/01/2020
 * Time: 00:10
 */

namespace Source\Controllers;


class Web extends Controller
{
    public function __construct($router)
    {
        parent::__construct($router);

        if (!empty($_SESSION['user'])) {
            $this->router->redirect('/app.home');
        }
    }

    public function login(): void
    {
        echo $this->view->render('theme/login', [
            'head' => $this->seo->optimize(
                "Faça login para continuar" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.login"),
                routeImage('Login')
            )->render()
        ]);
    }

    public function register(array $data): void
    {
        echo $this->view->render('theme/register', [
            'head' => $this->seo->optimize(
                "Cria sua conta no site" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.register"),
                routeImage('Register')
            )->render(),
            "user" => (object)[
                'first_name' => 'Thiago',
                'last_name' => 'Kauai',
                'email' => 'thiago@gmail.com'
            ]
        ]);
    }

    public function forget(): void
    {
        echo $this->view->render('theme/forget', [
            'head' => $this->seo->optimize(
                "Recupere sua senha no site" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.forget"),
                routeImage('Register')
            )->render(),
            "user" => (object)[
                'first_name' => 'Thiago',
                'last_name' => 'Kauai',
                'email' => 'thiago@gmail.com'
            ]
        ]);

    }

    public function reset($data): void
    {
        echo $this->view->render('theme/reset', [
            'head' => $this->seo->optimize(
                "Crie sua nova senha |" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.reset"),
                routeImage('Reset')
            )->render()
        ]);
    }

    public function error($data): void
    {
        $error = filter_var($data['errcode'],FILTER_VALIDATE_INT);
        echo $this->view->render('theme/error', [
            'head' => $this->seo->optimize(
                "OOps {$error} |" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.error",['errcode' => $error]),
                routeImage('Register')
            )->render(),
            "error" => $error
        ]);
    }


}
