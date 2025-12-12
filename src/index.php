<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Parqueadero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-menu { transition: transform 0.2s; cursor: pointer; text-decoration: none; color: inherit; }
        .card-menu:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 3rem; margin-bottom: 15px; }
    </style>
</head>
<body>

    <?php include("menu.php"); ?>

    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h1 class="display-4 fw-bold text-primary">Bienvenido al Sistema</h1>
                <p class="lead text-muted">Seleccione una opción para comenzar</p>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-md-6 col-lg-4">
                <a href="parqueadero.php" class="card card-menu h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box text-primary"><i class="bi bi-p-square"></i></div>
                        <h4 class="card-title fw-bold">Parqueadero</h4>
                        <p class="card-text text-muted">Registrar entradas y salidas de vehículos. Control de cupos.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="consultarfactura.php" class="card card-menu h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box text-success"><i class="bi bi-cash-coin"></i></div>
                        <h4 class="card-title fw-bold">Facturación</h4>
                        <p class="card-text text-muted">Ver historial de facturas, ingresos diarios y reportes.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="cliente.php" class="card card-menu h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box text-info"><i class="bi bi-people-fill"></i></div>
                        <h4 class="card-title fw-bold">Clientes</h4>
                        <p class="card-text text-muted">Administrar usuarios, registrar nuevos clientes y editar datos.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="vehiculo.php" class="card card-menu h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box text-warning"><i class="bi bi-car-front"></i></div>
                        <h4 class="card-title fw-bold">Vehículos</h4>
                        <p class="card-text text-muted">Gestionar la base de datos de vehículos registrados.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="tarifa.php" class="card card-menu h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="icon-box text-danger"><i class="bi bi-tags-fill"></i></div>
                        <h4 class="card-title fw-bold">Tarifas</h4>
                        <p class="card-text text-muted">Configurar precios por hora según el tipo de vehículo.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>