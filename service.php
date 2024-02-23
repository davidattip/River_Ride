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
          // Récupération des points d'arrêt depuis la table 'pointsdarret'
          $points_darret = array();
          $query = "SELECT * FROM pointsdarret";
          $stmt = $bdd->prepare($query);
          $stmt->execute();
          
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $points_darret[] = $row;
          }
    ?>
    <main>
        <div class="container">
            <h1>Service de Transport de Bagages</h1>
            <form id="calculForm">
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
                <button type="button" onclick="calculerPrix()" class="btn btn-primary">Calculer le Prix</button>
                <button type="button" onclick="reserver()" class="btn btn-success">Réserver</button>
            </form>
        </div>
    </main>

    <script>
        function reserver() {
    var pointA = document.getElementById('pointA').value;
    var pointB = document.getElementById('pointB').value;
    var date = document.getElementById('date').value;
    var poids = document.getElementById('poids').value;
    var promo = document.getElementById('promo').value;
    var prix = document.getElementById('prix').textContent;

    // Envoi des données pour la réservation
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'reserver_bagage.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
            var data = JSON.parse(xhr.responseText);
            if(data.success) {
                // Redirection vers la page de paiement Stripe
                window.location.href = "stripe_payment_page.php?reservation_id=" + data.reservation_id;
            } else {
                alert('Erreur de réservation');
            }
        }
    };
    xhr.onerror = function () {
        alert('Erreur de connexion');
    };
    xhr.send('pointA=' + pointA + '&pointB=' + pointB + '&date=' + date + '&poids=' + poids + '&promo=' + promo + '&prix=' + prix);
}

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
<?php include('includes/footer.php'); ?> 
</html>
