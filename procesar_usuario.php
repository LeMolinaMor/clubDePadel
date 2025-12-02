<?php
require_once 'includes/functions.php';
session_start();

// Verificar que es admin
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['tipo'] !== '0') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear usuario
    if (isset($_POST['crear_usuario'])) {
        $nombre = $_POST['nombre'];
        $pass = $_POST['pass'];
        $tipo = $_POST['tipo'];
        
        if (crear_usuario($nombre, $pass, $tipo)) {
            header("Location: dashboard_admin.php?success=usuario_creado");
        } else {
            header("Location: dashboard_admin.php?error=usuario_duplicado");
        }
        exit();
    }
    
    // Borrar usuario
    if (isset($_POST['borrar_usuario'])) {
        $id_usuario = $_POST['id_usuario'];
        
        if (borrar_usuario($id_usuario)) {
            header("Location: dashboard_admin.php?success=usuario_borrado");
        } else {
            header("Location: dashboard_admin.php?error=usuario_no_borrado");
        }
        exit();
    }
}

header("Location: dashboard_admin.php");
exit();
?>