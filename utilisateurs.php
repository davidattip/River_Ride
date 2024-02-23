<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        main {
            padding-top: 60px;  /* Ajout d'un padding en haut pour éviter le chevauchement */
        }
    </style>
</head>
<body>
    
        <?php 
            include('includes/header.php');
        ?>
    
    <main>
    <div class="container">
        <h1>Liste utilisateurs</h1>

        <input type="text" id="searchInput" class="form-control" placeholder="Trouver un utilisateur" onkeyup="rechercher()">
        <div id="carTable" class="table-responsive">

        <?php
        include('includes/db.php');

        $q = 'SELECT nom, prenom, id FROM users';

        $req = $bdd->prepare($q);
        $req->execute();
        $users = $req->fetchAll(PDO::FETCH_ASSOC);

        if (count($users) > 0) {
            echo '<table class="table">
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Actions</th>
                    </tr>';
            foreach ($users as $index => $user) {
                echo '<tr>
                        <td>' . $user['id'] . '</td>
                        <td>' . $user['nom'] . '</td>
                        <td>' . $user['prenom'] . '</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="modification.php?id=' . $user['id'] . '">Modifier</a>
                            <a class="btn btn-danger btn-sm" href="bannir.php?id=' . $user['id'] . '">Supprimer</a>
                        </td>
                    </tr>';
            }
            echo '</table>';
        } else {
            echo '<p>Aucun utilisateur trouvé.</p>';
        }
        ?>
    </div> 
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function rechercher() {
        var searchQuery = document.getElementById('searchInput').value;
        var xhr = new XMLHttpRequest();


        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {

                    if (xhr.responseText.length !== 0) {
                        var carTable = document.getElementById('carTable');
                        carTable.innerHTML = xhr.responseText;
                    }

                } else {
                    console.error('Une erreur s\'est produite.');
                }
            }
        };

        xhr.open('GET', 'search_users.php?dmd=' + encodeURIComponent(searchQuery), true);
        xhr.send();
    }
    </script>
</body>
</html>
