<?php
session_start();
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer l'ID de l'hébergement et de l'utilisateur à partir de l'URL
$hebergement_id = isset($_GET['hebergement_id']) ? $_GET['hebergement_id'] : 0;
$user_id = $_SESSION['id'];

// Récupérer les détails de l'hébergement
$sql = "SELECT * FROM hebergements WHERE ID = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$hebergement_id]);
$hebergement = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les dates de disponibilité
$dateDebutDisponible = $hebergement['DateDebutDisponible'];
$dateFinDisponible = $hebergement['DateFinDisponible'];

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    // Récupérer la date d'aujourd'hui
    $today = date('Y-m-d');

    // Vérifier si les dates sont dans la plage de disponibilité de l'hébergement
    if (strtotime($dateDebut) < strtotime($dateDebutDisponible) || strtotime($dateFin) > strtotime($dateFinDisponible)) {
        echo "<div class='alert alert-danger'>Les dates choisies ne sont pas dans la période de disponibilité de cet hébergement.</div>";
    } elseif (strtotime($dateDebut) < strtotime($today) || strtotime($dateFin) < strtotime($today)) {
        echo "<div class='alert alert-danger'>Les réservations ne peuvent pas être faites pour des dates antérieures à aujourd'hui.</div>";
    } elseif (strtotime($dateFin) <= strtotime($dateDebut)) {
        echo "<div class='alert alert-danger'>La date de fin doit être postérieure à la date de début.</div>";
    } else {
        // Vérifier si une réservation existe déjà pour ces dates
        $checkSql = "SELECT * FROM reservations WHERE HebergementID = ? AND (DateDebut BETWEEN ? AND ? OR DateFin BETWEEN ? AND ?)";
        $checkStmt = $bdd->prepare($checkSql);
        $checkStmt->execute([$hebergement_id, $dateDebut, $dateFin, $dateDebut, $dateFin]);

        if ($checkStmt->rowCount() > 0) {
            echo "<div class='alert alert-danger'>Une réservation existe déjà pour ces dates.</div>";
        } else {
            // Insertion dans la table reservations
            $sql = "INSERT INTO reservations (UserID, HebergementID, DateDebut, DateFin, Statut) VALUES (?, ?, ?, ?, 'En attente')";
            $stmt = $bdd->prepare($sql);
            $stmt->execute([$user_id, $hebergement_id, $dateDebut, $dateFin]);

            if ($stmt->rowCount() > 0) {
                echo "<div class='alert alert-success'>Réservation réussie</div>";
            } else {
                echo "<div class='alert alert-danger'>Erreur lors de la réservation</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Réserver un hébergement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1 class="my-4">Réserver l'hébergement #<?php echo $hebergement['ID']; ?></h1>
    
    <form action="" method="post">
      <label for="dateDebut">Date de début :</label>
      <input type="date" id="dateDebut" name="dateDebut"><br>

      <label for="dateFin">Date de fin :</label>
      <input type="date" id="dateFin" name="dateFin"><br>

      <button type="submit" class="btn btn-primary">Réserver</button>
    </form>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
