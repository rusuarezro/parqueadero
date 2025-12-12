<?php
include "menu.php";
date_default_timezone_set('America/Bogota');
include("../controller/conexion.php");

// --- INICIALIZACIÓN DE FILTROS ---
// Por defecto, mostramos las ventas del día actual
$fechaInicio = date('Y-m-d'); 
$fechaFin    = date('Y-m-d');

$totalRecaudado = 0;
$totalFacturas  = 0;

// Si el usuario filtra, actualizamos las variables
if(isset($_POST['filtrar'])){
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin    = $_POST['fecha_fin'];
}

// --- CONSULTA SQL (JOIN DE 4 TABLAS) ---
// Unimos factura -> historial -> vehiculo -> usuario para tener todos los datos
$sql = "SELECT f.id_factura, f.created_at, f.tiempo, f.valor_pagar, 
        v.placa, v.modelo, u.NOMBRES, u.APELLIDOS 
        FROM factura f
        INNER JOIN historial_puesto hp ON f.id_historialpuesto = hp.idpuesto
        INNER JOIN vehiculo v ON hp.idvehiculo = v.id_vehiculo
        INNER JOIN tbusuarios u ON hp.idusuario = u.ID_USUARIO
        WHERE DATE(f.created_at) BETWEEN '$fechaInicio' AND '$fechaFin'
        ORDER BY f.created_at DESC";

$resultado = mysqli_query($conn, $sql);

// Calcular totales antes de mostrar la tabla (para las tarjetas de resumen)
// Nota: En sistemas grandes esto se hace con una query SUM(), aquí lo hacemos en el loop visual
$datosTabla = []; // Guardamos los datos para recorrerlos dos veces si fuera necesario, o sumamos al vuelo
while($row = mysqli_fetch_assoc($resultado)){
    $datosTabla[] = $row;
    $totalRecaudado += $row['valor_pagar'];
    $totalFacturas++;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; }
        .card-stat { border-left: 5px solid; }
        .border-success { border-color: #198754 !important; }
        .border-primary { border-color: #0d6efd !important; }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-secondary"><i class="bi bi-file-earmark-spreadsheet"></i> Reporte de Facturación</h2>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="parqueadero.php" class="btn btn-outline-secondary">Volver al Parqueadero</a>
        </div>
    </div>

    <div class="row mb-4">
        
        <div class="col-lg-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-3"><i class="bi bi-funnel"></i> Filtrar por Rango de Fechas</h6>
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="row g-2 align-items-end">
                        <div class="col-4">
                            <label class="small fw-bold">Desde:</label>
                            <input type="date" class="form-control" name="fecha_inicio" value="<?= $fechaInicio ?>">
                        </div>
                        <div class="col-4">
                            <label class="small fw-bold">Hasta:</label>
                            <input type="date" class="form-control" name="fecha_fin" value="<?= $fechaFin ?>">
                        </div>
                        <div class="col-4">
                            <button type="submit" name="filtrar" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row g-3">
                <div class="col-6">
                    <div class="card card-stat border-success h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-success fw-bold text-uppercase small">Total Recaudado</h6>
                                    <h3 class="mb-0 fw-bold">$<?= number_format($totalRecaudado, 0) ?></h3>
                                </div>
                                <div class="fs-1 text-success opacity-25">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-stat border-primary h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-primary fw-bold text-uppercase small">Vehículos Salidos</h6>
                                    <h3 class="mb-0 fw-bold"><?= $totalFacturas ?></h3>
                                </div>
                                <div class="fs-1 text-primary opacity-25">
                                    <i class="bi bi-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Listado de Facturas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th># Factura</th>
                            <th>Fecha y Hora</th>
                            <th>Placa / Vehículo</th>
                            <th>Cliente</th>
                            <th class="text-center">Tiempo</th>
                            <th class="text-end pe-4">Valor Pagado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($datosTabla) > 0): ?>
                            <?php foreach($datosTabla as $fila): ?>
                                <tr>
                                    <td class="fw-bold text-muted">FAC-<?= str_pad($fila['id_factura'], 4, "0", STR_PAD_LEFT) ?></td>
                                    <td>
                                        <?= date("d/m/Y", strtotime($fila['created_at'])) ?> <br>
                                        <small class="text-muted"><?= date("h:i A", strtotime($fila['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark"><?= strtoupper($fila['placa']) ?></span>
                                        <div class="small text-muted"><?= $fila['modelo'] ?></div>
                                    </td>
                                    <td><?= $fila['NOMBRES'] ?> <?= $fila['APELLIDOS'] ?></td>
                                    <td class="text-center"><?= $fila['tiempo'] ?> Horas</td>
                                    <td class="text-end pe-4 fw-bold text-success">
                                        $<?= number_format($fila['valor_pagar'], 0) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron facturas en el rango de fechas seleccionado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light text-muted small text-end">
            Mostrando resultados del <?= date("d/m/Y", strtotime($fechaInicio)) ?> al <?= date("d/m/Y", strtotime($fechaFin)) ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Cerramos conexión al final
mysqli_close($conn);
?>