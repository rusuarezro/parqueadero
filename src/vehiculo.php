<?php


include("../controller/conexion.php");
$id="";
$nit="";
$nombre="";
$apellido="";
$telefono="";
$email="";
//$perfil=0;
$estado=0;
$fecha="";
$vehiculo=["--Selecione--"];
$botones=0;
$placa="";
$marca="";
$modelo="";
$color="";
$tipo="";
$idVehiculo='';

$sqlvehiculo="SELECT * FROM tipovehiculo";
$resultadoV= mysqli_query($conn,$sqlvehiculo);
while($vehiculo1=mysqli_fetch_array($resultadoV)){
   // echo '<option value="'.$vehiculo1["id_tipo"].'">'.$vehiculo1["id_tipo"].'=>'.$vehiculo1["vehiculo"].'</option>';
    array_push($vehiculo, $vehiculo1["vehiculo"]);
}

//$vehiculo1=mysqli_fetch_assoc($resultadoV);
//echo var_dump($vehiculo1);
mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vehiculo</title>
</head>
<body>
    <?php

        if(!empty($_POST)){

       
            if(isset($_POST['guardar'])){

                $id=$_POST['Id'];
                $placa=$_POST['placa'];
                $marca=$_POST['marca'];
                $modelo=$_POST['modelo'];
                $color=$_POST['color'];
                $fecha=date("Y-m-d H:i:s"); 
                $tipovehiculo=$_POST['tipo'];

                include("../controller/conexion.php");
                $sql="INSERT INTO vehiculo (placa,marca,modelo,color,idusuario,id_tipovehiculo,created_at,updated_at)";
                $sql= $sql ." VALUES('".$placa."','".$marca."','".$modelo."','".$color."',".$id.",".$tipovehiculo.",'".$fecha."','".$fecha."')";
                echo $sql;
                $sqlB="SELECT * FROM vehiculo where placa='".$placa."'";
                echo $sqlB;
                $resultadoB=mysqli_query($conn,$sqlB);
                $buscar= mysqli_fetch_assoc($resultadoB);
                if(!empty($buscar)){ 

                    echo "<script language='JavaScript'> 
                    alert('El vehiculo ya existe en la BD');
                     location.assign('vehiculo.php');
                     </script>";               

                }else{

                    $resultado= mysqli_query($conn,$sql);
                    //echo $resultado;
                    if ($resultado){
                      
                        echo "<script language='JavaScript'> 
                           alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('vehiculo.php');
                            </script>";
                    }else{
                        echo "<script language='JavaScript'> 
                            alert('ERROR: los datos no fueron ingresados a la BD');
                            location.assign('vehiculo.php');
                            </script>";
                    }
                }
               
                mysqli_close($conn);



            
            }elseif(isset($_POST['buscar'])){
                $nit=$_POST['nit'];
                include("../controller/conexion.php");
                $sql="SELECT * FROM tbusuarios WHERE IDENTIFICACION='".$nit."'";
                //echo $sql;
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
                    $botones=1;
                  

                }

                mysqli_close($conn);

            }elseif(isset($_POST['editar'])){
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
            }
        }
        
        if(!empty($_GET)){

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
        }
    ?>

<h1>Vehiculo</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
        <input type="hidden" id="Id" name="Id" value="<?= $id ?>">
        <input type="hidden" id="idVehiculo" name="idVehiculo" value="<?= $idVehiculo ?>">      
        <p><label for="NIT">Identificacion: <input type="text" id="Nit" name="nit" value="<?= $nit ?>" minlength="5" maxlength="100"><input type="submit" name="buscar" value="Buscar"></label></p>
        <p><label for="nombre">Nombres: <?= $nombre.$apellido ?> </label></p>
        <p><label for="telefono">Telefono: <?= $telefono ?></label></p>
        <p><label for="email">Email: <?= $email ?></label></p>
        <?php if($estado===0):?>
            <p><label for="email">Estado: INACTIVO</label></p>
        <?php else: ?>
            <p><label for="email">Estado: ACTIVO</label></p>
        <?php endif;?>
       
        <p><label for="tipo">Tipo de vehiculo: 
            <select id="tipo" name="tipo"> 
              <?php foreach($vehiculo as $index=> $value):?>
                <?php if((int)$tipo==$index):?>
                    <?= "<option value='".$index."' selected>".$value."</option>"; ?>
                <?php else: ?>
                    <?= "<option value='".$index."'>".$value."</option>"; ?>
                <?php endif; ?>
              <?php endforeach;?>  
            </select>
            </label></p>
            <p><label for="placa">Placa de Vehiculo: <input type="text" id="placa" name="placa" value="<?= $placa ?>" minlength="3" maxlength="12"></label></p>
            <p><label for="marca">Marca del Vehiculo: <input type="text" id="marca" name="marca" value="<?= $marca ?>" minlength="3" maxlength="20"></label></p>
            <p><label for="modelo">Modelo del Vehiculo: <input type="text" id="modelo" name="modelo" value="<?= $modelo ?>" minlength="3" maxlength="20"></label></p>
            <p><label for="color">Color del Vehiculo: <input type="text" id="color" name="color" value="<?= $color ?>" minlength="3" maxlength="20"></label></p>
        <p>
           <input type="submit" name="guardar" value="Guardar">
           <input type="submit" name="editar" value="Editar">
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
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
              if($id!=""){
                include("../controller/conexion.php");
                $sqlvehiculo="SELECT id_vehiculo, placa, marca, modelo, color, tipovehiculo.vehiculo as tipo ";
                $sqlvehiculo= $sqlvehiculo ."FROM vehiculo INNER JOIN tipovehiculo ON vehiculo.id_tipovehiculo=tipovehiculo.id_tipo ";
                $sqlvehiculo= $sqlvehiculo ."WHERE idusuario=$id";
                //echo $sqlvehiculo;
                $tablavehiculos=mysqli_query($conn,$sqlvehiculo);

                while($filaVehiculo=mysqli_fetch_array($tablavehiculos)): ?>
                    <tr>
                         <td><?=$filaVehiculo['tipo'] ?></td>
                         <td><?=$filaVehiculo['placa'] ?></td>
                         <td><?=$filaVehiculo['marca'] ?></td>
                         <td><?=$filaVehiculo['modelo'] ?></td>
                         <td><?=$filaVehiculo['color'] ?></td>
                        <td>
                            <a href="vehiculo.php?id=<?= $filaVehiculo['id_vehiculo'] ?>&cc=<?= $nit ?>&editar=1"> EDITAR </a>

                        </td>
                    </tr>
                <?php endwhile;
                mysqli_close($conn);
            }

         //mysql_close($conn);
        ?>
      </tbody>
    </table>
    

    

</body>
</html>