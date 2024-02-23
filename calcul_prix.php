<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Vérifier si les données du formulaire ont été soumises
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pointA = $_POST['pointA'];
    $pointB = $_POST['pointB'];
    $date = $_POST['date'];
    $poids = $_POST['poids'];

    // Tarif par kilogramme (exemple : 5 euros par kg)
    $tarif_par_kg = 5;

    // Calcul du prix total
    $prix_total = $poids * $tarif_par_kg;

    // Afficher le résultat
    echo "<h1>Le coût total du transport de bagages est de : $prix_total euros</h1>";
    echo "<a href='service.php'>Retour</a>";

    // Ici, vous pouvez également enregistrer ces informations dans la base de données si nécessaire

} else {
    // Rediriger vers la page de formulaire si la méthode n'est pas POST
    header('Location: service.php');
}
?>

