<?php
$id_seccion = $_POST['seccion'];
$id_materia = $_POST['materia'];
$profesor = $_POST['profesor'];

require '../../Config/config.php';

// Verificar si el profesor ya está asociado con la materia
$sql = "SELECT * FROM profesores_materias WHERE profesores_cedula_profesor = :profesor AND materias_id_materia = :materia";
$result = $connect->prepare($sql);
$result->bindParam(':profesor', $profesor, PDO::PARAM_INT);
$result->bindParam(':materia', $id_materia, PDO::PARAM_INT);
$result->execute();

if ($result->rowCount() == 0) {
    // Insertar la relación si no existe
    $sql = "INSERT INTO profesores_materias (profesores_cedula_profesor, materias_id_materia) VALUES(:profesor, :materia)";
    $result = $connect->prepare($sql);
    $result->bindParam(':profesor', $profesor, PDO::PARAM_INT);
    $result->bindParam(':materia', $id_materia, PDO::PARAM_INT);
    $result->execute();
}

// Obtener el id_profesor_materia recién insertado o existente
$sql = "SELECT id_profesor_materia FROM profesores_materias WHERE profesores_cedula_profesor = :profesor AND materias_id_materia = :materia";
$result = $connect->prepare($sql);
$result->bindParam(':profesor', $profesor, PDO::PARAM_INT);
$result->bindParam(':materia', $id_materia, PDO::PARAM_INT);
$result->execute();
$alo = $result->fetch(PDO::FETCH_ASSOC);
$id_profesor_materia = $alo['id_profesor_materia'];

// Verificar si la relación con la sección ya existe utilizando JOIN
$sql = "SELECT pms.* FROM profesor_materias_seccion pms
        JOIN profesores_materias pm ON pms.id_profesor_materia = pm.id_profesor_materia
        WHERE pms.id_seccion_profesor_periodo = :id AND pm.materias_id_materia = :materia";
$result = $connect->prepare($sql);
$result->bindParam(':id', $id_seccion, PDO::PARAM_INT);
$result->bindParam(':materia', $id_materia, PDO::PARAM_INT);
$result->execute();

if ($result->rowCount() == 0) {
    // Insertar la relación si no existe
    $sql = "INSERT INTO profesor_materias_seccion (id_seccion_profesor_periodo, id_profesor_materia) VALUES(:id, :materia_prof)";
} else {
    // Actualizar la relación si existe
    $sql = "UPDATE profesor_materias_seccion SET id_profesor_materia = :materia_prof WHERE id_seccion_profesor_periodo = :id";
}
$result = $connect->prepare($sql);
$result->bindParam(':id', $id_seccion, PDO::PARAM_INT);
$result->bindParam(':materia_prof', $id_profesor_materia, PDO::PARAM_INT);

if ($result->execute()) {
    echo 1;
} else {
    echo 0;
}
?>