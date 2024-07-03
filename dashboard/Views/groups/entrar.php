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

            <div class="col-sm-12 p-0 d-flex justify-content-lg-end justify-content-center">

              <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                <i class="material-icons">&#xE147;</i> </a>

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

    <table>
      <thead>
        <tr>
          <th>Cedula</th>
          <th>Nombre</th>
          <th>fecha de nacimiento</th>
          <th>Representante</th>
          <th>Status</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT a.id_inscripcion, b.cedula_estudiante, b.nombres, b.fecha_nac, b.status, c.cedula_representante_legal, c.nombre FROM inscripcion a
        JOIN estudiantes b ON a.estudiantes_cedula_estudiante = b.cedula_estudiante
        JOIN representante_legal c ON c.cedula_representante_legal = a.cedula_representante
        WHERE id_seccion = :id";
        $results = $connect->prepare($query);
        $results->bindParam(':id', $id, PDO::PARAM_INT);
        $results->execute();
        $estudiantes = $results->fetchAll(PDO::FETCH_OBJ);
        foreach ($estudiantes as $estudiante) {
          echo "<tr>";
          echo "<td>" . $estudiante->cedula_estudiante . "</td>";
          echo "<td>" . $estudiante->nombres . "</td>";
          echo "<td>" . $estudiante->fecha_nac . "</td>";
          echo "<td>". $estudiante->nombre."</td>";
          echo "<td>" . $estudiante->status . "</td>";
          echo "<td onclick='deleteAlert(`$estudiante->id_inscripcion`, `$id`)'>Eliminar</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>

    <!-- add Modal HTML -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <form enctype="multipart/form-data" method="POST" autocomplete="off">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">
                <i class="fa fa-user mr-1"></i>REGISTRO DEL ALUMNOS
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="col-sm-6" style="display:none;">
                <div class="form-group">
                  <label class="control-label">Nombre de la seccion</label>
                  <input type="text" value="<?php echo $obj->idsec; ?>" name="idsec" required="" class="form-control">
                </div>
              </div>

              <div class="col-sm-12">
                <select name="cedulita" id="cedula">
                  <?php
                  $sql = "SELECT * FROM estudiantes";
                  $results = $connect->prepare($sql);
                  $results->execute();
                  $cedulas = $results->fetchAll(PDO::FETCH_OBJ);
                  foreach ($cedulas as $cedula) {
                    echo "<option value='" . $cedula->cedula_estudiante . "'>" . $cedula->nombres . "</option>";
                  }
                  ?>
                </select>
                <select name="cedula_r">
                <?php
                  $sql = "SELECT * FROM representante_legal";
                  $results = $connect->prepare($sql);
                  $results->execute();
                  $cedulas = $results->fetchAll(PDO::FETCH_OBJ);
                  foreach ($cedulas as $cedula) {
                    echo "<option value='" . $cedula->cedula_representante_legal . "'>" . $cedula->nombre . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button name='agregar' class="btn btn-primary">GUARDAR</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Edit Modal HTML -->
  </div>
</div>

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

<script src="./inscritos.js"></script>
</body>

</html>