<?php
include '../../conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $archivo_token = __DIR__ . "/../tokens/$token.json";

    if (file_exists($archivo_token)) {
        $contenido = json_decode(file_get_contents($archivo_token), true);

        if (time() < $contenido['expiracion']) {
            $email = $contenido['email'];
            $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE Usuarios SET contrasenia=? WHERE correo=?");
            $stmt->execute([$nueva_contrasena, $email]);

            unlink($archivo_token);
            //echo "<script>alert('Contraseña actualizada exitosamente.'); window.location='index.php';</script>";
            $_SESSION['success'] = "Contraseña actualizada exitosamente.";
            header('Location: ../login.php');
            exit();
        } else {
            unlink($archivo_token);
            //echo "<script>alert('El enlace expiró, inténtalo nuevamente.'); window.location='recuperar_contrasena.php';</script>";
            $_SESSION['error'] = "El enlace expiró, inténtalo nuevamente.";
            header('Location: ../recuperar_contrasena.php');
            exit();
        }
    } else {
        //echo "<script>alert('Token inválido.'); window.location='index.php';</script>";
        $_SESSION['error'] = "Token inválido, inténtalo nuevamente.";
        header('Location: ../recuperar_contrasena.php');
        exit();
    }
}
