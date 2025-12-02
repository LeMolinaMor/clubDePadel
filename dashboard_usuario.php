<?php
require_once 'includes/functions.php';
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario - Club de Pádel</title>
    <link rel="stylesheet" href="assets/style.css?version=<?php echo time(); ?>">
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <main class="simple-main">
        <!-- MENSAJES LLAMATIVOS -->
        <?php if (isset($_GET['success'])): ?>
            <div class="flash-message success">
                <div class="flash-icon">✓</div>
                <div class="flash-text">
                    <?php 
                    switch($_GET['success']) {
                        case 'reserva_creada': echo "Reserva realizada con éxito"; break;
                        case 'reserva_borrada': echo "Reserva cancelada correctamente"; break;
                        default: echo "Operación completada";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="flash-message error">
                <div class="flash-icon">✗</div>
                <div class="flash-text">
                    <?php 
                    switch($_GET['error']) {
                        case 'pista_ocupada': 
                            echo "Atención: Esa pista ya está reservada en ese horario. Por favor elige otra pista u otro turno.";
                            break;
                        case 'reserva_no_creada': echo "Error: No se pudo crear la reserva. Verifica los datos."; break;
                        case 'reserva_no_borrada': echo "Error: No se pudo cancelar la reserva."; break;
                        case 'sin_permisos': echo "Error: No tienes permisos para esta acción."; break;
                        default: echo "Ha ocurrido un error";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Crear Nueva Reserva -->
        <section class="simple-section">
            <h2>Hacer Nueva Reserva</h2>
            
            <div class="simple-form">
                <div class="dashboard-form">
                    <form method="POST" action="procesar_reserva.php">
                        <?php
                        $conexion = conectarBD();
                        $pistas = mysqli_query($conexion, "SELECT id_pista, nombre FROM PISTA");
                        mysqli_close($conexion);
                        ?>
                        
                        <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Pista:</label>
                                <select name="pista" class="form-control" required>
                                    <option value="">Seleccionar pista</option>
                                    <?php while ($pista = mysqli_fetch_assoc($pistas)): ?>
                                        <option value="<?php echo $pista['id_pista']; ?>">
                                            <?php echo htmlspecialchars($pista['nombre']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Turno:</label>
                                <select name="turno" class="form-control" required>
                                    <option value="">Seleccionar turno</option>
                                    <option value="Mañana">Mañana</option>
                                    <option value="Tarde">Tarde</option>
                                    <option value="Noche">Noche</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <input type="submit" name="crear_reserva" value="Hacer Reserva" class="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Mis Reservas -->
        <section class="simple-section">
            <h2>Mis Reservas</h2>
            
            <div class="simple-table">
                <?php mostrar_mis_reservas($_SESSION['id_usuario']); ?>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html>