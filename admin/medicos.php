<?php
include '../conexion.php';
$dni_filter = $_GET['dni'] ?? '';
$nombre_apellido_filter = $_GET['nombre_apellido'] ?? '';
$especialidad_filter = $_GET['especialidad'] ?? '';

$sql = "SELECT T1.idMedico, T2.dni, T2.nombre, T2.apellido, 
T3.nombreEspecialidad, T1.numeroLicenciaMedica, T1.anosExperiencia
FROM Medicos T1
INNER JOIN Usuarios T2 ON T2.idUsuario = T1.idUsuario
INNER JOIN Especialidades T3 on T3.idEspecialidad = T1.idEspecialidad WHERE 1=1";

if($dni_filter) {
    $sql .= " AND T2.dni LIKE '%$dni_filter%'";
}
if($nombre_apellido_filter) {
    $sql .= " AND T2.nombre LIKE '%$nombre_apellido_filter%' OR T2.apellido LIKE '%$nombre_apellido_filter%'";
}
if($especialidad_filter) {
    $sql .= " AND T1.idEspecialidad LIKE '%$especialidad_filter%'";
}

try {
    $query = $conn->prepare($sql);
    $query->execute();
    $medicos = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../css/filter.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="contenedor">
        <?php include 'menu.php'; ?>
        <main class="contenido">
            <div class="filter-container">
                <form method="GET" action="">
                    <input type="text" name="dni" placeholder="Buscar por DNI" value="<?= $dni_filter ?>" autocomplete="off">
                    <input type="text" name="nombre_apellido" placeholder="Buscar por Nombre/Apellido" value="<?= $nombre_apellido_filter ?>" autocomplete="off">
                    <select name="especialidad">
                        <option value="">Especialidad</option>
                        <?php
                        include '../conexion.php';
                        $consulta = "SELECT * FROM Especialidades";
                        $statement = $conn->prepare($consulta);
                        $statement->execute();
                        $resultset = $statement->fetchAll();
                        foreach ($resultset as $especialidad) {
                            $isselected = $especialidad_filter == $especialidad['idEspecialidad'] ? 'selected' : '';
                            echo '<option value="' . $especialidad['idEspecialidad'] . '" ' . $isselected . '>' . $especialidad['nombreEspecialidad'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit">Filtrar</button>
                </form>
            </div>
            <div class="table-container">
                <h2>TABLA DE MÉDICOS</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>ESPECIALIDAD</th>
                                <th>LICENCIA MEDICA</th>
                                <th>EXPERIENCIA</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($medicos) > 0) {
                                foreach ($medicos as $fila) {
                                    echo "<tr>
                                <td>{$fila['idMedico']}</td>
                                <td>{$fila['dni']}</td>
                                <td>{$fila['nombre']}</td>
                                <td>{$fila['apellido']}</td>
                                <td>{$fila['nombreEspecialidad']}</td>
                                <td>{$fila['numeroLicenciaMedica']}</td>
                                <td>{$fila['anosExperiencia']} años</td>
                                <td>
                                    <a href='editar_usuario.php?id={$fila['idMedico']}'><img src=\"../img/edit.png\" width=\"35\" height=\"35\"></a>
                                    <a href='eliminar_usuario.php?id={$fila['idMedico']}'><img src=\"../img/delete.png\" width=\"35\" height=\"35\"></a>
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