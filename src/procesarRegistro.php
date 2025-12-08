<?php
require_once 'DatabaseConnection.php';

require_once 'UsuarioController.php';

session_start();

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../public/register.php");
        exit();
    }

    $nombre = trim($_POST["nombreUsuario"]);
    $apelledios = trim($_POST["apellidosUsuario"]);
    $dni = trim($_POST["dniUsuario"]);
    $telefono = trim($_POST["telUsuario"]);
    $email = trim($_POST["emailUsuario"]);
    $cotra = trim($_POST["contraUsuario"]);

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $usuarioController = new UsuarioController($conn);

    if ($usuarioController->usuarioExisteDNI($dni) || $usuarioController->usuarioExisteEmail($email)) {
        $_SESSION['errorRegistro'] = "Este usuario ya existe.";
        header("Location: ../public/register.php");
        exit();
    }

    $usuario = new Usuario();
    $usuario->setNombre($nombre);
    $usuario->setApellidos($apelledios);
    $usuario->setDni($dni);
    $usuario->setTelefono($telefono);
    $usuario->setEmail($email);
    $usuario->hashPassword($cotra);

    if ($usuarioController->registrarUsuario($usuario)) {
        header("Location: ../public/login.php");
        exit();
    } else {
        $_SESSION['errorRegistro'] = "Error al registrar el usuario.";
        header("Location: ../public/register.php");
        exit();
    }
} catch (PDOException $th) {
    $_SESSION['error'] = "Error al conectar con la base de datos: " . $th->getMessage();
    header("Location: ../public/register.php");
    exit();
}
