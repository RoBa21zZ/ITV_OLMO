<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #333;
        line-height: 1.5;
        padding: 25px;
    }

    .header {
        text-align: justify;
        margin-bottom: 15px;
    }

    .header h1 {
        font-size: 22px;
        color: #2e5e2e;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .intro {
        margin-bottom: 15px;
    }

    .details {
        margin-bottom: 15px;
    }

    .details table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid black;
    }

    .details th,
    .details td {
        text-align: justify;
        padding: 8px;
        border: 2px solid black;
    }

    .details th {
        background-color: #2e5e2e;
        color: #fff;
    }

    .recomendaciones {
        margin-top: 20px;
    }

    .recomendaciones ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .footer {
        margin-top: 25px;
        font-size: 11px;
        color: #666;
    }
</style>

<div class='header'>
    <h1>Confirmación Cita Previa - ITV Olmo</h1>
</div>

<div class='intro'>
    <p>Estimad@ cliente, estos son los datos de la cita que concertaste:</p>
</div>

<div class='details'>
    <table>
        <tr>
            <th>Nº de Cita</th>
            <td><?= $cita->getId_cita() ?></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><?= $cita->getFecha_cita() ?></td>
        </tr>
        <tr>
            <th>Hora</th>
            <td><?= $cita->getHora_cita() ?></td>
        </tr>
        <tr>
            <th>Matrícula</th>
            <td><?= $cita->get_Matricula_Cita() ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?= $cita->getEstado() ?></td>
        </tr>
    </table>
</div>

<div class='recomendaciones'>
    <p>No olvides llevar los siguientes documentos y seguir las recomendaciones antes de iniciar la inspección:</p>
    <ul>
        <li>Tarjeta de Inspección Técnica (original, sin plastificar).</li>
        <li>Permiso de Circulación y/o DNI.</li>
        <li>Justificante de pago del seguro obligatorio.</li>
    </ul>
    <p>Con el fin de agilizar el proceso de inspección, le rogamos acceda, si es posible, sin pasajeros en el vehículo.</p>
    <p>A partir del 20 de mayo de 2023, si como propietario desea negarse a la recogida de datos de consumo de combustible o energía en condiciones reales y el número de identificación del vehículo al pasar la inspección técnica, puede hacerlo bajo el Reglamento (UE) 2021/392. Para ello, diríjase a las oficinas administrativas de la estación ITV para cumplimentar el preceptivo formulario.</p>
    <p>Si tienes alguna duda, queja o sugerencia, ponte en contacto con nosotros desde la sección de contacto.</p>
</div>

<div class='footer'>
    © ITV Olmo — Gracias por confiar en nosotros.
</div>