<?php
require_once 'config.php';



function login_usuario($usuario,$contrasena){
    $conexion = conectarBD();
    $consulta = "SELECT * FROM USUARIO WHERE nombre = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($resultado) === 1){
        $usuario_db = mysqli_fetch_assoc($resultado);
        
        if (password_verify($contrasena, $usuario_db['pass'])) {
            mysqli_close($conexion);
            return $usuario_db;
        }   
    }
    
    mysqli_close($conexion);
    return false;
}

function mostrar_usuarios() {
    $conexion = conectarBD();
    $consulta = "SELECT * FROM USUARIO";
    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) > 0){
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        $campos = mysqli_fetch_fields($resultado);
        foreach($campos as $campo) {
            echo "<th>$campo->name</th>";
        }
        echo "<th>Acciones</th>";
        echo "</tr>";
        
        mysqli_data_seek($resultado, 0);
        
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            foreach($fila as $valor) {
                echo "<td>$valor</td>";
            }
            echo "<td>";
            
    
            echo "<form method='POST' action='procesar_usuario.php' style='display: inline;'>";
            echo "<input type='hidden' name='id_usuario' value='" . $fila['id_usuario'] . "'>";
            echo "<input type='submit' name='borrar_usuario' value='🗑️' 
                  onclick='return confirm(\"¿Seguro que quieres borrar este usuario?\")'
                  title='Borrar usuario'>";
            echo "</form>";
            
        
            echo "<form method='GET' action='includes/modificar_usuario.php' style='display: inline; margin-left: 5px;'>";
            echo "<input type='hidden' name='id' value='" . $fila['id_usuario'] . "'>";
            echo "<input type='submit' value='✏️' title='Modificar usuario'>";
            echo "</form>";
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</div>";
    } else {
        echo "No hay usuarios registrados";
    }
    
    mysqli_close($conexion);
}

function crear_usuario($nombre, $pass, $tipo) {
    $conexion = conectarBD();
    
    $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);// Hasheamos la contraseña antes de guardarla
    
    $consulta = "INSERT INTO USUARIO (nombre, pass, tipo) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $pass_hasheada, $tipo);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function modificar_usuario($id_usuario, $nombre, $pass, $tipo){
    if (!is_numeric($id_usuario)) {
        return false;
    }
    
    $conexion = conectarBD();
    
    $pass_hasheada = password_hash($pass, PASSWORD_DEFAULT);
    
    $consulta = "UPDATE USUARIO SET nombre = ?, pass = ?, tipo = ? WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "sssi", $nombre, $pass_hasheada, $tipo, $id_usuario);
    
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function borrar_usuario($id_usuario){
     if (!is_numeric($id_usuario)) {
        return false;
    }
    
    $conexion = conectarBD();
    $consulta = "DELETE FROM USUARIO WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    $resultado= mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;

}

