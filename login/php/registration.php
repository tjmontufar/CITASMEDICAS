<?php 
    include '../../conexion.php';
    session_start();
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $tipoUsuario = $_POST['tipoUsuario'];

    if($tipoUsuario == 2) {
        $licenciaMedica = $_POST['licenciaMedica'];
        $aniosExperiencia = $_POST['aniosExperiencia'];
        $tipoUsuario = 'Médico';

    } else if ($tipoUsuario == 1) {
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $sexo = $_POST['sexo'];
        $telefono = $_POST['telefono'];
        $tipoUsuario = 'Paciente';

    } else {
        $licenciaMedica = null;
        $aniosExperiencia = null;
        $fechaNacimiento = null;
        $sexo = null;
        $telefono = null;
        $tipoUsuario = 'Administrador';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $consulta = "INSERT INTO Usuarios (dni, nombre, apellido, correo, usuario, contrasenia, rol) VALUES (?,?,?,?,?,?,?)";
        $statement = $conn->prepare($consulta);
        $statement->execute([$dni, $nombre, $apellido, $correo, $usuario, $password, $tipoUsuario]);

        if($statement->rowCount() > 0) {
            $idUsuario = $conn->lastInsertId();
            $medico = "INSERT INTO Medicos (idUsuario, licenciaMedica, aniosExperiencia) VALUES (?,?,?)";
            $_SESSION['success'] = "Usuario registrado correctamente.";
            header('Location: ../registrarse.php');
        }
        else
        {
            $_SESSION['error'] = "Error al registrar usuario.";
            header('Location: ../registrarse.php');
        }
    }

?>