
<?php
include "menu.php";
include("../controller/conexion.php");

// --- INICIALIZACIÓN DE VARIABLES ---
$id         = "";
$nit        = "";
$nombre     = "";
$apellido   = "";
$telefono   = "";
$email      = "";
$pass       = "";
$perfil     = 0; // Por defecto
$estado     = 0; // Por defecto
$fecha      = "";
$botones    = 0; // 0: Creando, 1: Editando

// Arrays de opciones (Mantenidos de tu código original)
$perfil2 = ["-- Seleccione --", "Administrador", "Empleado", "Cliente"];
$estado2 = ["-- Seleccione --", "Activo", "Inactivo"];

// --- LÓGICA POST (ACCIONES) ---
if(!empty($_POST)){

    // 1. BUSCAR USUARIO POR NIT
    if(isset($_POST['buscar'])){
        $nit = $_POST['nit'];
        $sql = "SELECT * FROM tbusuarios WHERE IDENTIFICACION='$nit'";
        $resultado = mysqli_query($conn, $sql);
        $fila = mysqli_fetch_assoc($resultado);

        if(!empty($fila)){
            $id         = $fila["ID_USUARIO"];
            $nit        = $fila["IDENTIFICACION"];
            $nombre     = $fila["NOMBRES"];
            $apellido   = $fila["APELLIDOS"];
            $telefono   = $fila["CELULAR"];
            $email      = $fila["EMAIL"];
            $pass       = $fila["CONTRASENA"];
            $perfil     = $fila["PERFIL_FK"];
            $estado     = $fila["ESTADO_FK"];
            $botones    = 1; // Modo Edición
        } else {
            echo "<script>alert('Usuario no encontrado. Puede registrarlo ahora.');</script>";
        }

    // 2. GUARDAR NUEVO USUARIO
    } elseif(isset($_POST['guardar'])){
        $nit        = $_POST['nit'];
        $nombre     = $_POST['nombre'];
        $apellido   = $_POST['apellido'];
        $telefono   = $_POST['telefono'];
        $email      = $_POST['email'];
        $pass       = $_POST['pass'];
        $pass1      = $_POST['pass1']; // Confirmación
        $perfil     = $_POST['perfil'];
        $estado     = $_POST['estado'];
        $fecha      = date("Y-m-d H:i:s"); 

        // Validar contraseñas
        if($pass !== $pass1){
            echo "<script>alert('Error: Las contraseñas no coinciden.'); location.assign('cliente.php');</script>";
        } else {
            // Verificar duplicado
            $sqlB = "SELECT * FROM tbusuarios where IDENTIFICACION='$nit'";
            $resB = mysqli_query($conn, $sqlB);

            if(mysqli_num_rows($resB) > 0){ 
                echo "<script>alert('El usuario con NIT $nit ya existe.'); location.assign('cliente.php');</script>";              
            } else {
                $sql = "INSERT INTO tbusuarios(IDENTIFICACION, NOMBRES, APELLIDOS, CELULAR, EMAIL, CONTRASENA, created_at, updated_at, PERFIL_FK, ESTADO_FK) 
                        VALUES ('$nit','$nombre','$apellido','$telefono','$email','$pass','$fecha','$fecha',$perfil,$estado)";
                
                if (mysqli_query($conn, $sql)){
                    echo "<script>alert('Usuario creado correctamente'); location.assign('cliente.php');</script>";
                } else {
                    echo "<script>alert('Error al guardar en BD');</script>";
                }
            }
        }

    // 3. EDITAR USUARIO EXISTENTE
    } elseif(isset($_POST['editar'])){
        $id         = $_POST['Id'];
        $nit        = $_POST['nit']; // Normalmente el NIT no se edita, pero lo dejamos si es necesario
        $nombre     = $_POST['nombre'];
        $apellido   = $_POST['apellido'];
        $telefono   = $_POST['telefono'];
        $email      = $_POST['email'];
        $pass       = $_POST['pass'];
        $perfil     = $_POST['perfil'];
        $estado     = $_POST['estado'];
        $fecha      = date("Y-m-d H:i:s"); 

        $sql = "UPDATE tbusuarios SET IDENTIFICACION='$nit', NOMBRES='$nombre', APELLIDOS='$apellido', 
                CELULAR='$telefono', EMAIL='$email', CONTRASENA='$pass', updated_at='$fecha', 
                PERFIL_FK=$perfil, ESTADO_FK=$estado WHERE ID_USUARIO=$id";
        
        if (mysqli_query($conn, $sql)){
            echo "<script>alert('Usuario modificado correctamente'); location.assign('cliente.php');</script>";
        } else {
            echo "<script>alert('Error al modificar');</script>";
        }

    // 4. ELIMINAR USUARIO
    } elseif(isset($_POST['eliminar'])){
        $id = $_POST['Id'];
        $sql = "DELETE FROM tbusuarios Where ID_USUARIO=$id";
        
        if (mysqli_query($conn, $sql)){
            echo "<script>alert('Usuario eliminado correctamente'); location.assign('cliente.php');</script>";
        } else {
            echo "<script>alert('Error al eliminar');</script>";
        }
    }
}

