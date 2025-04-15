<?php
session_start();
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario']['rol'] != "Médico") {
        header('Location: ../');
    }
} else {
    header('Location: ../');
}
?>