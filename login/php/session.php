<?php 
    include '../../conexion.php';
    session_start();
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $consulta = "SELECT * FROM Usuarios WHERE usuario = ? AND contrasenia = ?";
        $statement = $conn->prepare($consulta);
        $statement->execute([$usuario, $password]);
        $resultset = $statement->fetch();
        
        if ($resultset) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../../admin/index.php');
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header('Location: ../login.php');
        }
    }
?>
