<?php
require_once 'includes/functions.php';
session_start();

// Verificar que es admin
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['tipo'] !== '0') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear pista
    if (isset($_POST['crear_pista'])) {
        $nombre = $_POST['nombre'];
        
        if (crear_pista($nombre)) {
            header("Location: dashboard_admin.php?success=pista_creada");
        } else {
            header("Location: dashboard_admin.php?error=pista_no_creada");
        }
        exit();
    }
    
    // Borrar pista
    if (isset($_POST['borrar_pista'])) {
        $id_pista = $_POST['id_pista'];
        
        if (borrar_pista($id_pista)) {
            header("Location: dashboard_admin.php?success=pista_borrada");
        } else {
            header("Location: dashboard_admin.php?error=pista_no_borrada");
        }
        exit();
    }
}

header("Location: dashboard_admin.php");
exit();
?>