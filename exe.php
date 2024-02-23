<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service de Transport de Bagages</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        main {
            padding-top: 60px;
        }
    </style>
</head>
<body>
    <?php 
        include('includes/header.php');
        include('includes/db.php'); // Connexion à la base de données
    ?>
    <main>
        <div class="container">
            <h1>Service de Transport de Bagages</h1>
            <form action="calcul_prix.php" method="post" id="calculForm">
            <div class="form-group">
                    <label for="pointA">Point d'arrêt A:</label>
                    <select id="pointA" name="pointA" class="form-control">
                        <?php foreach($points_darret as $point): ?>
                            <option value="<?php echo $point['ID']; ?>"><?php echo $point['Nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="pointB">Point d'arrêt B:</label>
                    <select id="pointB" name="pointB" class="form-control">
                        <?php foreach($points_darret as $point): ?>
                            <option value="<?php echo $point['ID']; ?>"><?php echo $point['Nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date">Date et Heure:</label>
                    <input type="datetime-local" id="date" name="date" class="form-control">
                </div>


                <div class="form-group">
                    <label for="poids">Poids des bagages (en kg):</label>
                    <input type="number" id="poids" name="poids" step="0.1" class="form-control" oninput="calculerPrix()">
                </div>
                
                <div class="form-group">
                    <label for="promo">Code Promo:</label>
                    <input type="text" id="promo" name="promo" class="form-control" oninput="calculerPrix()">
                </div>

                <div class="form-group">
                    <label for="prix">Prix estimé :</label>
                    <span id="prix" class="form-control">0</span> euros
                </div>
                <input type="submit" value="Calculer le Prix" class="btn btn-primary">
            </form>
        </div>
    </main>

    <script>
        function calculerPrix() {
            var poids = document.getElementById('poids').value;
            var tarif_par_kg = 5;
            var prix = poids * tarif_par_kg;

            // AJAX pour valider le code promo
            var promo_code = document.getElementById('promo').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'validate_promo.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = JSON.parse(xhr.responseText);
                    var discount = data.discount || 0;
                    var final_price = prix * (1 - discount / 100);
                    document.getElementById('prix').textContent = final_price.toFixed(2);
                } else {
                    console.error('Erreur du serveur');
                }
            };
            xhr.onerror = function () {
                console.error('Erreur de connexion');
            };
            xhr.send('promo=' + promo_code);
        }
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
