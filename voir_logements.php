<?php
session_start();
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer l'ID du point d'arrêt à partir de l'URL
$id_point = isset($_GET['id']) ? $_GET['id'] : 0;

// Récupérer la date choisie, si elle est fournie
$date_choisie = isset($_GET['date']) ? $_GET['date'] : null;

// Préparer la requête SQL
$sql = "SELECT * FROM hebergements WHERE PointDArretID = ?";
$params = [$id_point];

if ($date_choisie) {
    $sql .= " AND DateDebutDisponible <= ? AND DateFinDisponible >= ?";
    array_push($params, $date_choisie, $date_choisie);
}

$stmt = $bdd->prepare($sql);
$stmt->execute($params);
$logements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Voir les hébergements disponibles</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1 class="my-4">Hébergements disponibles au point d'arrêt #<?php echo $id_point; ?></h1>
    
    <!-- Formulaire pour choisir une date -->
    <form action="" method="GET">
      <input type="hidden" name="id" value="<?php echo $id_point; ?>">
      <label for="date">Choisir une date :</label>
      <input type="date" id="date" name="date">
      <button type="submit" class="btn btn-primary">Filtrer</button>
    </form>

    <?php if(count($logements) > 0): ?>
      <?php foreach ($logements as $logement): ?>
        <div class="card mb-2">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($logement['Nom']); ?></h5>
            <img src="<?php echo htmlspecialchars($logement['Photo']); ?>" alt="Photo de l'hébergement" class="img-fluid mb-3">
            <p class="card-text">Surface: <?php echo htmlspecialchars($logement['Surface']); ?> m²</p>
            <p class="card-text">Adultes: <?php echo htmlspecialchars($logement['Adultes']); ?></p>
            <p class="card-text">Enfants: <?php echo htmlspecialchars($logement['Enfants']); ?></p>
            <p class="card-text">Prix par nuit: €<?php echo htmlspecialchars($logement['PrixParNuit']); ?></p>
            <a href="details_logement.php?id=<?php echo $logement['ID']; ?>" class="btn btn-info">Détails</a>
            <a href="reserver.php?hebergement_id=<?php echo $logement['ID']; ?>&user_id=<?php echo $_SESSION['id']; ?>" class="btn btn-primary">Réserver</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun hébergement disponible pour ce point d'arrêt à la date choisie.</p>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
