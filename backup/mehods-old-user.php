<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 23/01/2020
 * Time: 11:45
 */

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo $this->ajaxResponse('message', [
        "type" => "warning",
        "message" => "O email que foi usado nao é valido!!"
    ]);
    return;
}

$checkUserEmail = (new User())->find('email = :email', "email={$data['email']}")->count();
if ($checkUserEmail) {
    echo $this->ajaxResponse('message', [
        "type" => "warning",
        "message" => "Esse usuario já existe na nossa aplicação"
    ]);
    return;
}
