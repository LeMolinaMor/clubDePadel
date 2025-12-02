<?php
require_once 'functions.php'; // No '../functions.php' si está en la misma carpeta
session_start();

// Verificar que el usuario está logueado y es admin
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['tipo'] !== '0') {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID del usuario a modificar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../dashboard_admin.php");
    exit();
}

$id_usuario = $_GET['id'];

// Obtener datos actuales del usuario
$conexion = conectarBD();
$consulta = "SELECT * FROM USUARIO WHERE id_usuario = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);

if (!$usuario) {
    header("Location: ../dashboard_admin.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $pass = $_POST['pass'];
    $tipo = $_POST['tipo'];
    
    if (modificar_usuario($id_usuario, $nombre, $pass, $tipo)) {
        header("Location: ../dashboard_admin.php?success=usuario_modificado");
        exit();
    } else {
        $error = "Error al modificar el usuario";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario - Club de Pádel</title>
    <link rel="stylesheet" href="../assets/style.css?version=<?php echo time(); ?>">
</head>
<body>
    <?php include_once 'header.php'; ?>
    
    <main class="simple-main">
        <section class="simple-section">
            <h2>Modificar Usuario</h2>
            
            <?php if (isset($error)): ?>
                <div class="flash-message error">
                    <div class="flash-icon">✗</div>
                    <div class="flash-text"><?php echo $error; ?></div>
                </div>
            <?php endif; ?>
            
            <div class="simple-form">
                <div class="dashboard-form">
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Contraseña:</label>
                                <input type="password" name="pass" class="form-control" placeholder="Nueva contraseña (dejar vacío para mantener actual)">
                            </div>
                            
                            <div class="form-group">
                                <label>Tipo:</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="0" <?php echo $usuario['tipo'] == '0' ? 'selected' : ''; ?>>Administrador</option>
                                    <option value="1" <?php echo $usuario['tipo'] == '1' ? 'selected' : ''; ?>>Usuario Normal</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" value="Modificar Usuario" class="btn">
                                <a href="../dashboard_admin.php" class="btn" style="background: var(--text-light); margin-left: 1rem;">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'footer.php'; ?>
</body>
</html>