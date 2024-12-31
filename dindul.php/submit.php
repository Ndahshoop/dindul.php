<?php
// Memeriksa apakah data telah disubmit
if (isset($_POST['username'])) {
    // Mengambil data dari formulir dengan sanitasi untuk keamanan
    $uname = htmlspecialchars($_POST['username']);
    $NIM = htmlspecialchars($_POST['NIM']);
    $Nama_prodi = htmlspecialchars($_POST['Nama_prodi']);
    $Email = htmlspecialchars($_POST['Email']);
    $password = htmlspecialchars($_POST['Password']);

    // Memproses array barang dan jumlah
    $barang = isset($_POST['barang']) ? $_POST['barang'] : []; // Array produk yang dipilih
    $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : []; // Array jumlah yang dipilih

    // Mengonversi array barang menjadi JSON untuk disimpan di database
    $jsonbarang = json_encode($barang);

    // Menghubungkan ke file koneksi.php
    include 'koneksi.php';

    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
    
    if (!empty($id)) {
        // Query untuk memperbarui data
        $sql = "UPDATE transaksi SET nama = '$uname', Nama_prodi='$Nama_prodi', email= '$Email', password = '$password', data_barang= '$jsonbarang' WHERE id= '$id'";
    } else {
        // Query untuk menyimpan data transaksi baru
        $sql = "INSERT INTO transaksi (nama, Nama_prodi, Email, Password, data_barang) VALUES ('$uname', '$Nama_prodi', '$Email', '$password', '$jsonbarang')";
    }

    // Menjalankan query
    if (mysqli_query($conn, $sql)) {
        $pesan = "Data berhasil disimpan!";
    } else {
        $pesan = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Menutup koneksi
    mysqli_close($conn);

    // Menyiapkan tampilan data dalam format invoice
    $tampil = "
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice { width: 800px; margin: 0 auto; border: 1px solid #000; padding: 10px; border-radius: 8px; }
        .header, .footer { text-align: center; }
        .content { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; } 
        th, td { text-align: left; padding: 5px; border: 1px solid #000; } 
    </style>
    <div class='invoice'>
        <div class='header'>
            <img src='https://th.bing.com/th/id/OIP.M7BUE9KUG4qitJngWSHrvgHaHa?w=177&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7' alt='Logo'>
            <h2 style='color: #800080;'>Invoice</h2>
            <p style='color: #800080;'>Data Pengguna</p>
        </div>
        <div class='content'>
            <table>
                <tr>
                    <th>Username</th>
                    <td>" . $uname . "</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>" . $NIM . "</td>
                </tr>
                <tr>
                    <th>Nama Prodi</th>
                    <td>" . $Nama_prodi . "</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>" . $Email . "</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>" . $password . "</td>
                </tr>
                <tr>
                    <th>Barang yang dipilih</th>
                    <td>";

    $totalHarga = 0;
    if (!empty($barang)) {
        foreach ($barang as $key => $product) {
            $product_quantity = isset($jumlah[$key]) ? (int)htmlspecialchars($jumlah[$key]) : 0;
            $product_price = 0;

            if ($product == 'Kerudung') {
                $product_price = 100000;
            } elseif ($product == 'Mukena') {
                $product_price = 250000;
            } elseif ($product == 'Gamis Abaya') {
                $product_price = 300000;
            } elseif ($product == 'Dress') {
                $product_price = 350000;
            } elseif ($product == 'T-Shirt') {
                $product_price = 80000;
            }

            $subtotal = $product_price * $product_quantity;
            $totalHarga += $subtotal;

            $tampil .= "<p>$product - jumlah: $product_quantity - subtotal: Rp " . number_format($subtotal, 0, ',', '.') . "</p>";
        }
    } else {
        $tampil .= "<p>Tidak ada barang yang dipilih.</p>";
    }

    $tampil .= "
                    </td>
                </tr>
            </table>
            <h3>Total Harga: Rp " . number_format($totalHarga, 0, ',', '.') . "</h3>
        </div>
        <div class='footer'>
            <p>Terima kasih sudah berbelanja!<br>Semoga harimu menyenangkan!</p>
        </div>
    </div>";
} else {
    $tampil = "
    <style>
        body { font-family: Arial, sans-serif; }
        .error { text-align: center; }
    </style>
    <div class='error'>
        <p>Data tidak disubmit. Silahkan coba lagi.</p>
    </div>";
}

echo $tampil;
?>
