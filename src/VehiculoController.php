<?php
require_once 'Vehiculo.php';
require_once 'DatabaseConnection.php';
require_once 'UsuarioController.php';
require_once 'Constantes.php';

class VehiculoController
{
    private $conn;
    private $usuarioController;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->usuarioController = new UsuarioController($conn);
    }

    public function eliminarVehiculo($id_vehiculo)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::ELIMINAR_VEHICULO_CITA);
            $stmt->bindParam(1, $id_vehiculo);

            return $stmt->execute();
        } catch (PDOException $th) {
            throw new Exception("Error al eliminar el vehiculo " . $th->getMessage());
        }
    }

    public function vehiculoExisteMatricula($matricula, $id_vehiculo = null)
    {
        try {
            if ($id_vehiculo === null) {
                $stmt = $this->conn->prepare(Constantes::EXISTE_VEHICULO_MATRICULA);
                $stmt->bindParam(1, $matricula);
                $stmt->execute();
            }else {
                $stmt = $this->conn->prepare(Constantes::EXISTE_VEHICULO_MATRICULA_EXCEPTO_ID);
                $stmt->bindParam(1, $matricula);
                $stmt->bindParam(2,$id_vehiculo);
                $stmt->execute();
            }


            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {
            throw new Exception("Error al comprobar si el vehiculo existe: " . $th->getMessage());
        }
    }

    public function vehiculoExisteId($vehiculo_id)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::EXISTE_VEHICULO_ID);
            $stmt->bindParam(1, $vehiculo_id);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {
            throw new Exception("Error al comprobar si el vehiculo existe: " . $th->getMessage());
        }
    }

    public function obtenerVehiculosPorUsuario($idUsuario)
    {
        try {
            if (!$this->usuarioController->usuarioExisteID($idUsuario)) {
                throw new Exception("El usuario no existe.");
            } else {
                $stmt = $this->conn->prepare(Constantes::OBTENER_VEHICULOS_USUARIO);
                $stmt->bindParam(1, $idUsuario);
                $stmt->execute();

                $vehiculos =  $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehiculo');

                return $vehiculos;
            }
        } catch (PDOException $th) {
            throw new Exception("Error al obtener los vehiculos del usuario: " . $th->getMessage());
        }
    }

    public function obtenerVehiculosSinCitaPorUsuario($idUsuario)
    {
        try {
            if (!$this->usuarioController->usuarioExisteID($idUsuario)) {
                throw new Exception("El usuario no existe.");
            } else {
                $stmt = $this->conn->prepare(Constantes::OBTENER_VEHICULOS_SIN_CITA);
                $stmt->bindParam(1, $idUsuario);
                $stmt->execute();

                $vehiculos =  $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehiculo');

                return ($vehiculos) ? $vehiculos : "Parece que no tienes ningun vehiculo registrado.<a href='../public/introducirVehiculo.php'> Pulsa aquí para añadir un vehiculo.</a>";
            }
        } catch (PDOException $th) {
            throw new Exception("Error al obtener los vehiculos del usuario: " . $th->getMessage());
        }
    }

    public function obtenerVehiculosConCitaPorUsuario($idUsuario)
    {
        try {
            if (!$this->usuarioController->usuarioExisteID($idUsuario)) {
                throw new Exception("El usuario no existe.");
            } else {
                $stmt = $this->conn->prepare(Constantes::OBTENER_VEHICULOS_CON_CITA);
                $stmt->bindParam(1, $idUsuario);
                $stmt->execute();

                $vehiculos =  $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehiculo');

                return ($vehiculos);
            }
        } catch (PDOException $th) {
            throw new Exception("Error al obtener los vehiculos del usuario: " . $th->getMessage());
        }
    }


    //Con esta funcion validamos si la matricula está bien escrita.
    public function validarMatricula($matricula)
    {
        //3 posibles patrones de matriculas 
        $patrones = [
            '/^\d{4}[- ]?[A-Z]{3}$/i', //moderna
            '/^[A-Z]{1,2}[- ]?\d{4}[- ]?[A-Z]{0,2}$/i', // antigua
            '/^E[ \-]?\d{4}[ \-]?[A-Z]{2}$/i' //vehiculo agricola
        ];
        //comprobamos si coincide con algun patron y devolvemos true
        foreach ($patrones as $patron) {
            if (preg_match($patron, $matricula)) {
                return true;
            }
        }

        return false;
    }
    //esta funcion sirve para que en la BBDD todas las matriculas tengan el mismo formato
    //en el sentido de que si el usuairo introduce una matricula con guiones esta se quite al
    //meterse a la BBDD
    public function normalizarMatricula($matricula)
    {
        //retornamos la matricula en mayusculas y sin espacios ni guiones
        return preg_replace('/[\s\-]/', '', strtoupper(trim($matricula)));
    }

    public function introducirVehiculo(Vehiculo $vehiculo)
    {
        try {
            if ($this->vehiculoExisteMatricula($vehiculo->getMatricula())) {
                return false;
            }

            $stmt = $this->conn->prepare(Constantes::INSERTAR_VEHICULO);
            $stmt->bindParam(1, $vehiculo->getId_usuario());
            $stmt->bindParam(2, $vehiculo->getMatricula());
            $stmt->bindParam(3, $vehiculo->getMarca());
            $stmt->bindParam(4, $vehiculo->getModelo());
            $stmt->bindParam(5, $vehiculo->getTipo());
            $stmt->bindParam(6, $vehiculo->getAnno_matriculacion());

            $stmt->execute();
            return true;
        } catch (PDOException $th) {
            throw new Exception("Error al introducir el vehiculo: " . $th->getMessage());
        }

        return false;
    }

    public function modificarVehiculo(Vehiculo $vehiculo)
    {
        try {
            if ($this->vehiculoExisteMatricula($vehiculo->getMatricula(),$vehiculo->getId_vehiculo())) {
                return false;
            }

            $stmt = $this->conn->prepare(Constantes::MODIFICAR_VEHICULO);

            $matricula = $vehiculo->getMatricula();
            $marca = $vehiculo->getMarca();
            $modelo = $vehiculo->getModelo();
            $tipo = $vehiculo->getTipo();
            $anno = $vehiculo->getAnno_matriculacion();
            $idVehiculo = $vehiculo->getId_vehiculo();

            $stmt->bindParam(1, $matricula);
            $stmt->bindParam(2, $marca);
            $stmt->bindParam(3, $modelo);
            $stmt->bindParam(4, $tipo);
            $stmt->bindParam(5, $anno);
            $stmt->bindParam(6, $idVehiculo);

            $stmt->execute();
            return true;
        } catch (PDOException $th) {
            throw new Exception("Error al modificar el vehiculo: " . $th->getMessage());
        }

        return false;
    }

    public function mostrarVehiculosPorUsuarioPorCita($id_Usuario)
    {
        $vehiculos_sinCita = $this->obtenerVehiculosSinCitaPorUsuario($id_Usuario);
        $vehiculos_conCita = $this->obtenerVehiculosConCitaPorUsuario($id_Usuario);

        foreach ($vehiculos_sinCita as $vehiculo) {
            echo "<option value={$vehiculo->getId_vehiculo()}>{$vehiculo->getMatricula()} - {$vehiculo->getMarca()} - {$vehiculo->getModelo()}</option>";
        }

        if ($vehiculos_conCita) {
            echo "<option disabled='true'>Vehiculos Con Cita Previa ↓</option>";
            foreach ($vehiculos_conCita as $vehiculo) {
                echo "<option disabled='true' value={$vehiculo->getId_vehiculo()}>{$vehiculo->getMatricula()}</option>";
            }
        }
    }
}
