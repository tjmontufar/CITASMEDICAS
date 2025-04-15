<style>
    form input[type="password"] {
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
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <form action="php/actualizar_contrasena.php" method="POST">
        <h2>Actualizar la contraseña</h2>
        <p>Por favor, ingresa tu nueva contraseña.</p>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
        <button type="submit">Actualizar contraseña</button>
    </form>
</body>
<?php 
session_start();
include 'alert.php'; 
?>
</html>