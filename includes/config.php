<?php
function conectarBD() {
    $host = 'localhost';
    $usuario = 'club_padel';
    $password = 'PadelSecure123!';
    $base_datos = 'padel';
    
    $conexion = mysqli_connect($host, $usuario, $password, $base_datos);
    
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    return $conexion;
}
?>
