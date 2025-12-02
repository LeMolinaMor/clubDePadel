<?php
require_once 'includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

if (empty($_POST['campo-usuario']) || empty($_POST['campo-contrasena'])) {
    header("Location: index.php?error=vacio");
    exit();
}

$usuario = trim($_POST['campo-usuario']);
$contrasena = $_POST['campo-contrasena'];

$usuario_db = login_usuario($usuario, $contrasena);

if ($usuario_db) {
    $_SESSION['logueado'] = true;
    $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
    $_SESSION['nombre'] = $usuario_db['nombre'];
    $_SESSION['tipo'] = $usuario_db['tipo'];
    
    if ($_SESSION['tipo'] == '0') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_usuario.php");
    }
    exit();
} else {
    header("Location: index.php?error=credenciales");
    exit();
}
?>