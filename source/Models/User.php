<?php
/**
 * Created by PhpStorm.
 * User: thiag
 * Date: 14/01/2020
 * Time: 14:00
 */

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users",["first_name","last_name","email","password"]);
    }
}
