<?php

  session_start();
  if(isset($_SESSION['id'])){
    header('Location: admin/pages-admin.php');
  }


  require '../Config/Config.php';



  if(isset($_POST['login'])) {
    $errMsg = '';

    // Get data from FORM
    $usuario = $_POST['usuario'];

    $clave = ($_POST['clave']);

    if($usuario == '')
      $errMsg = 'Digite su usuario';
    if($clave == '')
      $errMsg = 'Digite su contraseña';

    if($errMsg == '') {
      try {

        $stmt = $connect->prepare('SELECT a.id_usuario, a.usuario, a.password, a.id_rol, b.nombre AS nombre, b.correo 
        FROM usuarios a
        JOIN profesores b 
        ON  b.cedula_profesor = a.cedula_profesor
        WHERE usuario = :usuario');
    
        $stmt->execute(array(
        ':usuario' => $usuario
        ));
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);


        if($data == false){
          $errMsg = "Usuario $usuario no encontrado.";
        }
        else {
          if(password_verify($clave, $data['password'])) {

            $_SESSION['id'] = $data['id_usuario'];
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['usuario'] = $data['usuario'];
            $_SESSION['correo'] = $data['correo'];
            $_SESSION['clave'] = $data['password'];
            $_SESSION['rol'] = $data['id_rol'];


    if($_SESSION['rol'] == 1){
          header('Location: admin/pages-admin.php');

        }else if($_SESSION['rol'] == 2){
          header('Location: panel-cliente/cliente.php');
        }
            exit;
          }
          else
            $errMsg = 'Contraseña incorrecta.';
        }
      }
      catch(PDOException $e) {
        $errMsg = $e->getMessage();
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Escolar</title>
  <link href="../Assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="../Assets/css/awesome-bootstrap-checkbox.min.css" rel="stylesheet">
  <link href="../Assets/css/font-awesome.min.css" rel="stylesheet">
  <link href="../Assets/css/style.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="96x96" href="../Assets/img/logo.png">
</head>
<body>
  <div class="background-blur"></div>
  
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-centered">
        <div class="login-panel">
          <form method="POST" autocomplete="off" role="form">
            <h4 class="login-panel-title">Liceo Nacional Francisco de Miranda</h4>
            <p class="login-panel-tagline">Para conectarse al sistema escolar es importante solicitar un usuario a la institución.</p>
            <?php if(isset($errMsg)){ echo '<div style="color:#FF0000;text-align:center;font-size:20px;">'.$errMsg.'</div>'; } ?>
            <div class="login-panel-section">
              <div class="form-group">
                <div class="input-group margin-bottom-sm">
                  <span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
                  <input class="form-control" name="usuario" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario'] ?>" autocomplete="off" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required type="text" placeholder="Nombre del usuario">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
                  <input class="form-control" name="clave" value="<?php if(isset($_POST['clave'])) echo MD5($_POST['clave']) ?>" required type="password" placeholder="Contraseña">
                </div>
              </div>
              <div class="checkbox checkbox-circle checkbox-success checkbox-small">
                <input type="checkbox" id="checkbox1">
               <label for="checkbox1">Recuérdame</label>
              <!--   <a href="#" class="pull-right">¿Olvidaste la contraseña?</a>-->
              </div>
            </div>
            <div class="login-panel-section">
              <button type="submit" name='login' class="btn btn-default"><i class="fa fa-sign-in fa-fw" aria-hidden="true"></i> Iniciar sesión</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="../Assets/js/jquery.min.js"></script>
  <script src="../Assets/js/bootstrap.min.js"></script>
</body>
</html>