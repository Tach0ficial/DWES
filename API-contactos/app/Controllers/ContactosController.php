<?php

namespace App\Controllers;


use App\Models\Contactos;

class ContactosController extends BaseController
{
    private $requestMethod;
    private $userId;
    private $contactos;

    public function __construct($requestMethod, $userId)
    {
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->contactos = contactos::getInstancia();
    }
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getContactos($this->userId);
                } else {
                    $response = $this->getAllContactos();
                };
                break;
            case 'POST':
                $response = $this->createContactosFromRequest();
                break;
            case 'PUT':
                $response = $this->updateContactosFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteContactos($this->userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        return $response;
    }
    public function updateContactosFromRequest($userId)
    {
        $input = (array) json_decode(file_get_contents('php://input'));
        ['nombre' => $nombre, 'telefono' => $telefono, 'email' => $email] = $this->contactos->get($userId)[0];
        $this->contactos->setId($userId);
        $this->contactos->setNombre($input['nombre'] ?? $nombre);
        $this->contactos->setTelefono($input['telefono'] ?? $telefono);
        $this->contactos->setEmail($input['email']  ?? $email);
        $this->contactos->edit();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($this->contactos->getMensaje());
        return $response;
    }

    public function createContactosFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        $this->contactos->setNombre($input['nombre']);
        $this->contactos->setTelefono($input['telefono']);
        $this->contactos->setEmail($input['email']);
        $this->contactos->set();
        $response['status_code_header'] = 'HTTP/1.1 201 CREATED';
        $response['body'] = json_encode($this->contactos->getMensaje());
        return $response;
    }
    public function getAllContactos()
    {
        $contactos = $this->contactos->getAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($contactos);
        return $response;
    }

    private function deleteContactos($userId)
    {
        $contacto = $this->contactos->get($userId);
        if ($contacto) {
            $this->contactos->setId($userId);
            $this->contactos->delete();
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($this->contactos->getMensaje());
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }
    private function getContactos($id)
    {
        $result = $this->contactos->get($id);

        if (count($result) < 1) {
            $response = $this->notFoundResponse();
        } else {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($result);
        }
        return $response;
    }
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
