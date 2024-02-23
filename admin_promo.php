<?php
include('includes/db.php');

// Ajout d'un nouveau code promo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $code = $_POST['code'];
    $discount = $_POST['discount'];

    $stmt = $bdd->prepare("INSERT INTO promo_codes (code, discount) VALUES (?, ?)");
    if ($stmt->execute([$code, $discount])) {
        $_SESSION['message'] = 'Code promo ajouté avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Modification d'un code promo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];

    $stmt = $bdd->prepare("UPDATE promo_codes SET code = ?, discount = ? WHERE id = ?");
    if ($stmt->execute([$code, $discount, $id])) {
        $_SESSION['message'] = 'Code promo modifié avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Suppression d'un code promo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $id = $_POST['id'];
    $stmt = $bdd->prepare("DELETE FROM promo_codes WHERE id = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['message'] = 'Code promo supprimé avec succès!';
        $_SESSION['message_type'] = 'success';
    }
}

// Récupération de tous les codes promo pour les afficher
$stmt = $bdd->prepare("SELECT * FROM promo_codes");
$stmt->execute();
$codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Administration des codes promo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
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

    <h1 class="my-4">Administration des codes promo</h1>

    <!-- Formulaire pour ajouter un code promo -->
    <div class="card mb-4">
      <div class="card-header">
        Ajouter un code promo
      </div>
      <div class="card-body">
        <form method="POST">
          <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" name="code" required>
          </div>
          <div class="mb-3">
            <label for="discount" class="form-label">Discount</label>
            <input type="number" class="form-control" name="discount" required>
          </div>
          <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
        </form>
      </div>
    </div>

    <!-- Liste des codes promo existants -->
    <h2 class="my-4">Codes promo existants</h2>
    <?php foreach ($codes as $code): ?>
      <div class="card mb-2">
        <div class="card-body">
          <form method="POST">
            <input type="hidden" name="id" value="<?php echo $code['id']; ?>">
            <div class="mb-3">
              <label for="code" class="form-label">Code</label>
              <input type="text" class="form-control" name="code" value="<?php echo htmlspecialchars($code['code']); ?>" required>
            </div>
            <div class="mb-3">
              <label for="discount" class="form-label">Discount</label>
              <input type="number" class="form-control" name="discount" value="<?php echo htmlspecialchars($code['discount']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success" name="modifier">Modifier</button>
            <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</body>
</html>
