<?php
// Archivo temporal para generar el hash
$password = "admin"; 

// Generar el hash
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h1>Hash generado para: '$password'</h1>";
echo "<p><strong>Hash:</strong> " . $hash . "</p>";

// Verificar que funciona
echo "<p><strong>Verificación:</strong> ";
if (password_verify($password, $hash)) {
    echo "✅ El hash es correcto y funciona con password_verify()";
} else {
    echo "❌ Error en el hash";
}
echo "</p>";

echo "<h2>Comando SQL para actualizar:</h2>";
echo "<code>UPDATE USUARIO SET pass = '" . $hash . "' WHERE nombre = 'tu_usuario_admin';</code>";
?>