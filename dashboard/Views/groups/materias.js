function asignar_materias(id){
    let materias = document.querySelectorAll('.materia');

    materias.forEach(materia => {
        if(materia.checked){
            let profesor = document.getElementById('prof'+materia.id);
            let request = new XMLHttpRequest();
            request.open('POST', './asignar_materias.php');
            request.setRequestHeader('content-type', 'application/x-www-form-urlencoded')
            request.onload = function (){
                console.log(this.responseText);
            }
            request.send(`materia=${materia.id}&seccion=${id}&profesor=${profesor.value}`);
        }
    });
}