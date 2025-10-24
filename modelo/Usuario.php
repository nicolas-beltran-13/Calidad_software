<?php
require_once 'conexion.php';

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $id;
    public $nombre;
    public $NumeroIdentificacion;
    public $direccion;
    public $telefono;
    public $rol;
    public $gmail;
    public $contraseña;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($gmail, $contraseña) {
        $query = "SELECT id, nombre, rol FROM " . $this->table_name . " WHERE gmail = :gmail AND contraseña = :contraseña LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":gmail", $gmail);
        $stmt->bindParam(":contraseña", $contraseña);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->rol = $row['rol'];
            return true;
        }

        return false;
    }

    public function registrar($nombre, $NumeroIdentificacion, $direccion, $telefono, $rol, $gmail, $contraseña) {
        $query = "INSERT INTO " . $this->table_name . " SET nombre=:nombre, NumeroIdentificacion=:NumeroIdentificacion, direccion=:direccion, telefono=:telefono, rol=:rol, gmail=:gmail, contraseña=:contraseña";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":NumeroIdentificacion", $NumeroIdentificacion);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":rol", $rol);
        $stmt->bindParam(":gmail", $gmail);
        $stmt->bindParam(":contraseña", $contraseña);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
