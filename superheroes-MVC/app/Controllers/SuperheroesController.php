<?php

namespace  App\Controllers;

use App\Models\Superheroe;
use App\Models\Peticion;
use App\Models\Habilidad;
use App\Models\Usuario;

class SuperheroesController extends BaseController
{

    public function homeAction()
    {
        $sh = Superheroe::getInstancia();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $buscar = clearData($_POST['buscar']);
            $data = $sh->buscar($buscar);
        } else {
            $data = $sh->getAll();
        }
        foreach ($data as $key => $heroe) {
            $data[$key]["habilidades"] = $sh->getHabilidades($heroe["id"]);
        }
        $this->renderHTML('../Views/index_view.php', $data);
    }

    // /sh/edit/id/ ShController EditAction
    public function editAction()
    {
        $id = explode('/', $_SERVER['REQUEST_URI'])[2];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sh = Superheroe::getInstancia();
            $sh->setId($id);
            $sh->setNombre(clearData($_POST['nombre']));
            $sh->setVelocidad(clearData($_POST['velocidad']));
            $sh->edit();
            header('Location: /');
        } else {
            $sh = Superheroe::getInstancia();
            $data = $sh->get($id);
            $this->renderHTML('../Views/edit_view.php', $data);
        }
    }

    public function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                if ($_POST['re-password'] == $_POST['password']) {
                    $user = Usuario::getInstancia();
                    if (!$user->userExist($_POST['username'])) {
                        $user->setUsername(clearData($_POST['username']));
                        $user->setPsw(clearData($_POST['password']));
                        $user->set();
                        $sh = Superheroe::getInstancia();
                        $sh->setNombre(clearData($_POST['nombre']));
                        define("MAXSIZE", 2097152);
                        define("DIR_UPLOAD", "img/");
                        $allowedExts = array("jpg", "jpeg", "gif", "png");
                        $allowedFormats = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/x-png");
                        $extension = explode(".", $_FILES["file"]["name"]);
                        $extension = strtolower(end($extension));
                        $format = $_FILES["file"]["type"];
                        $size = $_FILES["file"]["size"];
                        $error = $_FILES["file"]["error"];
                        $name =
                            substr($_FILES["file"]["name"], 0, strrpos($_FILES["file"]["name"], ".")) .
                            getdate()["year"] .
                            getdate()["mon"] .
                            getdate()["mday"] .
                            getdate()["hours"] .
                            getdate()["minutes"] .
                            getdate()["seconds"] . "." . $extension;
                        if (
                            $size <= MAXSIZE
                            && in_array($format, $allowedFormats)
                            && in_array($extension, $allowedExts)
                            && $error == 0
                            && $name != ""
                        ) {
                            echo "Foto subida.<br>";
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], DIR_UPLOAD . $name)) {
                                echo "La foto " .  basename($_FILES["file"]["name"]) .
                                    " ha sido subido correctamente.";
                            } else {
                                echo "Ha ocurrido un error al subir la foto.";
                            }
                        } else {
                            echo "Error al subir la foto.";
                        }
                        $sh->setImagen($name);
                        $sh->setIdUsuario($user->lastInsert());
                        $sh->set();
                        $idSuperheroe = $sh->lastInsert();
                        foreach ($_POST['habilidades'] as $habilidad) {
                            $sh->setHabilidadById($idSuperheroe, $habilidad, $_POST[$habilidad . 'Valor']);
                        }
                        header('Location: /');
                    } else {
                        header('Location: /add');
                    }
                } else {
                    header('Location: /add');
                }
            } else {
                header('Location: /add');
            }
        } else {
            $hb = Habilidad::getInstancia();
            $data = $hb->getAll();
            $this->renderHTML('../Views/add_view.php', $data);
        }
    }

    public function deleteAction()
    {
        $id = explode('/', $_SERVER['REQUEST_URI'])[2];
        $sh = Superheroe::getInstancia();
        $data = $sh->get($id);
        $sh->delete($id);
        $this->renderHTML('../Views/delete_view.php', $data);
    }

    public function newHabilidadAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sh = Superheroe::getInstancia();
            $habilidad = Habilidad::getInstancia();
            $habilidad->setNombre(clearData($_POST['nombre']));
            $habilidad->set();
            $habilidad->setId($habilidad->lastInsert());
            $sh->setHabilidad($habilidad->getId(), clearData($_POST['valor']));
            header('Location: /');
        } else {
            $this->renderHTML('../Views/newHabilidad_view.php');
        }
    }

    public function showPeticionesAction()
    {
        $superheroe = Superheroe::getInstancia();
        $idSuperheroe = $superheroe->getIdSuperheroeByIdUser($_SESSION['id']);
        $peticion = Peticion::getInstancia();
        $data = $peticion->getAllByIdSuperheroe($idSuperheroe);
        $this->renderHTML('../Views/show_peticiones_view.php', $data);
    }

    public function realizarPeticionAction()
    {
        $idPeticion = explode('/', $_SERVER['REQUEST_URI'])[2];
        $peticion = Peticion::getInstancia();
        $sh = Superheroe::getInstancia();
        $peticion->realizada($idPeticion);
        if ($peticion->getNumOfPeticiones($sh->getIdSuperheroeByIdUser($_SESSION['id'])) == 3) {
            $sh->experto($sh->getIdSuperheroeByIdUser($_SESSION['id']));
            $_SESSION['perfil'] = "superheroeExperto";
        }
        header('Location: /');
    }
}
