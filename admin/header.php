<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCitas - Citas Médicas</title>
    <link rel="stylesheet" href="../css/estilo-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="barra-superior">
        <div class="logo">MediCitas</div>
        <div class="usuario">
            <span><?php echo "(ADMIN) " . $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']; ?></span>
            <a href="../principal/index.php" class="btn-salir">Salir</a>
        </div>
    </header>
</body>
</html>