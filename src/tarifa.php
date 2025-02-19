<?php


include("../controller/conexion.php");
$id="";
$estado=0;
$tipo=0;
$precio=0;
$fecha="";
$vehiculo=["--Selecione--"];
$estado2=["--Selecione--", "Activo","Inactivo"];
$botones=0;


$sqltarifa="SELECT * FROM tipovehiculo";
$resultadoV= mysqli_query($conn,$sqltarifa);
while($vehiculo1=mysqli_fetch_array($resultadoV)){
   // echo '<option value="'.$vehiculo1["id_tipo"].'">'.$vehiculo1["id_tipo"].'=>'.$vehiculo1["vehiculo"].'</option>';
    array_push($vehiculo, $vehiculo1["vehiculo"]);
}

mysqli_close($conn);

//echo print_r($vehiculo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tarifa</title>
</head>
<body>
    <?php

        if(!empty($_POST)){

       
            if(isset($_POST['guardar'])){

                $tipo=$_POST['tipo'];
                $precio=$_POST['precio'];
                $estado=$_POST['estado'];
                $fecha=date("Y-m-d H:i:s"); 

                include("../controller/conexion.php");
                $sql="INSERT INTO tarifa (tipoVehiculo, precio, idestado, create_at, updated_at) ";
                $sql= $sql ."VALUES($tipo, $precio, $estado,'".$fecha."','".$fecha."')";
                echo $sql;
                $sqlB="SELECT * FROM tarifa where tipoVehiculo=$tipo and idestado=$estado ";
                echo $sqlB;
                $resultadoB=mysqli_query($conn,$sqlB);
                $buscar= mysqli_fetch_assoc($resultadoB);
                if(!empty($buscar)){ 

                    echo "<script language='JavaScript'> 
                    alert('La tarifa ya existe en la BD');
                     location.assign('tarifa.php');
                     </script>";               

                }else{

                    $resultado= mysqli_query($conn,$sql);
                    //echo $resultado;
                    if ($resultado){
                      
                        echo "<script language='JavaScript'> 
                           alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('tarifa.php');
                            </script>";
                    }else{
                        echo "<script language='JavaScript'> 
                            alert('ERROR: los datos no fueron ingresados a la BD');
                            location.assign('tarifa.php');
                            </script>";
                    }
                }
               
                mysqli_close($conn);


            }elseif(isset($_POST['editar'])){
                $id=$_POST['Id'];
                $tipo=$_POST['tipo'];
                $precio=$_POST['precio'];
                $estado=$_POST['estado'];
                $fecha=date("Y-m-d H:i:s"); 
                $botones=1; 

                include("../controller/conexion.php");
                $sql="UPDATE tarifa SET tipoVehiculo=$tipo, precio=$precio, idestado=$estado, ";
                $sql=$sql ."updated_at='".$fecha."' WHERE id_tarifa=$id";
                echo $sql;
                //die();
                $resultado= mysqli_query($conn,$sql);
                //echo $resultado;
                if ($resultado){
                    echo "<script language='JavaScript'> 
                       alert('Los datos fueron Modificados correctamente a la BD');
                        location.assign('tarifa.php');
                        </script>";
                }else{
                    echo "<script language='JavaScript'> 
                        alert('ERROR: los datos no fueron modificados a la BD');
                        location.assign('tarifa.php');
                        </script>";
                } 
                mysqli_close($conn);

            }
        }
        
        if(!empty($_GET)){

            if(isset($_GET['id'])){

                $id=$_GET['id'];
                include("../controller/conexion.php");

                $sql="SELECT * FROM tarifa WHERE id_tarifa=$id";

                //echo $sql;
                //die();
                $resultado= mysqli_query($conn,$sql);
                $fila=mysqli_fetch_assoc($resultado);
                //echo var_dump($fila);
                //echo print_r($fila);
                if(!empty($fila)){
                    $id=$fila["id_tarifa"];
                    $tipo=$fila['tipoVehiculo'];
                    $precio=$fila['precio'];
                    $estado=$fila['idestado'];                    
                    $botones=2;

                  }
          
             }
        }
    ?>

<h1>Tarifa</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
        <input type="hidden" id="Id" name="Id" value="<?= $id ?>">       
        <p><label for="tipo">Tipo de vehiculo: 
            <select id="tipo" name="tipo"> 
              <?php foreach($vehiculo as $index=> $value):?>
                <?php if($tipo==$index):?>
                    <?= "<option value='".$index."' selected>".$value."</option>"; ?>
                <?php else: ?>
                    <?= "<option value='".$index."'>".$value."</option>"; ?>
                <?php endif; ?>
              <?php endforeach;?>  
            </select>
            </label></p>
            <p><label for="precio">Precio por Hora <input type="text" id="precio" name="precio" value="<?= $precio ?>" minlength="3" maxlength="12"></label></p>
            <p><label for="estado">Estado : 
                <select id="estado" name="estado">   
                <?php foreach($estado2 as $i=> $value2):?>
                    <?php if((int)$estado==$i):?>
                        <?= "<option value='".$i."' selected>".$value2."</option>"; ?>
                    <?php else: ?>
                        <?= "<option value='".$i."'>".$value2."</option>"; ?>
                    <?php endif; ?>  
                <?php endforeach;?> 
                </select>
                </label></p>
            <p>
           <input type="submit" name="guardar" value="Guardar">
           <input type="submit" name="editar" value="Editar">



    </p>
        </fieldset>
    </form>

    <h1>Tarifas</h1>
    <table>
      <thead>
        <tr>
          <th>Tipo de vehiculo</th>
          <th>Precio</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
                include("../controller/conexion.php");
                $sqltarifa="SELECT id_tarifa, tipovehiculo.vehiculo as tipo, precio, tbestado.DESCRIPCION_EST as estado from  tarifa ";
                $sqltarifa= $sqltarifa ."INNER JOIN tipovehiculo ON tarifa.tipoVehiculo=tipovehiculo.id_tipo ";
                $sqltarifa= $sqltarifa ."INNER JOIN tbestado ON tarifa.idestado=tbestado.ID_ESTADO ";
                $sqltarifa= $sqltarifa ."WHERE idestado=1";
                //echo $sqltarifa;
                //die();
                $tablatarifa=mysqli_query($conn,$sqltarifa);

                while($filatarifa=mysqli_fetch_array($tablatarifa)): ?>
                    <tr>
                         <td><?=$filatarifa['tipo'] ?></td>
                         <td><?=$filatarifa['precio'] ?></td>
                         <td><?=$filatarifa['estado'] ?></td>
                        <td>
                            <a href="tarifa.php?id=<?= $filatarifa['id_tarifa'] ?>"> EDITAR </a>

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