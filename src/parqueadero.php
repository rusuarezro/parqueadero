
<?php


include("../controller/conexion.php");
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Parqueadero</title>
</head>
<body>
    <?php

        if(!empty($_POST)){

       
            if(isset($_POST['Ingresar'])){

                //$id=$_POST["idusuario"];
                $idVehiculo=$_POST["idVehiculo"];  
                $idusuario=$_POST["idusuario"];
                $estadoPar=3;
                $fecha=date("Y-m-d H:i:s");
                $botones=1;

                include("../controller/conexion.php");
                $sql="INSERT INTO historial_puesto(idusuario, idvehiculo, ESTADO_FK, created_at, updated_at) ";
                $sql=$sql ."VALUE($idusuario, $idVehiculo, $estadoPar,'".$fecha."', '".$fecha."')";
                echo $sql;
                //die();
                $sqlB="SELECT * FROM historial_puesto where idvehiculo=$idVehiculo and ESTADO_FK=3";
                echo $sqlB;
                $resultadoB=mysqli_query($conn,$sqlB);
                $buscar= mysqli_fetch_assoc($resultadoB);
                if(!empty($buscar)){ 

                    echo "<script language='JavaScript'> 
                    alert('El vehiculo ya existe en la BD');
                     location.assign('parqueadero.php');
                     </script>";               

                }else{

                    $resultado= mysqli_query($conn,$sql);
                    //echo $resultado;
                    if ($resultado){
                      
                        echo "<script language='JavaScript'> 
                           alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('parqueadero.php');
                            </script>";
                    }else{
                        echo "<script language='JavaScript'> 
                            alert('ERROR: los datos no fueron ingresados a la BD');
                            location.assign('parqueadero.php');
                            </script>";
                    }
                }
               
                mysqli_close($conn);



            
            }elseif(isset($_POST['buscar'])){
                $placa=$_POST['placa'];
                include("../controller/conexion.php");
                $sql="SELECT vehiculo.marca, vehiculo.modelo, vehiculo.color, vehiculo.id_vehiculo, ";
                $sql=$sql ."tipovehiculo.vehiculo as tipo, tbusuarios.IDENTIFICACION, ";
                $sql=$sql ."tbusuarios.NOMBRES, tbusuarios.APELLIDOS, tbusuarios.CELULAR, ";
                $sql=$sql ."tbusuarios.EMAIL, tbusuarios.ESTADO_FK, tbusuarios.ID_USUARIO FROM vehiculo ";
                $sql=$sql ."INNER JOIN tipovehiculo ON vehiculo.id_vehiculo=tipovehiculo.id_tipo ";
                $sql=$sql ."INNER JOIN tbusuarios ON vehiculo.idusuario=tbusuarios.ID_USUARIO ";
                $sql=$sql ." WHERE placa='".$placa."'";
                //echo $sql;
                //die();
                $resultado= mysqli_query($conn,$sql);
                $fila=mysqli_fetch_assoc($resultado);
                //echo var_dump($fila);
                //echo print_r($fila);
                if(!empty($fila)){
                    $id=$fila["ID_USUARIO"];
                    $nit=$fila["IDENTIFICACION"];
                    $nombre=$fila["NOMBRES"];
                    $apellido=$fila["APELLIDOS"];
                    $telefono=$fila["CELULAR"];
                    $email=$fila["EMAIL"];
                    $estado=$fila["ESTADO_FK"];
                    $idusuario=$fila["ID_USUARIO"];
                    $idVehiculo=$fila["id_vehiculo"];
                    $marca=$fila["marca"];
                    $modelo=$fila["modelo"];
                    $color=$fila["color"];
                    $tipo=$fila["tipo"];
                    $botones=1;
                  

                }

                mysqli_close($conn);

            }/*elseif(isset($_POST['editar'])){
                $idVehiculo=$_POST['idVehiculo'];
                $placa=$_POST["placa"];
                $marca=$_POST["marca"];
                $modelo=$_POST["modelo"];
                $color=$_POST["color"];
                $tipo=$_POST["tipo"];
                $fecha=date("Y-m-d H:i:s"); 
                $botones=1; 

                include("../controller/conexion.php");
                $sql="UPDATE vehiculo SET placa='".$placa."', marca='".$marca."', modelo='".$modelo."', ";
                $sql=$sql ."color='".$color."', id_tipovehiculo=$tipo WHERE id_vehiculo=$idVehiculo";
                echo $sql;
                $resultado= mysqli_query($conn,$sql);
                //echo $resultado;
                if ($resultado){
                    echo "<script language='JavaScript'> 
                       alert('Los datos fueron Modificados correctamente a la BD');
                        location.assign('vehiculo.php');
                        </script>";
                }else{
                    echo "<script language='JavaScript'> 
                        alert('ERROR: los datos no fueron modificados a la BD');
                        location.assign('clientevehiculo.php');
                        </script>";
                } 
                mysqli_close($conn);

            }elseif(isset($_POST['eliminar'])){
                $idVehiculo=$_POST['idVehiculo'];


                include("../controller/conexion.php");
                $sql="DELETE FROM vehiculo Where id_vehiculo=$idVehiculo";
                echo $sql;
                $resultado= mysqli_query($conn,$sql);
                //echo $resultado;
                if ($resultado){
                    echo "<script language='JavaScript'> 
                       alert('Los datos fueron eliminados correctamente a la BD');
                        location.assign('vehiculo.php');
                        </script>";
                }else{
                    echo "<script language='JavaScript'> 
                        alert('ERROR: los datos no fueron modificados a la BD');
                        location.assign('vehiculo.php');
                        </script>";
                }
                mysqli_close($conn);
            }*/
        }
        
        /*if(!empty($_GET)){

            if(isset($_GET['editar'])){

                $nit=$_GET['cc'];
                $id=$_GET['id'];
                include("../controller/conexion.php");

                $sql="SELECT ID_USUARIO, IDENTIFICACION, NOMBRES, APELLIDOS, CELULAR, EMAIL, ESTADO_FK,"; 
                $sql= $sql ."id_vehiculo, placa, marca, modelo, color, id_tipovehiculo FROM tbusuarios "; 
                $sql= $sql ." INNER JOIN vehiculo ON tbusuarios.ID_USUARIO=vehiculo.idusuario";
                $sql= $sql ." WHERE IDENTIFICACION='".$nit."' and id_vehiculo=$id";

                //echo $sql;
                //die();
                $resultado= mysqli_query($conn,$sql);
                $fila=mysqli_fetch_assoc($resultado);
                //echo var_dump($fila);
                //echo print_r($fila);
                if(!empty($fila)){
                    $id=$fila["ID_USUARIO"];
                    $idVehiculo=$fila["id_vehiculo"];
                    $nit=$fila["IDENTIFICACION"];
                    $nombre=$fila["NOMBRES"];
                    $apellido=$fila["APELLIDOS"];
                    $telefono=$fila["CELULAR"];
                    $email=$fila["EMAIL"];
                    $estado=$fila["ESTADO_FK"];
                    $placa=$fila["placa"];
                    $marca=$fila["marca"];
                    $modelo=$fila["modelo"];
                    $color=$fila["color"];
                    $tipo=$fila["id_tipovehiculo"];
                    $botones=2;

                  }
          
             }
        }*/
    ?>

