<?php
include "menu.php";
require_once("../controller/basededatos.php");

// Inicialización de variables
$id="";
$idusuario="";
$idVehiculo='';
$nit="";
$nombre="";
$apellido="";
$telefono="";
$email="";
$estado=0;
$fecha="";
$botones=0;
$placa="";
$marca="";
$modelo="";
$color="";
$tipo="";

// --- LÓGICA PHP ---
if(!empty($_POST)){

    // CASO 1: PRESIONÓ INGRESAR
    if(isset($_POST['Ingresar'])){
        $idVehiculo = $_POST["idVehiculo"];  
        $idusuario  = $_POST["idusuario"];
        $estadoPar  = 4;
        $fecha      = date("Y-m-d H:i:s");

        include("../controller/conexion.php");
        
        // Verificar si ya existe
        $sqlB="SELECT * FROM historial_puesto where idvehiculo='$idVehiculo' and ESTADO_FK=4";
        $resultadoB = mysqli_query($conn, $sqlB);
        $buscar     = mysqli_fetch_assoc($resultadoB);

        if(!empty($buscar)){ 
             echo "<script>alert('El vehículo ya está dentro del parqueadero'); location.assign('parqueadero.php');</script>";              
        } else {
             $sql="INSERT INTO historial_puesto(idusuario, idvehiculo, ESTADO_FK, created_at, updated_at) VALUES ($idusuario, $idVehiculo, $estadoPar, '$fecha', '$fecha')";
             $resultado = mysqli_query($conn, $sql);
             
             if ($resultado){
                 echo "<script>alert('Ingreso registrado correctamente'); location.assign('parqueadero.php');</script>";
             } else {
                 echo "<script>alert('ERROR al ingresar'); location.assign('parqueadero.php');</script>";
             }
        }
        mysqli_close($conn);

    // CASO 2: PRESIONÓ BUSCAR
    } elseif(isset($_POST['buscar'])){
        $placa = $_POST['placa'];
        include("../controller/conexion.php");
        
         $sql="SELECT vehiculo.marca, vehiculo.modelo, vehiculo.color, vehiculo.id_vehiculo, ";
                $sql=$sql ."tipovehiculo.vehiculo as tipo, tbusuarios.IDENTIFICACION, ";
                $sql=$sql ."tbusuarios.NOMBRES, tbusuarios.APELLIDOS, tbusuarios.CELULAR, ";
                $sql=$sql ."tbusuarios.EMAIL, tbusuarios.ESTADO_FK, tbusuarios.ID_USUARIO FROM vehiculo ";
                $sql=$sql ."INNER JOIN tipovehiculo ON vehiculo.id_tipovehiculo=tipovehiculo.id_tipo ";
                $sql=$sql ."INNER JOIN tbusuarios ON vehiculo.idusuario=tbusuarios.ID_USUARIO ";
                $sql=$sql ." WHERE vehiculo.placa='".$placa."'";
        ///echo($sql);
        //die();

        $resultado = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($resultado);

         //echo var_dump($fila);
        //die();
                //echo print_r($fila);

        if(!empty($fila)){
            $id         = $fila["ID_USUARIO"];
            $nit        = $fila["IDENTIFICACION"];
            $nombre     = $fila["NOMBRES"];
            $apellido   = $fila["APELLIDOS"];
            $telefono   = $fila["CELULAR"];
            $email      = $fila["EMAIL"];
            $estado     = $fila["ESTADO_FK"];
            $idusuario  = $fila["ID_USUARIO"];
            $idVehiculo = $fila["id_vehiculo"];
            $marca      = $fila["marca"];
            $modelo     = $fila["modelo"];
            $color      = $fila["color"];
            $tipo       = $fila["tipo"];
            $botones    = 1;
        } else {
             // Opcional: Avisar si no se encontró
             echo "<script>alert('Placa no encontrada o usuario inactivo');</script>";
        }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Parqueadero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .table thead { background-color: #212529; color: white; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-primary"><i class="bi bi-p-square-fill"></i> Gestión de Parqueadero</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Buscar Vehículo</h5>
                </div>
                <div class="card-body">
                    
                    <form action="" method="POST" class="mb-3">
                        <label for="placa" class="form-label fw-bold">Placa del vehículo:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="placa" value="<?=$placa ?>" placeholder="Ej: ABC-123" required>
                            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>

                    <hr>

                    <form action="" method="POST">
                        <input type="hidden" name="idusuario" value="<?= $idusuario ?>">
                        <input type="hidden" name="idVehiculo" value="<?= $idVehiculo ?>">      

                        <div class="mb-2"><strong>Cliente:</strong> <?= $nombre ? $nombre." ".$apellido : '<span class="text-muted">---</span>' ?></div>
                        <div class="mb-2"><strong>Cédula:</strong> <?= $nit ?: '---' ?></div>
                        <div class="mb-2"><strong>Teléfono:</strong> <?= $telefono ?: '---' ?></div>
                        
                        <div class="p-2 bg-light border rounded mt-3">
                            <h6 class="text-secondary small text-uppercase">Vehículo</h6>
                            <div class="d-flex justify-content-between">
                                <span><strong>Marca:</strong> <?= $marca ?: '---' ?></span>
                                <span><strong>Color:</strong> <?= $color ?: '---' ?></span>
                            </div>
                            <div><strong>Tipo:</strong> <?= $tipo ?: '---' ?></div>
                        </div>

                        <div class="mt-3 text-center">
                            <?php if($estado===0 && $nit==""): ?>
                                <span class="badge bg-secondary w-100 py-2">Esperando búsqueda...</span>
                            <?php elseif($estado===0):?>
                                <span class="badge bg-danger w-100 py-2">USUARIO INACTIVO</span>
                            <?php else: ?>
                                <span class="badge bg-success w-100 py-2">USUARIO ACTIVO</span>
                            <?php endif;?>
                        </div>

                        <?php if($idVehiculo != ""): ?>
                        <div class="d-grid gap-2 mt-4">
                            <input type="submit" name="Ingresar" value="Registrar Ingreso" class="btn btn-success btn-lg">
                        </div>
                        <?php endif; ?>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Vehículos Estacionados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Placa</th>
                                    <th>Detalles</th>
                                    <th>Propietario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                include("../controller/conexion.php");
                                $sqlvehiculo="SELECT hp.idpuesto, hp.created_at, tv.vehiculo as tipo, v.placa, v.marca, v.modelo, v.color, u.IDENTIFICACION, u.NOMBRES, u.APELLIDOS, u.CELULAR 
                                              FROM historial_puesto hp
                                              INNER JOIN tbusuarios u ON hp.idusuario = u.ID_USUARIO 
                                              INNER JOIN vehiculo v ON hp.idvehiculo = v.id_vehiculo 
                                              INNER JOIN tipovehiculo tv ON v.id_tipovehiculo = tv.id_tipo 
                                              WHERE hp.ESTADO_FK=4 ORDER BY hp.created_at DESC";
                                
                                $tablavehiculos=mysqli_query($conn,$sqlvehiculo);

                                while($fila=mysqli_fetch_array($tablavehiculos)): ?>
                                <tr>
                                    <td><?= $fila['tipo'] ?></td>
                                    <td class="fw-bold"><?= $fila['placa'] ?></td>
                                    <td class="small"><?= $fila['marca'] ?> <br> <?= $fila['color'] ?></td>
                                    <td class="small">
                                        <?= $fila['NOMBRES'] ?> <br>
                                        <span class="text-muted"><?= $fila['CELULAR'] ?></span>
                                    </td>
                                    <td>
                                        <a href="factura.php?id=<?= $fila['idpuesto'] ?>" class="btn btn-sm btn-outline-primary" title="Salida"><i class="bi bi-box-arrow-right"></i></a>
                                        <a href="eliminar.php?id=<?= $fila['idpuesto'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar?')" title="Borrar"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endwhile; mysqli_close($conn); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>