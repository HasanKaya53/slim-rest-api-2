<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Libraries\JWTClass;
use App\Libraries\PasswordClass;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $JWTClass = new JWTClass();

        $token = $JWTClass->encode(['id' => 1, 'name' => 'Hasan Kaya']);

        $response->getBody()->write($token);
        return $response;
    });

    $app->post('/v1/services/login', function (Request $request, Response $response) {
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




        $password = PasswordClass::hash($password);





        echo json_encode(['username' => $username, 'password' => $password]);
        die;

        $token = $JWTClass->encode($data);

        $response->getBody()->write($token);
        return $response;
    });
};
