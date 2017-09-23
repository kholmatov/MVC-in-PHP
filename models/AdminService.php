<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 12/09/2017
 * Time: 18:03
 */
class AdminService{

    private $user = 'admin';
    private $pass = '123';

    public function compare($login, $code){

        if($this->user == $login && $this->pass == $code){
            $_SESSION['status'] = 1;
            $_SESSION['admin'] = 'Admin';
            return 1;
        }
        return 0;
    }


}