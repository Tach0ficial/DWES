<?php

namespace  App\Controllers;

use App\Models\Ciudadano;
use App\Models\Peticion;

class CiudadanosController extends BaseController
{
    public function peticionAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ciudadano = Ciudadano::getInstancia();
            $idSuperheroe = explode('/', $_SERVER['REQUEST_URI'])[2];
            $idCiudadano = $ciudadano->getIdCiudadanoByIdUser($_SESSION['id']);
            if (isset($_POST['titulo']) && isset($_POST['descripcion'])) {
                $peticion = Peticion::getInstancia();
                $peticion->setTitulo(clearData($_POST['titulo']));
                $peticion->setDescripcion(clearData($_POST['descripcion']));
                $peticion->setIdSuperheroe($idSuperheroe);
                $peticion->setIdCiudadano($idCiudadano);
                $peticion->set();
                header('Location: ./');
            }else{
                $data["error"] = "No se ha podido realizar la petición";
                $this->renderHTML('../Views/peticion_view.php', $data);
            }
        } else {
            $this->renderHTML('../Views/peticion_view.php');
        }   
    }
}
