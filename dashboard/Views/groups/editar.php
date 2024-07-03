<?php

$seccion = $_GET['code'];
require '../../Config/config.php';
?>

<html>

<body>
    <form method="post" action="./mostrar.php">
        <input type="hidden" value="<?php echo 1?>" name="actualizar">
        <input type="hidden" name="idsec" value="<?php echo $seccion ?>">
        <select name="idtutor" id="tutor">
            <option value="" disabled>SELECCIONE UN TUTOR</option>
            <?php 
                $sentencia = $connect->prepare("SELECT * FROM profesores");
                $sentencia->execute();
                $profesores = $sentencia->fetchAll(PDO::FETCH_OBJ);
                foreach ($profesores as $profesor) {
                    echo "<option values='".$profesor->cedula_profesor."'>".$profesor->nombre."</option>";
                }
            ?>
        </select>
        <select name="idano" id="anio">
            <option value="" disabled>SELECCIONE UN AÑO</option>
            <?php 
                $sentencia = $connect->prepare("SELECT * FROM anios");
                $sentencia->execute();
                $anios = $sentencia->fetchAll(PDO::FETCH_OBJ);
                foreach ($anios as $anio) {
                    echo "<option values='".$anio->id_anio."'>".$anio->anio."</option>";
                }
            ?>
        </select>
        <select name="idseccion" id="seccion">
            <option value="" disabled>SELECCIONE UNA SECCION</option>
            <?php 
                $sentencia = $connect->prepare("SELECT * FROM seccion");
                $sentencia->execute();
                $secciones = $sentencia->fetchAll(PDO::FETCH_OBJ);
                foreach ($secciones as $seccion) {
                    echo "<option values='".$seccion->id_seccion."'>".$seccion->letra."</option>";
                }
            ?>
        </select>
        <select name="idperiodo" id="periodo">
            <option value="" disabled>SELECCIONE UN PERIODO</option>
            <?php 
                $sentencia = $connect->prepare("SELECT * FROM periodo_academico");
                $sentencia->execute();
                $periodos = $sentencia->fetchAll(PDO::FETCH_OBJ);
                foreach ($periodos as $periodo) {
                    echo "<option values='".$periodo->id_periodo."'>".$periodo->nombre."</option>";
                }
            ?>
        </select>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>