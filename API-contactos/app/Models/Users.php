<?php

namespace App\Models;
class Users extends DBAbstractModel {
    /*CONSTRUCCIÓN DEL MODELO SINGLETON*/
    private static $instancia;
    public static function getInstancia(){
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    public function __clone(){
        trigger_error('La clonación no es permitida!.', E_USER_ERROR);
    }
    
    public function login($usuario, $password) {
        $this->query = "
                SELECT *
                FROM contactos_usuarios
                WHERE usuario = :usuario and
                      password = :password";
       
        $this->parametros['usuario'] = $usuario;
        $this->parametros['password'] = $password;

        
        $this->get_results_from_query();

        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'contacto encontrado';
        } else {
            $this->mensaje = 'contacto no encontrado';
        }
        return $this->rows[0] ?? null;
    }
    public function get($id = '') {
    }
    public function set() {
    }
    public function edit() {
    }
    public function delete() {
    }
}
