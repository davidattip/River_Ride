<?php
require 'vendor/autoload.php'; // Assurez-vous d'avoir installé le SDK Stripe via Composer

\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY'); // Remplacez par votre propre clé secrète Stripe

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242'; // Remplacez par le domaine de votre site

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Réservation de transport de bagages',
            ],
            'unit_amount' => 2000, // Remplacez par le montant à payer
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success.php',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.php',
]);

echo json_encode(['id' => $checkout_session->id]);
?>
