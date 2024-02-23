<?php


// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Ajout d'un point d'arrêt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    // Gestion du fichier téléchargé
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = $_FILES['photo']['name'];
    $fileDestination = 'images/' . $fileName;

    move_uploaded_file($fileTmpPath, $fileDestination);

    $stmt = $bdd->prepare("INSERT INTO PointsDArret (Nom, Description, Photo) VALUES (?, ?, ?)");
    if ($stmt->execute([$nom, $description, $fileDestination])) {
        $_SESSION['message'] = 'Point d\'arrêt ajouté avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Modification d'un point d'arrêt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    $stmt = $bdd->prepare("UPDATE PointsDArret SET Nom = ?, Description = ?, Photo = ? WHERE ID = ?");
    if ($stmt->execute([$nom, $description, $photo, $id])) {
        $_SESSION['message'] = 'Point d\'arrêt modifié avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Suppression d'un point d'arrêt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $id = $_POST['id'];

    // Ensuite, supprimer le point d'arrêt de la table 'PointsDArret'
    $stmt = $bdd->prepare("DELETE FROM PointsDArret WHERE ID = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['message'] = 'Point d\'arrêt supprimé avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Récupérer tous les points d'arrêt pour les afficher
$stmt = $bdd->prepare("SELECT * FROM PointsDArret");
$stmt->execute();
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Administration des points d'arrêt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
        .container {
            margin-top: 20px;
        }
        main {
            padding-top: 100px;  /* Ajout d'un padding en haut pour éviter le chevauchement */
        }
    </style>
</head>
<body>
  <?php include('includes/header.php'); ?>
  <main>
  <div class="container">
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
        <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
          unset($_SESSION['message_type']);
        ?>
      </div>
    <?php endif; ?>

    <h1 class="my-4">Administration des points d'arrêt</h1>

    <!-- Formulaire pour ajouter un point d'arrêt -->
        <div class="card mb-4">
      <div class="card-header">
        Ajouter un point d'arrêt
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" required>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" class="form-control" name="photo" required>
          </div>
          <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
        </form>
      </div>
    </div>

    <!-- Liste des points d'arrêt -->
    <h2 class="my-4">Points d'arrêt existants</h2>
    <?php foreach ($points as $point): ?>
      <div class="card mb-2">
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $point['ID']; ?>">
            <div class="mb-3">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($point['Nom']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" name="description" rows="3" required><?php echo htmlspecialchars($point['Description']); ?></textarea>
            </div>
            <div class="mb-3">
              <label for="photo" class="form-label">Photo</label>
              <input type="file" class="form-control" name="photo">
              <input type="hidden" name="photo" value="<?php echo htmlspecialchars($point['Photo']); ?>">
              <img src="<?php echo htmlspecialchars($point['Photo']); ?>" alt="<?php echo htmlspecialchars($point['Nom']); ?>" class="img-fluid mt-2" style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-success" name="modifier">Modifier</button>
            <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

  </div>

  <!-- Bootstrap JS (optionnel) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  </main>
</body>
</html>
