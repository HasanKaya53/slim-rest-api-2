<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTClass
{


    private $key = '';
    private $payload = [];

    function __construct()
    {
        $this->key = 'secretKey';
        $iat = time();
        $nbf = $iat + 40;
        $this->payload = [
            'iss' => 'https://hasankaya.info',
            'aud' => 'https://hasankaya.info',
            'iat' => $iat,
            'nbf' => $nbf
        ];
    }

    public function encode($data)
    {
        $this->payload['user'] = $data;
        return JWT::encode($this->payload, $this->key, 'HS256');

    }

    public function decode($jwt)
    {
       return  JWT::decode($jwt, new Key($this->key, 'HS256'));
    }


}