<?php 

class basededatos{
    
    private $db_host; //Lugar o IP donde esta el servidor de Base de datos
    private $db_user; // dbRusuarezrO Nombre del usuario para conectarnos a la base de datos 
    private $db_pass; // rusuarezro123 Contraseña del Usuario de la Base de datos
    private $db_name; // Nombre de la Base de Datos
    private $conn;
    private $resultado;
    private $buscar;

    public function __construct($db_host="localhost:3306", $db_user="nisbeth", $db_pass="pass12345", $db_name="dbjrparking"){
        $this->db_host=$db_host;
        $this->db_user=$db_user;
        $this->db_pass=$db_pass;
        $this->db_name=$db_name;
    }
  

    public function conexion(){

        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        // Verificar la conexión
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //echo "Conexión exitosa a la base de datos.";
      
    }

    public function buscar($sql){

        $resultado=mysqli_query($this->conn,$sql);
        return $buscar= mysqli_fetch_assoc($resultado);

    }

    public function executeQuery($sql){

        return $resultado= mysqli_query($this->conn,$sql);

    }

    public function closeConexion(){
        
        mysqli_close($this->conn);
    }
  
  
  }
  