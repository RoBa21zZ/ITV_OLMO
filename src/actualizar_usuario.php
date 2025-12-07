<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'UsuarioController.php';
try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../public/modificaUsuario.php");
        exit();
    }

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $usuarioController = new UsuarioController($conn);

    $id_usuario = $_SESSION["usuario_id"];

    $nombre = $_POST["nombreUsuario"];
    $apellidos = $_POST["apellidosUsuario"];
    $dni = $_POST["dniUsuario"];
    $telefono = $_POST["telUsuario"];
    $email = $_POST["emailUsuario"];

    if ($usuarioController->usuarioExisteDNI($dni, $id_usuario)) {
        $_SESSION["error_modificarUsuario"] = "El DNI ya está registrado.";
        header("Location: ../public/modificarUsuario.php");
        exit();
    }


    if ($usuarioController->usuarioExisteEmail($email, $id_usuario)) {
        $_SESSION["error_modificarUsuario"] = "El email ya está registrado.";
        header("Location: ../public/modificarUsuario.php");
        exit();
    }

    $usuario = new Usuario();
    $usuario->setId_usuario($id_usuario);
    $usuario->setNombre($nombre);
    $usuario->setApellidos($apellidos);
    $usuario->setDni($dni);
    $usuario->setTelefono($telefono);
    $usuario->setEmail($email);

    if ($usuarioController->modificarUsuario($usuario)) {
        header("Location: ../public/home.php");
        exit();
    } else {
        $_SESSION["error_modificarUsuario"] = "Error modificando usuario.";
        header("Location: ../public/modificarUsuario.php");
        exit();
    }
} catch (PDOException $th) {
    throw new Exception("Error Processing Request", $th->getMessage());
}
