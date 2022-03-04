<?php

namespace App\Controllers;

use \Firebase\JWT\JWT;
use \Firebase\JWT\key;
use App\Models\Users;

class AuthController
{
    private $users;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->users = Users::getInstancia();
    }
    public function loginFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $usuario = $input['usuario'];
        $password = $input['password'];
        $dataUser = $this->users->login($usuario, $password);

        if ($dataUser) {
            $issuer_claim = "http://apirestcontactos.local"; // this can be the servername
            $audience_claim = "http://apirestcontactos.local";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = time(); //not before in seconds
            $expire_claim = $issuedat_claim + 3600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "usuario" => $usuario,

                )
            );

            $jwt = JWT::encode($token, KEY, 'HS256');
            $res = json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,

                )
            );


            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = $res;
        } else {
            $response['status_code_header'] = 'HTTP/1.1 401 Login failed';
            $response['body'] = null;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
}
