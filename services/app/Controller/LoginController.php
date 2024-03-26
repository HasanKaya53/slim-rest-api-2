<?php

namespace App\Controller;

use App\Model\PlateModel;
use App\Model\TransitionModel;


use App\Libraries\PasswordClass;
use App\Model\UserModel;
use App\Libraries\JWTClass;
class LoginController
{

    public function doLogin($request, $response)
    {
        $JWTClass = new JWTClass();
        try {
            $data = $request->getParsedBody();
            $data = json_decode(json_encode($data),true);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
        if (!isset($data['username']) || !isset($data['password'])) {
            echo json_encode(['error' => 'Kullanıcı adı ve şifre zorunludur.']);
            die;
        }
        $username = $data['username'] ?: null;
        $password = $data['password'] ?: null;

        if (is_null($username) || is_null($password)) {
            echo json_encode(['error' => 'Kullanıcı adı ve şifre zorunludur.']);
            die;
        }


        $userModel = new UserModel();
        $user = $userModel->getUser($username, PasswordClass::hash($password));

        if (count($user) == 0) {
            echo json_encode(['error' => 'Kullanıcı adı veya şifre hatalı.']);
            die;
        }
        $user = $user[0];

        session_start();
        $sessionID = session_id();
        $token = $JWTClass->encode($sessionID);
        $_SESSION['user'] = $user;
        $_SESSION['token'] = $token;
        //echo json ..
        $response->getBody()->write(json_encode(['status'=>true,'token' => $token]));
        return $response;

    }


}