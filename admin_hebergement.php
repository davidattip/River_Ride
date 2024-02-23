<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Fonction pour vérifier si tous les champs nécessaires sont présents dans POST
function postContainsFields($fields) {
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            return false;
        }
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['nom', 'surface', 'adultes', 'enfants', 'prixParNuit', 'quantite', 'statut', 'point_darret_id', 'dateDebut', 'dateFin'];

    if (isset($_POST['ajouter']) && postContainsFields($requiredFields)) {
        $nom = $_POST['nom'];
    $surface = $_POST['surface'];
    $adultes = $_POST['adultes'];
    $enfants = $_POST['enfants'];
    $prixParNuit = $_POST['prixParNuit'];
    $quantite = $_POST['quantite'];
    $statut = $_POST['statut'];
    $point_darret_id = $_POST['point_darret_id'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    // Code pour le téléchargement de l'image (à compléter)
    $photo = 'chemin/vers/image.jpg';

     // Votre requête SQL modifiée
     $sql = "INSERT INTO hebergements (Nom, Photo, Surface, Adultes, Enfants, PrixParNuit, Quantite, Statut, PointDArretID, DateDebutDisponible, DateFinDisponible) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
     $stmt= $bdd->prepare($sql);
     $stmt->execute([$nom, $photo, $surface, $adultes, $enfants, $prixParNuit, $quantite, $statut, $point_darret_id, $dateDebut, $dateFin]);
    }
    elseif (isset($_POST['modifier']) && postContainsFields(array_merge(['id'], $requiredFields))) {
        $id = $_POST['id'];
    $nom = $_POST['nom'];
    $surface = $_POST['surface'];
    $adultes = $_POST['adultes'];
    $enfants = $_POST['enfants'];
    $prixParNuit = $_POST['prixParNuit'];
    $quantite = $_POST['quantite'];
    $statut = $_POST['statut'];
    $point_darret_id = $_POST['point_darret_id'];
    // etc. pour chaque champ
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    // Code pour le téléchargement de l'image (à compléter)
    $photo = 'chemin/vers/image.jpg';

     // Votre requête SQL modifiée
     $sql = "UPDATE hebergements SET Nom=?, Photo=?, Surface=?, Adultes=?, Enfants=?, PrixParNuit=?, Quantite=?, Statut=?, PointDArretID=?, DateDebutDisponible=?, DateFinDisponible=? WHERE ID=?";
     $stmt= $bdd->prepare($sql);
     $stmt->execute([$nom, $photo, $surface, $adultes, $enfants, $prixParNuit, $quantite, $statut, $point_darret_id, $dateDebut, $dateFin, $id]);
    }
    elseif (isset($_POST['supprimer']) && isset($_POST['id'])) {
        $id = $_POST['id'];
    $sql = "DELETE FROM hebergements WHERE ID=?";
    $stmt= $bdd->prepare($sql);
    $stmt->execute([$id]);
    }
    else {
        echo" Données POST incomplètes ou incorrectes";
    }
}
// Afficher les hébergements existants
$sql = "SELECT * FROM hebergements";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$hebergements = $stmt->fetchAll();

// Récupérer tous les points d'arrêt pour les afficher
$stmt = $bdd->prepare("SELECT * FROM PointsDArret");
$stmt->execute();
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Hébergements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('includes/header.php'); ?>
<main>
<div class="container mt-5">
    <h1 class="mb-4">Gestion des hébergements</h1>

    <div class="mb-4">
        <label for="point_select" class="form-label">Sélectionner un point d'arrêt</label>
        <select id="point_select" class="form-control">
            <?php foreach ($points as $point): ?>
                <option value="<?php echo $point['ID']; ?>"><?php echo htmlspecialchars($point['Nom']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <form method="post" class="mb-4">
        <h2 class="mb-3">Ajouter un hébergement</h2>
        <div class="form-group">
            <label>Point d'arrêt</label>
            <select name="point_darret_id" class="form-control">
                <?php foreach ($points as $point): ?>
                <option value="<?php echo $point['ID']; ?>"><?php echo htmlspecialchars($point['Nom']); ?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <label>Nom</label>
        <input type="text" name="nom" required><br>
        <!-- Vous pouvez ajouter un champ pour télécharger une image ici -->
        <label>Surface</label>
        <input type="number" name="surface" required><br>
        <label>Nombre d'adultes</label>
        <input type="number" name="adultes" required><br>
        <label>Nombre d'enfants</label>
        <input type="number" name="enfants" required><br>
        <label>Prix par nuit</label>
        <input type="number" name="prixParNuit" required><br>
        <label>Quantité</label>
        <input type="number" name="quantite" required><br>
        <label>Statut</label>
        <select name="statut">
            <option value="Disponible">Disponible</option>
            <option value="Indisponible">Indisponible</option>
        </select><br>
        <label>Date de début disponible</label>
    <input type="date" name="dateDebut" required><br>
    <label>Date de fin disponible</label>
    <input type="date" name="dateFin" required><br>
        <input type="submit" name="ajouter" value="Ajouter" class="btn btn-primary mt-3">
    </form>

    <h2 class="mb-3">Liste des hébergements</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Surface</th>
                <th>Adultes</th>
                <th>Enfants</th>
                <th>Prix par nuit</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Date début</th> <!-- Nouvelle colonne -->
                <th>Date fin</th>  <!-- Nouvelle colonne -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="hebergements-list">
            <?php foreach ($hebergements as $hebergement): ?>
                <tr>
                    <td><?php echo $hebergement['ID']; ?></td>
                    <td><?php echo $hebergement['Nom']; ?></td>
                    <td><?php echo $hebergement['Surface']; ?></td>
                    <td><?php echo $hebergement['Adultes']; ?></td>
                    <td><?php echo $hebergement['Enfants']; ?></td>
                    <td><?php echo $hebergement['PrixParNuit']; ?></td>
                    <td><?php echo $hebergement['Quantite']; ?></td>
                    <td><?php echo $hebergement['Statut']; ?></td>
                    <td><?php echo $hebergement['DateDebutDisponible']; ?></td> <!-- Nouvelle cellule -->
                    <td><?php echo $hebergement['DateFinDisponible']; ?></td> 
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $hebergement['ID']; ?>">
                            <input type="submit" name="supprimer" value="Supprimer">
                        </form>
                        <a href="modifier_hebergement.php?id=<?php echo $hebergement['ID']; ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const pointSelect = document.getElementById('point_select');

  pointSelect.addEventListener('change', function() {
    const pointId = this.value;
    fetch(`fetch_hebergements.php?point_id=${pointId}`)
      .then(response => response.json())
      .then(data => {
        let tableContent = '';
        data.forEach(row => {
          tableContent += `
            <tr>
              <td>${row.ID}</td>
              <td>${row.Nom}</td>
              <td>${row.Surface}</td>
              <td>${row.Adultes}</td>
              <td>${row.Enfants}</td>
              <td>${row.PrixParNuit}</td>
              <td>${row.Quantite}</td>
              <td>${row.Statut}</td>
              <td>${row.DateDebutDisponible}</td>  <!-- Nouvelle cellule -->
              <td>${row.DateFinDisponible}</td>
              <td>
                <!-- Votre code pour les boutons Modifier/Supprimer -->
              </td>
            </tr>
          `;
        });

        document.getElementById('hebergements-list').innerHTML = tableContent;
      });
   
  });
});
</script>
</main>
</body>
</html>

