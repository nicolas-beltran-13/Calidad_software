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

    public function login($gmail, $contrasena) {
        $query = "SELECT id, nombre, rol FROM " . $this->table_name . " WHERE gmail = :gmail AND contraseña = :contrasena LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":gmail", $gmail);
        $stmt->bindParam(":contrasena", $contrasena);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log('[Usuario::login] fetched row: ' . var_export($row, true));

        if($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->rol = $row['rol'];
            return true;
        }

        return false;
    }

    public function registrar($nombre, $NumeroIdentificacion, $direccion, $telefono, $rol, $gmail, $contrasena) {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nombre, NumeroIdentificacion, direccion, telefono, rol, gmail, contraseña) VALUES (:nombre, :NumeroIdentificacion, :direccion, :telefono, :rol, :gmail, :contrasena)";

            $stmt = $this->conn->prepare($query);

            // Validar longitudes máximas según la estructura de la tabla
            if (strlen($nombre) > 30) throw new PDOException("El nombre excede los 30 caracteres permitidos");
            if (strlen($direccion) > 50) throw new PDOException("La dirección excede los 50 caracteres permitidos");
            if (strlen($telefono) > 11) throw new PDOException("El teléfono excede los 11 caracteres permitidos");
            if (strlen($rol) > 10) throw new PDOException("El rol excede los 10 caracteres permitidos");
            if (strlen($gmail) > 50) throw new PDOException("El email excede los 50 caracteres permitidos");
            if (strlen($contrasena) > 20) throw new PDOException("La contraseña excede los 20 caracteres permitidos");

            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":NumeroIdentificacion", $NumeroIdentificacion);
            $stmt->bindParam(":direccion", $direccion);
            $stmt->bindParam(":telefono", $telefono);
            $stmt->bindParam(":rol", $rol);
            $stmt->bindParam(":gmail", $gmail);
            $stmt->bindParam(":contrasena", $contrasena);

            if($stmt->execute()) {
                return true;
            }

            throw new PDOException("Error al ejecutar la consulta: " . implode(" ", $stmt->errorInfo()));
        } catch (PDOException $e) {
            error_log("Error en registrar: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
