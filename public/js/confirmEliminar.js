document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn_eliminar").forEach((enlace) => {
    enlace.addEventListener("click", function (e) {
      const tipo = enlace.dataset.type;

      let mensaje;
      if (tipo === "vehiculo") {
        mensaje = "¿Seguro que quieres eliminar este vehículo?\nSi está asociado a una cita, esta también se eliminará.";
      } else {
        mensaje = "¿Seguro que quieres eliminar este campo?";
      }

      if (!confirm(mensaje)) {
        e.preventDefault();
      }
    });
  });
});
