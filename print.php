<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Pengeluaran Barang</title>
</head>

<style>
.header1 {
    font-family: 'Trebuchet MS';
    margin: auto;
}

h3 {
    text-decoration: underline;
    font-family: 'Trebuchet MS';
    padding-left: 270px;
}

table,
th,
td {
    border: 1px solid black;
    padding-left: 4px;
    border-collapse: collapse;
    text-align: center;
    height: 22px;
    width: 905px;
    font-family: 'Trebuchet MS';
}

.ttd {
    padding: 10px;
    height: 75px;
}

h4 {
    font-size: 10px;
    font-family: 'Trebuchet MS';
    margin-top: 5px;
}

.t2 {
    margin-top: 30px;
    text-align: center;
}

tr.tr1 {
    text-align: left;
}
</style>

<header class="header1">
    <p style="margin-bottom: 0; margin-top: 0;">PT. Unggul Semesta
    <h3 style="margin-bottom: 0; margin-top: 0; margin-left: 50px;">BUKTI PENGELUARAN BARANG</h3>
    </p>
</header>

<?php
// Memulai sesi
session_start();

// Periksa apakah parameter 'index' ada di URL
if (!isset($_GET['index'])) {
    die("Index not provided");
}

$index = $_GET['index'];

// Membaca file data.json
$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);

// Inisialisasi variabel user dan periode
$user = 'N/A';
$periode = 'N/A';
$no_barang = 'N/A';
$ket = 'N/A';


// Ambil user dan periode berdasarkan indeks yang diberikan
if (isset($data[$index])) {
    $user = htmlspecialchars($data[$index]['user']);
    $periode = htmlspecialchars($data[$index]['periode']);
    $no_barang = htmlspecialchars($data[$index]['no_barang']);
    $ket = htmlspecialchars($data[$index]['ket']);
    $details = isset($data[$index]['details']) ? $data[$index]['details'] : [];

} else {
    die("Invalid index");
}
?>

<body>
    <div class="container">
        <table>
            <th colspan="4" style="text-align:center;"><?= $no_barang ?></th>
            <tr>
                <th colspan="1" style="text-align:center;">User: <?= $user ?></th>
                <th colspan="1" style="text-align:center;">Periode: <?= $periode ?></th>
            </tr>
        </table>
    </div>
    <br>
    <div class="container">
        <table>
            <tr>
                <th style="width:4%">No.</th>
                <th style="width:45%">Nama Barang</th>
                <th style="width:20%">Jumlah</th>
                <th>Keterangan</th>
            </tr>
            <?php if (!empty($details)): ?>
            <?php foreach ($details as $detailIndex => $detail): ?>
            <tr>
                <td><?= $detailIndex + 1 ?></td>
                <td><?= htmlspecialchars($detail['nama_barang']) ?></td>
                <td><?= htmlspecialchars($detail['jumlah']) ?></td>
                <td><?= htmlspecialchars($detail['ket2']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada detail tersedia.</td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>2</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>9</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>10</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>
        <table border="1" class="t2">
            <tr>
                <td colspan="2" class="t2"><span>Yang Mengeluarkan</span></td>
                <td colspan="2" class="t2"><span>Mengetahui</span></td>
                <td colspan="1" class="t2"><span>Yang Menerima</span></td>
            </tr>
            <tr>
                <td>Karyawan ybs</td>
                <td>Kepala Divisi</td>
                <td>HRD & GA</td>
                <td>Security</td>
                <td></td>
            </tr>
            <tr>
                <td class="ttd"></td>
                <td class="ttd"></td>
                <td class="ttd"></td>
                <td class="ttd"></td>
                <td class="ttd"></td>
            </tr>
            <tr>
                <td colspan="1" class="nama" style="text-align:center;">Sinta</td>
                <td colspan="1" class="nama" style="text-align:center;"></td>
                <td colspan="1" class="nama" style="text-align:center;"></td>
                <td colspan="1" class="nama" style="text-align:center;"></td>
            </tr>
        </table>
        </table>
        <h4>DIVISI IT/UGS</h4>
    </div>
</body>

</html>
