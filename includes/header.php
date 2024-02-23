<?php 
 if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

?>

<header class="fixed-top">
  <nav class="navbar navbar-expand-lg navbar-light bg-light position-fixed w-100">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="river.png" alt="Logo" width="auto" height="100"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item pe-4">
            <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
          </li>

          <?php
            if(!isset($_SESSION['id'])){
              echo '<li class="nav-item pe-4"> <a class="nav-link" href="connexion.php">Nos packs</a></li>';
              echo '<li class="nav-item pe-4"><a class="btn btn-primary" href="connexion.php">Connexion</a></li>';
            } else {
              if($_SESSION['role'] == "user") {
                echo '<li class="nav-item pe-4"><a class="nav-link" href="packs.php">Nos packs</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="compose_iti.php">Composer son itinéraire</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="service.php">Services</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="profil_client.php">Profil & Réservations</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="client.php">Panier</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="deconnexion.php">Deconnexion</a></li>';
              }
              if($_SESSION['role'] == "admin") {
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_packs.php">Packs</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_point_arret.php">Points d\'arrêts</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_hebergement.php">Hébergements</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_reservation.php">Réservations</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_iti.php">Itinéraires</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="admin_promo.php">Code promo</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="utilisateurs.php">Utilisateurs</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="newsletter/compose.php">Newsletter</a></li>';
                echo '<li class="nav-item pe-4"><a class="nav-link" href="deconnexion.php">Deconnexion</a></li>';
              }
            }
          ?>
        </ul>  
      </div>
    </div>
  </nav>
</header>
<style>
  body {
    padding-top: 100px;  /* Hauteur de l'espace en haut, ajustez selon la hauteur de votre en-tête */
  }
</style>
