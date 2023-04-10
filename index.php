<!-- Buka dashboard.midtrans.com > Environtment > Sand box (Mode Uji Coba transaksinya ga beneran)  -->
<!-- Pengaturan > Access Key -->

<!-- Payment gateway midtrans: https://github.com/Midtrans/midtrans-php -->
<!-- PAYMENT GATEWAY Bisa di Folder Snap/Snap-redirect. ada 3 Metode. checkout/checkout-simple nahh -->
<!-- Folder midtrans/example/snap/checkout-process-simple-version.php | Pay with snap -->
<?php
include "./connect.php"; 
$data = getData("SELECT * FROM client ORDER BY id DESC"); 

if(isset($_POST['btnpayment'])) {
    $idpesanan = rand();
    insertData($_POST, $idpesanan); 
    header("Location: ./midtrans/examples/snap/checkout-process-simple-version.php?pesanan=$idpesanan");
    // Transaksi Uji Coba menggunakan BCA KLIK PAY
    // Transaksi Jika sudah berhasil 
    // https://dashboard.sandbox.midtrans.com/transactions

    // Transaksi Uji coba menggunakan QRIS GOPAY
    // https://simulator.sandbox.midtrans.com/qris/index

    // Problemnya Status tidak akan berubah jika pembayaran berhasil dilakukan 
    // Solvingnya Pergi Ke 
    // Dashboard.sandbox.midtrans.com > Pengaturan > Konfigurasi 
    // WEBNYA HARUS DI HOSTING DULU. KARNA UNTUK PENGISIAN KONFIGURASI HARUS LINK HTTP BUKAN HTTPS
    // NOTE: BISA PAKE NGROK 
    /* Isi 
         Payment notification Url     (http://blabla.com/midtrans/examples/notification-handler.php)
         Reccuring notification Url   (http://blabla.com/midtrans/examples/notification-handler.php)
         Pay account notification Url (http://blabla.com/midtrans/examples/notification-handler.php)
         Finish Redirect Url          (http://blabla.com/tabel.php)  
         Unfinish Redirect Url        (http://blabla.com/index.php)  
         Error Redirect Url           (http://blabla.com/index.php)  
    */

    // JIKA SUDAH PERGI KE folder midtrans/examples/notification-handler.php    
}
?>
<form action="" method="post">
    <input type="text" name="nama" placeholder="Nama"><br>              
    <input type="email" name="email" placeholder="Email"><br>              
    <button class="btn btn-primary" name="btnpayment">Payment Gateway</button>
</form>

<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Biaya</th>
        <th>ID Pesanan</th>
        <th>Status</th>
        <th>notif - order_id</th>
        <th>notif - transaction_status</th>
        <th>notif - transaction_id</th>
    </tr>

<!-- Contoh tabel Jadinya
No | Nama | Email	       | Biaya | ID Pesanan | Status	      | notif - order_id | notif - transaction_status | notif - transaction_id
1  | bimo | bimo@gmail.com | 10000 | 1675300530 | Payment Success | 1675300530	     | settlement	              | 5cd0cdfe-8a44-4f41-b5df-5192112db0e8
-->
    <?php $no=1; ?>
    <?php foreach($data as $d): ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['nama']; ?></td>
        <td><?php echo $d['email']; ?></td>
        <td><?php echo $d['biaya']; ?></td>
        <td><?php echo $d['id_pesanan']; ?></td>
        <td>
            <?php 
                if($d['status'] >= 3)
                    echo "Payment Success";
                elseif($d['status'] >= 2) 
                    echo "Payment Pending";
                else 
                    echo "Payment Failed";
            ?>
        </td>
        <!-- Kolom Bawaan Midtrans (Gausah dibuat kolomnya didatabase juga gapapa. cuman buat notifikasi) -->
        <td><?php echo $d['oid']; ?></td>
        <td><?php echo $d['transaction_status']; ?></td>
        <td><?php echo $d['transaction_id']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>