<style>
    form input[type="text"], form input[type="password"] {
        width: 80%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="php/session.php" method="POST">
        <img src="../img/logo-medicitas.png" alt="logo" class="imagen">
        <label>
            <i class="fa-solid fa-user"></i>
            <input placeholder="usuario" type="text" name="usuario" autocomplete="off">
        </label>
        <label>
            <i class="fa-solid fa-lock"></i>
            <input placeholder="contraseña" type="password" name="password" autocomplete="off">
        </label>
        <a href="recuperar_contrasena.php" class="link">¿Olvidó su contraseña?</a>
        <button>Iniciar sesión</button>
        <a href="registrarse.php" class="link">¿No tienes cuenta? Regístrate aquí</a>
        <a href="../" class="link">Volver a inicio</a>
    </form>
</body>

</html>
<?php
session_start();
include 'alert.php';
?>