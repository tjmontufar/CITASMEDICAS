<?php
include '../conexion.php';
$sql = "SELECT idusuario, dni, nombre, apellido, usuario, correo, rol FROM usuarios";

try {
    $query = $conn->prepare($sql);
    $query->execute();
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al ejecutar la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/tabla.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="contenedor">
        <?php include 'menu.php'; ?>
        <main class="contenido">
            <div class="table-container">
                <h2>Tabla de Usuarios</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>USUARIO</th>
                                <th>CORREO</th>
                                <th>PERMISOS</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($usuarios) > 0) {
                                foreach ($usuarios as $fila) {
                                    echo "<tr>
                                <td>{$fila['idusuario']}</td>
                                <td>{$fila['dni']}</td>
                                <td>{$fila['nombre']}</td>
                                <td>{$fila['apellido']}</td>
                                <td>{$fila['usuario']}</td>
                                <td>{$fila['correo']}</td>
                                <td>{$fila['rol']}</td>
                                <td>
                                    <a href='editar_usuario.php?id={$fila['idusuario']}'><img src=\"../img/edit.png\" width=\"35\" height=\"35\"></a>
                                    <a href='eliminar_usuario.php?id={$fila['idusuario']}'><img src=\"../img/delete.png\" width=\"35\" height=\"35\"></a>
                                </td>
                              </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No hay usuarios registrados</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </main>
    </div>
</body>

</html>