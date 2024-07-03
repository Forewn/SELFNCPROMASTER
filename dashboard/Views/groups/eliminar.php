<?php
   require '../../Config/config.php';
   $inscripcion = $_GET['code'];

   $sql = $connect->prepare("DELETE FROM inscripcion WHERE id_inscripcion = :id");
   $sql->bindParam(":id", $inscripcion, PDO::PARAM_INT);
   if($sql->execute()){
    echo 1;
   }
   else{
    echo 0;
   }
?>