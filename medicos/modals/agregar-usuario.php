<link rel="stylesheet" href="../css/modal-usuario.css">
<style>
    .form-doctor,
    .form-paciente {
        display: none;
        margin-top: 15px;
    }
</style>
<div id="modalAgregarUsuario" class="modalAgregarUsuario">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="php/add-user.php" method="POST">
            <div class="title">Nuevo Paciente</div>
            <div class="form-group">
                <label for="add-dni">DNI</label>
                <input id="add-dni" type="text" name="dni" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['dni']) ? $_SESSION['form_data']['dni'] : ''; ?>">

                <label for="add-nombre">Nombre</label>
                <input id="add-nombre" type="text" name="nombre" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : ''; ?>">

                <label for="add-apellido">Apellido</label>
                <input id="add-apellido" type="text" name="apellido" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['apellido']) ? $_SESSION['form_data']['apellido'] : ''; ?>">

                <label for="add-correo">Correo</label>
                <input id="add-correo" type="email" name="correo" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['correo']) ? $_SESSION['form_data']['correo'] : ''; ?>">

                <label for="add-usuario">Nombre de Usuario</label>
                <input id="add-usuario" type="text" name="usuario" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['usuario']) ? $_SESSION['form_data']['usuario'] : ''; ?>">

                <label for="add-password">Contraseña</label>
                <input id="add-password" type="password" name="password" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : ''; ?>">

                <label for="add-confirmPassword">Confirmar Contraseña</label>
                <input id="add-confirmPassword" type="password" name="confirmPassword" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['confirmPassword']) ? $_SESSION['form_data']['confirmPassword'] : ''; ?>">

                <label for="add-tipoUsuario">Tipo de Usuario</label>
                <select id="add-tipoUsuario" name="tipoUsuario">
                    <option value="" <?= empty($_SESSION['form_data']['tipoUsuario']) ? 'selected' : '' ?>>Seleccionar</option>
                    <option value="1" <?= (isset($_SESSION['form_data']['tipoUsuario']) && $_SESSION['form_data']['tipoUsuario'] == '1') ? 'selected' : '' ?>>Paciente</option>
                    <option value="2" <?= (isset($_SESSION['form_data']['tipoUsuario']) && $_SESSION['form_data']['tipoUsuario'] == '2') ? 'selected' : '' ?>>Médico</option>
                    <option value="3" <?= (isset($_SESSION['form_data']['tipoUsuario']) && $_SESSION['form_data']['tipoUsuario'] == '3') ? 'selected' : '' ?>>Administrador</option>
                </select>

                <input type="text" id="rol-tipoUsuario" name="rol-tipoUsuario" readonly="true" value="">
            </div>

            <div class="form-paciente">
                <label for="add-fechaNacimiento">Fecha de Nacimiento</label>
                <input id="add-fechaNacimiento" type="date" name="fechaNacimiento" value="<?php echo isset($_SESSION['form_data']['fechaNacimiento']) ? $_SESSION['form_data']['fechaNacimiento'] : ''; ?>">

                <label for="add-sexo">Sexo</label>
                <select id="add-sexo" name="sexo">
                    <option value="" <?= empty($_SESSION['form_data']['add-tipoUsuario']) ? 'selected' : '' ?>>Seleccionar</option>
                    <option value="Masculino" <?= (isset($_SESSION['form_data']['sexo']) && $_SESSION['form_data']['sexo'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="Femenino" <?= (isset($_SESSION['form_data']['sexo']) && $_SESSION['form_data']['sexo'] == 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                </select>

                <label for="add-telefono">Teléfono</label>
                <input id="add-telefono" type="text" name="telefono" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['telefono']) ? $_SESSION['form_data']['telefono'] : ''; ?>">

                <label for="add-direccion">Dirección (opcional)</label>
                <input id="add-direccion" type="text" name="direccion" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['direccion']) ? $_SESSION['form_data']['direccion'] : ''; ?>">
            </div>
            <button type="submit" class="modificar">Registrar Paciente</button>
        </form>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tipoUsuarioSelect = document.getElementById("add-tipoUsuario");
                const rolTipoUsuario = document.getElementById("rol-tipoUsuario");
                const formPaciente = document.querySelector(".form-paciente");
                const paginaActual = "<?php echo $paginaActual; ?>";
                
                if (paginaActual === "pacientes") {
                    tipoUsuarioSelect.value = "1";
                    tipoUsuarioSelect.hidden = true;
                    rolTipoUsuario.value = "Paciente";
                    rolTipoUsuario.hidden = false;
                    
                } else {
                    tipoUsuarioSelect.hidden = false;
                    rolTipoUsuario.value = "";
                    rolTipoUsuario.hidden = true;
                }

                tipoUsuarioSelect.addEventListener("change", function() {

                    if (tipoUsuarioSelect.value === "1") {
                        formPaciente.style.display = "grid";
                    } else {
                        formPaciente.style.display = "none";
                    }
                });

                if (tipoUsuarioSelect.value === "1") {
                    formPaciente.style.display = "grid";
                } else {
                    formPaciente.style.display = "none";
                }
            });
        </script>
    </div>
</div>