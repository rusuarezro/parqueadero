<?php
include "menu.php";
include("../controller/conexion.php");

// --- INICIALIZACIÓN DE VARIABLES ---
$idUsuario      = "";
$nit            = "";
$nombre         = "";
$apellido       = "";
$telefono       = "";
$email          = "";
$estadoUsuario  = 0;
$fecha          = "";
$botones        = 0; // 0: Nada, 1: Usuario encontrado, 2: Editando vehículo

// Variables del vehículo
$idVehiculo     = "";
$placa          = "";
$marca          = "";
$modelo         = "";
$color          = "";
$tipo           = ""; // ID del tipo de vehículo

// Cargar Tipos de Vehículo para el Select (Usando ID real)
$listaTipos = [];
$sqlvehiculo = "SELECT * FROM tipovehiculo";
$resultadoV = mysqli_query($conn, $sqlvehiculo);
while($row = mysqli_fetch_assoc($resultadoV)){
    $listaTipos[] = $row; // Guardamos toda la fila (id_tipo y vehiculo)
}

// --- LÓGICA POST (ACCIONES) ---
if(!empty($_POST)){

    // 1. BUSCAR USUARIO
    if(isset($_POST['buscar'])){
        $nit = $_POST['nit']; // Viene del form pequeño
        $sql = "SELECT * FROM tbusuarios WHERE IDENTIFICACION='$nit'";
        $resultado = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($resultado);

        if(!empty($fila)){
            $idUsuario      = $fila["ID_USUARIO"];
            $nit            = $fila["IDENTIFICACION"];
            $nombre         = $fila["NOMBRES"];
            $apellido       = $fila["APELLIDOS"];
            $telefono       = $fila["CELULAR"];
            $email          = $fila["EMAIL"];
            $estadoUsuario  = $fila["ESTADO_FK"];
            $botones        = 1; // Habilitar formulario de ingreso
        } else {
            echo "<script>alert('Usuario no encontrado');</script>";
        }
    
    // 2. GUARDAR NUEVO VEHÍCULO
    } elseif(isset($_POST['guardar'])){
        // Recuperamos datos ocultos y del form
        $idUsuario  = $_POST['idUsuario'];
        $nit        = $_POST['nit_hidden']; // Para mantener la vista del usuario
        
        $placa      = $_POST['placa'];
        $marca      = $_POST['marca'];
        $modelo     = $_POST['modelo'];
        $color      = $_POST['color'];
        $tipo       = $_POST['tipo'];
        $fecha      = date("Y-m-d H:i:s");

        // Verificar duplicado
        $sqlB = "SELECT * FROM vehiculo where placa='$placa'";
        $resB = mysqli_query($conn, $sqlB);
        
        if(mysqli_num_rows($resB) > 0){ 
            echo "<script>alert('Error: La placa $placa ya existe en la BD'); location.assign('vehiculo.php');</script>";              
        } else {
            $sql = "INSERT INTO vehiculo (placa, marca, modelo, color, idusuario, id_tipovehiculo, created_at, updated_at) 
                    VALUES ('$placa','$marca','$modelo','$color', $idUsuario, $tipo, '$fecha', '$fecha')";
            
            if (mysqli_query($conn, $sql)){
                // Redirigimos simulando una búsqueda para ver el nuevo dato
                echo "<script>alert('Vehículo registrado correctamente'); location.href='vehiculo.php?cc=$nit&rebuscar=1';</script>";
            } else {
                echo "<script>alert('Error al guardar');</script>";
            }
        }

    // 3. ACTUALIZAR VEHÍCULO
    } elseif(isset($_POST['editar'])){
        $idVehiculo = $_POST['idVehiculo'];
        $nit        = $_POST['nit_hidden']; // Para redirección
        
        $placa      = $_POST['placa'];
        $marca      = $_POST['marca'];
        $modelo     = $_POST['modelo'];
        $color      = $_POST['color'];
        $tipo       = $_POST['tipo'];
        $fecha      = date("Y-m-d H:i:s");

        $sql = "UPDATE vehiculo SET placa='$placa', marca='$marca', modelo='$modelo', color='$color', id_tipovehiculo=$tipo, updated_at='$fecha' WHERE id_vehiculo=$idVehiculo";
        
        if (mysqli_query($conn, $sql)){
            echo "<script>alert('Vehículo modificado correctamente'); location.href='vehiculo.php?cc=$nit&rebuscar=1';</script>";
        } else {
            echo "<script>alert('Error al modificar');</script>";
        }

    // 4. ELIMINAR VEHÍCULO
    } elseif(isset($_POST['eliminar'])){
        $idVehiculo = $_POST['idVehiculo'];
        $nit        = $_POST['nit_hidden'];

        $sql = "DELETE FROM vehiculo WHERE id_vehiculo=$idVehiculo";
        
        if (mysqli_query($conn, $sql)){
            echo "<script>alert('Vehículo eliminado'); location.href='vehiculo.php?cc=$nit&rebuscar=1';</script>";
        } else {
            echo "<script>alert('Error al eliminar');</script>";
        }
    }
}

