<style>
    .modal-content .tabla-container {
        display: none;
    }

    .autocomplete-container {
        position: relative;
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
<link rel="stylesheet" href="../css/modal-usuario.css">
<div id="modalAgregarCita" class="modalAgregarCita">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="php/add-cita.php" method="POST">
            <div class="title">Nueva Cita</div>
            <div class="form-group">
                <label for="add-buscarpaciente">Paciente</label>
                <div class="autocomplete-container">
                    <input type="text" id="add-buscarpaciente" placeholder="Buscar paciente..." autocomplete="off">
                    <div class="suggestions" id="suggestions"></div>
                </div>

                <label for="add-dnipaciente">DNI Paciente</label>
                <input type="text" name="dnipaciente" id="add-dnipaciente" autocomplete="off" required>

                <label for="add-idpaciente">ID Paciente</label>
                <input type="text" name="idpaciente" id="add-idpaciente" autocomplete="off" required readonly="true">

                <label for="add-fecha">Fecha</label>
                <input id="add-fecha" onchange="obtenerHorariosDisponibles()" type="date" name="fecha" autocomplete="off" required>
            </div>
            <div class="tabla-container" id="tablaHorariosDisponibles">

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>DIA</th>
                                <th>MEDICO</th>
                                <th>HORARIO</th>
                                <th>CUPOS</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label for="add-dnimedico">DNI Médico</label>
                <input type="text" name="dnimedico" id="add-dnimedico" autocomplete="off" required>

                <label for="add-idmedico" >ID Médico</label>
                <input type="text" name="idmedico" id="add-idmedico" autocomplete="off" required readonly="true" >

                <label for="add-medico">Médico</label>
                <input type="text" name="medico" id="add-medico" autocomplete="off" required readonly="true">

                <label for="add-hora">Hora</label>
                <input id="add-hora" type="time" name="hora" autocomplete="off" required>

                <label for="add-motivo">Motivo</label>
                <input id="add-motivo" type="text" name="motivo" autocomplete="off" required>

                <label for="add-estado">Estado</label>
                <select id="add-estado" name="estado" required>
                    <option value="">Seleccionar</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Cancelada">Cancelada</option>
                </select>

                <label for="add-idhorario">Horario</label>
                <input id="add-idhorario" type="text" name="idHorario" autocomplete="off" required>
            </div>
            <button type="submit" class="modificar">Agregar Cita</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("add-dnimedico").addEventListener("input", function() {
            let dni = this.value.trim();
            if (dni.length > 0) {
                fetch("php/buscar-medico.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: "query=" + encodeURIComponent(dni),
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("add-medico").value = data.nombre || "No encontrado";
                        document.getElementById("add-idmedico").value = data.idMedico || "No encontrado";
                    })
                    .catch(error => console.error("Error:", error));
            } else {
                document.getElementById("add-medico").value = "";
                document.getElementById("add-idmedico").value = "";
            }
        });
    });

    function obtenerHorariosDisponibles() {
        const fecha = document.getElementById("add-fecha").value;
        const tablaHorariosDisponibles = document.getElementById("tablaHorariosDisponibles");
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "php/obtener-horarios.php?fecha=" + fecha, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                if (respuesta.success) {
                    actualizarTablaHorarios(respuesta.horarios);
                    tablaHorariosDisponibles.style.display = "block";
                } else {
                    actualizarTablaHorarios(respuesta.horarios);
                    //tablaHorariosDisponibles.style.display = "none";
                }
            }
        };
        xhr.send();
    }

    function actualizarTablaHorarios(horarios) {
        const tbody = document.querySelector("#modalAgregarCita tbody");
        tbody.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos

        if (horarios.length > 0) {
            horarios.forEach(horario => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td>${horario.fecha}</td>
                <td>${horario.diaSemana}</td>
                <td>${horario.Medico}</td>
                <td>${horario.HoraInicio} - ${horario.HoraFin}</td>
                <td>${horario.cupos}</td>
                <td>
                    <a href="#" class="edit-btn"
                        data-idhorario="${horario.idHorario}"
                        data-dnimedico="${horario.DNIMedico}"
                        data-idmedico="${horario.idMedico}"
                        data-nombremedico="${horario.Medico}">
                        <img src="../img/edit.png" width="35" height="35">
                    </a>
                </td>
            `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No hay médicos disponibles en este horario.</td></tr>";
        }

        SeleccionarMedico();
    }

    // Lista dinamica de pacientes
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("add-buscarpaciente");
        const suggestionsBox = document.getElementById("suggestions");

        input.addEventListener("input", function() {
            let query = this.value.trim();

            suggestionsBox.innerHTML = ""; // Limpiar sugerencias
            if (query.length === 0) {
                suggestionsBox.style.display = "none";
                return;
            }

            // Enviar consulta AJAX al servidor
            fetch("php/buscar-paciente.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "query=" + encodeURIComponent(query)
                })
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    if (data.length > 0) {
                        suggestionsBox.style.display = "block";
                        data.forEach(paciente => {
                            let div = document.createElement("div");
                            div.textContent = paciente.Paciente;
                            div.dataset.id = paciente.idPaciente; // Guardar ID en el elemento
                            div.dataset.dni = paciente.dni; // Guardar DNI en el elemento
                            div.addEventListener("click", function() {
                                input.value = this.textContent;
                                document.getElementById("add-idpaciente").value = this.dataset.id;
                                document.getElementById("add-dnipaciente").value = this.dataset.dni;
                                suggestionsBox.style.display = "none";
                            });
                            suggestionsBox.appendChild(div);
                        });
                    } else {
                        suggestionsBox.style.display = "none";
                    }
                })
                .catch(error => console.error("Error:", error));
        });

        // Ocultar sugerencias si se hace clic fuera
        document.addEventListener("click", function(e) {
            if (!document.querySelector(".autocomplete-container").contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });
    });

    function SeleccionarMedico() {
        const editButtons = document.querySelectorAll(".edit-btn");
        editButtons.forEach(btn => {
            btn.addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("add-dnimedico").value = this.dataset.dnimedico;
                document.getElementById("add-idmedico").value = this.dataset.idmedico;
                document.getElementById("add-medico").value = this.dataset.nombremedico;
                document.getElementById("add-idhorario").value = this.dataset.idhorario;
            });
        });
    }
</script>