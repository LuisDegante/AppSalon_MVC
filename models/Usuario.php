<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    //Mensajes de validación para la creación de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo Electrónico es Obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        } elseif(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 Caracteres';
        }

        return self::$alertas;
    }

    //Mensajes de validación para el inicio de sesión
    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo Electrónico es Obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        }

        return self::$alertas;
    }

    //Mensajes de validación para la Recuperación de Contraseña
    public function validarEmailRecuperacion() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El Correo Electrónico es Obligatorio';
        }

        return self::$alertas;
    }

    //Mensaje de validación para el nuevo Password
    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La Contraseña es Obligatoria';
        } elseif(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La Contraseña debe contener al menos 6 Caracteres';
        }

        return self::$alertas;
    }

    //Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";
        // vardumpFormateado($query);

        $resultado = self::$db->query($query);
        // vardumpFormateado($resultado);

        if($resultado->num_rows) {
            //El usuario ya está regitrado
            self::$alertas['error'][] = 'El Usuario ya está Registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPassword($password) {
        $resultado = password_verify($password, $this->password);
        // vardumpFormateado($resultado);

        return $resultado;
    }

    public function comprobarVerificacion() {
        // vardumpFormateado($this);

        if(!$this->confirmado) {
            //El usuario aún no está confirmado
            return false;
        } else {
            //El usuario ya está confirmado
            return true;
        }
    }
}