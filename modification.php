<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Modification</title>
</head>

<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $dn = trim($_POST['dn']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    if (empty($nom) || empty($prenom) || empty($dn) || empty($email) ){
        header('location:modification.php?message=Veuillez remplir tous les champs indiqués.');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location:modification.php?message=Email invalide.');
        exit;
    }

    if(isset($_GET['id']) ){
        $id = $_GET['id'];
    } 

    include('includes/db.php');

    $q = 'UPDATE users SET nom = :nom, prenom = :prenom, email = :email, date = :dn, role = :role WHERE id = :id';

    $req = $bdd->prepare($q);

    $req->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'dn' => $dn,
        'role' => $role,
        'id' => $id
    ]);

    header('location:utilisateurs.php?message= La modification a été prise en compte');
    exit;

}

?>

<main>
    <h1>Modifier le profil</h1>
        <div>
            <form method="POST">
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="prenom" placeholder="Prénom"> 
                <input type="email" name="email" placeholder="Adresse mail">
                <input type="date" name="dn" placeholder="Date de naissance">
                <select name="role">
                <option value="user">Client</option>
                <option value="admin">Admin</option>
                <option value="coach">Coach</option>
            </select>
                <button type="submit" class="send">Modifier</button>
            </form>
        </div>   
        
</main>
</body>
</html>