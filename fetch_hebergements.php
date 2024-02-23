<?php
include('includes/db.php');

if (isset($_GET['point_id'])) {
    $pointId = $_GET['point_id'];
    $stmt = $bdd->prepare("SELECT * FROM hebergements WHERE PointDArretID = ?");
    $stmt->execute([$pointId]);
    $hebergements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($hebergements);
}
?>
