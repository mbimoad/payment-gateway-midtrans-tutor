<?php
namespace Midtrans;
require_once dirname(__FILE__) . '/../../Midtrans.php';


// Checkout ini langsung Redirect ke halaman lain untuk payment gatewaynya
Config::$serverKey = 'SB-Mid-server-ktUiPYbLuSyrPMWHyR7OKHFO';
printExampleWarningMessage();

$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => 145000, // no decimal allowed for creditcard
);

// Optional
$item1_details = array(
    'id' => 'a1',
    'price' => 50000,
    'quantity' => 2,
    'name' => "Apple"
);

// Optional
$item2_details = array(
    'id' => 'a2',
    'price' => 45000,
    'quantity' => 1,
    'name' => "Orange"
);

// Optional
$item_details = array ($item1_details, $item2_details);

// Optional
$billing_address = array(
    'first_name'    => "Andri",
    'last_name'     => "Litani",
    'address'       => "Mangga 20",
    'city'          => "Jakarta",
    'postal_code'   => "16602",
    'phone'         => "081122334455",
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    => "Obet",
    'last_name'     => "Supriadi",
    'address'       => "Manggis 90",
    'city'          => "Jakarta",
    'postal_code'   => "16601",
    'phone'         => "08113366345",
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    => "Andri",
    'last_name'     => "Litani",
    'email'         => "andri@litani.com",
    'phone'         => "081122334455",
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

// Fill SNAP API parameter
$params = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

try {
    // Get Snap Payment Page URL
    $paymentUrl = Snap::createTransaction($params)->redirect_url;
  
    // Redirect to Snap Payment Page
    header('Location: ' . $paymentUrl);
}
catch (\Exception $e) {
    echo $e->getMessage();
}

function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'<your server key>\';');
        die();
    } 
}
