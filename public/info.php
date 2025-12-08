<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}
?>
<?php include __DIR__ . "/components/header.php"; ?>

<div class="info_contenedor">
    <h2>Sobre Nosotros</h2>
    <p>
        Bienvenido a ITV el Olmo. Nuestra misión es garantizar que todos los vehículos circulen en condiciones óptimas de seguridad y medioambiente.
    </p>

    <div class="contacto">
        <h3>Contacto</h3>
        <p><strong>Dirección:</strong> Calle El Olmo, 3, Otero, León</p>
        <p><strong>Teléfono:</strong> 918 13 21 03</p>
        <p><strong>Email:</strong> <a href="mailto:itvelomo@cylitv.com">itvelomo@cylitv.com</a></p>
    </div>

    <div class="mapa">
        <h3>Ubicación</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4049.0241295170235!2d-6.770082721116786!3d42.576613965490544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1ses!2ses!4v1765222632631!5m2!1ses!2ses" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

<?php include __DIR__ . "/components/footer.php"; ?>
