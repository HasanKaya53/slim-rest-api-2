<?php

namespace App\Libraries;

Class PasswordClass
{

    public static function hash($password){
        return md5('kdfm29324*129853k209xmöçvç....çöcmdjk'.md5(md5(md5('xxx'.md5(md5($password))))));
    }

    public static function verify($password, $hash){
        return $hash == self::hash($password);
    }
}