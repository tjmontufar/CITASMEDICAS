<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        Hola, <?php echo $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']; unset($_SESSION['usuario']); ?>    
    </div>
</body>
</html>