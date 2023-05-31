function startTime() {
    var hoy = new Date();
    var hora = hoy.getHours();
    var minutos = hoy.getMinutes();
    var sec = hoy.getSeconds();
    ap = (hora < 12) ? "<span style='color:white; font-size:14px'>AM</span>" : "<span style='color:white;'>PM</span>";
    hora = (hora == 0) ? 12 : hora;
    hora = (hora > 12) ? hora - 12 : hora;
    //Añadir un cero al frente de los números < 10
    hora = checkTime(hora);
    minutos = checkTime(minutos);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hora + ":" + minutos + ":" + sec + " " + ap;
    
    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    var dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    var curWeekDay = dias[hoy.getDay()];
    var curDay = hoy.getDate();
    var curMonth = meses[hoy.getMonth()];
    var curYear = hoy.getFullYear();
    var date = curWeekDay+", "+curDay;
    var date2 = curMonth+" "+curYear;
    document.getElementById("date").innerHTML = date;
    document.getElementById("date2").innerHTML = date2;
    
    var time = setTimeout(function(){ startTime() }, 500);
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}