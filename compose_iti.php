<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer tous les points d'arrêt pour les afficher
$stmt = $bdd->prepare("SELECT * FROM pointsdarret");
$stmt->execute();
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Composer un itinéraire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php 
  include('includes/header.php');
?>
    
  <div class="container">
    <h1 class="my-4">Composer un itinéraire</h1>

    <!-- Début du formulaire pour la composition d'itinéraire -->
    <form action="valider_itineraire.php" method="POST">
      <label for="nomItineraire">Nom de l'itinéraire :</label>
      <input type="text" id="nomItineraire" name="nomItineraire" required>
      
      <h2 class="my-4">Points d'arrêt disponibles</h2>
      <?php foreach ($points as $point): ?>
        <div class="card mb-2">
          <div class="card-body">
            <h5 class="card-title">
              <input type="checkbox" name="points[]" value="<?php echo $point['ID']; ?>"> 
              <?php echo htmlspecialchars($point['Nom']); ?>
            </h5>
            <p class="card-text"><?php echo substr(htmlspecialchars($point['Description']), 0, 100) . '...'; ?></p>
            <!-- Boutons pour consulter les détails et voir les logements -->
            <a href="details_point_arret.php?id=<?php echo $point['ID']; ?>" class="btn btn-info">Consulter</a>
            <a href="voir_logements.php?id=<?php echo $point['ID']; ?>" class="btn btn-primary">Voir les logements disponibles</a>
          </div>
        </div>
      <?php endforeach; ?>

      <!-- Bouton pour valider la sélection des points d'arrêt -->
      <button type="submit" class="btn btn-success my-4">Valider l'itinéraire</button>
    </form>
    <!-- Fin du formulaire -->
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

  <?php include('includes/footer.php'); ?> 
</body>
</html>
