<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 26/12/2019
 * Time: 08:37
 */

/*
 * SITE CONFIG
 */
define("SITE", [
    "name" => "Auth em mvc",
    "desc" => "Projeto login teste",
    "domain" => "teste.com",
    "locale" => "pt_BR",
    "root" => "https://www.localhost/CODIGO-ABERTO/Temporada-01/"
]);

/*
 * SITE MINIFY
 */
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    require __DIR__ . "/Minify.php";
}

/*
 * CONECTION DATABASE
 */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "fullstackphp",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/*
 * SOCIAL
 */
define("SOCIAL", [
    "facebook_page" => "testefacebook",
    "facebook_author" => "author-teste",
    "facebook_appid" => "123456565",
    "twitter_creator" => "@teste-twitter",
    "twitter_site" => "@teste-twitter"
]);

/*
 * MAIL CONNECT
 */
define("MAIL",[]);

/*
 * SOCIAL LOGIN
 */
define("FACEBOOK_LOGIN","AA");
define("GOOGLE_LOGIN","");

