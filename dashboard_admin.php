<?php
require_once 'includes/functions.php';
session_start();

// Verificar que el usuario está logueado y es admin
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || $_SESSION['tipo'] !== '0') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Club de Pádel</title>
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
                        case 'usuario_creado': echo "Usuario creado exitosamente"; break;
                        case 'usuario_borrado': echo "Usuario eliminado correctamente"; break;
                        case 'pista_creada': echo "Pista agregada al sistema"; break;
                        case 'pista_borrada': echo "Pista eliminada correctamente"; break;
                        case 'reserva_creada': echo "Reserva realizada con éxito"; break;
                        case 'reserva_borrada': echo "Reserva cancelada"; break;
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
                        case 'usuario_duplicado': echo "Error: Ese nombre de usuario ya existe en el sistema."; break;
                        case 'reserva_no_creada': echo "Error: No se pudo crear la reserva. Verifica los datos."; break;
                        default: echo "Ha ocurrido un error";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Gestión de Usuarios -->
        <section class="simple-section">
            <h2>Gestión de Usuarios</h2>
            
            <div class="simple-form">
                <h3>Crear Nuevo Usuario</h3>
                <div class="dashboard-form">
                    <form method="POST" action="procesar_usuario.php">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre de usuario" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña:</label>
                                <input type="password" name="pass" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="form-group">
                                <label>Tipo:</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="0">Administrador</option>
                                    <option value="1">Usuario Normal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="crear_usuario" value="Crear Usuario" class="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="simple-table">
                <h3>Lista de Usuarios</h3>
                <?php mostrar_usuarios(); ?>
            </div>
        </section>

        <!-- Gestión de Pistas -->
        <section class="simple-section">
            <h2>Gestión de Pistas</h2>
            
            <div class="simple-form">
                <h3>Crear Nueva Pista</h3>
                <div class="dashboard-form">
                    <form method="POST" action="procesar_pista.php">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre de la pista:</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre de la pista" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="crear_pista" value="Crear Pista" class="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="simple-table">
                <h3>Pistas Disponibles</h3>
                <?php mostrar_pistas(); ?>
            </div>
        </section>

        <!-- Gestión de Reservas -->
        <section class="simple-section">
            <h2>Gestión de Reservas</h2>
            
            <div class="simple-form">
                <h3>Crear Nueva Reserva</h3>
                <div class="dashboard-form">
                    <form method="POST" action="procesar_reserva.php">
                        <?php
                        $conexion = conectarBD();
                        $usuarios = mysqli_query($conexion, "SELECT id_usuario, nombre FROM USUARIO");
                        $pistas = mysqli_query($conexion, "SELECT id_pista, nombre FROM PISTA");
                        mysqli_close($conexion);
                        ?>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Usuario:</label>
                                <select name="usuario" class="form-control" required>
                                    <option value="">Seleccionar usuario</option>
                                    <?php while ($user = mysqli_fetch_assoc($usuarios)): ?>
                                        <option value="<?php echo $user['id_usuario']; ?>">
                                            <?php echo htmlspecialchars($user['nombre']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Pista:</label>
                                <select name="pista" class="form-control" required>
                                    <option value="">Seleccionar pista</option>
                                    <?php mysqli_data_seek($pistas, 0); ?>
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
                                <input type="submit" name="crear_reserva" value="Crear Reserva" class="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="simple-table">
                <h3>Reservas Existentes</h3>
                <?php mostrar_reservas(); ?>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html>