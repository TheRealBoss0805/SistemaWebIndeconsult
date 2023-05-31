ruta = $(".ruta").val();

if(ruta==null){
    ruta = "inicio";
}else if(ruta == "entradas" || ruta == "crear-entrada" || ruta == "reportes-entradas" || ruta == "detalle-entradas"){
 ruta = "entradas";
}else if(ruta == "salidas" || ruta == "crear-salida" || ruta == "reportes-salidas" || ruta == "detalle-salidas"){
    ruta = "salidas";
}

lista = $("#"+ruta);
lista.addClass("active");