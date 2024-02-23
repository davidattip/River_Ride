<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Avec river ride, repoussez vos limites !</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
</header>
<main class="container">
    <h1>Inscription</h1>
    <div>
        <form action="inscription2.php" method="POST">
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom">
            </div>
            <div class="form-group">
                <input type="text" name="prenom" class="form-control" placeholder="Prénom"> 
            </div>
            <div class="form-group">
                <input type="date" name="dn" class="form-control" placeholder="Date de naissance"> 
            </div>
            <button type="submit" class="btn btn-primary">Inscription</button>
        </form>
        <div>
            <a href="connexion.php" class="btn btn-secondary">Suivant</a>
        </div>
    </div>
</main>
</body>
</html>
