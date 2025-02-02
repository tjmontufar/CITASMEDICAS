<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro a MediCitas</title>
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form action="php/session.php" method="POST">
        <div class="title">Registrarse a MediCitas</div>

        <!-- Contenedor para alinear inputs -->
        <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" type="text" name="dni">
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" name="nombre">
            <label for="apellido">Apellido</label>
            <input id="apellido" type="text" name="apellido">
        </div>

        <div class="form-group">
            <label for="correo">Correo</label>
            <input id="correo" type="email" name="correo">
        </div>

        <div class="form-group">
            <label for="usuario">Nombre de Usuario</label>
            <input id="usuario" type="text" name="usuario">
            <label for="tipoUsuario">Tipo de Usuario</label>
            <input id="tipoUsuario" type="text" name="tipoUsuario">
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password">
            <label for="confirmPassword">Confirmar Contraseña</label>
            <input id="confirmPassword" type="password" name="confirmPassword">
        </div>

        <button type="submit">Registrarse</button>
        <a href="login.php" class="link">Volver a iniciar sesión</a>
    </form>
</body>
</html>
