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
<?php include __DIR__ . "/components/header.php"  ?>
<div class="citas_contenedor">

    <?php
    if (count($citas) === 0) {
        echo "<p>No tienes citas preveias registrados. <a href='introducirCita.php'>Añade una ahora</a></p>";
    } else {

        echo "<h2>Tus citas actuales</h2>";
        echo "<ul class='citas_lista'>";
        foreach ($citas as $cita) {
            $datos = $citaController->prepararInfoCita($cita);

            echo "<li class='citas_item'> <p class='cita_datos'>"
                . htmlspecialchars($cita->getFecha_cita())
                . " - "
                . htmlspecialchars($cita->getHora_cita())
                . " - Vehículo: "
                . htmlspecialchars($cita->get_Matricula_Cita())
                . "</p>";

            echo $datos["mensaje"];



            echo "<div class='acciones_cita'>";

            echo "<button class='btn_Cita_pdf'><a href='../src/procesarPdfCita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'>Descargar Justificante Cita 🗃️</a></button>";

            if ($datos["puedeModificar"]  && $datos["estadoTiempo"] !== "vencida") {
                echo "<button class='btn_modificar'><a href='modificarCita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'>Modificar ✏️</a></button>";
            } else {
                echo "<button class='btn_modificar' disabled>Modificar</button>";
            }

            echo "<button class='btn_eliminar'><a href='../src/eliminar_cita.php?id_cita=" . htmlspecialchars($cita->getId_cita()) . "'>Eliminar Cita ❌</a></button>";




            echo "</div>";


            echo "</li><br>";
        }
        echo "</ul>";
        echo "<a href='introducirCita.php' class='annadir_nueva_cita'>Añadir otra cita</a>";
    }

    ?>

    <div class="cita_volver">
        <a href="home.php">Volver al Inicio</a>
    </div>

</div>
<script src="js/confirmEliminar.js"></script>
