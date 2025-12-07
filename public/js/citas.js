document.addEventListener("DOMContentLoaded", function () {
  const fechaInput = document.getElementById("fecha_cita");
  const horaSelect = document.getElementById("hora_cita");

  const hora_inicio = 8;
  const hora_final = 21;

  function generarHoras() {
    horaSelect.innerHTML = "";

    for (let h = hora_inicio; h <= hora_final; h++) {
      for (let m = 0; m < 60; m += 15) {
        let hora = generarHoraTexto(h, m);

        let option = document.createElement("option");
        option.value = hora;
        option.textContent = hora;
        horaSelect.appendChild(option);
      }
    }
  }

  function establecerFechaMinimaMaxima() {
    const hoy = new Date();

    const hora_actual = hoy.getHours();
    const minuto_actual = hoy.getMinutes();

    const minDate = new Date();

    if (
      hoy.getHours() >= hora_final ||
      (hora_actual === hora_final && minuto_actual > 0)
    ) {
      minDate.setDate(minDate.getDate() + 1);
    }

    const maxDate = new Date();
    maxDate.setMonth(maxDate.getMonth() + 1);

    const formato = (fecha) => fecha.toISOString().split("T")[0];

    fechaInput.min = formato(minDate);
    fechaInput.max = formato(maxDate);
  }

  function generarHoraTexto(h, m) {
    let hora = "";
    let minutos = "";
    if (h < 10) {
      hora = "0" + h;
    } else {
      hora = h;
    }

    if (m === 0) {
      minutos = "00";
    } else if (m < 10) {
      minutos = "0" + m;
    } else {
      minutos = m;
    }

    return hora + ":" + minutos + ":00";
  }

  establecerFechaMinimaMaxima();
  generarHoras();

  //Impedir que se puedan escojer los findes de semana.

  fechaInput.addEventListener("input", function () {
    //obtenemos la fecha que ha seleccionado el usuario y la transformamos a fecha
    const date = new Date(this.value);
    const day = date.getDay();

    if (day === 0 || day === 6) {
      alert("No se pueden seleccionar fines de semana");
      this.value = "";
      horaSelect.innerHTML = "";
      generarHoras();
      return;
    }
    generarHoras();

    const hoy = new Date();
    const seleccion = new Date(this.value);
    //Comprobamos si el dia y hora seleccionamos 
    if (
      seleccion.getDate() === hoy.getDate() &&
      seleccion.getMonth() === hoy.getMonth() &&
      seleccion.getFullYear() === hoy.getFullYear()
    ) {
      filtrarHorasDeHoy();
    }

    cargarHorasOcupadas(this.value);
  });

  function filtrarHorasDeHoy(){
    const ahora = new Date();
    let hora_actual = ahora.getHours();
    let minuto_actual = ahora.getMinutes();

    if(minuto_actual > 0 && minuto_actual <= 15){
      minuto_actual = 15;
    }else if(minuto_actual > 30 && minuto_actual <= 45){
      minuto_actual = 30;
    }else {
      hora_actual++;
      minuto_actual = 0;
    }

    [...horaSelect.options].forEach(function (option) {
      const horaTexto = option.value;
      const partes = horaTexto.split(":")

      const hora = parseInt(partes[0]);
      const minutos = parseInt(partes[1]);
      
      if(hora < hora_actual || (hora === hora_actual && minutos < minuto_actual)){
        option.disabled = true;
        option.style.color = "gray";
      }

    })
  }

  function cargarHorasOcupadas(fecha) {
    fetch("../src/obtener_horas_ocupadas.php?fecha=" + fecha)
      .then((res) => res.json())
      .then((horas) => {
        marcarHorasOcupadas(horas);
      })
      .catch((err) => console.error(err));
  }

  function marcarHorasOcupadas(horasOcupadas) {
    //generamos todas las horas.
    generarHoras();

    //Transformamos las horas que vienen del sevidor a un mapa para que esten en un array
    //y asi se pueden comparar con las que estab ocupadas y que el usuario no las pueda seleccionar
    const horas = horasOcupadas.map((h) => h.hora_cita);

    //convertimos todas las horas del select options para que se pueda recorrer.
    [...horaSelect.options].forEach((opt) => {
      //Ahora recorremos todas las horas y comprobamos con las ocupadas si lo están y las hacemos disabled y con texto rojo.
      if (horas.includes(opt.value)) {
        opt.disabled = true;
        opt.style.backgroundColor = "lightgrey";
        opt.style.color = "red";
      }
    });
  }
});
