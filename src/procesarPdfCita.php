<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once "CitaController.php";

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

if(!isset($_GET["id_cita"])){
    header("Location: ../public/citasInfo.php");
}
$id_cita = $_GET["id_cita"];
$db = new DatabaseConnection();
$conn = $db->conectar();
$citaController = new CitaController($conn);
$cita = $citaController->obterCitaPorID($id_cita);



ob_start();
include "../src/templates/template_cita_previaPdf.php"; 
$html = ob_get_clean();

$pdf = new Dompdf();

$pdf->loadHtml($html);

$pdf->setPaper("A4","portrait");
$pdf->render();

$pdf->stream("cita_itv_ElOlmo_{$cita->getId_cita()}.pdf", ["Attachment" => true]);