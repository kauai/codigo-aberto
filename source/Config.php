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
    "root" => "https://www.localhost/CODIGO-ABERTO/Temporada-01/",
    "root02" => "https://localhost/CODIGO-ABERTO/Temporada-01",
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

/**
 * MAIL
 */
define('CONF_MAIL_HOST', "smtp.sendgrid.net");
define('CONF_MAIL_PORT', "587");
define('CONF_MAIL_USER', "apikey");
define('CONF_MAIL_SENDER', ["name" => "", "address" => ""]);
define('CONF_MAIL_PASS', "");
define('CONF_MAIL_SUPPORT', "");

define('CONF_MAIL_OPTION_LANG', "br");
define('CONF_MAIL_OPTION_HTML', true);
define('CONF_MAIL_OPTION_AUTH', true);
define('CONF_MAIL_OPTION_SECURE', "tls");
define('CONF_MAIL_OPTION_CHARSET', "utf-8");

/*
 * SOCIAL LOGIN
 */
define("FACEBOOK_LOGIN",[
    'clientId'          => '',
    'clientSecret'      => '',
    'redirectUri'       => SITE['root02']."/facebook",
    'graphApiVersion'   => 'v4.0'
]);

define("GOOGLE_LOGIN",[
    'clientId'          => '.apps.googleusercontent.com',
    'clientSecret'      => '',
    'redirectUri'       => SITE['root02']."/google",
]);