function mostrar_pistas() {
    $conexion = conectarBD();
    $consulta = "SELECT * FROM PISTA";
    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) > 0){
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        $campos = mysqli_fetch_fields($resultado);
        foreach($campos as $campo) {
            echo "<th>$campo->name</th>";
        }
        echo "<th>Acciones</th>";
        echo "</tr>";
        
        mysqli_data_seek($resultado, 0);
        
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            foreach($fila as $valor) {
                echo "<td>$valor</td>";
            }
            echo "<td>";
            
            // BOTÓN BORRAR - RUTA CORREGIDA
            echo "<form method='POST' action='procesar_pista.php' style='display: inline;'>";
            echo "<input type='hidden' name='id_pista' value='" . $fila['id_pista'] . "'>";
            echo "<input type='submit' name='borrar_pista' value='🗑️' 
                  onclick='return confirm(\"¿Seguro que quieres borrar esta pista?\")'
                  title='Borrar pista'>";
            echo "</form>";
            
            // BOTÓN MODIFICAR
            echo "<form method='GET' action='includes/modificar_pista.php' style='display: inline; margin-left: 5px;'>";
            echo "<input type='hidden' name='id' value='" . $fila['id_pista'] . "'>";
            echo "<input type='submit' value='✏️' title='Modificar pista'>";
            echo "</form>";
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</div>";
    } else {
        echo "No hay pistas registradas";
    }
    
    mysqli_close($conexion);
}
function crear_pista($nombre) {
    $conexion = conectarBD();
    $consulta = "INSERT INTO PISTA (nombre) VALUES (?)";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $nombre);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function modificar_pista($id_pista, $nombre) {
    if (!is_numeric($id_pista)) {
        return false;
    }
    
    $conexion = conectarBD();
    $consulta = "UPDATE PISTA SET nombre = ? WHERE id_pista = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "si", $nombre, $id_pista);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function borrar_pista($id_pista){
    if (!is_numeric($id_pista)) {
        return false;
    }
    
    $conexion = conectarBD();
    $consulta = "DELETE FROM PISTA WHERE id_pista = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id_pista);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function mostrar_reservas() {
    $conexion = conectarBD();
    $consulta = "SELECT * FROM RESERVA";
    $resultado = mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($resultado) > 0){
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        $campos = mysqli_fetch_fields($resultado);
        foreach($campos as $campo) {
            echo "<th>$campo->name</th>";
        }
        echo "<th>Acciones</th>";
        echo "</tr>";
        
        mysqli_data_seek($resultado, 0);
        
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            foreach($fila as $valor) {
                echo "<td>$valor</td>";
            }
            echo "<td>";
            
            
            echo "<form method='POST' action='procesar_reserva.php' style='display: inline;'>";
            echo "<input type='hidden' name='id_reserva' value='" . $fila['id_reserva'] . "'>";
            echo "<input type='submit' name='borrar_reserva' value='🗑️' 
                  onclick='return confirm(\"¿Seguro que quieres borrar esta reserva?\")'
                  title='Borrar reserva'>";
            echo "</form>";
            
           
            echo "<form method='GET' action='includes/modificar_reserva.php' style='display: inline; margin-left: 5px;'>";
            echo "<input type='hidden' name='id' value='" . $fila['id_reserva'] . "'>";
            echo "<input type='submit' value='✏️' title='Modificar reserva'>";
            echo "</form>";
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</div>";
    } else {
        echo "No hay reservas registradas";
    }
    
    mysqli_close($conexion);
}

function borrar_reserva($id_reserva){
    if (!is_numeric($id_reserva)) {
        return false;
    }
    
    $conexion = conectarBD();
    $consulta = "DELETE FROM RESERVA WHERE id_reserva = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id_reserva);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}


function modificar_reserva($id_reserva, $usuario, $pista, $turno) {
    if (!is_numeric($id_reserva)) {
        return false;
    }
    
    $conexion = conectarBD();
    $consulta = "UPDATE RESERVA SET usuario = ?, pista = ?, turno = ? WHERE id_reserva = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "iisi", $usuario, $pista, $turno, $id_reserva);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function crear_reserva($usuario, $pista, $turno) {
    // Validar que la pista esté disponible
    if (!pista_disponible($pista, $turno)) {
        return false; // Pista ya ocupada en ese turno
    }
    
    $conexion = conectarBD();
    $consulta = "INSERT INTO RESERVA (usuario, pista, turno) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "iis", $usuario, $pista, $turno);
    $resultado = mysqli_stmt_execute($stmt);
    mysqli_close($conexion);
    return $resultado;
}

function pista_disponible($pista, $turno) {
    $conexion = conectarBD();
    $consulta = "SELECT COUNT(*) as total FROM RESERVA WHERE pista = ? AND turno = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "is", $pista, $turno);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $fila = mysqli_fetch_assoc($resultado);
    mysqli_close($conexion);
    
    return $fila['total'] == '0';
}

function mostrar_mis_reservas($id_usuario) {
    $conexion = conectarBD();
    $consulta = "SELECT r.*, p.nombre as nombre_pista 
                 FROM RESERVA r 
                 JOIN PISTA p ON r.pista = p.id_pista 
                 WHERE r.usuario = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($resultado) > 0){
        // AÑADE ESTA LÍNEA
        echo "<div class='table-container'>";
        
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Pista</th>";
        echo "<th>Turno</th>";
        echo "<th>Acciones</th>";
        echo "</tr>";
        
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila['id_reserva'] . "</td>";
            echo "<td>" . htmlspecialchars($fila['nombre_pista']) . "</td>";
            echo "<td>" . $fila['turno'] . "</td>";
            echo "<td>";
            
            echo "<form method='POST' action='procesar_reserva.php' style='display: inline;'>";
            echo "<input type='hidden' name='id_reserva' value='" . $fila['id_reserva'] . "'>";
            echo "<input type='submit' name='borrar_reserva' value='🗑️ Borrar' 
                  onclick='return confirm(\"¿Seguro que quieres borrar esta reserva?\")'>";
            echo "</form>";
            
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        // AÑADE ESTA LÍNEA
        echo "</div>";
    } else {
        echo "<p>No tienes reservas realizadas.</p>";
    }
    
    mysqli_close($conexion);
}



?>