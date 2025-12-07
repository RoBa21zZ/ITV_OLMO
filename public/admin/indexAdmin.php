<?php
session_start();
if (!isset($_SESSION["usuario_rol"]) || $_SESSION["usuario_rol"] !== "admin") {
    header("Location: ../login.php");
    exit();
}
require_once '../../src/UsuarioController.php';
require_once '../../src/VehiculoController.php';
require_once '../../src/CitaController.php';

$db = new DatabaseConnection();
$conn = $db->conectar();
$usuarioController = new UsuarioController($conn);
$vehiculosController = new VehiculoController($conn);
$citaController = new CitaController($conn);
$usuarios = $usuarioController->obtnerUsuarios();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>

<body>
    <h2>Panel de administración</h2>
    <button><a href="../../src/logOut.php">Log out</a></button>
    <div class="contenedor">
    
    <?php foreach ($usuarios as $user): ?>
        <div clas="usuario">
            <h3><?= $user->getNombreCompleto() ?> (<?= $user->getEmail() ?>) — Rol: <strong><?= $user->getRol() ?></strong></h3>
            <form action="../../src/procesarAdmin.php" method="POST">
                <input type="hidden" name="id_usuario" value="<?= $user->getId_usuario(); ?>">
                <button name="accion" value="cambiar_rol">Cambiar Rol</button>
                <button name="accion" value="eliminar_usuario" style="background:red;color:white;" onclick="return confirmar('¿Seguro que quieres eliminar esta usuario?')">Eliminar usuario</button>
            </form>

            <h4>Vehículos</h4>
            <?php
            $vehiculos = $vehiculosController->obtenerVehiculosPorUsuario($user->getId_usuario());

            if (empty($vehiculos)) {
                echo "<p>No tiene vehículos</p>";
            }
            ?>

            <?php foreach ($vehiculos as $vehiculo): ?>
                <div class="vehiculo">
                    <strong><?= $vehiculo->getMarca() ?> <?= $vehiculo->getModelo() ?></strong> — <?= $vehiculo->getMatricula() ?>

                    <form action="../../src/procesarAdmin.php" method="POST">
                        <input type="hidden" name="id_vehiculo" value="<?= $vehiculo->getId_vehiculo(); ?>">
                        <button name="accion" value="eliminar_vehiculo" style="background:red;color:white;" onclick="return confirmar('¿Seguro que quieres eliminar este vehiculo?')">
                            Eliminar Vehículo
                        </button>
                    </form>

                    <h4>Cita:</h4>

                    <?php $cita = $citaController->obterCitaPorID_Vehiculo($vehiculo->getId_vehiculo()); ?>

                    <?php if (!$cita): ?>
                        <p>No tiene cita.</p>
                    <?php else: ?>
                        <div class="cita">
                            <p>Fecha: <?= $cita->getFecha_cita() ?></p>
                            <p>Hora: <?= $cita->getHora_cita() ?></p>

                            <form action="../../src/procesarAdmin.php" method="POST">
                                <input type="hidden" name="id_cita" value="<?= $vehiculo->getId_cita(); ?>">
                                <button name="accion" value="eliminar_cita" style="background:red;color:white;" onclick="return confirmar('¿Seguro que quieres eliminar esta cita?')">
                                    Eliminar Cita
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </div>

    
</body>

</html>