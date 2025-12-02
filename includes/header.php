<header class="header">
    <div class="header-container">
        <div class="logo-section">
            <h1 class="logo">🎾 Club de Pádel</h1>
            <p class="slogan">...tu punto de encuentro!</p>
        </div>
        <nav class="nav-menu">
            <ul class="nav-list">
                <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                    <li><a href="<?php echo $_SESSION['tipo'] === '0' ? 'dashboard_admin.php' : 'dashboard_usuario.php'; ?>" class="nav-link">Dashboard</a></li>
                    <li><span class="user-welcome">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span></li>
                    <li><a href="logout.php" class="nav-link logout">Cerrar Sesión</a></li>
                <?php else: ?>
             
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>