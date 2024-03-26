<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;




return function (App $app) {


    $app->group('/v1', function (Group $group) {
        $group->post('/login', \App\Controller\LoginController::class . ':doLogin');
    });




    $app->group('/v1/services',function (Group $group) {
        $group->post('/transition/new', \App\Controller\TransitionController::class . ':createNewTransition');


        $group->get('/transition/list', \App\Controller\TransitionController::class . ':listTransition');
    });


};
