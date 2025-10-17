<?php
session_start();
session_unset();
session_destroy();

// Détection auto selon l'environnement
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    header("Location: http://localhost/PROJETWEB/index.php");
} else {
    header("Location: /index.php"); // racine de ton site InfinityFree
}
exit();
?>
