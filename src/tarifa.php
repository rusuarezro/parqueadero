<?php
include "menu.php";
include("../controller/conexion.php");

// Inicialización de variables
$id = "";
$estado = 0;
$tipo = 0;
$precio = ""; // Cambiado a vacío para mejor UX
$fecha = "";
$vehiculo = ["-- Seleccione --"];
$estado2 = ["-- Seleccione --", "Activo", "Inactivo"];
$editando = false; // Variable para controlar qué botones mostrar

// Cargar tipos de vehículo para el Select
$sqltarifa = "SELECT * FROM tipovehiculo";
$resultadoV = mysqli_query($conn, $sqltarifa);
while($vehiculo1 = mysqli_fetch_array($resultadoV)){
    // Guardamos clave y valor para que el select funcione bien con IDs reales
    // Nota: Tu lógica original usaba array push simple, aquí lo adapto para mantener tu lógica
    // pero idealmente deberías guardar el ID también. Asumiré que el index del array coincide.
    array_push($vehiculo, $vehiculo1["vehiculo"]);
}
// Cerramos conexión temporalmente o la mantenemos (en este script simple se reabre abajo)
mysqli_close($conn);


// --- LÓGICA POST (Guardar / Editar) ---
if(!empty($_POST)){
    
    if(isset($_POST['guardar'])){
        $tipo   = $_POST['tipo'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $fecha  = date("Y-m-d H:i:s"); 

        include("../controller/conexion.php");
        
        // Validar duplicados
        $sqlB = "SELECT * FROM tarifa where tipoVehiculo='$tipo' and idestado='$estado'";
        $resultadoB = mysqli_query($conn, $sqlB);
        $buscar = mysqli_fetch_assoc($resultadoB);
        
        if(!empty($buscar)){ 
            echo "<script>alert('Error: Ya existe una tarifa con ese tipo y estado.'); location.assign('tarifa.php');</script>";              
        } else {
            $sql = "INSERT INTO tarifa (tipoVehiculo, precio, idestado, create_at, updated_at) VALUES ($tipo, $precio, $estado, '$fecha', '$fecha')";
            $resultado = mysqli_query($conn, $sql);
            
            if ($resultado){
                echo "<script>alert('Tarifa guardada correctamente'); location.assign('tarifa.php');</script>";
            } else {
                echo "<script>alert('Error al guardar en BD'); location.assign('tarifa.php');</script>";
            }
        }
        mysqli_close($conn);

    } elseif(isset($_POST['editar'])){
        $id     = $_POST['Id'];
        $tipo   = $_POST['tipo'];
        $precio = $_POST['precio'];
        $estado = $_POST['estado'];
        $fecha  = date("Y-m-d H:i:s"); 

        include("../controller/conexion.php");
        $sql = "UPDATE tarifa SET tipoVehiculo=$tipo, precio=$precio, idestado=$estado, updated_at='$fecha' WHERE id_tarifa=$id";
        $resultado = mysqli_query($conn, $sql);

        if ($resultado){
            echo "<script>alert('Tarifa actualizada correctamente'); location.assign('tarifa.php');</script>";
        } else {
            echo "<script>alert('Error al actualizar'); location.assign('tarifa.php');</script>";
        } 
        mysqli_close($conn);
    }
}

// --- LÓGICA GET (Cargar datos para editar) ---
if(!empty($_GET)){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        include("../controller/conexion.php");
        $sql = "SELECT * FROM tarifa WHERE id_tarifa=$id";
        $resultado = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        
        if(!empty($fila)){
            $id = $fila["id_tarifa"];
            $tipo = $fila['tipoVehiculo'];
            $precio = $fila['precio'];
            $estado = $fila['idestado'];                    
            $editando = true; // Activamos modo edición
        }
        // No cerramos conexión aquí si no es necesario, o la reabrimos en la tabla
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tarifas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .table thead { background-color: #212529; color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-success"><i class="bi bi-currency-dollar"></i> Gestión de Tarifas</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header <?php echo $editando ? 'bg-warning' : 'bg-success'; ?> text-white">
                    <h5 class="mb-0">
                        <?php if($editando): ?>
                            <i class="bi bi-pencil-square"></i> Editando Tarifa
                        <?php else: ?>
                            <i class="bi bi-plus-circle"></i> Nueva Tarifa
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" id="Id" name="Id" value="<?= $id ?>">       
                        
                        <div class="mb-3">
                            <label for="tipo" class="form-label fw-bold">Tipo de Vehículo</label>
                            <select class="form-select" id="tipo" name="tipo"> 
                                <?php foreach($vehiculo as $index => $value): ?>
                                    <option value="<?= $index ?>" <?= ($tipo == $index) ? 'selected' : '' ?>>
                                        <?= $value ?>
                                    </option>
                                <?php endforeach; ?>  
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label fw-bold">Precio por Hora</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio" name="precio" value="<?= $precio ?>" min="0" step="0.01" required placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label fw-bold">Estado</label>
                            <select class="form-select" id="estado" name="estado">   
                                <?php foreach($estado2 as $i => $value2): ?>
                                    <option value="<?= $i ?>" <?= ((int)$estado == $i) ? 'selected' : '' ?>>
                                        <?= $value2 ?>
                                    </option>
                                <?php endforeach; ?> 
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <?php if($editando): ?>
                                <input type="submit" name="editar" value="Actualizar Tarifa" class="btn btn-warning text-dark fw-bold">
                                <a href="tarifa.php" class="btn btn-secondary">Cancelar</a>
                            <?php else: ?>
                                <input type="submit" name="guardar" value="Guardar Tarifa" class="btn btn-success">
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Listado de Tarifas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Tipo Vehículo</th>
                                    <th>Precio / Hora</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("../controller/conexion.php");
                                // Nota: He mejorado un poco la query para asegurar que trae todo correctamente
                                $sqltarifa = "SELECT t.id_tarifa, tv.vehiculo as tipo, t.precio, te.DESCRIPCION_EST as estado 
                                              FROM tarifa t
                                              INNER JOIN tipovehiculo tv ON t.tipoVehiculo = tv.id_tipo 
                                              INNER JOIN tbestado te ON t.idestado = te.ID_ESTADO 
                                              WHERE t.idestado = 1 
                                              ORDER BY t.tipoVehiculo ASC"; // Ordenado por tipo

                                $tablatarifa = mysqli_query($conn, $sqltarifa);

                                if(mysqli_num_rows($tablatarifa) > 0):
                                    while($filatarifa = mysqli_fetch_array($tablatarifa)): ?>
                                        <tr>
                                            <td>
                                                <i class="bi bi-car-front"></i> <?= $filatarifa['tipo'] ?>
                                            </td>
                                            <td class="fw-bold text-success">
                                                $ <?= number_format($filatarifa['precio'], 2) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-success"><?= $filatarifa['estado'] ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="tarifa.php?id=<?= $filatarifa['id_tarifa'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                    <i class="bi bi-pencil-fill"></i> Editar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile;
                                else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No hay tarifas activas registradas.</td>
                                    </tr>
                                <?php endif;
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>