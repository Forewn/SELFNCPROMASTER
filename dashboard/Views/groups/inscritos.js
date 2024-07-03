function deleteAlert(code, id) {
    swal({
        title: "Eliminar",
        text: "Esta seguro de que desea eliminar este estudiante de la seccio?",
        icon: "warning",
        buttons: {
            cancel: "Cancelar",
            confirm: {
                text: "Aceptar",
                value: "accept",
            }
        }
    }).then((value) => {
        if (value === "accept") {
            swal("Acción aceptada", "El código ha sido eliminado.", "success");
            let request = new XMLHttpRequest()
            request.open('GET', `./eliminar.php?code=${code}`);
            request.onload = function () {
                if (this.responseText == 0) {
                    swal({
                        title: "Error",
                        icon: "error",
                        text: "No se ha podido eliminar el estudiante"
                    })
                }
                else {
                    swal({
                        title: "Eliminacion exitosa!",
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "Aceptar",
                                value: "accept",
                            }
                        }
                    }).then((value) => {
                        if (value == "accept") {
                            window.location.href = "./entrar.php?id=" + id
                        }
                    }
                    )
                }
            }
            request.send();
        } else {
            swal("Acción cancelada", "El código no ha sido eliminado.", "warning");
        }
    });
}
