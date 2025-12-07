<?php
session_start();
require_once 'DatabaseConnection.php';
require_once 'Usuario.php';
require_once 'UsuarioController.php';

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {



        $email = trim($_POST["emailUsuario"]);
        $contra = trim($_POST["contraUsuario"]);

        $db = new DatabaseConnection();
        $conn = $db->conectar();

        $usuarioController = new UsuarioController($conn);

        $usuario = $usuarioController->loginUsuario($email, $contra);

        if ($usuario) {

            $_SESSION["usuario_id"] = $usuario->getId_usuario();
            $_SESSION["usuario_nombre"] = $usuario->getNombre();
            $_SESSION["usuario_rol"] = $usuario->getRol();

            header("Location: ../public/home.php");
            exit();
        } else {
            $_SESSION['error_login'] = "Contraseña o email incorrectos.";
            header("Location: ../public/login.php");
            exit();
        }
    } else {
        header("Location: ../public/login.php");
        exit();
    }
} catch (PDOException $th) {
    $_SESSION['error_login'] = "Contraseña o email incorrectos. " . $th->getMessage();
    header("Location: ../public/login.php");
    exit();
}
