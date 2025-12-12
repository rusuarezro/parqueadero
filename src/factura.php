
<?php
date_default_timezone_set('America/Bogota'); // Ajusta a tu zona horaria si es necesario
include("../controller/conexion.php");

// --- INICIALIZACIÓN VARIABLES ---
$idparqueadero  = "";
$nitEmpresa     = "";
$razonSocial    = "";
$dirEmpresa     = "";
$telEmpresa     = "";

$idpuesto       = 0;
$nombreCli      = "";
$docCli         = "";
$telCli         = "";
$emailCli       = "";
$modelo         = "";
$marca          = "";
$placa          = "";
$tipoVehiculo   = "";
$color          = "";

$fechaEntrada   = "";
$fechaSalida    = "";
$horasTotal     = 0;
$precioHora     = 0;
$totalPagar     = 0;

// --- FUNCIÓN CALCULAR HORAS (Redondeo hacia arriba) ---
function calcularHorasCobro($inicio, $fin) {
    $dateInicio = new DateTime($inicio);
    $dateFin    = new DateTime($fin);
    
    // Diferencia total
    $diff = $dateInicio->diff($dateFin);
    
    // Horas base
    $horas = ($diff->days * 24) + $diff->h;
    
    // Si hay minutos extra (ej: 1 hora y 5 min), se cobra la siguiente hora
    if($diff->i > 0){
        $horas++;
    }
    
    // Cobro mínimo de 1 hora
    if($horas == 0){
        $horas = 1;
    }
    
    return $horas;
}

// --- LÓGICA GET (Cargar Datos para Visualizar) ---
if(!empty($_GET['id'])){
    
    $idpuesto = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Obtener Datos de la Empresa (Parqueadero)
    $sqlRazon = "SELECT * FROM tbparqueaderos WHERE ESTADO_FK=1 LIMIT 1";
    $resRazon = mysqli_query($conn, $sqlRazon);
    $filaRazon = mysqli_fetch_assoc($resRazon);
    
    if($filaRazon){
        $idparqueadero = $filaRazon['ID_PARQUEADERO'];
        $nitEmpresa    = $filaRazon['nit'];
        $razonSocial   = $filaRazon['NOMBRE'];
        $dirEmpresa    = $filaRazon['DIRECCION'];
        $telEmpresa    = $filaRazon['phone'];
    }

    // 2. Obtener Datos del Ticket/Vehículo
    $sqlHistoria = "SELECT hp.idpuesto, hp.created_at, u.NOMBRES, u.APELLIDOS, u.IDENTIFICACION, u.CELULAR, u.EMAIL, 
                    v.marca, v.modelo, v.placa, v.color, tv.vehiculo as tipo, t.precio 
                    FROM historial_puesto hp
                    INNER JOIN tbusuarios u ON hp.idusuario = u.ID_USUARIO 
                    INNER JOIN vehiculo v ON hp.idvehiculo = v.id_vehiculo 
                    INNER JOIN tipovehiculo tv ON v.id_tipovehiculo = tv.id_tipo 
                    INNER JOIN tarifa t ON tv.id_tipo = t.tipoVehiculo 
                    WHERE hp.idpuesto = '$idpuesto' AND t.idestado = 1"; // Aseguramos tarifa activa

    $resHist = mysqli_query($conn, $sqlHistoria);
    $fila = mysqli_fetch_assoc($resHist);

    if($fila){
        $nombreCli      = $fila['NOMBRES'] . " " . $fila['APELLIDOS'];
        $docCli         = $fila['IDENTIFICACION'];
        $telCli         = $fila['CELULAR'];
        $emailCli       = $fila['EMAIL'];
        
        $marca          = $fila['marca'];
        $modelo         = $fila['modelo'];
        $placa          = $fila['placa'];
        $color          = $fila['color'];
        $tipoVehiculo   = $fila['tipo'];
        
        $fechaEntrada   = $fila['created_at'];
        $fechaSalida    = date("Y-m-d H:i:s");
        $precioHora     = $fila['precio'];
        
        // Cálculos
        $horasTotal     = calcularHorasCobro($fechaEntrada, $fechaSalida);
        $totalPagar     = $horasTotal * $precioHora;
    }
}

