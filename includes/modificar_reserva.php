<?php
require_once 'functions.php';
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID de la reserva a modificar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    if ($_SESSION['tipo'] === '0') {
        header("Location: ../dashboard_admin.php");
    } else {
        header("Location: ../dashboard_usuario.php");
    }
    exit();
}

$id_reserva = $_GET['id'];

// Obtener datos actuales de la reserva
$conexion = conectarBD();
$consulta = "SELECT * FROM RESERVA WHERE id_reserva = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "i", $id_reserva);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$reserva = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);

if (!$reserva) {
    if ($_SESSION['tipo'] === '0') {
        header("Location: ../dashboard_admin.php");
    } else {
        header("Location: ../dashboard_usuario.php");
    }
    exit();
}

// Verificar que el usuario normal solo modifica sus propias reservas
if ($_SESSION['tipo'] === '1' && $reserva['usuario'] != $_SESSION['id_usuario']) {
    header("Location: ../dashboard_usuario.php");
    exit();
}

// Obtener listas de usuarios y pistas para los selects
$conexion = conectarBD();
$usuarios = mysqli_query($conexion, "SELECT id_usuario, nombre FROM USUARIO");
$pistas = mysqli_query($conexion, "SELECT id_pista, nombre FROM PISTA");
mysqli_close($conexion);

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $pista = $_POST['pista'];
    $turno = $_POST['turno'];
    
    // Si es usuario normal, forzar que sea su propio ID
    if ($_SESSION['tipo'] === '1') {
        $usuario = $_SESSION['id_usuario'];
    }
    
    if (modificar_reserva($id_reserva, $usuario, $pista, $turno)) {
        if ($_SESSION['tipo'] === '0') {
            header("Location: ../dashboard_admin.php?success=reserva_modificada");
        } else {
            header("Location: ../dashboard_usuario.php?success=reserva_modificada");
        }
        exit();
    } else {
        $error = "Error al modificar la reserva";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Reserva</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include_once '../includes/header.php'; ?>
    
    <main class="simple-main">
        <div class="modificar-container">
            <h1>Modificar Reserva</h1>
            
            <?php if (isset($error)): ?>
                <div class="modificar-flash-message error">
                    <div class="modificar-flash-icon">✗</div>
                    <div class="modificar-flash-text"><?php echo $error; ?></div>
                </div>
            <?php endif; ?>
            
            <div class="modificar-form">
                <form method="POST">
                    <?php if ($_SESSION['tipo'] === '0'): ?>
                    <div class="form-group">
                        <label>Usuario:</label>
                        <select name="usuario" class="form-control" required>
                            <?php while ($user = mysqli_fetch_assoc($usuarios)): ?>
                                <option value="<?php echo $user['id_usuario']; ?>" 
                                    <?php echo $reserva['usuario'] == $user['id_usuario'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['nombre']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label>Pista:</label>
                        <select name="pista" class="form-control" required>
                            <?php mysqli_data_seek($pistas, 0); ?>
                            <?php while ($pista_opt = mysqli_fetch_assoc($pistas)): ?>
                                <option value="<?php echo $pista_opt['id_pista']; ?>" 
                                    <?php echo $reserva['pista'] == $pista_opt['id_pista'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pista_opt['nombre']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Turno:</label>
                        <select name="turno" class="form-control" required>
                            <option value="Mañana" <?php echo $reserva['turno'] == 'Mañana' ? 'selected' : ''; ?>>Mañana</option>
                            <option value="Tarde" <?php echo $reserva['turno'] == 'Tarde' ? 'selected' : ''; ?>>Tarde</option>
                            <option value="Noche" <?php echo $reserva['turno'] == 'Noche' ? 'selected' : ''; ?>>Noche</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <input type="submit" value="Modificar Reserva" class="btn-modify">
                        <?php if ($_SESSION['tipo'] === '0'): ?>
                            <a href="../dashboard_admin.php" class="btn-secondary">Cancelar</a>
                        <?php else: ?>
                            <a href="../dashboard_usuario.php" class="btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once '../includes/footer.php'; ?>
</body>
</html>