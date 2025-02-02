<?php
    include "conexion.php";

    if(isset($_GET['dateInicio'])&&isset($_GET['dateFin'])&&isset($_GET['timeInicio'])&&isset($_GET['timeFin'])) {
        $dateInicio = $_GET['dateInicio'];
        $timeInicio = $_GET['timeInicio'];
        $dateTimeInicio= date('Y-m-d H:i:s', strtotime("$dateInicio $timeInicio"));

        $dateFin = $_GET['dateFin'];
        $timeFin = $_GET['timeFin'];
        $dateTimeFin= date('Y-m-d H:i:s', strtotime("$dateFin $timeFin"));
  
        $fechaFiltro = $_GET['fechaFiltro'];

        $sql = "SELECT rss.categoria as categoria, count(*) as contador FROM (SELECT categorias.categoria as categoria FROM (SELECT * FROM ordenes WHERE (".$fechaFiltro." between '".$dateTimeInicio."' and '".$dateTimeFin."')) as rs, categorias WHERE rs.idCategoria=categorias.id) as rss GROUP BY rss.categoria";
    }
    $result = mysqli_query($conn, $sql);
    $datos = mysqli_fetch_all($result,MYSQLI_ASSOC);
    

    if(!empty($datos)){
        echo json_encode($datos);
    }else{
        $sql = "SELECT r.categoria as categoria, count(*) as contador FROM(SELECT categorias.categoria as categoria FROM ordenes, categorias WHERE ordenes.idCategoria=categorias.id) as r GROUP BY r.categoria";
        $result = mysqli_query($conn, $sql);
        $datos = mysqli_fetch_all($result,MYSQLI_ASSOC);
        

        echo json_encode($datos);
    }
?>