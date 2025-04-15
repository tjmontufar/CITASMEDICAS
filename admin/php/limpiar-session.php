<?php
session_start();
unset($_SESSION['form_data']);
echo json_encode(['success' => true]);
?>