<?php
require_once 'functions.php';
session_start();

// Verificar que el usuario está logueado y es admin
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['tipo'] !== '0') {
    header("Location: ../index.php");
    exit();
}

// Obtener el ID de la pista a modificar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../dashboard_admin.php");
    exit();
}

$id_pista = $_GET['id'];

// Obtener datos actuales de la pista
$conexion = conectarBD();
$consulta = "SELECT * FROM PISTA WHERE id_pista = ?";
$stmt = mysqli_prepare($conexion, $consulta);
mysqli_stmt_bind_param($stmt, "i", $id_pista);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$pista = mysqli_fetch_assoc($resultado);
mysqli_close($conexion);

if (!$pista) {
    header("Location: ../dashboard_admin.php");
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    
    if (modificar_pista($id_pista, $nombre)) {
        header("Location: ../dashboard_admin.php?success=pista_modificada");
        exit();
    } else {
        $error = "Error al modificar la pista";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Pista - Club de Pádel</title>
    <link rel="stylesheet" href="../assets/style.css?version=<?php echo time(); ?>">
</head>
<body>
    <?php include_once 'header.php'; ?>
    
    <main class="simple-main">
        <section class="simple-section">
            <h2>Modificar Pista</h2>
            
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
                                <label>Nombre de la pista:</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($pista['nombre']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" value="Modificar Pista" class="btn">
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