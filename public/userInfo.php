<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}
require_once '../src/DatabaseConnection.php';
require_once '../src/Usuario.php';
require_once '../src/UsuarioController.php';

try {
    $idUsuario = $_SESSION["usuario_id"];

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $usuarioController = new UsuarioController($conn);

    $usuario = $usuarioController->obtenerUsuarioPorId($idUsuario);
} catch (\Throwable $th) {
    //throw $th;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($usuario->getNombre())?></h1>
    <h2>Información personal</h2>
    <ul>
        <li><strong>Nombre:</strong><?php echo htmlspecialchars($usuario->getNombre())?></li>
        <li><strong>Apellidos:</strong><?php echo htmlspecialchars($usuario->getApellidos())?></li>
        <li><strong>DNI:</strong><?php echo htmlspecialchars($usuario->getDni())?></li>
        <li><strong>Teléfono:</strong><?php echo htmlspecialchars($usuario->getTelefono())?></li>
        <li><strong>Email: </strong><?php echo htmlspecialchars($usuario->getEmail())?></li>
    </ul>
    <button><a href="modificarUsuario.php">Modificar información personal</a></button>
    <button><a href="home.php">Volver al inicio</a></button>
</body>
</html>


