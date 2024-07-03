function borrar(id){
    let request = new XMLHttpRequest();
    request.open('GET', `./get_section_data.php?idsec=${id}`);
    request.onload = function (){
        if(this.responseText == 1){
            swal("¡Eliminado!", "Eliminado correctamente", "success").then(function() {
                window.location = "mostrar.php";
              });
        }
        else{
            swal("¡Error!", "No se pudo eliminar el registro", "error");
        }
    }
    request.send();
}

function editar(code){
    window.location.href = "./editar.php?code="+code;
}