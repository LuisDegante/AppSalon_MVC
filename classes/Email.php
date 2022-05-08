<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        
        //Creando en objeto de Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c907de0e15e3bf';
        $mail->Password = '33bddfd1de98ab';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Creando los datos del remitente
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','App Salón Suite');
        $mail->Subject = ('Confirma tu Cuenta');

        //Creando en cuerpo del mensaje
        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "!</strong> Has creado una cuenta en nuestro portal de App Salón, por lo cual requerimos que la confirmes dando click en el siguiente enlace</p>";
        $contenido .= "<a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";
        $contenido .= "<p><strong>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</strong></p>";
        $contenido .= "</html>";

        //Pasando el contenido al cuerpo del mensaje
        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();

    }

    public function enviarInstrucciones() {
        
        //Creando en objeto de Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c907de0e15e3bf';
        $mail->Password = '33bddfd1de98ab';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        //Creando los datos del remitente
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','App Salón Suite');
        $mail->Subject = ('Restablece Tu Contraseña');

        //Creando en cuerpo del mensaje
        $contenido = "<html>";
        $contenido .= "<p><strong> Hola " . $this->nombre . "!</strong> Has solicitado restablecer tu contraseña de la cuenta en nuestro portal de App Salón, por lo cual requerimos que des click en el siguiente enlace</p>";
        $contenido .= "<a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Restablecer Contraseña</a>";
        $contenido .= "<p><strong>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</strong></p>";
        $contenido .= "</html>";

        //Pasando el contenido al cuerpo del mensaje
        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();

    }
}