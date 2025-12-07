document.addEventListener("DOMContentLoaded", function () {

    const marcaSelect = document.getElementById("marca");
    const modeloSelect = document.getElementById("modelo");

    const jsonMarcas = "../public/assets/marcas.json";

    fetch(jsonMarcas)
        .then(response => response.json())
        .then(data => {

            window.marcasModelos = data;

            cargarMarcas(data);

            marcaSelect.addEventListener("change", () => {
                cargarModelosPorMarca(marcaSelect.value);
            });
        })
        .catch(error => console.error("Error al procesar el archivo JSON: ", error));



    function cargarMarcas(data) {
        data.forEach(marca => {
            const option = document.createElement("option");
            option.value = marca.title;
            option.textContent = marca.title;
            marcaSelect.appendChild(option);
        });
    }

    function cargarModelosPorMarca(marcaSeleccionada) {

        modeloSelect.innerHTML = "";

        if (marcaSeleccionada === "") {
            const option = document.createElement("option");
            option.value = "";
            option.textContent = "Seleccione una marca primero";
            modeloSelect.appendChild(option);
            return;
        }

        const marca = window.marcasModelos.find(
            m => m.title === marcaSeleccionada
        );

        if (!marca) {
            console.error("Marca no encontrada");
            return;
        }

        marca.models.forEach(modelo => {
            const option = document.createElement("option");
            option.value = modelo.title;
            option.textContent = modelo.title;
            modeloSelect.appendChild(option);
        });
    }

});
