<?php
// Obtener el nombre del archivo actual para saber qué opción marcar como "Activa"
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
        <i class="bi bi-p-square-fill text-warning"></i> JRParking
    </a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <li class="nav-item">
          <a class="nav-link <?= ($pagina_actual == 'index.php') ? 'active text-warning' : '' ?>" href="index.php">
            <i class="bi bi-speedometer2"></i> Inicio
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= ($pagina_actual == 'parqueadero.php') ? 'active text-warning' : '' ?>" href="parqueadero.php">
            <i class="bi bi-car-front-fill"></i> Operación (Entrada/Salida)
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= (in_array($pagina_actual, ['cliente.php', 'vehiculo.php'])) ? 'active text-warning' : '' ?>" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-database-gear"></i> Gestión
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="cliente.php"><i class="bi bi-people"></i> Clientes / Usuarios</a></li>
            <li><a class="dropdown-item" href="vehiculo.php"><i class="bi bi-car-front"></i> Vehículos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="tarifa.php"><i class="bi bi-currency-dollar"></i> Tarifas</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= ($pagina_actual == 'reporte_facturas.php') ? 'active text-warning' : '' ?>" href="consultarfactura.php">
            <i class="bi bi-file-earmark-spreadsheet"></i> Reportes
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>