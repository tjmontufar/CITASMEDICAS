<div id="modalEditarExpediente" class="modalEditarExpediente">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="php/edit-expediente.php" method="POST">
            <div class="title">Editar datos de Expediente</div>
            <div class="form-group">
                <label for="edit-idExpediente">ID Expediente</label>
                <input id="edit-idExpediente" type="number" name="idExpediente" autocomplete="off" readonly>

                <label for="edit-idPaciente">ID Paciente</label>
                <input id="edit-idPaciente" type="number" name="idPaciente" autocomplete="off">

                <label for="edit-nombrePaciente">Paciente</label>
                <input id="edit-nombrePaciente" type="text" name="nombrePaciente" autocomplete="off">

                <label for="edit-fechaCreacion">Fecha Creación</label>
                <input id="edit-fechaCreacion" type="date" name="fechaCreacion" autocomplete="off">

                <label for="edit-antecedentes">Antecedentes</label>
                <textarea id="edit-antecedentes" name="antecedentes" autocomplete="off"></textarea>

                <label for="edit-alergias">Alergias</label>
                <textarea id="edit-alergias" name="alergias" autocomplete="off"></textarea>

                <label for="edit-medicamentos">Medicamentos Actuales</label>
                <textarea id="edit-medicamentos" name="medicamentosActuales" autocomplete="off"></textarea>

                <label for="edit-enfermedades">Enfermedades Crónicas</label>
                <textarea id="edit-enfermedades" name="enfermedadesCronicas" autocomplete="off"></textarea>

                <label for="edit-descripcion">Descripción</label>
                <textarea id="edit-descripcion" name="descripcion" autocomplete="off"></textarea>

                <label for="edit-fechaActualizacion">Fecha de Actualización</label>
                <input id="edit-fechaActualizacion" type="date" name="fechaActualizacion" autocomplete="off">
            </div>
            <button type="submit" class="modificar">Modificar Expediente</button>
        </form>
    </div>
</div>