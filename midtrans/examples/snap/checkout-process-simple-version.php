<?php
namespace Midtrans;
require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-ktUiPYbLuSyrPMWHyR7OKHFO';
Config::$clientKey = 'SB-Mid-client-5Vqd3LDFtuERXo-2';

printExampleWarningMessage();
Config::$isSanitized = Config::$is3ds = true;

require "../../../connect.php"; 
$vpesanan = $_GET['pesanan'];
$client   = getData("SELECT * FROM client WHERE id_pesanan='$vpesanan'")[0]; 

// Required
$transaction_details = array(
    'order_id'     => $client['id_pesanan'], // Ambil Inputan User
    'gross_amount' => $client['biaya'],      // no decimal allowed for creditcard
);
// Optional
$item_details = array (
    array(
        'id' => 'a1',
        'price' => $client['biaya'],
        'quantity' => 1,
        'name' => "Wedding Invitation"
    ),
  );
// Optional
$customer_details = array(
    'first_name'    => $client['nama'],
    'last_name'     => "",
    'email'         => $client['email'],
    'phone'         => "082124663487",
    // 'billing_address'  => $billing_address,
    // 'shipping_address' => $shipping_address
);
// Fill transaction details
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
}
catch (\Exception $e) {
    echo $e->getMessage();
}
// echo "snapToken = ".$snap_token;

function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        // Tambahkan Server Keynya
        echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-ktUiPYbLuSyrPMWHyR7OKHFO\';');
        die();
    } 
}

?>

<!DOCTYPE html>
<html>
    <body>
        <p>Registrasi Berhasil Selesaikan Pembayaran</p>
        <button id="pay-button">Pay!</button>
        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('<?php echo $snap_token?>');
            };
        </script>
    </body>
</html>
