<?php
include '../../conexion.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['form_data'] = $_POST;
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $rol = $_POST['tipoUsuario'];
    $rolPaginaActual = $_POST['rol-tipoUsuario'];
    $esNino = $_POST['esNino'];

    function Redirigir($rolPaginaActual)
    {
        ob_clean(); // Limpia el buffer de salida antes de redirigir
        if ($rolPaginaActual == 'Médico') {
            header('Location: ../medicos.php');
        } else if ($rolPaginaActual == 'Paciente') {
            header('Location: ../pacientes.php');
        } else {
            header('Location: ../usuarios.php');
        }
    }

    if ($esNino == 'si') {
        $rol = '1';
        if (empty($dni) || empty($nombre) || empty($apellido)) {
            $_SESSION['error'] = "Complete los campos obligatorios.";
            Redirigir($rolPaginaActual);
            exit();
        }
    } else {
        if (empty($dni) || empty($nombre) || empty($apellido) || empty($correo) || empty($usuario) || empty($password) || empty($confirmPassword) || empty($rol)) {
            $_SESSION['error'] = "Complete los campos obligatorios.";
            Redirigir($rolPaginaActual);
            exit();
        }
    }

    if ($rol == '1') {
        $rol = 'Paciente';
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $sexo = $_POST['sexo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        if ($esNino == 'si') {
            $nombreTutor = $_POST['nombreTutor'];
            $dniTutor = $_POST['dniTutor'];
            $idTutor = $_POST['idTutor'] ?? null;

            if (empty($nombreTutor) || empty($dniTutor)) {
                $_SESSION['error'] = "Complete los campos obligatorios.";
                Redirigir($rolPaginaActual);
                exit();
            }
        } else {
            $nombreTutor = null;
            $dniTutor = null;
            $idTutor = null;
        }

        if (empty($fechaNacimiento) || empty($sexo) || empty($telefono) || empty($direccion)) {
            $_SESSION['error'] = "Complete los campos obligatorios.";
            Redirigir($rolPaginaActual);
            exit();
        }
    } else if ($rol == '2') {
        $idespecialidad = $_POST['idespecialidad'];
        $licenciaMedica = $_POST['licenciaMedica'];
        $aniosExperiencia = $_POST['aniosExperiencia'];
        $telefonoMedico = $_POST['telefonoMedico'];
        $rol = 'Médico';

        if ($idespecialidad == 0 || empty($licenciaMedica) || empty($aniosExperiencia) || empty($telefonoMedico)) {
            $_SESSION['error'] = "Complete los campos obligatorios";
            Redirigir($rolPaginaActual);
            exit();
        }
    } else if ($rol == '3') {
        $idespecialidad = null;
        $licenciaMedica = null;
        $aniosExperiencia = null;
        $fechaNacimiento = null;
        $sexo = null;
        $telefono = null;
        $telefonoMedico = null;
        $rol = 'Administrador';
    } else {
        $_SESSION['error'] = "Seleccione un rol.";
        Redirigir($rolPaginaActual);
        exit();
    }

    if ($password != $confirmPassword) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        Redirigir($rolPaginaActual);
        exit();
    }
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $consulta = "SELECT * FROM Usuarios WHERE dni = ? OR (correo IS NOT NULL AND correo = ?) OR (usuario IS NOT NULL AND usuario = ?)";
        $statement = $conn->prepare($consulta);
        $statement->execute([$dni, $correo, $usuario]);

        if ($statement->fetch()) {
            $_SESSION['error'] = "El DNI, correo o usuario ya están registrados.";
            Redirigir($rolPaginaActual);
            exit();
        }

        if ($rol == 'Médico') {
            $consulta = "SELECT * FROM Medicos WHERE numerolicenciaMedica = ? OR telefono = ?";
            $statement = $conn->prepare($consulta);
            $statement->execute([$licenciaMedica, $telefonoMedico]);

            if ($statement->fetch()) {
                $_SESSION['error'] = "El número de licencia médica o el número telefónico ya está registrado.";
                Redirigir($rolPaginaActual);
                exit();
            }
        }

        // Si el paciente es un adulto, verificar si la edad es menor a 18 años
        if ($esNino == 'no') {
            if ($rol == 'Paciente') {
                $fechaNacimientoObj = new DateTime($fechaNacimiento);
                $fechaActual = new DateTime(); // Fecha actual

                // Calcular la diferencia de años
                $edad = $fechaNacimientoObj->diff($fechaActual)->y;

                if ($edad < 18) {
                    $_SESSION['error'] = "El paciente debe ser mayor de edad.";
                    Redirigir($rolPaginaActual);
                    exit();
                }
            }

            $consulta = "INSERT INTO Usuarios (dni, nombre, apellido, usuario, correo, contrasenia, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $conn->prepare($consulta);
            $statement->execute([$dni, $nombre, $apellido, $usuario, $correo, $passwordHash, $rol]);

            if ($statement->rowCount() > 0) {
                if ($rol == 'Médico') {
                    // Obtenemos el ID del usuario recién insertado
                    $consulta = "SELECT idUsuario FROM Usuarios WHERE usuario = ?";
                    $statement = $conn->prepare($consulta);
                    $statement->execute([$usuario]);
                    $idusuario = $statement->fetchColumn();

                    if (!$idusuario) {
                        $_SESSION['error'] = "Error al obtener el ID del usuario.";
                        header('Location: ../registrarse.php');
                        exit();
                    }
                    $medico = "INSERT INTO Medicos (idUsuario, idEspecialidad, numerolicenciaMedica, anosExperiencia, telefono) VALUES (?,?,?,?,?)";
                    $statement = $conn->prepare($medico);
                    $statement->execute([$idusuario, $idespecialidad, $licenciaMedica, $aniosExperiencia, $telefonoMedico]);
                } else if ($rol == 'Paciente') {
                    // Obtenemos el ID del usuario recién insertado
                    $consulta = "SELECT idUsuario FROM Usuarios WHERE usuario = ?";
                    $statement = $conn->prepare($consulta);
                    $statement->execute([$usuario]);
                    $idusuario = $statement->fetchColumn();

                    if (!$idusuario) {
                        $_SESSION['error'] = "Error al obtener el ID del usuario.";
                        header('Location: ../registrarse.php');
                        exit();
                    }
                    $paciente = "INSERT INTO Pacientes (idUsuario, fechaNacimiento, sexo, telefono, direccion) VALUES (?,?,?,?,?)";
                    $statement = $conn->prepare($paciente);
                    $statement->execute([$idusuario, $fechaNacimiento, $sexo, $telefono, $direccion]);
                }

                $_SESSION['success'] = "Usuario registrado correctamente.";
                unset($_SESSION['form_data']);
                Redirigir($rolPaginaActual);
                exit();
            } else {
                $_SESSION['error'] = "Error al registrar el usuario.";
                Redirigir($rolPaginaActual);
                exit();
            }
        }


        if ($esNino == 'si') {
            // Si el paciente es un niño, verificar que sea menor de 18 años
            $fechaNacimientoObj = new DateTime($fechaNacimiento);
            $fechaActual = new DateTime(); // Fecha actual

            // Calcular la diferencia de años
            $edad = $fechaNacimientoObj->diff($fechaActual)->y;

            if ($edad > 18) {
                $_SESSION['error'] = "El paciente menor de edad no puede ser mayor a 18 años.";
                Redirigir($rolPaginaActual);
                exit();
            }

            $consulta = "INSERT INTO Usuarios (dni, nombre, apellido, rol) VALUES (?, ?, ?, ?)";
            $statement = $conn->prepare($consulta);
            $statement->execute([$dni, $nombre, $apellido, $rol]);

            if ($statement->rowCount() > 0) {
                $idusuario = $conn->lastInsertId();

                if ($idTutor != null) {
                    $idresponsable = $idTutor;
                } else {
                    $responsable = "INSERT INTO Responsables (nombre, dni, telefono) VALUES (?,?,?)";
                    $statement = $conn->prepare($responsable);
                    $statement->execute([$nombreTutor, $dniTutor, $telefono]);
                    $idresponsable = $conn->lastInsertId();
                }

                if ($statement->rowCount() > 0) {
                    $paciente = "INSERT INTO Pacientes (idUsuario, fechaNacimiento, sexo, direccion, idResponsable) VALUES (?, ?, ?, ?, ?)";
                    $statement = $conn->prepare($paciente);
                    $statement->execute([$idusuario, $fechaNacimiento, $sexo, $direccion, $idresponsable]);

                    if ($statement->rowCount() > 0) {
                        $_SESSION['success'] = "Paciente registrado correctamente.";
                        unset($_SESSION['form_data']);
                        Redirigir($rolPaginaActual);
                        exit();
                    } else {
                        $_SESSION['error'] = "Error al registrar el paciente: " . $statement->errorInfo()[2];
                        Redirigir($rolPaginaActual);
                        exit();
                    }
                } else {
                    $_SESSION['error'] = "Error al registrar/editar el tutor: " . $idresponsable;
                    Redirigir($rolPaginaActual);
                    exit();
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error en la base de datos: " . $e->getMessage();
        Redirigir($rolPaginaActual);
        exit();
    }
}
