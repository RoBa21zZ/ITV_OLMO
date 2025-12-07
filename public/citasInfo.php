<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

require_once '../src/Cita.php';
require_once '../src/CitaController.php';


try {
    $idUsuario = $_SESSION["usuario_id"];

    $db = new DatabaseConnection();
    $conn = $db->conectar();

    $citaController = new CitaController($conn);

    $citas = $citaController->obtenerCitasPorUsuario($idUsuario);
} catch (\Throwable $th) {
    throw new Exception("Error al obtener las citas " . $th->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus citas</title>
</head>

<body>
    <?php
    if (count($citas) === 0) {
        echo "<p>No tienes citas preveias registrados. <a href='introducirCita.php'>Añade una ahora</a></p>";
    } else {

        echo "<h2>Tus citas actuales</h2>";
        echo "<ul>";
        foreach ($citas as $cita) {
            $datos = $citaController->prepararInfoCita($cita);

            echo "<li>"
                . htmlspecialchars($cita->getFecha_cita())
                . " - "
                . htmlspecialchars($cita->getHora_cita())
                . " - Vehículo: "
                . htmlspecialchars($cita->get_Matricula_Cita())
                . " ";

            echo "<br>" . $datos["mensaje"];

            echo "<div class='acciones-cita'>";

            echo "<button class='btn_eliminar'><a href='../src/eliminar_cita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'>Eliminar Cita</a></button>";
            
            echo "<button class='btn_Cita_pdf'><a href='../src/procesarPdfCita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'>Descargar Justificante Cita</a></button>";



            if ($datos["puedeModificar"]  && $datos["estadoTiempo"] !== "vencida") {
                echo "<a href='modificarCita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'><button>Modificar</button></a>";
            } else {
                echo "<button class='btn_modificar' disabled>Modificar</button>";
            }

            echo "</div>";


            echo "</li><br>";
        }
        echo "</ul>";
        echo "<p><a href='introducirCita.php'>Añadir otra cita</a></p>";
    }

    ?>


    <a href="home.php">Volver al Inicio</a>

    <script src="js/confirmEliminar.js"></script>
</body>

</html>