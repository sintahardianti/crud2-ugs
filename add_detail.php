<?php
$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);
$index = $_GET['index'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST request
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $ket2 = $_POST['ket2'];

    // Buat array baru untuk detail
    $newDetail = array(
        'nama_barang' => $nama_barang,
        'jumlah' => $jumlah,
        'ket2' => $ket2
    );

    // Pastikan $data[$index]['details'] sudah diinisialisasi dan merupakan array
    if (!isset($data[$index]['details']) || !is_array($data[$index]['details'])) {
        $data[$index]['details'] = array(); // Inisialisasi jika belum ada
    }

    // Tambahkan detail baru jika belum mencapai 10
    if (count($data[$index]['details']) < 10) {
        $data[$index]['details'][] = $newDetail;

        // Simpan data kembali ke file JSON
        file_put_contents($dataFile, json_encode($data));
    }
    
    // Redirect kembali ke halaman detail
    header('Location: detail.php?index=' . $index);
    exit;
}
?>
