<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro a MediCitas</title>
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .form-doctor,
        .form-paciente {
            display: none;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <form action="php/registration.php" method="POST">
        <div class="title">Registrarse a MediCitas</div>

        <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" type="text" name="dni">

            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre">

            <label for="apellido">Apellido</label>
            <input id="apellido" type="text" name="apellido">

            <label for="correo">Correo</label>
            <input id="correo" type="email" name="correo">

            <label for="usuario">Nombre de Usuario</label>
            <input id="usuario" type="text" name="usuario">

            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password">

            <label for="confirmPassword">Confirmar Contraseña</label>
            <input id="confirmPassword" type="password" name="confirmPassword">

            <label for="tipoUsuario">Tipo de Usuario</label>
            <select id="tipoUsuario" name="tipoUsuario">
                <option value="0">Seleccionar</option>
                <option value="1">Paciente</option>
                <option value="2">Doctor</option>
                <option value="3">Administrador</option>
            </select>
        </div>

        <div class="form-doctor">
            <label for="idespecialidad">Especialidad</label>
            <select id="idespecialidad" name="idespecialidad">
                <option value="0">Seleccionar</option>
                <?php
                
                include '../conexion.php';
                $consulta = "SELECT * FROM Especialidades";
                $statement = $conn->prepare($consulta);
                $statement->execute();
                $resultset = $statement->fetchAll();
                foreach ($resultset as $especialidad) {
                    echo '<option value="' . $especialidad['idEspecialidad'] . '">' . $especialidad['nombreEspecialidad'] . '</option>';
                }
                ?>
            </select>

            <label for="licenciaMedica">Nº Licencia Médica</label>
            <input id="licenciaMedica" type="text" name="licenciaMedica">

            <label for="aniosExperiencia">Años de Experiencia</label>
            <input id="aniosExperiencia" type="text" name="aniosExperiencia">
        </div>

        <div class="form-paciente">
            <label for="fechaNacimiento">Fecha de Nacimiento</label>
            <input id="fechaNacimiento" type="text" name="fechaNacimiento">

            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo">
                <option value="0">Seleccionar</option>
                <option value="1">M</option>
                <option value="2">F</option>
            </select>

            <label for="telefono">Teléfono</label>
            <input id="telefono" type="text" name="telefono">

            <label for="direccion">Dirección (opcional)</label>
            <input id="direccion" type="text" name="direccion">
        </div>

        <button type="submit">Registrarse</button>
        <a href="login.php" class="link">Volver a iniciar sesión</a>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tipoUsuarioSelect = document.getElementById("tipoUsuario");
            const formDoctor = document.querySelector(".form-doctor");
            const formPaciente = document.querySelector(".form-paciente");

            tipoUsuarioSelect.addEventListener("change", function() {
                if (tipoUsuarioSelect.value === "2") {
                    formDoctor.style.display = "block";
                } else {
                    formDoctor.style.display = "none";
                }

                if (tipoUsuarioSelect.value === "1") {
                    formPaciente.style.display = "block";
                } else {
                    formPaciente.style.display = "none";
                }
            });
        });
    </script>
</body>
<?php
if (isset($_SESSION['error'])) {
    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error",
                        text: "' . $_SESSION['error'] . '",
                        icon: "error"
                    });
                });
            </script>';
    unset($_SESSION['error']);
} else if (isset($_SESSION['success'])) {
    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Éxito",
                        text: "' . $_SESSION['success'] . '",
                        icon: "success"
                    });
                });
            </script>';
    unset($_SESSION['success']);
}
?>

</html>