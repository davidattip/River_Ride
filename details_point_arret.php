<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Vérifier si un ID a été passé en paramètre d'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les détails du point d'arrêt spécifié
    $stmt = $bdd->prepare("SELECT * FROM pointsdarret WHERE ID = ?");
    $stmt->execute([$id]);
    $point = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($point) {
        // Point d'arrêt trouvé
    } else {
        // Point d'arrêt non trouvé
        echo "Point d'arrêt non trouvé.";
        exit;
    }
} else {
    // ID non spécifié
    echo "ID non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Détails du point d'arrêt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Détails du point d'arrêt</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($point['Nom']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($point['Description']); ?></p>
                <img src="<?php echo htmlspecialchars($point['Photo']); ?>" alt="<?php echo htmlspecialchars($point['Nom']); ?>" class="img-fluid mt-2" style="max-width: 400px;">
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
