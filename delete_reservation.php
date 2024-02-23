<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
  
    // Supprimer la réservation
    $sql = "DELETE FROM reservations WHERE ID = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  
    header('Location: admin_reservation.php');
    exit();
}
?>
