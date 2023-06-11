<?php
header('Content-Type: application/json; charset=utf8');

// Allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "tubes_linda");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data + Bisa lebih spesifik
    $sql = "SELECT * FROM penjualan";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id_penjualan = $_POST['id_penjualan']; // All Required since its a new data
    $nama_customer = $_POST['nama_customer']; 
    $harga_satuan = $_POST['harga_satuan'];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['total'];
    $sql = "INSERT INTO penjualan (id_penjualan,nama_customer,harga_satuan,jumlah,total) VALUES('$id_penjualan','$nama_customer','$harga_satuan','$jumlah','$total')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id_penjualan = $_GET['id_penjualan']; 
    $sql = "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id_penjualan = $_PUT['id_penjualan_update']; 
    $nama_customer = $_PUT['nama_customer_update'];
    $harga_satuan = $_PUT['harga_satuan_update'];
    $jumlah = $_PUT['jumlah_update'];
    $total = $_PUT['total_update'];

    $sql = "UPDATE penjualan SET nama_customer='$nama_customer', harga_satuan='$harga_satuan', jumlah='$jumlah', total='$total' WHERE id_penjualan='$id_penjualan'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Berhasil"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>
