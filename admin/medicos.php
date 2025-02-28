<?php
include '../conexion.php';
$paginaActual = 'medicos';
$dni_filter = $_GET['dni'] ?? '';
$nombre_apellido_filter = $_GET['nombre_apellido'] ?? '';
$especialidad_filter = $_GET['especialidad'] ?? '';

$sql = "SELECT T1.idUsuario, T1.idMedico, T2.dni, T2.nombre, T2.apellido, 
T1.idEspecialidad, T3.nombreEspecialidad, T1.numeroLicenciaMedica, T1.anosExperiencia
FROM Medicos T1
INNER JOIN Usuarios T2 ON T2.idUsuario = T1.idUsuario
INNER JOIN Especialidades T3 on T3.idEspecialidad = T1.idEspecialidad WHERE 1=1";

if ($dni_filter) {
    $sql .= " AND T2.dni LIKE '%$dni_filter%'";
}
if ($nombre_apellido_filter) {
    $sql .= " AND T2.nombre LIKE '%$nombre_apellido_filter%' OR T2.apellido LIKE '%$nombre_apellido_filter%'";
}
if ($especialidad_filter) {
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
            <?php include 'modals/editar-medico.php'; ?>
            <?php include 'modals/agregar-usuario.php'; ?>
            <?php include 'alert.php'; ?>
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
                <div class="encabezado">
                    <a href="#" class="add-btn">Agregar Usuario</a>
                </div>
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
                                    <a href='#' class='edit-btn'
                                        data-idusuario='{$fila['idUsuario']}'
                                        data-idmedico='{$fila['idMedico']}'
                                        data-dni='{$fila['dni']}'
                                        data-nombre='{$fila['nombre']}'
                                        data-apellido='{$fila['apellido']}'
                                        data-especialidad='{$fila['idEspecialidad']}'
                                        data-licencia='{$fila['numeroLicenciaMedica']}'
                                        data-experiencia='{$fila['anosExperiencia']}'>
                                    <img src=\"../img/edit.png\" width=\"35\" height=\"35\"></a>
                                    <a href='#' class='delete-btn' data-idmedico='{$fila['idMedico']}' data-idusuario='{$fila['idUsuario']}'><img src=\"../img/delete.png\" width=\"35\" height=\"35\"></a>
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
    <script>
        const modals = document.querySelectorAll(".modalAgregarUsuario, .modalEditarMedico");
        const closeButtons = document.querySelectorAll(".close");
        const editButtons = document.querySelectorAll(".edit-btn");
        const addButtons = document.querySelectorAll(".add-btn");
        const deleteButtons = document.querySelectorAll(".delete-btn");

        addButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                event.preventDefault();
                modalAgregarUsuario.style.display = "block";
            });
        });

        editButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                event.preventDefault();
                document.getElementById("edit-idusuario").value = this.dataset.idusuario;
                document.getElementById("edit-idmedico").value = this.dataset.idmedico;
                document.getElementById("edit-dni").value = this.dataset.dni;
                document.getElementById("edit-nombre").value = this.dataset.nombre;
                document.getElementById("edit-apellido").value = this.dataset.apellido;
                document.getElementById("edit-idespecialidad").value = this.dataset.especialidad;
                document.getElementById("edit-licenciaMedica").value = this.dataset.licencia;
                document.getElementById("edit-aniosExperiencia").value = this.dataset.experiencia;
                modalEditarMedico.style.display = "block";
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener("click", function() {
                modals.forEach(modal => modal.style.display = "none");
            });
        });

        window.onclick = function(event) {
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        };

        deleteButtons.forEach(btn => {
            btn.addEventListener("click", async event => {
                event.preventDefault();
                const idmedico = btn.dataset.idmedico;
                const idusuario = btn.dataset.idusuario;
                const confirmacion = await Swal.fire({
                    title: `¿Realmente quieres eliminar el Médico Nº ${idmedico}?`,
                    text: "Esta acción no se puede deshacer.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Eliminar",
                    cancelButtonText: "Cancelar"
                });
                if (!confirmacion.isConfirmed) return;
                try {
                    const response = await fetch("php/delete-doctor.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `idmedico=${idmedico}&idusuario=${idusuario}`
                    });
                    const data = await response.json();
                    await Swal.fire({
                        title: data.status === "success" ? "Éxito" : "Error",
                        text: data.message,
                        icon: data.status === "success" ? "success" : "error"
                    });
                    if (data.status === "success") location.reload();
                } catch (error) {
                    Swal.fire({
                        title: "Error",
                        text: "Hubo un problema al eliminar el médico.",
                        icon: "error"
                    });
                    console.error("Error:", error);
                }
            });
        });
    </script>
</body>

</html>