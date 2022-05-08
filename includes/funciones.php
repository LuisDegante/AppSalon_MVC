<?php

function vardumpFormateado($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function sanitizar($html) : string {
    $sanitizar = htmlspecialchars($html);
    return $sanitizar;
}

function esUltimo(string $actual, string $proximo) : bool {
    if($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}

//Función que revisa que el usuario esté autenticado
function estaAutenticado() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//Revisar que el usuario sea administrador
function esAdministrador() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}