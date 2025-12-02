<?php
session_start();

// Verificar si el usuario ya está logueado
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    if($_SESSION['tipo'] === '0'){
        header("Location: dashboard_admin.php");
        exit();
    } else {
        header("Location: dashboard_usuario.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Club de Pádel</title>
    <link rel="stylesheet" href="assets/style.css?version=<?php echo time(); ?>">
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    
    <main class="simple-main">
        
        <!-- MENSAJES DE ERROR -->
        <?php if (isset($_GET['error'])): ?>
            <div class="flash-message error">
                <div class="flash-icon">✗</div>
                <div class="flash-text">
                    <?php 
                    switch($_GET['error']) {
                        case 'credenciales': echo "Error: Usuario o contraseña incorrectos."; break;
                        case 'vacio': echo "Error: Por favor, completa todos los campos."; break;
                        default: echo "Ha ocurrido un error al iniciar sesión";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="flash-message success">
                <div class="flash-icon">✓</div>
                <div class="flash-text">
                    <?php 
                    switch($_GET['success']) {
                        case 'logout': echo "Sesión cerrada correctamente."; break;
                        default: echo "Operación completada";
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>


        <section class="simple-section">
            <h2>Iniciar Sesión</h2>
            
            <div class="simple-form">
                <div class="login-form-container">
                    <form method="POST" action="procesar_login.php" class="login-form">
                        <div class="form-group">
                            <label>Usuario:</label>
                            <input type="text" name="campo-usuario" class="form-control" placeholder="Ingresa tu usuario" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" name="campo-contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" value="Iniciar Sesión" class="btn btn-login">
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once 'includes/footer.php'; ?>
</body>
</html>