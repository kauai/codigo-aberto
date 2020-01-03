<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 02/01/2020
 * Time: 23:47
 */

namespace Source\Controllers;


use CoffeeCode\Optimizer\Optimizer;
use CoffeeCode\Router\Router;
use League\Plates\Engine;

abstract class Controller
{
    /** @var  Engine */
    protected $view;

    /** @var  Router */
    protected $router;

    /** @var  Optimizer */
    protected $seo;

    public function __construct($router)
    {
        $this->router = $router;
        $this->view = Engine::create(dirname(__DIR__, '2') . '/views', 'php');
        $this->view->addData(['router' => $this->router]);
        $this->seo = new Optimizer();
        $this->seo->openGraph("name", "locale", "article")
            ->publisher(SOCIAL['facebook_page'], SOCIAL['facebook_author'])
            ->twitterCard(SOCIAL['twitter_creator'], SOCIAL['twitter_site'], SITE['domain'])
            ->facebook(SOCIAL['facebook_appid']);
    }

    public function ajaxResponse(string $param, array $values): string
    {
        return json_encode([$param => $values]);
    }


}
