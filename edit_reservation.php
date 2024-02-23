<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
  
    // Récupérer la réservation spécifique
    $sql = "SELECT * FROM reservations WHERE ID = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mettre à jour la réservation
    $id = $_POST['id'];
    $dateDebut = $_POST['DateDebut'];
    $dateFin = $_POST['DateFin'];
    $statut = $_POST['Statut'];

    $sql = "UPDATE reservations SET DateDebut = :dateDebut, DateFin = :dateFin, Statut = :statut WHERE ID = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':dateDebut', $dateDebut, PDO::PARAM_STR);
    $stmt->bindParam(':dateFin', $dateFin, PDO::PARAM_STR);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->execute();
  
    header('Location: admin_reservation.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Éditer la Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Éditer la Réservation</h1>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $reservation['ID']; ?>">
            <div class="mb-3">
                <label for="DateDebut">Date de début</label>
                <input type="date" name="DateDebut" id="DateDebut" value="<?php echo $reservation['DateDebut']; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="DateFin">Date de fin</label>
                <input type="date" name="DateFin" id="DateFin" value="<?php echo $reservation['DateFin']; ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="Statut">Statut</label>
                <input type="text" name="Statut" id="Statut" value="<?php echo $reservation['Statut']; ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
