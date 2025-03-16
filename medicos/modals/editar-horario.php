<link rel="stylesheet" href="../css/modal-horario.css">
<link rel="stylesheet" href="../css/tabla.css">
<div id="modalEditarHorario" class="modalEditarHorario">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="php/edit-horario.php" method="POST">
            <div class="title">Actualizar datos del Horario</div>
            <div class="table-container">
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
                <label for="edit-idHorario">ID Horario</label>
                <input id="edit-idHorario" type="text" name="idHorario" readonly>

                <label for="edit-dnimedico">DNI Médico</label>
                <input id="edit-dnimedico" type="text" name="dniMedico">

                <label for="edit-idmedico">ID Médico</label>
                <input id="edit-idmedico" type="text" name="idMedico">

                <label for="edit-nombreMedico">Médico</label>
                <input id="edit-nombreMedico" type="text" name="nombreMedico">

                <label for="edit-fecha">Fecha</label>
                <input id="edit-fecha" type="date" name="fecha">

                <label for="edit-diaSemana">Día</label>
                <input id="edit-diaSemana" type="text" name="diaSemana" readonly>

                <label for="edit-hora">Hora Inicio</label>
                <input id="edit-hora" type="time" name="horaInicio">

                <label for="edit-fin">Hora Fin</label>
                <input id="edit-fin" type="time" name="horaFin">

                <label for="edit-cupos">Cupos</label>
                <input id="edit-cupos" type="number" name="cupos">
            </div>
            <div class="botones">
                <button type="submit" class="estilobotones">Modificar Horario</button>
                <button type="submit" class="estilobotones">Eliminar Horario</button>
                <button type="button" class="estilobotones" onclick="abrirModalDesdeEditar()">Nuevo Horario</button>

            </div>
        </form>
    </div>
</div>
<script>
    function abrirModalDesdeEditar() {
        // Obtener los valores de fecha y día de la semana desde modalEditarHorario
        const fecha = document.getElementById("edit-fecha").value;
        const dia = document.getElementById("edit-diaSemana").value;

        // Verificar si los elementos existen y tienen valores
        if (!fecha || !dia) {
            console.error("No se encontraron valores de fecha o día en modalEditarHorario.");
            return;
        }

        // Cerrar modalEditarHorario
        const modalEditar = document.getElementById("modalEditarHorario");
        if (modalEditar) {
            modalEditar.style.display = "none";
        }

        // Abrir modalAgregarHorario y asignar valores
        const modalAgregar = document.getElementById("modalAgregarHorario");
        if (modalAgregar) {
            modalAgregar.style.display = "block";

            // Insertar valores en los inputs de modalAgregarHorario
            document.getElementById("add-fecha").value = fecha;
            document.getElementById("add-diaSemana").value = dia;
        }
    }

    function autocompletarCampos() {
        const editButtons = document.querySelectorAll(".edit-btn");
        editButtons.forEach(btn => {
            btn.addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("edit-idHorario").value = this.dataset.idhorario;
                document.getElementById("edit-dnimedico").value = this.dataset.dnimedico;
                document.getElementById("edit-idmedico").value = this.dataset.idmedico;
                document.getElementById("edit-nombreMedico").value = this.dataset.nombremedico;
                document.getElementById("edit-fecha").value = this.dataset.fecha;
                document.getElementById("edit-diaSemana").value = this.dataset.diasemana;
                document.getElementById("edit-hora").value = this.dataset.horainicio;
                document.getElementById("edit-fin").value = this.dataset.horafin;
                document.getElementById("edit-cupos").value = this.dataset.cupos;
            });
        });
    }
</script>