<?php
require 'vendor/autoload.php'; // Make sure you ran: composer require stripe/stripe-php

// Allow requests from frontend (if on different domain)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

use Stripe\StripeClient;

$stripe = new StripeClient('sk_test_51SCJjjRrq2LqEckHn2BjwE70y4aJ5hYxLPtCMls9jznZUiDqn6Sm60J043rd7hJ93bwMbJswbOABZNuR8zPEMDlt002DrkMKnK');

// Read JSON input from frontend
$input = json_decode(file_get_contents("php://input"), true);

$name = isset($input['name']) ? trim($input['name']) : '';
$email = isset($input['email']) ? trim($input['email']) : '';
$amount = isset($input['amount']) ? intval($input['amount']) : 0; // in INR

// Validate input
if (empty($name) || empty($email) || $amount <= 0) {
    echo json_encode(['error' => 'Invalid request. Name, email, and amount are required.']);
    exit;
}

try {
    // Create Stripe PaymentIntent
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => $amount * 100, // amount in paisa
        'currency' => 'inr',
        'payment_method_types' => ['card'],
        'receipt_email' => $email,
        'description' => "Property purchase by $name",
    ]);

    // Return client secret to frontend
    echo json_encode([
        'client_secret' => $paymentIntent->client_secret
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Return error message
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>