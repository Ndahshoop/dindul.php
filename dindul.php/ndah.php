koneksi berhasil!<form action="submit.php" method="post" onsubmit="return validateform()"style="
    background-color: #f4f4f9;
    padding: 30px; 
    border-radius: 10px; 
    width: 100%; 
    max-width: 400px; 
    margin: 20px auto; 
    font-family: 'Poppins', sans-serif; 
    color: #333; 
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1); 
">
    <label for="username" style="display: block; margin-bottom: 8px; font-weight: bold;">Username:</label>
    <input type="text" name="username" required style="
        width: 100%; 
        padding: 12px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        box-sizing: border-box;
    ">

    <label for="NIM" style="display: block; margin-bottom: 8px; font-weight: bold;">NIM:</label>
    <input type="text" name="NIM" required style="
        width: 100%; 
        padding: 12px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        box-sizing: border-box;
    ">

    <label for="Nama_prodi" style="display: block; margin-bottom: 8px; font-weight: bold;">Nama Prodi:</label>
    <input type="text" name="Nama_prodi" required style="
        width: 100%; 
        padding: 12px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        box-sizing: border-box;
    ">
 
    <label for="Email" style="display: block; margin-bottom: 8px; font-weight: bold;">Email:</label>
    <input type="email" name="Email" required style ="
        width: 100%; 
        padding: 12px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        box-sizing: border-box;
    ">

    <label for="Password" style="display: block; margin-bottom: 8px; font-weight: bold;">Password:</label>
    <input type="password" id="Password" name="Password" placeholder="Password" required style="
        width: 100%; 
        padding: 12px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 8px; 
        box-sizing: border-box;
    ">

    <link href='ndah.php' rel='stylesheet'>
    <h2>Silahkan isi sesuai kebutuhan!</h2>

    <input type="hidden" nama="id" value="11">
        <table>

    <!-- Checkbox dan Input Jumlah untuk Barang -->
    <label style="display: block; margin-bottom: 10px; font-weight: bold;">Barang:</label>
    <div>
        <input type="checkbox" id="Kerudung" name="barang[]" value="Kerudung">
        <label for="Kerudung">Kerudung - Rp100.000</label>
        <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" style="width: 80px;">
        <input type="hidden" name="harga[]" value="100000">
    </div>
    <div>
        <input type="checkbox" id="Mukena" name="barang[]" value="Mukena">
        <label for="Mukena">Mukena - Rp250.000</label>
        <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" style="width: 80px;">
        <input type="hidden" name="harga[]" value="250000">
    </div>
    <div>
        <input type="checkbox" id="Gamis Abaya" name="barang[]" value="Gamis Abaya">
        <label for="Gamis Abaya">Gamis Abaya - RP.300.000</label>
        <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" style="width: 80px;">
        <input type="hidden" name="harga[]" value="300000">
    </div>
    <div>
        <input type="checkbox" id="Dress" name="barang[]" value="Dress">
        <label for="Dress">Dress - Rp.350.000</label>
        <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" style="width: 80px;">
        <input type="hidden" name="harga[]" value="350000">
    </div>
    <div>
        <input type="checkbox" id="T-Shirt" name="barang[]" value="T-Shirt">
        <label for="T-Shirt">T-Shirt - Rp.80.000</label>
        <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" style="width: 80px;">
        <input type="hidden" name="harga[]" value="80000">
    </div>

    <?php
    // Decode data barang terpilih
        $data_barang_terpilih = (!empty($data['data_barang'])) ?json_decode($data['data_barang'], true) : array ();
        ?>

    <!-- Tombol Hitung Total -->
    <button type="button" onclick="calculateTotal()" style="
        margin-top: 15px; 
        padding: 10px; 
        background-color: orange; 
        color: white; 
        border: none; 
        border-radius: 8px; 
        cursor: pointer;
    ">Hitung Total Harga</button>

    <p id="totalHarga" style="margin-top: 15px; font-weight: bold; color: #333;"></p>

    <input type="submit" value="Submit" style="
        width: 100%; 
        padding: 12px; 
        background-color: #4CAF50; 
        color: white; 
        border: none; 
        border-radius: 8px; 
        cursor: pointer; 
        font-size: 16px;
    ">
</form>

<script>
function validateform() {
    var Password = document.getElementById("Password").value;
    if (Password.length < 6) {
        alert("Password harus memiliki minimal 6 karakter");
        return false;
    }
    return true;
}

function calculateTotal() {
    var checkboxes = document.querySelectorAll('input[name="barang[]"]:checked');
    var jumlahInputs = document.querySelectorAll('input[name="jumlah[]"]');
    var hargaInputs = document.querySelectorAll('input[name="harga[]"]');
    let total = 0;

    checkboxes.forEach((checkbox, index) => {
        var jumlah = parseInt(jumlahInputs[index].value) || 0; // Get jumlah or default to 0
        var harga = parseInt(hargaInputs[index].value); // Get the price from hidden input
        if (jumlah > 0) {
            total += harga * jumlah; // Add to the total price
        }
    });

    console.log("Total Harga: Rp " + total.toLocaleString());  // Debug log
    document.getElementById("totalHarga").innerText = "Total Harga: Rp " + total.toLocaleString(); // Update the total on the page
}
</script>
