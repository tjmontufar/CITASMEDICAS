<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Pacientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .autocomplete-container {
            position: relative;
            width: 300px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .suggestions {
            position: absolute;
            width: 100%;
            border: 1px solid #ccc;
            border-top: none;
            background: white;
            max-height: 150px;
            overflow-y: auto;
            display: none;
        }
        .suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        .suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="autocomplete-container">
    <input type="text" id="search" placeholder="Buscar paciente..." autocomplete="off">
    <div class="suggestions" id="suggestions"></div>
</div>

<script>
    // Lista de pacientes (simulación de una base de datos)
    const pacientes = [
        "Ana Pérez", "Carlos Gómez", "Daniela Fernández",
        "Esteban López", "Fernanda Castro", "Gabriel Martínez",
        "Hugo Ramírez", "Isabel Mendoza", "Jorge Salazar"
    ];

    const input = document.getElementById("search");
    const suggestionsBox = document.getElementById("suggestions");

    // Evento al escribir en el input
    input.addEventListener("input", () => {
        const query = input.value.toLowerCase();
        suggestionsBox.innerHTML = ""; // Limpiar sugerencias
        if (query.trim() === "") {
            suggestionsBox.style.display = "none";
            return;
        }

        // Filtrar pacientes que coincidan con la búsqueda
        const resultados = pacientes.filter(paciente => 
            paciente.toLowerCase().includes(query)
        );

        // Mostrar sugerencias
        if (resultados.length > 0) {
            suggestionsBox.style.display = "block";
            resultados.forEach(paciente => {
                const div = document.createElement("div");
                div.textContent = paciente;
                div.addEventListener("click", () => {
                    input.value = paciente;
                    suggestionsBox.style.display = "none";
                });
                suggestionsBox.appendChild(div);
            });
        } else {
            suggestionsBox.style.display = "none";
        }
    });

    // Ocultar sugerencias si se hace clic fuera
    document.addEventListener("click", (e) => {
        if (!document.querySelector(".autocomplete-container").contains(e.target)) {
            suggestionsBox.style.display = "none";
        }
    });
</script>

</body>
</html>
