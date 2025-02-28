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
    $modelo="";
    $marca="";
    $placa='';
    $fechaentrada="";
    $fechasalida="";
    $horastranscurridas=0;
    $precio=0;
    $valorpaga=0;



    function calcularHoras($fechaInicio, $fechaFin) {
        // Crear objetos DateTime a partir de las cadenas de fecha
        $inicio = new DateTime($fechaInicio);
        $fin = new DateTime($fechaFin);
    
        // Calcular la diferencia entre las fechas
        $diferencia = $inicio->diff($fin);
    
        // Obtener la diferencia en horas
        $horas = ($diferencia->days * 24) + $diferencia->h;
    
        return $horas;
    }


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
        $sqlhistoria=$sqlhistoria ."vehiculo.marca,vehiculo.modelo, vehiculo.placa, tipovehiculo.vehiculo, tarifa.precio ";
        $sqlhistoria=$sqlhistoria ."from historial_puesto ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN tbusuarios ON historial_puesto.idusuario=tbusuarios.ID_USUARIO ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN vehiculo ON historial_puesto.idvehiculo=vehiculo.id_vehiculo ";
        $sqlhistoria=$sqlhistoria ."INNER JOIN tipovehiculo ON vehiculo.id_tipovehiculo=tipovehiculo.id_tipo ";
        $sqlhistoria=$sqlhistoria ." INNER JOIN tarifa ON tipovehiculo.id_tipo=tarifa.tipoVehiculo ";
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
            $marca=$fila1['marca'];
            $modelo=$fila1['modelo'];
            $placa=$fila1['placa'];
            $fechaentrada=$fila1['created_at'];
            $fechasalida=date("Y-m-d H:i:s");
            $horasTranscurridas = calcularHoras($fechaentrada, $fechasalida);
            $precio=$fila1['precio'];
            $valorpaga=$horasTranscurridas*$precio;

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
            <p><label for="nombre">Nombre del Cliente: <?= $nombre ?></label></p>
            <p><label for="cc">Identificación: <?= $cc ?> </label></p>
            <p><label for="phone">Telefono del cliente: <?= $phonecliente ?> </label></p>
            <p><label for="email">Email: <?= $email ?></label></p>
            <p><label for="nombre">Placa :<?= $placa ?></label></p>
            <p><label for="cc">Marca: <?= $marca ?> </label></p>
            <p><label for="modelo">Modelo: <?= $modelo ?> </label></p>
            <p><label for="fechaentrada">Fecha de Entrada: <?= $fechaentrada ?></label></p>
            <p><label for="fechasalida">Fecha de Salida <?= $fechasalida ?> </label></p>
            <p><label for="hora">Hora: <?= $horasTranscurridas ?></label></p>
            <p><label for="valor">Valor a pagar: <?= $valorpaga
             ?></label></p>

            <p>
            <input type="submit" name="Guardar" value="Guardar">
            </p>
        </fieldset>
    </form>   

</body>
</html>