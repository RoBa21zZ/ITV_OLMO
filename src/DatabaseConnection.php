<?php
class DatabaseConnection
{

    private $host   = "localhost";
    private $dbname = "itv";
    private $user   = "root";
    private $pass   = "";
    //private $conexion;

    public function conectar()
    {


        try {
            $conexion = new PDO(
                "mysql:host={$this->host};port=3307;dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->pass
            );

            $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);

            return $conexion;

        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }

        
    }

    public function closeConn($conexion)
    {
        try {

            if ($conexion != null) {
                $conexion = null;
            }
        } catch (PDOException $e) {

            throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}
