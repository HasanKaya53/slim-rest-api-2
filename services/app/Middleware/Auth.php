<?php



namespace App\Middleware;


class Auth
{
    public function __invoke($request, $handler)
    {
        $response = $handler->handle($request);



        $authorizationHeader = $request->getHeaderLine('Authorization');

        if (empty($authorizationHeader) || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            echo json_encode(['status'=>false,'error' => 'token bulunamadı']);
        }


        $jwt = $matches[1];


        $jwtClass = new \App\Libraries\JWTClass();
        $decoded = $jwtClass->decode($jwt);


        if (isset($decoded->exp) && $decoded->exp < time()) {
            throw new UnauthorizedException($request, 'Token has expired');
        }




        return $response;




    }
}


