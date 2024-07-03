<?php include ("../header.php") ?>

<!--------main-content------------->


<div class="main-content">
    <div class="row">

        <div class="col-md-12">
            <div class="table-wrapper">

                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6 p-0 d-flex justify-content-lg-start justify-content-center">
                            <h2 class="ml-lg-2">Sección</h2>
                        </div>

                    </div>
                </div>


                <div class="container">
                    <div class="main-body">

                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="main-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../admin/pages-admin.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="../groups/mostrar">Sección</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Secciones alumnos</li>
                            </ol>
                        </nav>
                        <!-- /Breadcrumb ------------>
                        <?php
                        require '../../Config/config.php';
                        $id = $_GET['id'];
                        ?>
                        <!-- /Breadcrumb ------------------------------------------>
                    </div>
                </div>
            </div>
        </div>
        <form action="">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Materia</th>
                        <th>Asignar</th>
                        <TH>Profesores</TH>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <?php
                        $sql = "SELECT b.materia, b.id_materia FROM seccion_profesor_periodo a
                        JOIN materias b ON b.id_anio = a.id_año
                        WHERE id_seccion_profesor_periodo = :id";
                        $sql = $connect->prepare($sql);
                        $sql->bindParam(':id', $id, PDO::PARAM_INT);
                        $sql->execute();
                        $materias = $sql->fetchAll();
                        foreach ($materias as $materia) {
                            echo "<tr>";
                            echo "<td>" . $materia->id_materia . "</td>";
                            echo "<td>" . $materia->materia . "</td>";
                            echo "<td><input type='checkbox' class='materia' id='" . $materia->id_materia . "'></td>";
                            echo "<td><select id='prof".$materia->id_materia."'>";
                            $sql = $connect->prepare("SELECT * FROM profesores");
                            $sql->execute();
                            $profesores = $sql->fetchAll();
                            foreach($profesores AS $profesor){
                                echo "<option value='".$profesor->cedula_profesor."'>".$profesor->nombre."</option>";

                            }
                            echo "</td></select>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
            <br>
            <input type="button" onclick="asignar_materias('<?php echo $id ?>')" value="Guardar" id="boton">
        </form>

    </div>
</div>
<!----------html code compleate----------->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".xp-menubar").on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });

        $(".xp-menubar,.body-overlay").on('click', function () {
            $('#sidebar,.body-overlay').toggleClass('show-nav');
        });

    });
</script>
<script type="text/javascript">

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php

if (isset($_POST['agregar'])) {

    $idsec = $id;
    $alumno = $_POST['cedulita'];
    $representante = $_POST['cedula_r'];
    // echo $item . "<br>";

    $statement = $connect->prepare("INSERT INTO inscripcion (id_seccion, estudiantes_cedula_estudiante, cedula_representante) VALUES ($idsec, '$alumno', '$representante')");
    //Execute the statement and insert our values.
    $inserted = $statement->execute();

    if ($inserted) {
        echo '<script type="text/javascript">
swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
            window.location = "mostrar.php";
        });
        </script>';
    }
}

?>

<script src="./materias.js"></script>
</body>

</html>