<?php
require '../../Config/config.php';

if (isset($_POST['idsec'])) {
    $idsec = trim($_POST['idsec']);
    $consulta = "SELECT * FROM seccion_profesor_periodo WHERE id_seccion_profesor_periodo = :idsec";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
}
else{
    $idsec = trim($_GET['idsec']);
    $consulta = "DELETE FROM seccion_profesor_periodo WHERE id_seccion_profesor_periodo = :idsec";
    $sql = $connect->prepare($consulta);
    $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
    if($sql->execute()){
        echo 1;
    }
    else{
        echo 0;
    }
}
?>
