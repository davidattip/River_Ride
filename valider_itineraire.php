<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "Veuillez vous connecter pour accéder à cette page.";
    exit();
}

// Connexion à la base de données
include('includes/db.php');

$userId = $_SESSION['id']; // Récupère l'ID utilisateur de la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['points']) && isset($_POST['nomItineraire'])) {
        $selected_points = $_POST['points'];
        $nomItineraire = $_POST['nomItineraire'];
        
        echo "Vous avez nommé votre itinéraire : " . htmlspecialchars($nomItineraire) . "<br>";
        echo "Vous avez sélectionné les points d'arrêt suivants: <br>";

        // Insérer un nouvel itinéraire dans la table `itineraire`
        $stmt = $bdd->prepare("INSERT INTO itineraire (UserID, Nom) VALUES (?, ?)");
        $stmt->execute([$userId, $nomItineraire]);
        $itineraireID = $bdd->lastInsertId();

        // Préparer la requête SQL pour insérer les données dans la table itineraire_pointsdarret
        $stmt = $bdd->prepare("INSERT INTO itineraire_pointsdarret (ItineraireID, PointDArretID) VALUES (?, ?)");

        foreach ($selected_points as $pointId) {
            echo "ID du point d'arrêt : " . htmlspecialchars($pointId) . "<br>";
            // Exécuter la requête SQL pour chaque point d'arrêt sélectionné
            $stmt->execute([$itineraireID, $pointId]);
        }

        echo "Itinéraire enregistré avec succès.";
    } else {
        echo "Aucun point d'arrêt sélectionné ou nom d'itinéraire manquant.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
