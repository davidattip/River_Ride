<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=river', 'root', '');
} catch (Exception $e) {
    die('Erreur: ' . $e->getMessage());
}
?>