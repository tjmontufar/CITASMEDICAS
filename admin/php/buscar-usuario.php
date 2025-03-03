<?php
include '../../conexion.php';

if (isset($_GET['idPaciente']) || isset($_GET['idMedico'])) {
    $idPaciente = $_GET['idPaciente'];
    $idMedico = $_GET['idMedico'];

    // Determinar la tabla a consultar
    if ($tipo == 'paciente') {
        $query = "SELECT nombre FROM pacientes WHERE idPaciente = ?";
    } elseif ($tipo == 'medico') {
        $query = "SELECT nombre FROM medicos WHERE idMedico = ?";
    } else {
        echo json_encode(["error" => "Tipo inválido"]);
        exit;
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["nombre" => $row['nombre']]);
    } else {
        echo json_encode(["nombre" => ""]);
    }

    $stmt->close();
    $conn->close();
}
?>
