<!DOCTYPE html>
<html lang="es">
<?php
function formatoHora()
{
    for ($hora = 0; $hora < 24; $hora++) {
        for ($minuto = 0; $minuto < 60; $minuto += 30) {
            $time = sprintf("%02d:%02d", $hora, $minuto);
            // PM
            if ($time >= "12:00" && $time <= "23:30") {
                if ($time >= "12:00" && $time <= "12:30") {
                    echo "<option value='$time'>$time PM</option>";
                } else {
                    $horaPM = sprintf("%02d:%02d", $hora - 12, $minuto);
                    echo "<option value='$time'>$horaPM PM</option>";
                }
            } else {
                // AM
                if ($time >= "00:00" && $time <= "00:30") {
                    $horaAM = sprintf("%02d:%02d", $hora + 12, $minuto);
                    echo "<option value='$time'>$horaAM AM</option>";
                } else {
                    echo "<option value='$time'>$time AM</option>";
                }
            }
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Médicos</title>
    <style>
        .schedule-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin: 20px auto;
            max-width: 800px;
        }

        .calendar-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .day {
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .day:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .available {
            background: linear-gradient(135deg, #1D6E8E 0%, #2E8DEF 100%);
            color: white;
        }

        .few-cupos {
            background: linear-gradient(135deg, #FFA500 0%, #FF8B00 100%);
            color: white;
        }

        .unavailable {
            background-color: #f5f5f5;
            color: #999;
            box-shadow: none;
        }

        .day h3 {
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .day small {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .month-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .month-selector select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .empty {
            background-color: transparent;
            box-shadow: none;
            cursor: default;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            max-width: 1000px;
            margin: 0 auto 10px auto;
            padding: 0 20px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }

        @media (max-width: 768px) {
            .calendar-container {
                grid-template-columns: repeat(7, 1fr);
            }

            .day {
                padding: 15px;
                min-height: 80px;
            }

            .day h3 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 724px) {
            .calendar-container {
                grid-template-columns: repeat(5, 1fr);
            }

            .day {
                padding: 10px;
                min-height: 60px;
            }

            .day h3 {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require '../php/vendor/autoload.php';
    include '../conexion.php';
    $paginaActual = 'horarios';


    $mesActual = isset($_GET['mes']) ? $_GET['mes'] : date('m');
    $anioActual = isset($_GET['anio']) ? $_GET['anio'] : date('Y');
    $diasEnMes = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);

    $sqlCupos = "SELECT H.fecha, 
                H.cupos AS cuposDisponibles
                FROM HorariosMedicos H
                LEFT JOIN Citas C ON H.idHorario = C.idHorario 
                LEFT JOIN Medicos T2 ON T2.idMedico = H.idMedico
                LEFT JOIN Usuarios T1 ON T1.idUsuario = T2.idUsuario
                WHERE MONTH(H.fecha) = :mesActual
                AND YEAR(H.fecha) = :anioActual
                AND T1.idUsuario = :idUsuario
                GROUP BY H.fecha, H.cupos;";

    $queryCupos = $conn->prepare($sqlCupos);
    $queryCupos->bindParam(':mesActual', $mesActual, PDO::PARAM_INT);
    $queryCupos->bindParam(':anioActual', $anioActual, PDO::PARAM_INT);
    $queryCupos->bindParam(':idUsuario', $_SESSION['usuario']['idusuario'], PDO::PARAM_INT);
    $queryCupos->execute();
    $cuposPorFecha = $queryCupos->fetchAll(PDO::FETCH_ASSOC);

    $cuposDisponibles = [];
    foreach ($cuposPorFecha as $row) {
        $cuposDisponibles[$row['fecha']] = $row['cuposDisponibles'];
    }

    ?>
    <div class="contenedor">
        <?php include 'menu.php'; ?>
        <?php include 'modals/editar-horario.php'; ?>
        <?php include 'modals/agregar-horario.php'; ?>
        
        <main class="contenido">
            <div class="schedule-container">
                <h2>HORARIOS MÉDICOS</h2>
                <div class="month-selector">
                    <select id="selectMes" onchange="cargarMes()">
                        <?php for ($m = 1; $m <= 12; $m++) { ?>
                            <option value="<?php echo str_pad($m, 2, "0", STR_PAD_LEFT); ?>" <?php if ($m == $mesActual) echo 'selected'; ?>>
                                <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <select id="selectAnio" onchange="cargarMes()">
                        <?php for ($y = date('Y'); $y <= date('Y') + 2; $y++) { ?>
                            <option <?php if ($y == $anioActual) echo 'selected'; ?>><?php echo $y; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="calendar-header">
                    <div>Domingo</div>
                    <div>Lunes</div>
                    <div>Martes</div>
                    <div>Miércoles</div>
                    <div>Jueves</div>
                    <div>Viernes</div>
                    <div>Sábado</div>
                </div>
                <div class="calendar-container">
                    <?php
                    // Calcular en qué día de la semana empieza el mes (0: Domingo, 6: Sábado)
                    $primerDiaMes = date('w', strtotime("$anioActual-$mesActual-01"));

                    // Insertar días vacíos para alinear correctamente el calendario
                    for ($i = 0; $i < $primerDiaMes; $i++) {
                        echo "<div class='empty'></div>";
                    }
                    
                    for ($dia = 1; $dia <= $diasEnMes; $dia++) {
                        $fecha = "$anioActual-$mesActual-" . str_pad($dia, 2, "0", STR_PAD_LEFT);
                        $dias = [
                            'Sunday' => 'Domingo',
                            'Monday' => 'Lunes',
                            'Tuesday' => 'Martes',
                            'Wednesday' => 'Miércoles',
                            'Thursday' => 'Jueves',
                            'Friday' => 'Viernes',
                            'Saturday' => 'Sábado'
                        ];
                        $diaSemana = $dias[date('l', strtotime($fecha))];
                        $idUsuario = $_SESSION['usuario']['idusuario'];
                        $cupos = isset($cuposDisponibles[$fecha]) ? $cuposDisponibles[$fecha] : 0;

                        if ($cupos > 5) {
                            $clase = "available";
                        } elseif ($cupos > 0) {
                            $clase = "few-cupos";
                        } else {
                            $clase = "unavailable";
                        }

                        $onclick = ($cupos == 0) ? "onclick=\"abrirModalAgregarHorario('$fecha','$diaSemana','$idUsuario')\"" : "onclick=\"abrirModalEditarHorario('$fecha','$diaSemana','$idUsuario')\"";

                        echo "<div class='day $clase' $onclick>
                <h3>$dia</h3>
                <small>$cupos cupos</small>
              </div>";
                    }
                    ?>
                </div>

            </div>
        </main>
    </div>
</body>
<script>
    const modals = document.querySelectorAll(".modalAgregarHorario, .modalEditarHorario");
    const closeButtons = document.querySelectorAll(".close");
    const btneditar = document.querySelector("#editarbtn");

    function verHorarios() {
        console.log("Ver horarios de: ");
    }

    function abrirModalAgregarHorario(fecha, dia) {
        const modal = document.getElementById("modalAgregarHorario");
        if (!modal) {
            console.error("El modal no existe en el DOM.");
            return;
        }
        modal.style.display = "block";

        document.getElementById("add-fecha").value = fecha;
        document.getElementById("add-diaSemana").value = dia;
        btneditar.style.display = "none";
    }

    function abrirModalEditarHorario(fecha, dia, idusuario) {
        const modal = document.getElementById("modalEditarHorario");

        if (!modal) {
            console.error("El modal no existe en el DOM.");
            return;
        }
        modal.style.display = "block";
        document.getElementById("edit-idHorario").value = "";
        document.getElementById("edit-dnimedico").value = "";
        document.getElementById("edit-idmedico").value = "";
        document.getElementById("edit-buscarmedico").value = "";
        document.getElementById("edit-fecha").value = fecha;
        document.getElementById("edit-diaSemana").value = dia;
        document.getElementById("edit-horainicio").value = "";
        document.getElementById("edit-horafin").value = "";
        document.getElementById("edit-cupos").value = "";
        obtenerHorariosDisponibles(fecha, idusuario);
        btneditar.style.display = "block";
    }

    function obtenerHorariosDisponibles(fecha, idusuario) {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "php/obtener-horarios.php?fecha=" + fecha + "&idUsuario=" + idusuario, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                if (respuesta.success) {
                    actualizarTablaHorarios(respuesta.horarios);
                } else {
                    alert("No se pudieron obtener los horarios.");
                }
            }
        };
        xhr.send();
    }

    function actualizarTablaHorarios(horarios) {
        const tbody = document.querySelector("#modalEditarHorario tbody");
        tbody.innerHTML = ""; // Limpiar la tabla antes de agregar nuevos datos

        if (horarios.length > 0) {
            horarios.forEach(horario => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td>${horario.fecha}</td>
                <td>${horario.diaSemana}</td>
                <td>${horario.medico}</td>
                <td>${horario.HoraInicio} - ${horario.HoraFin}</td>
                <td>${horario.cupos}</td>
                <td>
                <a href="#" class="edit-btn" 
                    data-idhorario="${horario.idHorario}"
                    data-dnimedico="${horario.DNIMedico}"
                    data-idmedico="${horario.idMedico}"
                    data-nombremedico="${horario.medico}"
                    data-fecha="${horario.fecha}"
                    data-diasemana="${horario.diaSemana}"
                    data-horainicio="${horario.HoraInicio}"
                    data-horafin="${horario.HoraFin}"
                    data-cupos="${horario.cupos}"></td>
            `;
                tbody.appendChild(tr);
                autocompletarCampos();
            });
        } else {
            tbody.innerHTML = "<tr><td colspan='6'>No hay horarios disponibles para esta fecha.</td></tr>";
        }
    }

    function cargarMes() {
        const mes = document.getElementById('selectMes').value;
        const anio = document.getElementById('selectAnio').value;
        window.location.href = `horarios.php?mes=${mes}&anio=${anio}`;
    }

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

    document.addEventListener('DOMContentLoaded', function() {

    });
</script>
<?php
include 'alert.php';
?>

</html>