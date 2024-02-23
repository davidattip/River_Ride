<?php
include('includes/db.php');

$discount = 0;

if (isset($_POST['promo'])) {
    $promo_code = $_POST['promo'];

    $sql = "SELECT discount FROM promo_codes WHERE code = ? AND expiry_date > NOW()";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$promo_code]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $discount = $result['discount'];
    }
}

echo json_encode(['discount' => $discount]);
?>
