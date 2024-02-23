<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Assurez-vous que la session est démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Récupérer l'ID de l'utilisateur à partir de la session
$userId = $_SESSION['id'];

// Récupérer les itinéraires réservés de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM itineraire WHERE UserID = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$itineraireData = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Récupérer les informations du profil utilisateur
$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$profileData = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les réservations de bagages de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM reservation_bagage WHERE ClientID = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$baggageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les réservations d'hébergements de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM reservations WHERE UserID = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$accommodationData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les packs réservés de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM packs WHERE id_user = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$packData = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil Client</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include('includes/header.php'); ?>

  <div class="container">
    <h1 class="my-4">Bienvenue, <?php echo htmlspecialchars($profileData['nom']); ?></h1>

    <!-- Informations de profil -->
    <h2 class="my-4">Informations de profil</h2>
    <form action="update_profile.php" method="POST">
    <div class="mb-3">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($profileData['nom']); ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($profileData['prenom']); ?>" class="form-control">
      </div>
      <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($profileData['email']); ?>" class="form-control">
      </div>
      <!-- Vous pouvez ajouter d'autres champs selon vos besoins -->
      <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>

        <!-- Itinéraires réservés -->
    <h2 class="my-4">Vos itinéraires réservés</h2>
    <?php foreach($itineraireData as $itineraire): ?>
    <div class="card mb-2">
        <div class="card-body">
        <h5 class="card-title">Itinéraire: <?php echo htmlspecialchars($itineraire['Nom']); ?></h5>
        <?php
        // Récupérer les points d'arrêt pour cet itinéraire
        $stmt = $bdd->prepare("SELECT p.* FROM pointsdarret p INNER JOIN itineraire_pointsdarret ip ON p.ID = ip.PointDArretID WHERE ip.ItineraireID = :itineraireId");
        $stmt->bindParam(':itineraireId', $itineraire['ItineraireID']);
        $stmt->execute();
        $points = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        
        ?>
        <p>Points d'arrêt :</p>
        <ul>
            <?php foreach($points as $point): ?>
            <li><?php echo htmlspecialchars($point['Nom']); ?></li>
            <?php endforeach; ?>
        </ul>
        </div>
    </div>
    <?php endforeach; ?>


    <!-- Réservations de bagages -->
    <h2 class="my-4">Vos réservations de bagages</h2>
    <?php foreach($baggageData as $baggage): ?>
      <div class="card mb-2">
        <div class="card-body">
          <p>Point A: <?php echo $baggage['PointA']; ?></p>
          <p>Point B: <?php echo $baggage['PointB']; ?></p>
          <p>Date: <?php echo $baggage['Date']; ?></p>
          <p>Poids: <?php echo $baggage['Poids']; ?> kg</p>
          <p>Code Promo: <?php echo $baggage['CodePromo']; ?></p>
          <p>Prix: <?php echo $baggage['Prix']; ?> €</p>
          <p>Statut: <?php echo $baggage['Status']; ?></p>
        </div>
      </div>
    <?php endforeach; ?>
    <!-- Réservations de packs -->
    <h2 class="my-4">Vos réservations de packs</h2>
    <?php foreach($packData as $pack): ?>
    <div class="card mb-2">
        <div class="card-body">
        <p>ID du pack: <?php echo $pack['id']; ?></p>
        <p>Nom du pack: <?php echo $pack['nom']; ?></p>
        <p>Description: <?php echo $pack['description']; ?></p>
        <p>Prix: <?php echo $pack['prix']; ?> €</p>
        <p>Date de réservation: <?php echo $pack['date']; ?></p>
        
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Réservations d'hébergements -->
    <h2 class="my-4">Vos réservations d'hébergements</h2>
    <?php foreach($accommodationData as $accommodation): ?>
      <div class="card mb-2">
        <div class="card-body">
          <p>ID d'hébergement: <?php echo $accommodation['HebergementID']; ?></p>
          <p>Date de début: <?php echo $accommodation['DateDebut']; ?></p>
          <p>Date de fin: <?php echo $accommodation['DateFin']; ?></p>
          <p>Statut: <?php echo $accommodation['Statut']; ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Bootstrap JS (optionnel) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <?php include('includes/footer.php'); ?> 
</body>
</html>
