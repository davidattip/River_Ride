<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Assurez-vous que la session a été démarrée
if (!isset($_SESSION)) {
    session_start();
}

// Vérifier que l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    // Réception des données POST
    $clientID = $_SESSION['id'];  // Récupérer l'ID du client depuis la session
    $pointA = $_POST['pointA'];
    $pointB = $_POST['pointB'];
    $date = $_POST['date'];
    $poids = $_POST['poids'];
    $promo = $_POST['promo'];
    $prix = $_POST['prix'];

    // Ajout de la colonne 'ClientID' dans la requête d'insertion
    $stmt = $bdd->prepare("INSERT INTO Reservation_bagage (PointA, PointB, Date, Poids, CodePromo, Prix, Status, ClientID) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?)");
    $stmt->execute([$pointA, $pointB, $date, $poids, $promo, $prix, $clientID]);

    // Retourner l'ID de la réservation pour le paiement
    echo json_encode(["success" => true, "reservation_id" => $bdd->lastInsertId()]);
} else {
    // Envoyer une réponse JSON échouée si l'utilisateur n'est pas connecté
    echo json_encode(["success" => false, "message" => "Utilisateur non connecté"]);
}
?>
