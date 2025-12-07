<?php
require_once 'DatabaseConnection.php';
require_once 'Constantes.php';
require_once 'Usuario.php';
class UsuarioController
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    //Con esta clase podemos saber si el nuevo usuario que vamos a registrar ya existe o no en la base de datos.

    public function obtnerUsuarios()
    {
        try {
            $stmt = $this->conn->prepare(Constantes::OBTENER_USUARIOS);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetchAll();
            return $usuario;
        } catch (PDOException $th) {

            throw new Exception("Error al obtner los usuarios " . $th->getMessage());
        }
    }

    public function usuarioExisteDNI($dniUsuario, $id_usuario = null)
    {
        try {

            if ($id_usuario === null) {
                $stmt = $this->conn->prepare(Constantes::EXISTE_USUARIO_DNI);
                $stmt->bindParam(1, $dniUsuario);
            } else {
                $stmt = $this->conn->prepare(Constantes::EXISTE_USUARIO_DNI_EXCEPTO_ID);
                $stmt->bindParam(1, $dniUsuario);
                $stmt->bindParam(2, $id_usuario);
            }


            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {

            throw new Exception("Error al comprobar si el usuario existe: " . $th->getMessage());
        }
    }

    public function usuarioExisteID($idUsuario)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::EXISTE_USUARIO_ID);
            $stmt->bindParam(1, $idUsuario);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {

            throw new Exception("Error al comprobar si el usuario existe: " . $th->getMessage());
        }
    }

    public function usuarioExisteEmail($emailUsuario, $id_usuario = null)
    {
        try {
            if ($id_usuario === null) {
                $stmt = $this->conn->prepare(Constantes::EXISTE_USUARIO_EMAIL);
                $stmt->bindParam(1, $emailUsuario);
            } else {
                $stmt = $this->conn->prepare(Constantes::EXISTE_USUARIO_EMAIL_EXCEPTO_ID);
                $stmt->bindParam(1, $emailUsuario);
                $stmt->bindParam(2, $id_usuario);
            }

            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $th) {
            throw new Exception("Error al comprobar si el Email existe " . $th->getMessage());
        }
    }
    /*
        Con esta funcion podemos añadir un usuario a la base de datos.
        En un primer momento comprabos si existe en la base de datos el dni en caso contrareo devolvemos false.

        De lo contrario hacemos unas sentencia preparada en la que introducimos todos los datos y devolvemos true.

        Cuanto a la contraseña, esta ya viene hasheada desde la clase Usuario.
    */
    public function registrarUsuario(Usuario $usuario)
    {
        if ($this->usuarioExisteDNI($usuario->getDni())) {
            return false;
        }

        try {
            $stmt = $this->conn->prepare(Constantes::INSERTAR_USUARIO);
            $stmt->bindParam(1, $usuario->getNombre());
            $stmt->bindParam(2, $usuario->getApellidos());
            $stmt->bindParam(3, $usuario->getDni());
            $stmt->bindParam(4, $usuario->getTelefono());
            $stmt->bindParam(5, $usuario->getEmail());
            $stmt->bindParam(6, $usuario->getPassword());

            $stmt->execute();
            return true;
        } catch (PDOException $th) {
            throw new Exception("Error al registrar el usuario: " . $th->getMessage());
        }

        return false;
    }
    /*En este caso como el usuario ya está creado comprobamos su existencia con el id autogenerado*/
    public function loginUsuario($emailUsuario, $password)
    {
        try {

            $stmt = $this->conn->prepare(Constantes::OBTENER_USUARIO_EMAIL);
            $stmt->bindParam(1, $emailUsuario);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
        } catch (PDOException $th) {
            throw new Exception("Error al iniciar sesión: " . $th->getMessage());
        }

        if ($usuario && password_verify($password, $usuario->getPassword())) {
            return $usuario;
        }

        return null;
    }

    public function obtenerUsuarioPorId($idUsuario)
    {
        try {
            $stmt = $this->conn->prepare(Constantes::OBTENER_USUARIO_ID);
            $stmt->bindParam(1, $idUsuario);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
            $usuario = $stmt->fetch();
            return $usuario;
        } catch (PDOException $th) {
            throw new Exception("Error al obtener el usuario: " . $th->getMessage());
        }
    }

    public function modificarUsuario(Usuario $usuario)
    {
        try {
            if ($this->usuarioExisteDNI($usuario->getDni(), $usuario->getId_usuario())) {
                return false;
            }


            if ($this->usuarioExisteEmail($usuario->getEmail(), $usuario->getId_usuario())) {
                return false;
            }

            $stmt = $this->conn->prepare(Constantes::MODIFICAR_USUARIO);

            $nombre = $usuario->getNombre();
            $apellidos = $usuario->getApellidos();
            $dni = $usuario->getDni();
            $telefono = $usuario->getTelefono();
            $email = $usuario->getEmail();
            $id = $usuario->getId_usuario();

            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $apellidos);
            $stmt->bindParam(3, $dni);
            $stmt->bindParam(4, $telefono);
            $stmt->bindParam(5, $email);
            $stmt->bindParam(6, $id);

            return $stmt->execute();
        } catch (PDOException $th) {
        }
    }

    public function modificarUsuarioAdmin($id_usuario)
    {

        try {
            if ($this->usuarioExisteID($id_usuario)) {
                $stmt = $this->conn->prepare(CONSTANTES::MODIFICAR_USUARIO_ADMIN);
                $stmt->bindParam(1, $id_usuario);
                return $stmt->execute();
            }

            return false;
        } catch (PDOException $th) {
            throw new Exception("Error al obtener el usuario: " . $th->getMessage());
        }
    }

    public function eliminarUsuario($id_usuario)
    {
        try {
            if ($this->usuarioExisteID($id_usuario)) {
                $stmt = $this->conn->prepare(CONSTANTES::ELIMINAR_USUARIO);
                $stmt->bindParam(1, $id_usuario);
                return $stmt->execute();
            }
            return false;
        } catch (PDOException $th) {
            throw new Exception("Error al obtener el usuario: " . $th->getMessage());
        }
    }
}
