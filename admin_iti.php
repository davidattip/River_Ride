<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer tous les itinéraires
$sql = "SELECT itineraire.ItineraireID, itineraire.Nom AS itineraire_nom, itineraire.Timestamp, users.id, users.nom AS user_nom, users.prenom
        FROM itineraire
        JOIN users ON itineraire.UserID = users.id";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$itineraries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Backoffice - Gestion des Itinéraires</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        main {
            padding-top: 60px;  
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <main>
        <div class="container">
            <h1>Gestion des Itinéraires</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Nom de l'itinéraire</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itineraries as $itinerary): ?>
                        <tr>
                            <td><?php echo $itinerary['ItineraireID']; ?></td>
                            <td><?php echo $itinerary['user_nom'] . ' ' . $itinerary['prenom']; ?></td>
                            <td><?php echo $itinerary['itineraire_nom']; ?></td>
                            <td><?php echo $itinerary['Timestamp']; ?></td>
                            <td>
                                <a href="edit_itinerary.php?id=<?php echo $itinerary['ItineraireID']; ?>">Éditer</a>
                                <a href="delete_itinerary.php?id=<?php echo $itinerary['ItineraireID']; ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
