<?php
class Constantes
{
    /*USUARIOS*/
    const EXISTE_USUARIO_DNI = "SELECT count(*) FROM usuarios WHERE dni = ?";
    const EXISTE_USUARIO_DNI_EXCEPTO_ID = "SELECT count(*) FROM usuarios WHERE dni = ? AND id_usuario != ?";
    const EXISTE_USUARIO_EMAIL_EXCEPTO_ID = "SELECT count(*) FROM usuarios WHERE email = ? AND id_usuario != ?";
    const EXISTE_USUARIO_EMAIL = "SELECT count(*) FROM usuarios WHERE email = ?";
    const EXISTE_USUARIO_ID = "SELECT count(*) FROM usuarios WHERE id_usuario = ?";
    const OBTENER_USUARIO_EMAIL = "SELECT * FROM usuarios WHERE email = ?";
    const OBTENER_USUARIO_ID = "SELECT * FROM usuarios WHERE id_usuario = ?";
    const OBTENER_USUARIOS = "SELECT id_usuario,nombre,apellidos,dni,telefono,email,rol FROM usuarios";
    const INSERTAR_USUARIO = "INSERT INTO usuarios (nombre,apellidos,dni,telefono,email,password) VALUES (?,?,?,?,?,?)";
    const MODIFICAR_USUARIO = "UPDATE usuarios SET nombre = ?, apellidos = ?, dni = ?, telefono = ?, email = ? WHERE id_usuario = ?";
    const MODIFICAR_USUARIO_ADMIN = "UPDATE usuarios SET rol = 'admin' WHERE id_usuario = ?";
    const ELIMINAR_USUARIO = "DELETE FROM usuarios WHERE id_usuario = ?";
    /*VEHICULOS*/
    const EXISTE_VEHICULO_MATRICULA = "SELECT count(*) FROM vehiculos WHERE matricula = ?";
    /*Esta sql se usa a la hora de modificar un vehiculo para que cuando se comprueba la matricula que introduce el usuario ignore la que ya tiene asociada */
    const EXISTE_VEHICULO_MATRICULA_EXCEPTO_ID ="SELECT count(*) FROM vehiculos WHERE matricula = ? AND id_vehiculo != ?";
    const EXISTE_VEHICULO_ID = "SELECT count(*) FROM vehiculos WHERE id_vehiculo = ?";
    const OBTENER_VEHICULOS_USUARIO = "SELECT * FROM vehiculos WHERE id_usuario = ?";
    const INSERTAR_VEHICULO = "INSERT INTO vehiculos (id_usuario,matricula,marca,modelo,tipo,anno_matriculacion) VALUES (?,?,?,?,?,?)";
    /* Con esta consulta obtenemos todos los vehiculo que no esten ya en una cita para que el ususuario no haga dos cita del mismo vehiculo*/
    const OBTENER_VEHICULOS_SIN_CITA = "SELECT v.* FROM vehiculos v LEFT JOIN citas c ON v.id_vehiculo = c.id_vehiculo WHERE v.id_usuario = ? AND c.id_vehiculo IS NULL";
    /* Aqui mostramos todos los que ya esten en una cita para que el usuario tenga constancia.*/
    const OBTENER_VEHICULOS_CON_CITA = "SELECT v.* FROM vehiculos v LEFT JOIN citas c ON v.id_vehiculo = c.id_vehiculo WHERE v.id_usuario = ? AND c.id_vehiculo IS NOT NULL";
    const ELIMINAR_VEHICULO_CITA = "DELETE v, c FROM vehiculos v LEFT JOIN citas c ON v.id_vehiculo = c.id_vehiculo WHERE v.id_vehiculo = ?";
    const MODIFICAR_VEHICULO = "UPDATE vehiculos SET  matricula = ?,marca = ?, modelo = ?, tipo = ?, anno_matriculacion = ? WHERE id_vehiculo = ?";
    /*CITAS*/
    const EXISTE_CITA_FECHA_HORA = "SELECT count(*) FROM citas WHERE fecha_cita = ? AND hora_cita = ?";
    const OBTENER_CITAS_POR_USUARIO = "SELECT c.* FROM citas c INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo WHERE v.id_usuario = ?";
    const OBTENER_CITAS_POR_USUARIO_CON_MATRICULA = "SELECT c.id_cita, c.fecha_cita, c.hora_cita, v.matricula FROM citas c INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo WHERE v.id_usuario = ?";
    const OBTENER_CITAS_POR_ID_CON_MATRICULA = "SELECT *,v.matricula FROM citas c INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo WHERE c.id_usuario = ?";
    const OBTENER_CITAS_POR_ID_VEHICULO = "SELECT * FROM citas WHERE id_vehiculo = ?";
    const OBTENER_HORAS_CITA = "SELECT hora_cita FROM citas WHERE fecha_cita = ?";
    const INSERTAR_CITA = "INSERT INTO citas (id_vehiculo,fecha_cita,hora_cita) VALUES (?,?,?)";
    const MODIFICAR_CITA = "UPDATE citas SET fecha_cita = ?,hora_cita = ? WHERE id_cita = ?";
    const ELIMINAR_CITA = "DELETE FROM citas WHERE id_cita = ?";
    const MARCAR_CITA_COMPLETADA = "UPDATE citas SET estado = 'completada' WHERE id_cita = ?";
    const MARCAR_CITA_CANCELADA = "UPDATE citas SET estado = 'completada' WHERE id_cita = ?";
    /*En esta sentencia actualizamos todas las citas en funcion si se ha pasado la fecha de la actual*/
    const ACTUALIZAR_ESTADO = "UPDATE citas SET estado = CASE WHEN CONCAT(fecha_cita, ' ', hora_cita) < NOW() THEN 'cancelada' ELSE estado END WHERE estado = 'pendiente'";
    const OBTENER_CITA_ID = "SELECT c.id_cita,c.fecha_cita,c.hora_cita,c.estado,v.matricula FROM citas c INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo WHERE c.id_cita = ?";

}
