<?php
require_once 'VehiculoController.php';
require_once 'DatabaseConnection.php';
require_once 'Constantes.php';
require_once 'Cita.php';
class CitaController
{
    private $conn;
    private $vehiculoController;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->vehiculoController = new VehiculoController($conn);
    }

    public function obterCitaPorID($id_cita)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::OBTENER_CITA_ID);
            $stmt->bindParam(1, $id_cita);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cita');
            $cita = $stmt->fetch();

            return $cita;
        } catch (PDOException $th) {
            throw new Exception("Erro al obtner la cita " . $th->getMessage());
        }
    }

    public function obterCitaPorID_Vehiculo($id_vehiculo)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::OBTENER_CITAS_POR_ID_VEHICULO);
            $stmt->bindParam(1, $id_vehiculo);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cita');
            $citas = $stmt->fetch();
            return $citas;
        } catch (PDOException $th) {
            throw new Exception("Erro al obtner la cita " . $th->getMessage());
        }
    }

    public function modificarCita($id_cita, $hora_cita, $fecha_cita)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::MODIFICAR_CITA);
            $stmt->bindParam(1, $fecha_cita);
            $stmt->bindParam(2, $hora_cita);
            $stmt->bindParam(3, $id_cita);

            return $stmt->execute();
        } catch (PDOException $th) {
            throw new Exception("Error al modificar la cita " . $th->getMessage());
        }
    }

    public function eliminarCita($id_cita)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::ELIMINAR_CITA);
            $stmt->bindParam(1, $id_cita);

            $stmt->execute();

            return true;
        } catch (PDOException $th) {
            throw new Exception("Erro al eliminar la citas " . $th->getMessage());
        }
    }

    public function obtenerCitasPorUsuario($id_usuario)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::OBTENER_CITAS_POR_USUARIO_CON_MATRICULA);
            $stmt->bindParam(1, $id_usuario);
            $stmt->execute();

            $citas = $stmt->fetchAll(PDO::FETCH_CLASS, 'Cita');

            return $citas;
        } catch (PDOException $th) {
            throw new Exception("Erro al obtener las citas " . $th->getMessage());
        }
    }

    public function citaOcupada($fecha, $hora)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::EXISTE_CITA_FECHA_HORA);
            $stmt->bindParam(1, $fecha);
            $stmt->bindParam(2, $hora);

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {
            throw new Exception("Error al comprobar si la cita existe " . $th->getMessage());
        }
    }

    public function registrarCita(Cita $cita)
    {

        try {

            if ($this->citaOcupada($cita->getFecha_cita(), $cita->getHora_cita())) {

                return false;
            }

            if ($this->vehiculoController->vehiculoExisteId($cita->getId_vehiculo())) {

                $stmt = $this->conn->prepare(Constantes::INSERTAR_CITA);

                $idVehiculo = $cita->getId_vehiculo();
                $fecha_cita = $cita->getFecha_cita();
                $hora_Cita = $cita->getHora_cita();

                $stmt->bindParam(1, $idVehiculo);
                $stmt->bindParam(2, $fecha_cita);
                $stmt->bindParam(3, $hora_Cita);

                $stmt->execute();
                return true;
            }
        } catch (PDOException $th) {
            echo ("Error al crear la nueva cita " . $th->getMessage());
        }
    }

    public function obtenerHorasPorFecha($cita_fecha)
    {
        try {
            //En este metodo obtenermos todas las horas que existan en una fecha determinada 
            // y generamos un json con tadas las horas.
            $stmt = $this->conn->prepare(Constantes::OBTENER_HORAS_CITA);
            $stmt->bindParam(1, $cita_fecha);
            $stmt->execute();
            $horas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($horas);
        } catch (PDOException $th) {
            throw new Exception("Error al obtener la horas " . $th->getMessage());
        }
    }

    public function marcarComoCompletado($id_cita)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::MARCAR_CITA_COMPLETADA);
            $stmt->bindParam(1, $id_cita);
            $stmt->execute();
        } catch (PDOException $th) {
            throw new Exception("Error modificar el estado de la cita" . $th->getMessage());
        }
    }

    public function marcarComoCancelada($id_cita)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::MARCAR_CITA_CANCELADA);
            $stmt->bindParam(1, $id_cita);
            $stmt->execute();
        } catch (PDOException $th) {
            throw new Exception("Error modificar el estado de la cita" . $th->getMessage());
        }
    }

    public function actualizarEstadosAutomaticamente()
    {
        try {
            $stmt = $this->conn->prepare(Constantes::ACTUALIZAR_ESTADO);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar estados: " . $e->getMessage());
        }
    }


    private function tiempoRestante($fechaCita, $horaCita)
    {
        $fechaHoraActual = new DateTime();
        $fechaCita = new DateTime($fechaCita . " " . $horaCita);

        $diff = $fechaHoraActual->diff($fechaCita);

        if ($fechaCita < $fechaHoraActual) {
            return "La cita ya ha pasado";
        }

        if ($diff->days == 0) {
            return "Hoy en " . $diff->h . "horas y " . $diff->i . " minutos";
        }

        return $diff->days . " días, " . $diff->h . "h " . $diff->i . "min";
    }

    public function prepararInfoCita(Cita $cita)
    {
        $fechaHoraActual = new DateTime();
        $fechaCita = new DateTime($cita->getFecha_cita() . " " . $cita->getHora_cita());

        if ($fechaCita < $fechaHoraActual) {
            $estadoTiempo = "vencida";
            $mensaje = "<p class='cita_mensaje' style='color:red'>❗ Esta cita ha vencido. No puedes modificarla.</p>";
            $puedeModificar = false;
            $resto = "";
        } else if ($fechaCita->format("Y-m-d") == $fechaHoraActual->format("Y-m-d")) {
            $estadoTiempo = "hoy";
            $mensaje = "<p class='cita_mensaje' style='color:orange'>⚠️ Tu cita es HOY.</p>";
            $puedeModificar = true;
            $resto = "";
        } else {
            $estadoTiempo = "futuro";
            $resto = $this->tiempoRestante($cita->getFecha_cita(), $cita->getHora_cita());
            $mensaje = "<p class='cita_mensaje'>⏳ Falta: $resto</p>";
            $puedeModificar = true;
        }

        return [
            "estadoTiempo" => $estadoTiempo,
            "mensaje" => $mensaje,
            "puedeModificar" => $puedeModificar,
            "resto" => $resto
        ];
    }
}
