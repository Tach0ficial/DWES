<?php

namespace  App\Controllers;

use App\Models\Usuario;
use App\Models\Ciudadano;

class AuthController extends BaseController
{
    public function loginAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = Usuario::getInstancia();
            if (isset($_POST['username']) && isset($_POST['password'])) {
                if ($user->login(clearData($_POST['username']), clearData($_POST['password']))) {
                    $usuario = $user->getByUsername(clearData($_POST['username']));
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['username'] = $usuario->getUsername();
                    $_SESSION['perfil'] = $usuario->getPerfil();
                    header('Location: ./');
                } else {
                    $data = "Usuario o contraseña incorrectos";
                    $this->renderHTML('../Views/login_view.php', $data);
                }
            }
        } else {
            $this->renderHTML('../Views/login_view.php');
        }
    }

    public function signupAction()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])) {
                if ($_POST['re-password'] == $_POST['password']) {
                    $user = Usuario::getInstancia();
                    if (!$user->userExist(clearData($_POST['username']))) {
                        $user->setUsername(clearData($_POST['username']));
                        $user->setPsw(clearData($_POST['password']));
                        $user->set();
                        $ciudadano = Ciudadano::getInstancia();
                        $ciudadano->setNombre(clearData($_POST['nombre']));
                        $ciudadano->setEmail(clearData($_POST['email']));
                        $ciudadano->setIdUsuario($user->lastInsert());
                        $ciudadano->set();
                        header('Location: ./login');
                    }else{
                        $data['error'] = 'El usuario ya existe';
                        $this->renderHTML('../Views/signup_view.php', $data);
                    }
                } else {
                    $data['error'] = 'Las contraseñas no coinciden';
                    $this->renderHTML('../Views/signup_view.php', $data);
                }
            }
        } else {
            $this->renderHTML('../Views/signup_view.php');
        }
    }
    public function logoutAction()
    {
        session_destroy();
        header('Location: ./login');
    }
}
