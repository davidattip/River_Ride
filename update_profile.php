<?php
// Inclure le fichier de connexion à la base de données
include('includes/db.php');

// Vérifier si la session est démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    
    // Récupérer l'ID de l'utilisateur à partir de la session
    $userId = $_SESSION['id'];

    // Préparer la requête SQL pour mettre à jour les données
    $stmt = $bdd->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :userId");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':userId', $userId);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Mettre à jour a réussi
        header('Location: profil_client.php?update=success');
    } else {
        // Échec de la mise à jour
        header('Location: profil_client.php?update=fail');
    }
} else {
    // Rediriger vers la page de profil si la méthode n'est pas POST
    header('Location: profil_client.php');
}
?>
