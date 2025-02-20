<?php

    include("../controller/conexion.php");

    $idparqueadero="";
    $nit="";
    $razon="";
    $direccion="";
    $phone="";
    $idpuesto=0;

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

            <p>
            <input type="submit" name="Guardar" value="Guardar">
            </p>
        </fieldset>
    </form>   

</body>
</html>