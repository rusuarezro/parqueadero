<?php

require_once("../controller/basededatos.php");

$id="";
$nit="";
$nombre="";
$apellido="";
$telefono="";
$email="";
$pass="";
$perfil=0;
$estado=0;
$fecha="";
$perfil2=["--Selecione--", "Adminsitrador","Empleado","Cliente"];
$estado2=["--Selecione--", "Activo","Inactivo"];
$botones=0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cliente</title>
</head>
<body>
    <?php

        if(!empty($_POST)){

       
            if(isset($_POST['guardar'])){
                $nit=$_POST['nit'];
                $nombre=$_POST['nombre'];
                $apellido=$_POST['apellido'];
                $telefono=$_POST['telefono'];
                $email=$_POST['email'];
                $pass=$_POST['pass'];
                $perfil=$_POST['perfil'];
                $estado=$_POST['estado'];
                $fecha=date("Y-m-d H:i:s"); 

                $cliente=new basededatos();
                $cliente->conexion();

                $sql="INSERT INTO tbusuarios(IDENTIFICACION,NOMBRES,APELLIDOS,CELULAR,EMAIL,CONTRASENA,created_at,updated_at,PERFIL_FK,ESTADO_FK)";
                $sql= $sql ." VALUES('".$nit."','".$nombre."','".$apellido."','".$telefono."','".$email."','".$pass."','".$fecha."','".$fecha."',$perfil,$estado)";

                $sqlB="SELECT * FROM tbusuarios where IDENTIFICACION='".$nit."'";
                $buscar= $cliente->buscar($sqlB);
                if(!empty($buscar)){ 

                    echo "<script language='JavaScript'> 
                    alert('El usuario ya existe en la BD');
                     location.assign('cliente.php');
                     </script>";               

                }else{

                    $resultado=$cliente->executeQuery($sql);
                    if ($resultado){
                      
                        echo "<script language='JavaScript'> 
                           alert('Los datos fueron ingresados correctamente a la BD');
                            location.assign('cliente.php');
                            </script>";
                    }else{
                        echo "<script language='JavaScript'> 
                            alert('ERROR: los datos no fueron ingresados a la BD');
                            location.assign('cliente.php');
                            </script>";
                    }
                }
                $cliente->closeConexion();
            
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
                    $pass=$fila["CONTRASENA"];
                    $perfil=$fila["PERFIL_FK"];
                    $estado=$fila["ESTADO_FK"];
                    $botones=1;

                }

                mysqli_close($conn);

            }elseif(isset($_POST['editar'])){
                $id=$_POST['Id'];
                $nit=$_POST['nit'];
                $nombre=$_POST['nombre'];
                $apellido=$_POST['apellido'];
                $telefono=$_POST['telefono'];
                $email=$_POST['email'];
                $pass=$_POST['pass'];
                $perfil=$_POST['perfil'];
                $estado=$_POST['estado'];
                $fecha=date("Y-m-d H:i:s"); 
                $botones=1; 

                include("../controller/conexion.php");
                $sql="UPDATE tbusuarios SET IDENTIFICACION='".$nit."', NOMBRES='".$nombre."', APELLIDOS='".$apellido."',";
                $sql= $sql . "CELULAR='".$telefono."', EMAIL='".$email."', CONTRASENA='".$pass."',";
                $sql= $sql ."updated_at='".$fecha."',PERFIL_FK=$perfil,ESTADO_FK=$estado ";
                $sql= $sql ."Where ID_USUARIO=$id";
                echo $sql;
                $resultado= mysqli_query($conn,$sql);
                //echo $resultado;
                if ($resultado){
                    echo "<script language='JavaScript'> 
                       alert('Los datos fueron Modificados correctamente a la BD');
                        location.assign('cliente.php');
                        </script>";
                }else{
                    echo "<script language='JavaScript'> 
                        alert('ERROR: los datos no fueron modificados a la BD');
                        location.assign('cliente.php');
                        </script>";
                } 
                mysqli_close($conn);

            }elseif(isset($_POST['eliminar'])){
                $id=$_POST['Id'];

                include("../controller/conexion.php");
                $sql="DELETE FROM tbusuarios Where ID_USUARIO=$id";
                echo $sql;
                $resultado= mysqli_query($conn,$sql);
                //echo $resultado;
                if ($resultado){
                    echo "<script language='JavaScript'> 
                       alert('Los datos fueron eliminados correctamente a la BD');
                        location.assign('cliente.php');
                        </script>";
                }else{
                    echo "<script language='JavaScript'> 
                        alert('ERROR: los datos no fueron modificados a la BD');
                        location.assign('cliente.php');
                        </script>";
                }
                mysqli_close($conn);
            }
        }
    ?>

<h1>Cliente</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
        <input type="hidden" id="Id" name="Id" value="<?= $id ?>">    
        <p><label for="NIT">Identificacion: <input type="text" id="Nit" name="nit" value="<?= $nit ?>" minlength="5" maxlength="100"><input type="submit" name="buscar" value="Buscar"></label></p>
        <p><label for="nombre">Nombres: <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>" minlength="3" maxlength="100"></label></p>
        <p><label for="apellido">Apellidos: <input type="text" id="apellido" name="apellido" value="<?= $apellido ?>" minlength="3" maxlength="100"></label></p>
        <p><label for="telefono">Telefono: <input type="tel" id="telefono" name="telefono" value="<?= $telefono ?>" minlength="8" maxlength="10"></label></p>
        <p><label for="email">Email: <input type="email" id="email" name="email" value="<?= $email ?>" minlength="8" maxlength="80"></label></p>
        <p><label for="pass">Contrasena: <input type="password" id="pass" name="pass" value="<?=$pass?>"></label></p>
        <?php if($botones===0): ?>
            <p><label for="pass1">Confirmar Contrasena: <input type="password" id="pass1" name="pass1"></label></p>
        <?php endif; ?>
        <p><label for="perfil"> Tipo de Perfil: 
            <select id="perfil" name="perfil">
              <?= $i=0; ?>  
              <?php foreach($perfil2 as $value):?>
                <?php if((int)$perfil===$i):?>
                        <?= "<option value='".$i."' selected>".$value."</option>"; ?>
                    <?php else: ?>
                        <?= "<option value='".$i."'>".$value."</option>"; ?>
                    <?php endif; ?>
                    <?= $i++; ?> 
              <?php endforeach;?>  
            </select>
            </label></p>
            <p><label for="estado">Estado del usuario : 
                <select id="estado" name="estado">
                <?= $i=0; ?>    
                <?php foreach($estado2 as $value2):?>
                    <?php if((int)$estado===$i):?>
                        <?= "<option value='".$i."' selected>".$value2."</option>"; ?>
                    <?php else: ?>
                        <?= "<option value='".$i."'>".$value2."</option>"; ?>
                    <?php endif; ?>
                    <?= $i++; ?>    
                <?php endforeach;?> 
                </select>
                </label></p>
        <p>
         <?php if($botones===0): ?>
           <input type="submit" name="guardar" value="Guardar">
           <input type="submit" name="editar" value="Editar" disabled>
           <input type="submit" name="eliminar" value="Eliminar" disabled>
         <?php else: ?>
            <input type="submit" name="guardar" value="Guardar" disabled>
            <input type="submit" name="editar" value="Editar">
            <input type="submit" name="eliminar" value="Eliminar">
         <?php endif;?>
    </p>
        </fieldset>
    </form>

</body>
</html>