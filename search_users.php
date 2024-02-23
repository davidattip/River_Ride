<?php
include('includes/db.php');

$content = $_GET['dmd'];

// Requête pour rechercher les utilisateurs correspondants à la recherche
$q = 'SELECT nom, prenom, id FROM users WHERE nom LIKE :searchQuery OR prenom LIKE :searchQuery';
$req = $bdd->prepare($q);
$req->execute(array(':searchQuery' => '%' . $content . '%'));
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
                <a class="btn btn-danger btn-sm" href="suppression.php?id=' . $user['id'] . '">Supprimer</a>
            </td>
            </tr>';
    }
    echo '</table>';
} else {
    echo '<p>Aucun utilisateur trouvé.</p>';
}
?>
