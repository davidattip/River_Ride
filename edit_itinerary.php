<?php
// Vérifiez si l'utilisateur est un administrateur
// if ($_SESSION['role'] !== 'admin') {
//    header('Location: index.php');
//    exit();
//}

// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Récupérer l'ID de l'itinéraire à éditer
$id = $_GET['id'];

// Requête SQL pour obtenir les détails de l'itinéraire
$sql = "SELECT * FROM itineraire WHERE ItineraireID = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$id]);
$itinerary = $stmt->fetch(PDO::FETCH_ASSOC);

// Requête SQL pour obtenir tous les utilisateurs
$sql = "SELECT id, nom, prenom FROM users";
$stmt = $bdd->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mise à jour de l'itinéraire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUserID = $_POST['UserID'];
    $newNom = $_POST['Nom'];

    $sql = "UPDATE itineraire SET UserID = ?, Nom = ? WHERE ItineraireID = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$newUserID, $newNom, $id]);

    header('Location: itineraries.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Itinerary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Itinerary</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="UserID" class="form-label">User</label>
                <select name="UserID" id="UserID" class="form-control">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == $itinerary['UserID']) ? 'selected' : ''; ?>>
                            <?php echo $user['nom'] . ' ' . $user['prenom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="Nom" class="form-label">Itinerary Name</label>
                <input type="text" name="Nom" id="Nom" class="form-control" value="<?php echo $itinerary['Nom']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