// --- LÓGICA POST (Procesar Pago) ---
if(isset($_POST['Pagar'])){
    
    $idParq         = $_POST['idparqueadero'];
    $idHistorial    = $_POST['historial_puesto'];
    $horas          = $_POST['horas'];
    $valor          = $_POST['valor_neto'];
    $observacion    = "Salida de Vehículo";
    $fechaActual    = date("Y-m-d H:i:s"); 

    // 1. Insertar Factura
    $sqlFactura = "INSERT INTO factura (idparqueadero, id_historialpuesto, observaciones, tiempo, valor_neto, valor_pagar, created_at) 
                   VALUES ('$idParq', '$idHistorial', '$observacion', '$horas', '$valor', '$valor', '$fechaActual')";
    
    if(mysqli_query($conn, $sqlFactura)){
        
        // 2. Actualizar Historial (Liberar puesto / marcar salida)
        // Asumiendo que ESTADO_FK = 3 significa "Salida/Pagado"
        $sqlUpd = "UPDATE historial_puesto SET ESTADO_FK=3, updated_at='$fechaActual' WHERE idpuesto='$idHistorial'";
        mysqli_query($conn, $sqlUpd);

        echo "<script>
                alert('¡Pago registrado con éxito! El vehículo puede salir.');
                location.assign('parqueadero.php');
              </script>";
    } else {
        echo "<script>
                alert('Error al generar la factura. Intente nuevamente.');
                history.back();
              </script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cobro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #e9ecef; }
        .invoice-card { 
            max-width: 800px; 
            margin: auto; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); 
            border: none;
        }
        .header-bg { background-color: #2c3e50; color: white; }
        .total-box { background-color: #d1e7dd; border: 2px solid #198754; color: #146c43; }
    </style>
</head>
<body>

<div class="container py-5">
    
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="idparqueadero" value="<?= $idparqueadero ?>">
        <input type="hidden" name="historial_puesto" value="<?= $idpuesto ?>">
        <input type="hidden" name="horas" value="<?= $horasTotal ?>">
        <input type="hidden" name="valor_neto" value="<?= $totalPagar ?>">

        <div class="card invoice-card">
            <div class="card-header header-bg text-center py-4">
                <h3 class="mb-0"><i class="bi bi-receipt"></i> Recibo de Caja / Salida</h3>
                <small>Comprobante de Pago de Parqueadero</small>
            </div>

            <div class="card-body p-4">
                
                <div class="text-center mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold"><?= $razonSocial ?></h4>
                    <div class="text-muted">NIT: <?= $nitEmpresa ?></div>
                    <div class="text-muted"><i class="bi bi-geo-alt-fill"></i> <?= $dirEmpresa ?></div>
                    <div class="text-muted"><i class="bi bi-telephone-fill"></i> <?= $telEmpresa ?></div>
                </div>

                <div class="row">
                    <div class="col-md-6 border-end">
                        <h6 class="text-primary fw-bold text-uppercase mb-3">Información del Cliente</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Cliente:</strong> <?= $nombreCli ?></li>
                            <li class="mb-2"><strong>ID:</strong> <?= $docCli ?></li>
                            <li class="mb-2"><strong>Teléfono:</strong> <?= $telCli ?></li>
                            <li class="mb-2"><strong>Email:</strong> <?= $emailCli ?></li>
                        </ul>

                        <h6 class="text-primary fw-bold text-uppercase mt-4 mb-3">Datos del Vehículo</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><strong>Placa:</strong> <span class="badge bg-dark fs-6"><?= strtoupper($placa) ?></span></li>
                            <li class="mb-2"><strong>Tipo:</strong> <?= $tipoVehiculo ?></li>
                            <li class="mb-2"><strong>Detalles:</strong> <?= $marca ?> - <?= $modelo ?> (<?= $color ?>)</li>
                        </ul>
                    </div>

                    <div class="col-md-6 ps-md-4">
                        <h6 class="text-primary fw-bold text-uppercase mb-3">Detalle del Servicio</h6>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Fecha de Entrada</label>
                            <strong><?= $fechaEntrada ?></strong>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Fecha de Salida (Actual)</label>
                            <strong><?= $fechaSalida ?></strong>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tarifa por Hora:</span>
                            <span>$<?= number_format($precioHora, 0) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tiempo Cobrado:</span>
                            <span class="fw-bold"><?= $horasTotal ?> Horas</span>
                        </div>

                        <div class="total-box p-3 text-center rounded mt-4">
                            <h5 class="mb-0">Total a Pagar</h5>
                            <h2 class="fw-bold mb-0">$<?= number_format($totalPagar, 0) ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light p-3">
                <div class="row">
                    <div class="col-6">
                        <a href="parqueadero.php" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left"></i> Cancelar / Volver
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" name="Pagar" class="btn btn-success w-100 fw-bold" onclick="return confirm('¿Confirmar pago y salida del vehículo?');">
                            <i class="bi bi-cash-coin"></i> Confirmar Pago y Salida
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```