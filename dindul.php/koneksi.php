<?php
// mengatur data koneksi
$host = "localhost"; // Alamat server Mysql (biasanya local host)
$user = "root"; // Username MySQL (delfaut: root)
$pass = ""; // password MySQL (delfaut : kosong)
$dbname = "belajar_php_kelasd"; // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $dbname);

// cek apakah koneksi berhasil
if (!$conn) {
    die("koneksi tidak berhasil: " . mysqli_connect_error());
}
echo "koneksi sukses!";
?>