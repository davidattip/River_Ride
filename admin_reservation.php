<?php
// Vérifiez si l'utilisateur est un administrateur
// Par exemple, vérifier une variable de session
// if ($_SESSION['role'] !== 'admin') {
//    header('Location: index.php');
//    exit();
//}

// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer toutes les réservations
$sql = "SELECT reservations.ID, reservations.DateDebut, reservations.DateFin, reservations.Statut, users.nom AS user_nom, users.prenom AS user_prenom, hebergements.nom AS hebergement_nom FROM reservations JOIN users ON reservations.UserID = users.id JOIN hebergements ON reservations.HebergementID = hebergements.ID";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Backoffice - Gestion des Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        main {
            padding-top: 60px;  /* Ajout d'un padding en haut pour éviter le chevauchement */
        }
    </style>
</head>
<body>
<?php 
            include('includes/header.php');
        ?>
    
    <main>
    <div class="container">
        <h1>Gestion des Réservations</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Hébergement</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo $reservation['ID']; ?></td>
                        <td><?php echo $reservation['user_nom'] . ' ' . $reservation['user_prenom']; ?></td>
                        <td><?php echo $reservation['hebergement_nom']; ?></td>
                        <td><?php echo $reservation['DateDebut']; ?></td>
                        <td><?php echo $reservation['DateFin']; ?></td>
                        <td><?php echo $reservation['Statut']; ?></td>
                        <td>
                            <!-- Les actions comme éditer ou supprimer peuvent être ajoutées ici -->
                            <a href="edit_reservation.php?id=<?php echo $reservation['ID']; ?>">Éditer</a>
                            <a href="delete_reservation.php?id=<?php echo $reservation['ID']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    </main>
</body>
</html>
