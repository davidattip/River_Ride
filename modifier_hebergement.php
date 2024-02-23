<?php
include('includes/db.php');

// Récupérer l'ID de l'hébergement à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Gérer l'erreur ici
    die("ID de l'hébergement non fourni.");
}

// Récupérer les informations de l'hébergement
$sql = "SELECT * FROM hebergements WHERE ID = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$id]);
$hebergement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hebergement) {
    die("Hébergement non trouvé.");
}

// Récupérer tous les points d'arrêt pour les afficher
$stmt = $bdd->prepare("SELECT * FROM PointsDArret");
$stmt->execute();
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un hébergement</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="container mt-5">
    <h1>Modifier un hébergement</h1>

    <form method="post" action="admin_hebergement.php">
        <input type="hidden" name="id" value="<?php echo $hebergement['ID']; ?>">
        <div class="form-group">
            <label>Point d'arrêt</label>
            <select name="point_darret_id" class="form-control">
                <?php foreach ($points as $point): ?>
                    <option value="<?php echo $point['ID']; ?>" <?php echo ($point['ID'] == $hebergement['PointDArretID']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($point['Nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="<?php echo $hebergement['Nom']; ?>" required>
        </div>
        <!-- Vous pouvez ajouter un champ pour télécharger une image ici -->
        <div class="form-group">
            <label>Surface</label>
            <input type="number" name="surface" value="<?php echo $hebergement['Surface']; ?>" required>
        </div>
        <div class="form-group">
            <label>Nombre d'adultes</label>
            <input type="number" name="adultes" value="<?php echo $hebergement['Adultes']; ?>" required>
        </div>
        <div class="form-group">
            <label>Nombre d'enfants</label>
            <input type="number" name="enfants" value="<?php echo $hebergement['Enfants']; ?>" required>
        </div>
        <div class="form-group">
            <label>Prix par nuit</label>
            <input type="number" name="prixParNuit" value="<?php echo $hebergement['PrixParNuit']; ?>" required>
        </div>
        <div class="form-group">
            <label>Quantité</label>
            <input type="number" name="quantite" value="<?php echo $hebergement['Quantite']; ?>" required>
        </div>
        <div class="form-group">
            <label>Statut</label>
            <select name="statut">
                <option value="Disponible" <?php echo ($hebergement['Statut'] == 'Disponible') ? 'selected' : ''; ?>>Disponible</option>
                <option value="Indisponible" <?php echo ($hebergement['Statut'] == 'Indisponible') ? 'selected' : ''; ?>>Indisponible</option>
            </select>
        </div>
        <div class="form-group">
            <label>Date de début disponible</label>
            <input type="date" name="dateDebut" value="<?php echo $hebergement['DateDebutDisponible']; ?>" required>
        </div>
        <div class="form-group">
            <label>Date de fin disponible</label>
            <input type="date" name="dateFin" value="<?php echo $hebergement['DateFinDisponible']; ?>" required>
        </div>

        <input type="submit" name="modifier" value="Modifier" class="btn btn-primary">
    </form>
</div>

</body>
</html>
