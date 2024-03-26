<?php

namespace App\Libraries;

Class PasswordClass
{

    public function hash($password){
        return md5('kdfm29324*129853k209xmöçvç....çöcmdjk'.md5(md5(md5('xxx'.md5(md5($password))))));
    }
}