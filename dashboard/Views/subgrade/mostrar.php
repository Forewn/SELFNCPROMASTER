<?php include("../header.php"); ?>
<?php
require '../../Config/config.php';

try {
    $connect = new PDO("mysql:host=".dbhost.";dbname=".dbname, dbuser, dbpass);
    $connect->query("set names utf8;");
    $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch(PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = $_POST['id_citacion'];
        // Mensaje de depuración
        error_log("Intentando eliminar la citación con ID: " . $id);

        $query = "DELETE FROM citaciones WHERE Idcitacion = :id";
        $stmt = $connect->prepare($query);

        // Comprobamos si la ejecución fue exitosa
        if ($stmt->execute(['id' => $id])) {
            echo '<script>
                    setTimeout(function(){
                        swal("Eliminada!", "La citación'.$id.' ha sido eliminada.", "success");
                    }, 500);
                  </script>';
        } else {
            echo '<script>
                    setTimeout(function(){
                        swal("Error!", "No se pudo eliminar la citación.", "error");
                    }, 500);
                  </script>';
        }
    }

    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $cedula_representante = $_POST['cedula_representante'];
        $cedula_estudiante = $_POST['cedula_estudiante'];
        $anio = $_POST['anio'];
        $seccion = $_POST['seccion'];
        $fecha = $_POST['fecha'];
        $descripcion = $_POST['descripcion'];

        $query = "INSERT INTO citaciones (Cedularepresentante, Cedulaestudiante, Anio, Seccion, Fecha, Descripcionmotivo) VALUES (:cedula_representante, :cedula_estudiante, :anio, :seccion, :fecha, :descripcion)";
        $stmt = $connect->prepare($query);
        if ($stmt->execute([
            'cedula_representante' => $cedula_representante,
            'cedula_estudiante' => $cedula_estudiante,
            'anio' => $anio,
            'seccion' => $seccion,
            'fecha' => $fecha,
            'descripcion' => $descripcion
        ])) {
            echo '<script>
                    setTimeout(function(){
                        swal("Agregada!", "La citación ha sido agregada.", "success");
                    }, 500);
                  </script>';
        } else {
            echo '<script>
                    setTimeout(function(){
                        swal("Error!", "No se pudo agregar la citación.", "error");
                    }, 500);
                  </script>';
        }
    }
}

$query = "SELECT c.*, r.nombre AS representante_nombre, s.letra, e.nombres AS estudiante_nombre
          FROM citaciones c
          JOIN representante_legal r ON c.Cedularepresentante = r.cedula_representante_legal
          JOIN estudiantes e ON c.Cedulaestudiante = e.cedula_estudiante
          JOIN seccion s ON s.id_seccion = c.Seccion";
$stmt = $connect->prepare($query);
$stmt->execute();
$citations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$representante_query = "SELECT cedula_representante_legal, nombre FROM representante_legal";
$representante_result = $connect->query($representante_query);

$estudiantes_query = "SELECT cedula_estudiante, nombres FROM estudiantes";
$estudiantes_result = $connect->query($estudiantes_query);

$anios_query = "SELECT id_anio, anio FROM anios";
$anios_result = $connect->query($anios_query);

$seccion_query = "SELECT id_seccion, letra FROM seccion";
$seccion_result = $connect->query($seccion_query);
?>

<body>
    <div class="container">
        <h2 class="mt-4">Gestión de Citaciones</h2>
        <div class="text-right mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addCitationModal">Agregar Citación</button>
            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre Representante</th>
                        <th>Nombre Estudiante</th>
                        <th>Año</th>
                        <th>Sección</th>
                        <th>Fecha</th>
                
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="citationTableBody">
                    <?php foreach ($citations as $citation): ?>
                        <tr>
                            <td><?php echo $citation['representante_nombre']; ?></td>
                            <td><?php echo $citation['estudiante_nombre']; ?></td>
                            <td><?php echo $citation['Anio']; ?></td>
                            <td><?php echo $citation['letra']; ?></td>
                            <td><?php echo $citation['Fecha']; ?></td>
                         
                            <td>
                                <a href="#deleteCitationModal" class="delete" data-toggle="modal" onclick="useId(this)" data-id="<?php echo $citation['Idcitacion']; ?>"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                <a href="plantilla.php?id=<?php echo $citation['Idcitacion']; ?>" class="print" data-toggle="tooltip" title="Print"><i class="material-icons">&#xE8AD;</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="addCitationModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm" method="POST">
                    <div class="modal-header">						
                        <h4 class="modal-title">Agregar Citación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <div class="form-group">
                            <label>Nombre Representante</label>
                            <select name="cedula_representante" class="form-control">
                                <?php while($row = $representante_result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $row['cedula_representante_legal']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre Estudiante</label>
                            <select name="cedula_estudiante" class="form-control">
                                <?php while($row = $estudiantes_result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $row['cedula_estudiante']; ?>"><?php echo $row['nombres']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Año</label>
                            <select name="anio" class="form-control">
                                <?php while($row = $anios_result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $row['id_anio']; ?>"><?php echo $row['anio']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sección</label>
                            <select name="seccion" class="form-control">
                                <?php while($row = $seccion_result->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $row['id_seccion']; ?>"><?php echo $row['letra']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción del Motivo</label>
                            <textarea name="descripcion" class="form-control" required></textarea>
                        </div>					
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="add">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Agregar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="deleteCitationModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    <div class="modal-header">						
                        <h4 class="modal-title">Eliminar Citación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">					
                        <p>¿Está seguro que desea eliminar esta citación?</p>
                        <p class="text-warning"><small>Esta acción no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_citacion" id="deleteId">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-danger" name="voton_citacion" value="Eliminar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#deleteCitationModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id_citacion');
            var modal = $(this);
            modal.find('#deleteId').val(id);
        });
    </script>
</body>
</html>

<script src="../../Assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../../Assets/js/popper.min.js"></script>
<script src="../../Assets/js/bootstrap-1.min.js"></script>
<script src="../../Assets/js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    function useId(element){
        document.getElementById('deleteId').value = element.dataset.id;
    }
</script>