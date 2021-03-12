window.onload = function() {
    modal = document.getElementById('modalUpdate');
}

function openModal() {
    modal.style.display = "block";

    var ajax = new objetoAjax();
    var token = document.getElementById('token').getAttribute('content');
    ajax.open('POST', 'calcularTotal', true);
    var datasend = new FormData();
    datasend.append('_token', token);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            console.log(respuesta)
            document.getElementById('total').innerHTML = respuesta['total'] + ' euros';
            document.getElementById('desc').innerHTML = respuesta['desc'];
        }
    }
    ajax.send(datasend);


}

function closeModal() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function objetoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function restarUnidad(id_p,precio){
    var unidades = document.getElementById(id_p).value;
    if (unidades > 1){
        unidades --;
        // console.log(unidades)
        actualizarUnidades(unidades,id_p,precio);
    }
}

function sumarUnidad(id_p,precio){
    var unidades = document.getElementById(id_p).value;
    if (unidades < 100){
        unidades ++;
        // console.log(unidades)
        actualizarUnidades(unidades,id_p,precio);
    }
}

function actualizarUnidades(unidades,id_p,precio){
    document.getElementById(id_p).value = unidades;
    document.getElementById('pt-'+id_p).value = unidades*precio;
    precio *= unidades;
    // LLamada para actualizar la base de datos
    var ajax = new objetoAjax();
    var token = document.getElementById('token').getAttribute('content');
    ajax.open('POST', 'updateUnidad', true);
    var datasend = new FormData();
    datasend.append('id_p', id_p);
    datasend.append('unidades', unidades);
    datasend.append('precio', precio);
    datasend.append('_token', token);
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            var respuesta = JSON.parse(ajax.responseText);
            // console.log(respuesta)
        }
    }
    ajax.send(datasend);
}

