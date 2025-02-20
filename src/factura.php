<?php

    include("../controller/conexion.php");

    $idparqueadero="";
    $nit="";
    $razon="";
    $direccion="";
    $phone="";
    $idpuesto=0;
    $nombre="";
    $cc="";
    $phonecliente="";
    $email="";

    if(!empty($_GET)){

        $sqlRazon="SELECT * FROM tbparqueaderos WHERE ESTADO_FK=1 ";
        $resultado= mysqli_query($conn,$sqlRazon);
        $fila=mysqli_fetch_assoc($resultado);
        if(!empty($fila)){
            $idparqueadero=$fila['ID_PARQUEADERO'];
            $nit=$fila['nit'];
            $razon=$fila['NOMBRE'];
            $direccion=$fila['DIRECCION'];
            $phone=$fila['phone'];
        }

        $idpuesto=$_GET['id'];

        $sqlhistoria="select historial_puesto.idpuesto, historial_puesto.created_at, ";
        $sqlhistoria=$sqlhistoria ."historial_puesto.updated_at, tbusuarios.NOMBRES as name, tbusuarios.APELLIDOS, ";
        $sqlhistoria=$sqlhistoria ."tbusuarios.IDENTIFICACION as cedula, tbusuarios.CELULAR, tbusuarios.EMAIL, ";
        $sqlhistoria=$sqlhistoria ."vehiculo.marca,vehiculo.modelo, vehiculo.placa, tipovehiculo.vehiculo ";
        $sqlhistoria=$sqlhistoria ."from historial_puesto ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN tbusuarios ON historial_puesto.idusuario=tbusuarios.ID_USUARIO ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN vehiculo ON historial_puesto.idvehiculo=vehiculo.id_vehiculo ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN tipovehiculo ON vehiculo.id_tipovehiculo=tipovehiculo.id_tipo ";
        $sqlhistoria=$sqlhistoria ." WHERE historial_puesto.idpuesto=$idpuesto";

        //echo $sqlhistoria;
       // die();

        $resultado1= mysqli_query($conn,$sqlhistoria);
        $fila1=mysqli_fetch_assoc($resultado1);
        if(!empty($fila1)){
            $nombre=$fila1['name'];
            $cc=$fila1['cedula'];
            $phonecliente=$fila1['CELULAR'];
            $email=$fila1['EMAIL'];
        }
        

    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Factura</title>
</head>
<body>

<h1>Factura</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
            <input type="hidden" id="idparqueadero" name="idparqueadero" value="<?= $id ?>">
                
            <p><label for="razon"><?= $razon ?></label></p>
            <p><label for="nit">NIT: <?= $nit ?> </label></p>
            <p><label for="direccion">Direccion: <?= $direccion ?> </label></p>
            <p><label for="telefono">Telefono: <?= $phone ?></label></p>
            <p><label for="nombre">Nombre del Cliente<?= $nombre ?></label></p>
            <p><label for="cc">Identificación: <?= $cc ?> </label></p>
            <p><label for="phone">Telefono del cliente: <?= $phonecliente ?> </label></p>
            <p><label for="email">Email: <?= $email ?></label></p>

            <p>
            <input type="submit" name="Guardar" value="Guardar">
            </p>
        </fieldset>
    </form>   

</body>
</html>