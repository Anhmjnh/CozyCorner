<?php
session_start();
session_destroy();
$redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
header('Location: ' . $redirect);
exit;
?>

