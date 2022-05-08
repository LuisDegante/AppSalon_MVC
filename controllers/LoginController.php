<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        // echo "Desde Login";

        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            // vardumpFormateado($auth);

            if(empty($alertas)) {
                //Verificar que el usuario existe
                $usuario = Usuario::where('email', $auth->email);
                // vardumpFormateado($usuario);

                if($usuario) {
                    //El usuario existe, verificar que el password sea correcto
                    // vardumpFormateado($usuario);
                    $resultado = $usuario->comprobarPassword($auth->password);

                    if($resultado) {
                        //Password correcto, verificar que el usuario esté confirmado
                        $confirmado = $usuario->comprobarVerificacion();

                        if($confirmado) {
                            //El Usuario ya está confirmado, autenticar el usuario

                            session_start();

                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;

                            //Checar qué tipo de usuario es para redireccionamiento a la página que le corresponde
                            if($usuario->admin === "1") {
                                //El Usuario es Administrador

                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header('Location: /admin');
                            } else {
                                //El Usuario no es Administrador

                                header('Location: /cita');
                            }
                        } else {
                            Usuario::setAlerta('error', 'El Usuario Aún No Está Confirmado');
                        }
                    } else {
                        Usuario::setAlerta('error','La Contraseña Es Incorrecta');
                    }
                } else {
                    Usuario::setAlerta('error','El Usuario No Existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout() {
        // echo "Desde Logout";
        session_start();

        $_SESSION = [];
        // vardumpFormateado($_SESSION);

        header('Location: /');
    }

    public static function olvide(Router $router) {
        // echo "Desde Olvide";

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmailRecuperacion();

            // vardumpFormateado($alertas);

            if(empty($alertas)) {
                //Verificar que el usuario existe

                $usuario = Usuario::where('email', $auth->email);
                // vardumpFormateado($usuario);

                if($usuario) {
                    //El Usuario existe, verificando que la cuenta esté comprobada
                    $confirmado = $usuario->comprobarVerificacion();

                    if($confirmado) {
                        //El Usuario Está confirmado, generar su token para generar nueva contraseña

                        //Generando el token
                        $usuario->crearToken();

                        //Almacenando al usuario en la BD
                        $resultado = $usuario->guardar();

                        //Enviar el email de restauración
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        // vardumpFormateado($email);
                        $email->enviarInstrucciones();

                        if($resultado) {
                            //Mandar a página para generar su nueva contraseña
                            Usuario::setAlerta('exito','Hemos Enviado Las Instrucciones Para Restablecer Tu Contraseña');
                        }
                    } else {
                        Usuario::setAlerta('error','El Usuario Aún No Está Confirmado');
                    }
                } else {
                    Usuario::setAlerta('error','El Usuario No Existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router) {
        // echo "Desde Recuperar";
        $alertas = [];

        $token = sanitizar($_GET['token']);
        // vardumpFormateado($token);

        $usuario = Usuario::where('token',$token);
        // vardumpFormateado($usuario);

        //Variable de error para ocultar formulario de recuperar contraseña, el ocultamiento se hace desde la vista de recuperar-password
        $error = false;

        if(empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token No Válido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $password = new Usuario($_POST);
            // vardumpFormateado($password);

            $alertas = $password->validarPassword();
            // vardumpFormateado($alertas);

            if(empty($alertas)) {
                
                //Eliminando el password anterior
                $usuario->password = null;

                //Asignando a la instancia de Usuario el nuevo password
                $usuario->password = $password->password;
                //Hashear el password
                $usuario->hashPassword();

                //Eliminando el Token
                $usuario->token = '';

                $resultado = $usuario->guardar();

                if($resultado) {
                    Usuario::setAlerta('exito','Contraseña Restablecida Correctamente, Redirigiendo al Inicio de Sesión');

                    $error = true;

                    //Redirigiendo al Inicio de Sesión
                    $url = '/';
                    $tiempo_espera = 5;
                    header("refresh: $tiempo_espera; url= $url");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('/auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {
        // echo "Desde Crear Cuenta";

        //Instanciando la clase de Usuario
        $usuario = new Usuario($_POST);
        // vardumpFormateado($usuario);

        //Arreglo de alertas vacías
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo "Enviaste el Formulario";

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            // vardumpFormateado($alertas);

            //Revisar que el arreglo de alertas esté vacío
            if(empty($alertas)) {
                // echo "Pasaste la validación";

                //Verificar que el usuario no esté registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //El usuario no está registrado

                    //Hasheando el Password
                    $usuario->hashPassword();

                    //Generar un tóken único
                    $usuario->crearToken();

                    //Enviar el email de confirmación
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    // vardumpFormateado($email);
                    $email->enviarConfirmacion();

                    //Almacenando al usuario en la BD
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        // echo "Guardado Correctamente";
                        header('Location: /mensaje') ;
                    }
                    // vardumpFormateado($usuario);
                }
            }
        }

        $router->render('/auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('/auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];

        $token = sanitizar($_GET['token']);
        // vardumpFormateado($token);

        $usuario = Usuario::where('token',$token);
        // vardumpFormateado($usuario);

        if(empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error','Token No Válido');
        } else {
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = '';
            // vardumpFormateado($usuario);

            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta Confirmada Correctamente, Redirigiendo al Inicio de Sesión...');

            //Redirigiendo al Inicio de Sesión
            $url = '/';
            $tiempo_espera = 5;
            header("refresh: $tiempo_espera; url= $url");
        }

        //Obtener Alertas
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}