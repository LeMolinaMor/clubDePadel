<?php
require_once 'includes/functions.php';
session_start();

// Verificar que está logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear reserva
    if (isset($_POST['crear_reserva'])) {
        $usuario = $_POST['usuario'];
        $pista = $_POST['pista'];
        $turno = $_POST['turno'];
        
        // Si es usuario normal, forzar su propio ID
        if ($_SESSION['tipo'] === '1') {
            $usuario = $_SESSION['id_usuario'];
        }
        
        if (crear_reserva($usuario, $pista, $turno)) {
            if ($_SESSION['tipo'] === '0') {
                header("Location: dashboard_admin.php?success=reserva_creada");
            } else {
                header("Location: dashboard_usuario.php?success=reserva_creada");
            }
        } else {
            // Manejar error de pista ocupada
            if ($_SESSION['tipo'] === '0') {
                header("Location: dashboard_admin.php?error=pista_ocupada&pista=$pista&turno=$turno");
            } else {
                header("Location: dashboard_usuario.php?error=pista_ocupada&pista=$pista&turno=$turno");
            }
        }
        exit();
    }
    
    // Borrar reserva - VERSIÓN CORREGIDA
    if (isset($_POST['borrar_reserva'])) {
        $id_reserva = $_POST['id_reserva'];
        
        // Si es admin, puede borrar cualquier reserva sin verificación adicional
        if ($_SESSION['tipo'] === '0') {
            if (borrar_reserva($id_reserva)) {
                header("Location: dashboard_admin.php?success=reserva_borrada");
            } else {
                header("Location: dashboard_admin.php?error=reserva_no_borrada");
            }
            exit();
        }
        // Si es usuario normal, verificar que es su reserva
        else if ($_SESSION['tipo'] === '1') {
            $conexion = conectarBD();
            $consulta = "SELECT usuario FROM RESERVA WHERE id_reserva = ?";
            $stmt = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($stmt, "i", $id_reserva);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            $reserva = mysqli_fetch_assoc($resultado);
            mysqli_close($conexion);
            
            if ($reserva && $reserva['usuario'] == $_SESSION['id_usuario']) {
                if (borrar_reserva($id_reserva)) {
                    header("Location: dashboard_usuario.php?success=reserva_borrada");
                } else {
                    header("Location: dashboard_usuario.php?error=reserva_no_borrada");
                }
            } else {
                header("Location: dashboard_usuario.php?error=sin_permisos");
            }
            exit();
        }
    }
}

// Redirigir según el tipo de usuario
if ($_SESSION['tipo'] === '0') {
    header("Location: dashboard_admin.php");
} else {
    header("Location: dashboard_usuario.php");
}
exit();
?>