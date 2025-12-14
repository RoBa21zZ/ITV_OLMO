/*
Este script nos permite diferenciar entre distintos tipos de botones y asi mostrar 
un mensaje de confirmacion adecuado antes de eliminar un elemento.
*/
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn_eliminar").forEach((enlace) => {
    enlace.addEventListener("click", function (e) {
      let mensaje;

      let tipo = enlace.dataset.type;

      switch (tipo) {
        case "vehiculo":
          mensaje =
            "¿Seguro que quieres eliminar este vehículo?\nSi está asociado a una cita, esta también se eliminará.";
          break;
        case "usuario":
          mensaje =
            "¿Seguro que quieres eliminar este usuario?\nSi está asociado a una cita o un vehículo estos también serán eliminados.";
          break;
        case "cita":
          mensaje = "¿Seguro que quieres eliminar esta cita?";
          break;
        case "rol":
          mensaje =
            "¿Seguro que quieres dar permisos a este usuario? \n No se podrá revertir";
          break;
        default:
          break;
      }

      if (!confirm(mensaje)) {
        e.preventDefault();
      }
    });
  });
});
