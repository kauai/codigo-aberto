<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 03/01/2020
 * Time: 00:10
 */

namespace Source\Controllers;

use Source\Models\User;

/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    /**
     * Web constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        if (!empty($_SESSION['user'])) {
            $this->router->redirect('app.home');
        }
    }

    /**
     *
     */
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

    /**
     * @param array $data
     */
    public function register(array $data): void
    {
        $form_user = (object)[
            'first_name' => '',
            'last_name' => '',
            'email' => ''
        ];

        $social_user = null;

        if(!empty($_SESSION['facebook_auth'])) {
            $social_user = unserialize($_SESSION['facebook_auth']);
        }

        if(!empty($_SESSION['google_auth'])) {
            $social_user = unserialize($_SESSION['google_auth']);
        }

        if ($social_user) {
            $form_user = (object) [
                'first_name' => $social_user->getFirstName(),
                'last_name' => $social_user->getLastName(),
                'email' => $social_user->getEmail()
            ];
        }

        echo $this->view->render('theme/register', [
            'head' => $this->seo->optimize(
                "Cria sua conta no site" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.register"),
                routeImage('Register')
            )->render(),
            "user" => $form_user
        ]);
    }

    /**
     *
     */
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

    /**
     * @param $data
     */
    public function reset($data): void
    {
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $forget = filter_var($data['forget'], FILTER_DEFAULT);

        if (empty($_SESSION['forget'])) {
            flash("info", "Informe seu email para recuperar a senha");
            $this->router->redirect("web.forget");
        }

        if (empty($email) || empty($forget)) {
            flash("error", "Nao foi possivel recuperar sua senha o Link foi corrompido");
            $this->router->redirect("web.forget");
        }

        $user = (new User())->find("email = :email AND forget = :forget", "email={$email}&forget={$forget}")->fetch();
        if (!$user) {
            flash("error", "Usuario nao existente!!");
            $this->router->redirect("web.forget");
        }

        echo $this->view->render('theme/reset', [
            'head' => $this->seo->optimize(
                "Crie sua nova senha |" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.reset"),
                routeImage('Reset')
            )->render()
        ]);
    }

    /**
     * @param $data
     */
    public function error($data): void
    {
        $error = filter_var($data['errcode'], FILTER_VALIDATE_INT);
        echo $this->view->render('theme/error', [
            'head' => $this->seo->optimize(
                "OOps {$error} |" . site('name'),
                site(SITE['desc']),
                $this->router->route("web.error", ['errcode' => $error]),
                routeImage('Register')
            )->render(),
            "error" => $error
        ]);
    }


}
