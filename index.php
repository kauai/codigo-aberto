<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 26/12/2019
 * Time: 10:06
 */
ob_start();
session_start();
require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace('Source\Controllers');
$router->group(null);
$router->get('/','Web:login','web.login');
$router->get('/cadastrar','Web:register','web.register');
$router->get('/recuperar','Web:forget','web.forget');
$router->get("/senha/{email}/{forget}",'Web:reset','web.reset');

/*
 * Auth
 */
$router->group(null);
$router->post('/login',"Auth:login","auth.login");
$router->post('/register',"Auth:register","auth.register");


/*
 * Auth-Social
 */


/*
 * Profile
 */

/*
 * Errors
 */
$router->group('/oops');
$router->get("/{errcode}","Web:error",'web.error');

/*
 * ROUTE PROCESS
 */

$router->dispatch();

/*
 * ERROR PROCESS
 */
if($router->error()){
    $router->redirect("web.error",['errcode' => $router->error()]);
}







ob_end_flush();