// --- LÓGICA GET (Cargar datos desde la tabla lateral) ---
if(isset($_GET['id'])){
    $idSel = $_GET['id'];
    $sql = "SELECT * FROM tbusuarios WHERE ID_USUARIO=$idSel";
    $res = mysqli_query($conn, $sql);
    $fila = mysqli_fetch_assoc($res);
    if(!empty($fila)){
        $id         = $fila["ID_USUARIO"];
        $nit        = $fila["IDENTIFICACION"];
        $nombre     = $fila["NOMBRES"];
        $apellido   = $fila["APELLIDOS"];
        $telefono   = $fila["CELULAR"];
        $email      = $fila["EMAIL"];
        $pass       = $fila["CONTRASENA"];
        $perfil     = $fila["PERFIL_FK"];
        $estado     = $fila["ESTADO_FK"];
        $botones    = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
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
            <h2 class="fw-bold text-primary"><i class="bi bi-people-fill"></i> Gestión de Usuarios / Clientes</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header <?php echo ($botones == 1) ? 'bg-warning' : 'bg-primary'; ?> text-white">
                    <h5 class="mb-0">
                        <?php if($botones == 1): ?>
                            <i class="bi bi-pencil-square"></i> Editar Usuario
                        <?php else: ?>
                            <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" name="Id" value="<?= $id ?>">

                        <label class="form-label fw-bold small">Identificación (NIT/CC)</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="nit" value="<?= $nit ?>" minlength="3" maxlength="20" required placeholder="Ingrese ID">
                            <button class="btn btn-outline-secondary" type="submit" name="buscar"><i class="bi bi-search"></i></button>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label fw-bold small">Nombres</label>
                                <input type="text" class="form-control" name="nombre" value="<?= $nombre ?>" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label fw-bold small">Apellidos</label>
                                <input type="text" class="form-control" name="apellido" value="<?= $apellido ?>" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold small">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" value="<?= $telefono ?>" maxlength="15">
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= $email ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-bold small">Contraseña</label>
                            <input type="password" class="form-control" name="pass" value="<?= $pass ?>" required>
                        </div>

                        <?php if($botones === 0): ?>
                            <div class="mb-2">
                                <label class="form-label fw-bold small text-danger">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="pass1" required>
                            </div>
                        <?php endif; ?>

                        <div class="mb-2">
                            <label class="form-label fw-bold small">Perfil</label>
                            <select class="form-select" name="perfil">
                                <?php foreach($perfil2 as $i => $value): ?>
                                    <option value="<?= $i ?>" <?= ((int)$perfil === $i) ? 'selected' : '' ?>><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Estado</label>
                            <select class="form-select" name="estado">
                                <?php foreach($estado2 as $i => $value2): ?>
                                    <option value="<?= $i ?>" <?= ((int)$estado === $i) ? 'selected' : '' ?>><?= $value2 ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <?php if($botones === 0): ?>
                                <input type="submit" name="guardar" value="Guardar Usuario" class="btn btn-success">
                            <?php else: ?>
                                <input type="submit" name="editar" value="Actualizar Datos" class="btn btn-warning fw-bold">
                                <input type="submit" name="eliminar" value="Eliminar Usuario" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este usuario permanentemente?');">
                                <a href="cliente.php" class="btn btn-secondary">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Base de Datos de Usuarios</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Identificación</th>
                                    <th>Nombre Completo</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Re-incluir o usar la conexión existente para listar
                                // Nota: Asumo que $conn sigue abierta. Si connection.php la cierra, ábrela de nuevo.
                                // include("../controller/conexion.php"); 
                                
                                $sqlList = "SELECT * FROM tbusuarios ORDER BY created_at DESC LIMIT 50";
                                $resList = mysqli_query($conn, $sqlList);

                                if(mysqli_num_rows($resList) > 0):
                                    while($row = mysqli_fetch_array($resList)): 
                                        // Traducir indices a texto para la tabla
                                        $txtPerfil = isset($perfil2[$row['PERFIL_FK']]) ? $perfil2[$row['PERFIL_FK']] : 'Desconocido';
                                        $txtEstado = isset($estado2[$row['ESTADO_FK']]) ? $estado2[$row['ESTADO_FK']] : 'Desconocido';
                                        $colorEstado = ($row['ESTADO_FK'] == 1) ? 'success' : 'secondary';
                                ?>
                                    <tr>
                                        <td class="fw-bold"><?= $row['IDENTIFICACION'] ?></td>
                                        <td>
                                            <?= $row['NOMBRES'] ?> <?= $row['APELLIDOS'] ?> <br>
                                            <small class="text-muted"><?= $row['EMAIL'] ?></small>
                                        </td>
                                        <td><span class="badge bg-info text-dark"><?= $txtPerfil ?></span></td>
                                        <td><span class="badge bg-<?= $colorEstado ?>"><?= $txtEstado ?></span></td>
                                        <td class="text-center">
                                            <a href="cliente.php?id=<?= $row['ID_USUARIO'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; 
                                else: ?>
                                    <tr><td colspan="5" class="text-center py-4">No hay usuarios registrados.</td></tr>
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