<h1>Parqueadero</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
        <input type="hidden" id="idusuario" name="idusuario" value="<?= $id ?>">
        <input type="hidden" id="idVehiculo" name="idVehiculo" value="<?= $idVehiculo ?>">      
        <p><label for="placa">Numero de placa: <input type="text" id="placa" name="placa" value="<?=$placa ?>" minlength="5" maxlength="100"><input type="submit" name="buscar" value="Buscar"></label></p>
        <p><label for="Nit">Identificacion: <?= $nit ?> </label></p>
        <p><label for="nombre">Nombres: <?= $nombre.$apellido ?> </label></p>
        <p><label for="telefono">Telefono: <?= $telefono ?></label></p>
        <p><label for="email">Email: <?= $email ?></label></p>
        <?php if($estado===0):?>
            <p><label for="email">Estado: INACTIVO</label></p>
        <?php else: ?>
            <p><label for="email">Estado: ACTIVO</label></p>
        <?php endif;?>
            <p><label for="marca">Tipo de Vehiculo: <?= $tipo ?></label></p>
            <p><label for="marca">Marca del Vehiculo: <?= $marca ?></label></p>
            <p><label for="modelo">Modelo del Vehiculo: <?= $modelo ?></label></p>
            <p><label for="color">Color del Vehiculo: <?= $color ?></label></p>
        <p>
           <input type="submit" name="Ingresar" value="Ingresar">
           <input type="submit" name="eliminar" value="Eliminar">


    </p>
        </fieldset>
    </form>

    <h1>Vehiculos clientes</h1>
    <table>
      <thead>
        <tr>
          <th>Tipo de vehiculo</th>
          <th>Placa</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Color</th>
          <th>NIT</th>
          <th>Nombre</th>
          <th>Telefono</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
             
                include("../controller/conexion.php");
                $sqlvehiculo="SELECT historial_puesto.idpuesto, historial_puesto.created_at as Fecha_Entrada, tipovehiculo.vehiculo as tipo, vehiculo.placa, ";
                $sqlvehiculo=$sqlvehiculo ."vehiculo.marca, vehiculo.modelo, vehiculo.color, tbusuarios.IDENTIFICACION, tbusuarios.NOMBRES, ";
                $sqlvehiculo=$sqlvehiculo ."tbusuarios.APELLIDOS, tbusuarios.CELULAR from historial_puesto ";
                $sqlvehiculo=$sqlvehiculo ."INNER JOIN tbusuarios ON historial_puesto.idusuario= tbusuarios.ID_USUARIO ";
                $sqlvehiculo=$sqlvehiculo ."INNER JOIN vehiculo ON historial_puesto.idvehiculo=vehiculo.id_vehiculo ";
                $sqlvehiculo=$sqlvehiculo ."INNER JOIN tipovehiculo ON vehiculo.id_tipovehiculo=tipovehiculo.id_tipo ";
                $sqlvehiculo=$sqlvehiculo ."WHERE historial_puesto.ESTADO_FK=3";
                //echo $sqlvehiculo;

                $tablavehiculos=mysqli_query($conn,$sqlvehiculo);

                while($filaVehiculo=mysqli_fetch_array($tablavehiculos)): ?>
                    <tr>
                         <td><?=$filaVehiculo['tipo'] ?></td>
                         <td><?=$filaVehiculo['placa'] ?></td>
                         <td><?=$filaVehiculo['marca'] ?></td>
                         <td><?=$filaVehiculo['modelo'] ?></td>
                         <td><?=$filaVehiculo['color'] ?></td>
                         <td><?=$filaVehiculo['IDENTIFICACION'] ?></td>
                         <td><?=$filaVehiculo['NOMBRES'] ?></td>
                         <td><?=$filaVehiculo['CELULAR'] ?></td>
                        <td>
                            <a href="factura.php?id=<?= $filaVehiculo['idpuesto'] ?>"> Egreso </a>
                            <a href="../controller/eliminar.php?id=<?= $filaVehiculo['idpuesto'] ?>"> Eliminar</a>

                        </td>
                    </tr>
                <?php endwhile;
                mysqli_close($conn);

         //mysql_close($conn);
        ?>
      </tbody>
    </table>
    

    

</body>
</html>