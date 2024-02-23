
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Avec River ride, repoussez vos limites !</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <style>
        #board {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 10px;
            width: 240px;
            height: 240px;
            background-color: rgb(255, 255, 255);
            border: 5px solid #00000074;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }

        #board img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin: 0;
            padding: 0;
            border: none;
        }
    </style>
</head>

<body>
<?php include('includes/header.php'); ?>
<main class="container mt-5 mb-5">
    <h1>Connexion</h1>
    <div>
        <form action="verif_connexion.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Adresse mail">
            </div>
            <div class="form-group">
                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe">
            </div>
            
            <button type="submit" id="submit-btn" class="btn btn-primary" >Connexion</button>
        </form>
        <div>
            <a href="inscription.php" class="btn btn-secondary">Inscription</a>
        </div>
        <div>
            <p>  <strong><a href="mdp_oublie/formulaire_mdp.php"> Mot de passe oublié ?</a></strong></p>
        </div>
    </div>
</main>
<?php include('includes/footer.php'); ?> 


</body>
</html>
