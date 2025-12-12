<?php

require_once("../controller/conexion.php");

// 2. Verificar si viene el ID en la URL
if(isset($_GET['id'])){
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Crear la consulta SQL de eliminación
    // Borramos del historial basándonos en el ID recibido
    $sql = "DELETE FROM historial_puesto WHERE idpuesto = '$id'";
    
    $resultado = mysqli_query($conn, $sql);

    // 4. Validar resultado y Redirigir
    if($resultado){
        // Si se borró correctamente
        echo "<script>
                alert('Vehículo eliminado del sistema correctamente.');
                // Regresar a la página de parqueadero.
                // Ajusta 'views' si tu carpeta se llama diferente, o usa window.history.back()
                window.location.href = 'parqueadero.php'; 
              </script>";
    } else {
        // Si hubo error SQL
        echo "<script>
                alert('Error al eliminar: " . mysqli_error($conn) . "');
                window.history.back(); // Regresa a la página anterior
              </script>";
    }

} else {
    // Si alguien intenta abrir este archivo sin enviar un ID, lo devolvemos
    echo "<script>
            window.location.href = 'parqueadero.php';
          </script>";
}

// 5. Cerrar conexión
mysqli_close($conn);
?>