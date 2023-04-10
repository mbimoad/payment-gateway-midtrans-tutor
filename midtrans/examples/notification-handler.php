<?php
namespace Midtrans;
require_once dirname(__FILE__) . '/../Midtrans.php';
require "../../connect.php";

Config::$isProduction = false;
Config::$serverKey = 'SB-Mid-server-ktUiPYbLuSyrPMWHyR7OKHFO';
// non-relevant function only used for demo/example purpose
printExampleWarningMessage();
try {
    $notif = new Notification();
}
catch (\Exception $e) {
    exit($e->getMessage());
}

// DEFAULT RESPONSE DARI MIDTRANS. (BUKAN KOLOM DATABASE)
$notif               = $notif->getResponse();
$vtransaction_status = $notif->transaction_status;
$vtransaction_id     = $notif->transaction_id;
$vorder_id           = $notif->order_id;

// $fraud       = $notif->fraud_status;
// if ($transaction == 'capture') {
//     // For credit card transaction, we need to check whether transaction is challenge by FDS or not
//     if ($type == 'credit_card') {
//         if ($fraud == 'challenge') {
//             // TODO set payment status in merchant's database to 'Challenge by FDS'
//             // TODO merchant should decide whether this transaction is authorized or not in MAP
//             echo "Transaction order_id: " . $order_id ." is challenged by FDS";
//         } else {
//             // TODO set payment status in merchant's database to 'Success'
//             echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
//         }
//     }
// }

if ($vtransaction_status == 'settlement') {
    updateStatus($vtransaction_id, $vtransaction_status, $vorder_id, 3);
} else if ($vtransaction_status == 'pending') {
    updateStatus($vtransaction_id, $vtransaction_status, $vorder_id, 2);
} else if ($vtransaction_status == 'deny') {
    updateStatus($vtransaction_id, $vtransaction_status, $vorder_id, 1);
} else if ($vtransaction_status == 'expire') {
    updateStatus($vtransaction_id, $vtransaction_status, $vorder_id, 1);
} else if ($vtransaction_status == 'cancel') {
    updateStatus($vtransaction_id, $vtransaction_status, $vorder_id, 1);
}

function printExampleWarningMessage() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
    }
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-ktUiPYbLuSyrPMWHyR7OKHFO\';');
        die();
    }   
}
