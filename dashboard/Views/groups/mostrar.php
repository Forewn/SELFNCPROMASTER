<?php include("../header.php") ?>

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
              <a href="#" class="btn btn-danger">
                <i class="material-icons">print</i> </a>
            </div>
          </div>
        </div>

        <?php 
          require '../../Config/config.php';

          // Manejar las acciones de agregar, actualizar y eliminar
          if(isset($_POST['eliminar'])){
            $idsec = trim($_POST['idsec']);
            $consulta = "DELETE FROM seccion_profesor_periodo WHERE id_seccion_profesor_periodo = :idsec";
            $sql = $connect->prepare($consulta);
            $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount() > 0){
              echo '<script type="text/javascript">
                swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
                  window.location = "mostrar.php";
                });
              </script>';
            } else {
              echo "<div class='content alert alert-danger'> No se pudo eliminar el registro  </div>";
              print_r($sql->errorInfo()); 
            }
          }

          if(isset($_POST['actualizar'])){
            $idsec = trim($_POST['idsec']); 
            $idano = trim($_POST['idano']);    
            $idseccion = trim($_POST['idseccion']);
            $idtutor = trim($_POST['idtutor']);
            $idperiodo = trim($_POST['idperiodo']);

            $consulta = "UPDATE seccion_profesor_periodo SET id_año = :idano, id_seccion = :idseccion, cedula_tutor = :idtutor, id_periodo = :idperiodo WHERE id_seccion_profesor_periodo = :idsec";
            $sql = $connect->prepare($consulta);
            $sql->bindParam(':idano', $idano, PDO::PARAM_INT);
            $sql->bindParam(':idseccion', $idseccion, PDO::PARAM_INT);
            $sql->bindParam(':idtutor', $idtutor, PDO::PARAM_INT);
            $sql->bindParam(':idperiodo', $idperiodo, PDO::PARAM_INT);
            $sql->bindParam(':idsec', $idsec, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount() > 0){
              echo '<script type="text/javascript">
                swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
                  window.location = "mostrar.php";
                });
              </script>';
            } else {
              echo "<div class='content alert alert-danger'> No se pudo actualizar el registro  </div>";
              print_r($sql->errorInfo()); 
            }
          }

          if(isset($_POST['agregar'])){
            $idano = $_POST['idano'];
            $idseccion = $_POST['idseccion'];
            $idtutor = $_POST['idtutor'];
            $idperiodo = $_POST['idperiodo'];

            $consulta = "INSERT INTO seccion_profesor_periodo (id_año, id_seccion, cedula_tutor, id_periodo) VALUES (:idano, :idseccion, :idtutor, :idperiodo)";
            $sql = $connect->prepare($consulta);
            $sql->bindParam(':idano', $idano, PDO::PARAM_INT);
            $sql->bindParam(':idseccion', $idseccion, PDO::PARAM_INT);
            $sql->bindParam(':idtutor', $idtutor, PDO::PARAM_INT);
            $sql->bindParam(':idperiodo', $idperiodo, PDO::PARAM_INT);
            $sql->execute();

            if($sql->rowCount() > 0){
              echo '<script type="text/javascript">
                swal("¡Registrado!", "Agregado correctamente", "success").then(function() {
                  window.location = "mostrar.php";
                });
              </script>';
            } else {
              echo "<div class='content alert alert-danger'> No se pudo agregar el registro  </div>";
              print_r($sql->errorInfo()); 
            }
          }

          $productosPorPagina = 5;
          $pagina = 1;
          if (isset($_GET["pagina"])) {
            $pagina = $_GET["pagina"];
          }
          $limit = $productosPorPagina;
          $offset = ($pagina - 1) * $productosPorPagina;

          $sentencia = $connect->query("SELECT count(*) AS conteo FROM seccion_profesor_periodo");
          $conteo = $sentencia->fetchObject()->conteo;
          $paginas = ceil($conteo / $productosPorPagina);

          $sentencia = $connect->prepare("SELECT a.*, b.letra, c.nombre AS nomte, d.anio AS anio, e.nombre AS periodo
                                          FROM seccion_profesor_periodo a 
                                          INNER JOIN seccion b ON a.id_seccion = b.id_seccion 
                                          INNER JOIN profesores c ON a.cedula_tutor = c.cedula_profesor 
                                          INNER JOIN anios d ON a.id_año = d.id_anio 
                                          INNER JOIN periodo_academico e ON a.id_periodo = e.id_periodo
                                          LIMIT :limit OFFSET :offset");
          $sentencia->bindParam(':limit', $limit, PDO::PARAM_INT);
          $sentencia->bindParam(':offset', $offset, PDO::PARAM_INT);
          $sentencia->execute();
          $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
        ?>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Tutor</th>
              <th>Año</th>
              <th>Sección</th>
              <th>Período</th>
              <th>Capacidad</th>
              <th>Estado</th>
              <th>Materias</th>
              <th>Alumnos</th>
              <th>Editar</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($productos as $persona){ ?>
            <tr>
              <td><?php echo $persona->nomte ?></td>
              <td><span class="badge badge-danger"><?php echo $persona->anio ?></span></td>
              <td><?php echo $persona->letra ?></td>
              <td><?php echo $persona->periodo ?></td>
              <td><?php echo "5"?></td>
              <td>Activo</td>
              <td><a href="materias.php?id=<?php echo $persona->id_seccion_profesor_periodo; ?>" class="btn btn-primary text-white"><i class='material-icons' data-toggle='tooltip' title='Entrar'>login</i></a></td>
              <td><a href="entrar.php?id=<?php echo $persona->id_seccion_profesor_periodo; ?>" class="btn btn-primary text-white"><i class='material-icons' data-toggle='tooltip' title='Entrar'>login</i></a></td>
              <td>
                <button class='btn btn-warning text-white edit-btn' onclick="editar(<?php echo $persona->id_seccion_profesor_periodo; ?>)"><i class='material-icons' data-toggle='tooltip' title='Edit'>&#xE254;</i></button>
              </td>
              <td>
                <form onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php echo $_SERVER['PHP_SELF'] ?>'>
                  <input type='hidden' name='idsec' value="<?php echo $persona->id_seccion_profesor_periodo; ?>">
                  <button name='eliminar' class='btn btn-danger text-white' onclick="borrar('<?php echo $persona->id_seccion_profesor_periodo; ?>')"><i class='material-icons' title='Delete'>&#xE872;</i></button>
                </form>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <nav aria-label="Page navigation example">
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> secciones disponibles</p>
            </div>
            <div class="col-xs-12 col-sm-6">
              <p>Página <?php echo $pagina ?> de <?php echo $paginas ?> </p>
            </div>
          </div>
          <ul class="pagination">
            <?php if ($pagina > 1) { ?>
            <li>
              <a href="./mostrar.php?pagina=<?php echo $pagina - 1 ?>">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php } ?>

            <?php for ($x = 1; $x <= $paginas; $x++) { ?>
            <li class="<?php if ($x == $pagina) echo "active" ?>">
              <a href="./mostrar.php?pagina=<?php echo $x ?>">
                <?php echo $x ?></a>
            </li>
            <?php } ?>
            <?php if ($pagina < $paginas) { ?>
            <li>
              <a href="./mostrar.php?pagina=<?php echo $pagina + 1 ?>">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>
</div>

<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="add-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="modal-header">
          <h5 class="modal-title">Agregar Sección</h5>
          <button type="button" class="close" data-dismiss="modal">&times;"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Año</label>
            <select id="add-idano" name="idano" class="form-control" required>
              <?php 
                $anos = $connect->query("SELECT * FROM anios")->fetchAll(PDO::FETCH_OBJ);
                foreach($anos as $ano){
                  echo "<option value='$ano->id_anio'>$ano->anio</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Sección</label>
            <select id="add-idseccion" name="idseccion" class="form-control" required>
              <?php 
                $secciones = $connect->query("SELECT * FROM seccion")->fetchAll(PDO::FETCH_OBJ);
                foreach($secciones as $seccion){
                  echo "<option value='$seccion->id_seccion'>$seccion->letra</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Docente</label>
            <select id="add-idtutor" name="idtutor" class="form-control" required>
              <?php 
                $profesores = $connect->query("SELECT * FROM profesores")->fetchAll(PDO::FETCH_OBJ);
                foreach($profesores as $profesor){
                  echo "<option value='$profesor->cedula_profesor'>$profesor->nombre</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Periodo Académico</label>
            <select id="add-idperiodo" name="idperiodo" class="form-control" required>
              <?php 
                $periodos = $connect->query("SELECT * FROM periodo_academico")->fetchAll(PDO::FETCH_OBJ);
                foreach($periodos as $periodo){
                  echo "<option value='$periodo->id_periodo'>$periodo->nombre</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal HTML -->
<div id="editEmployeeModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="edit-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="modal-header">
          <h5 class="modal-title">Editar Sección</h5>
          <button type="button" class="close" data-dismiss="modal">&times;"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit-idsec" name="idsec">
          <div class="form-group">
            <label>Año</label>
            <select id="edit-idano" name="idano" class="form-control" required>
              <?php 
                $anos = $connect->query("SELECT * FROM anios")->fetchAll(PDO::FETCH_OBJ);
                foreach($anos as $ano){
                  echo "<option value='$ano->id_anio'>$ano->anio</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Sección</label>
            <select id="edit-idseccion" name="idseccion" class="form-control" required>
              <?php 
                $secciones = $connect->query("SELECT * FROM seccion")->fetchAll(PDO::FETCH_OBJ);
                foreach($secciones as $seccion){
                  echo "<option value='$seccion->id_seccion'>$seccion->letra</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Docente</label>
            <select id="edit-idtutor" name="idtutor" class="form-control" required>
              <?php 
                $profesores = $connect->query("SELECT * FROM profesores")->fetchAll(PDO::FETCH_OBJ);
                foreach($profesores as $profesor){
                  echo "<option value='$profesor->cedula_profesor'>$profesor->nombre</option>";
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Periodo Académico</label>
            <select id="edit-idperiodo" name="idperiodo" class="form-control" required>
              <?php 
                $periodos = $connect->query("SELECT * FROM periodo_academico")->fetchAll(PDO::FETCH_OBJ);
                foreach($periodos as $periodo){
                  echo "<option value='$periodo->id_periodo'>$periodo->nombre</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    // Toggle sidebar
    $(".xp-menubar").on('click', function(){
      $('#sidebar').toggleClass('active');
      $('#content').toggleClass('active');
    });

    $(".xp-menubar, .body-overlay").on('click', function(){
      $('#sidebar, .body-overlay').toggleClass('show-nav');
    });

    // Edit button click
    $('.edit-btn').on('click', function(){
      var idsec = $(this).data('id');
      $.ajax({
        url: './get_section_data.php',
        type: 'POST',
        data: { idsec: idsec },
        dataType: 'json',
        success: function(data){
          console.log(data);
          $('#edit-idsec').val(data.idsec);
          $('#edit-idano').val(data.idano);
          $('#edit-idseccion').val(data.idseccion);
          $('#edit-idtutor').val(data.idtutor);
          $('#edit-idperiodo').val(data.idperiodo);
          $('#editEmployeeModal').val('show');
        }
      });
    });

    // Handle form submission for updating data
    $('#edit-form').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url: 'update_section.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response){
          swal("¡Actualizado!", "Actualizado correctamente", "success").then(function() {
            window.location = "mostrar.php";
          });
        },
        error: function(response){
          swal("¡Error!", "No se pudo actualizar el registro", "error");
        }
      });
    });

  });
</script>
<script src="./secciones.js"></script>