// --- LÓGICA GET (Recargar usuario o Cargar edición) ---
if(!empty($_GET)){
    
    // Caso A: Re-buscar usuario (después de guardar/editar para ver la tabla actualizada)
    if(isset($_GET['rebuscar']) && isset($_GET['cc'])){
        $nit = $_GET['cc'];
        $sql = "SELECT * FROM tbusuarios WHERE IDENTIFICACION='$nit'";
        $res = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($res);
        if(!empty($fila)){
            $idUsuario      = $fila["ID_USUARIO"];
            $nit            = $fila["IDENTIFICACION"];
            $nombre         = $fila["NOMBRES"];
            $apellido       = $fila["APELLIDOS"];
            $telefono       = $fila["CELULAR"];
            $email          = $fila["EMAIL"];
            $estadoUsuario  = $fila["ESTADO_FK"];
            $botones        = 1;
        }
    }

    // Caso B: Cargar datos para EDITAR un vehículo específico
    if(isset($_GET['editar']) && isset($_GET['id']) && isset($_GET['cc'])){
        $idVehiculoEdit = $_GET['id'];
        $nit            = $_GET['cc'];

        // Traemos datos del usuario Y del vehículo
        $sql = "SELECT u.ID_USUARIO, u.IDENTIFICACION, u.NOMBRES, u.APELLIDOS, u.CELULAR, u.EMAIL, u.ESTADO_FK, 
                v.id_vehiculo, v.placa, v.marca, v.modelo, v.color, v.id_tipovehiculo 
                FROM tbusuarios u 
                INNER JOIN vehiculo v ON u.ID_USUARIO = v.idusuario 
                WHERE u.IDENTIFICACION='$nit' AND v.id_vehiculo=$idVehiculoEdit";

        $resultado = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        
        if(!empty($fila)){
            // Datos Usuario
            $idUsuario      = $fila["ID_USUARIO"];
            $nombre         = $fila["NOMBRES"];
            $apellido       = $fila["APELLIDOS"];
            $telefono       = $fila["CELULAR"];
            $email          = $fila["EMAIL"];
            $estadoUsuario  = $fila["ESTADO_FK"];
            
            // Datos Vehículo
            $idVehiculo     = $fila["id_vehiculo"];
            $placa          = $fila["placa"];
            $marca          = $fila["marca"];
            $modelo         = $fila["modelo"];
            $color          = $fila["color"];
            $tipo           = $fila["id_tipovehiculo"];
            
            $botones        = 2; // Modo Edición
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vehículos</title>
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
            <h2 class="fw-bold text-primary"><i class="bi bi-car-front-fill"></i> Registro de Vehículos</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-person-search"></i> 1. Buscar Cliente</h6>
                </div>
                <div class="card-body">
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" name="nit" value="<?= $nit ?>" placeholder="Ingrese Cédula/NIT" required>
                            <button class="btn btn-primary" type="submit" name="buscar">Buscar</button>
                        </div>
                    </form>

                    <?php if($idUsuario != ""): ?>
                        <div class="mt-3 p-2 bg-light border rounded small">
                            <div class="fw-bold text-primary"><?= $nombre." ".$apellido ?></div>
                            <div><i class="bi bi-telephone"></i> <?= $telefono ?></div>
                            <div><i class="bi bi-envelope"></i> <?= $email ?></div>
                            <div class="mt-1">
                                <?php if($estadoUsuario == 1): ?>
                                    <span class="badge bg-success">ACTIVO</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">INACTIVO</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header <?= ($botones==2) ? 'bg-warning' : 'bg-primary' ?> text-white">
                    <h6 class="mb-0">
                        <?php if($botones == 2): ?>
                            <i class="bi bi-pencil-square"></i> 2. Editar Vehículo
                        <?php else: ?>
                            <i class="bi bi-plus-circle"></i> 2. Datos del Vehículo
                        <?php endif; ?>
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">
                        <input type="hidden" name="idVehiculo" value="<?= $idVehiculo ?>">
                        <input type="hidden" name="nit_hidden" value="<?= $nit ?>">

                        <fieldset <?= ($idUsuario == "") ? "disabled" : "" ?>>
                            
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Placa</label>
                                <input type="text" class="form-control" name="placa" value="<?= $placa ?>" minlength="3" maxlength="10" required placeholder="AAA-123" style="text-transform: uppercase;">
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-bold">Tipo</label>
                                <select class="form-select" name="tipo" required>
                                    <option value="">-- Seleccione --</option>
                                    <?php foreach($listaTipos as $t): ?>
                                        <option value="<?= $t['id_tipo'] ?>" <?= ($tipo == $t['id_tipo']) ? 'selected' : '' ?>>
                                            <?= $t['vehiculo'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label small fw-bold">Marca</label>
                                    <input type="text" class="form-control" name="marca" value="<?= $marca ?>" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label small fw-bold">Modelo</label>
                                    <input type="text" class="form-control" name="modelo" value="<?= $modelo ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Color</label>
                                <input type="text" class="form-control" name="color" value="<?= $color ?>" required>
                            </div>

                            <div class="d-grid gap-2">
                                <?php if($botones == 2): // MODO EDICIÓN ?>
                                    <input type="submit" name="editar" value="Actualizar Datos" class="btn btn-warning fw-bold">
                                    <input type="submit" name="eliminar" value="Eliminar Vehículo" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este vehículo?');">
                                    <a href="vehiculo.php?cc=<?= $nit ?>&rebuscar=1" class="btn btn-secondary">Cancelar Edición</a>
                                <?php else: // MODO CREACIÓN ?>
                                    <input type="submit" name="guardar" value="Guardar Vehículo" class="btn btn-success">
                                <?php endif; ?>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Vehículos Registrados del Cliente</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Placa</th>
                                    <th>Tipo</th>
                                    <th>Detalles (Marca/Modelo/Color)</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($idUsuario != ""){
                                    include("../controller/conexion.php");
                                    $sqlvehiculo = "SELECT v.id_vehiculo, v.placa, v.marca, v.modelo, v.color, tv.vehiculo as tipo 
                                                    FROM vehiculo v 
                                                    INNER JOIN tipovehiculo tv ON v.id_tipovehiculo = tv.id_tipo 
                                                    WHERE v.idusuario = $idUsuario";
                                    
                                    $tablavehiculos = mysqli_query($conn, $sqlvehiculo);

                                    if(mysqli_num_rows($tablavehiculos) > 0):
                                        while($fila = mysqli_fetch_array($tablavehiculos)): ?>
                                            <tr>
                                                <td class="fw-bold text-primary"><?= strtoupper($fila['placa']) ?></td>
                                                <td><?= $fila['tipo'] ?></td>
                                                <td class="small">
                                                    <?= $fila['marca'] ?> <?= $fila['modelo'] ?> - <?= $fila['color'] ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="vehiculo.php?id=<?= $fila['id_vehiculo'] ?>&cc=<?= $nit ?>&editar=1" class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile;
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-5">
                                                Este cliente no tiene vehículos registrados aún.
                                            </td>
                                        </tr>
                                    <?php endif;
                                    mysqli_close($conn);
                                } else {
                                    echo '<tr><td colspan="4" class="text-center text-muted py-5">Utilice el buscador para ver los vehículos de un cliente.</td></tr>';
                                }
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
```