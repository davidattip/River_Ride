<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <div class="title">
       <link rel="stylesheet" href="style.css">

        <title>Inscription</title>
    </div>
</head>

<body>
<header>
</header>
<main>
    <h1>Poursuivez votre inscription</h1>
        <div>
            <form action="verif_inscription.php" method="POST">  
            <?php
                // Récupération des données de la première étape
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $dn = $_POST['dn'];
            ?>  
                <input type="hidden" name="nom" value="<?php echo $nom; ?>">  
                <input type="hidden" name="prenom" value="<?php echo $prenom; ?>">
                <input type="hidden" name="dn" value="<?php echo $dn; ?>">         
                <input type="email" name="email" placeholder="Adresse mail">
                <input type="password" name="mdp" placeholder="Mot de passe">
                <button type="submit" class="send">Inscription</button>
            </form>
            <li>
                <a href="index.php">Connexion</a>
            </li>
        </div>
        
</main>
</body>
</html>

