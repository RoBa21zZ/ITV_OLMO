<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITV El Olmo</title>

    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/annadir_vehiculo.css">
    <link rel="stylesheet" href="styles/annadir_cita.css">
    <link rel="stylesheet" href="styles/citasInfo.css">
    <link rel="stylesheet" href="styles/userInfo.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="styles/info.css">
</head>

<body>

<header>
    <div class="app-title"><a href="../public/home.php">ITV El Olmo.</a></div>

    <nav>
        <a href="info.php">Sobre Nosotros</a>
        <a href="info_itv.php">¿Qué es la ITV?</a>
        <a href="introducirCita.php">Añadir Cita</a>
    </nav>
</header>

<main>
