<style>
    form input[type="email"] {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }
</style>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <form action="php/enviar_recuperacion.php" method="POST">
        <h2>Recuperar el acceso a tu cuenta</h2>
        <br>
        <p>Ingresa tu correo electrónico para recibir un enlace de recuperación.</p>
        <input type="email" name="email" placeholder="correo@ejemplo.com" required autocomplete="off">
        <button type="submit">Enviar enlace</button>
        <a href="login.php" class="link">Volver a iniciar sesión</a>
    </form>
</body>
<?php 
session_start();
include 'alert.php'; 
?>
</html>