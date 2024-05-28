<?php
session_start();

$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);

// Fungsi untuk menghasilkan no_barang baru
function generateNoBarang($data) {
    $lastNumber = 0;
    foreach ($data as $item) {
        $currentNumber = intval(substr($item['no_barang'], 3)); // Ambil angka setelah "TI-"
        if ($currentNumber > $lastNumber) {
            $lastNumber = $currentNumber;
        }
    }
    $newNumber = $lastNumber + 1;
    return 'IT-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newItem = [
        'no_barang' => generateNoBarang($data),
        'user' => $_POST['user'],
        'periode' => $_POST['periode'],
        'ket' => $_POST['ket'],
    ];

    $data[] = $newItem;
    file_put_contents($dataFile, json_encode($data));

    // Simpan user dan periode ke dalam sesi
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['periode'] = $_POST['periode'];
    $_SESSION['ket'] = $_POST['ket'];

    header('Location: index.php');
    exit;
}
?>


<?php include "../barang/layout/header.php" ?>

<!DOCTYPE html>
<html lang="en">

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengeluaran Barang</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <h3 class="judul">Bukti Pengeluaran Barang</h3>
        <button id="addBtn" class="btn btn-success">Tambah</button>
        <table id="barangTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No Barang</th>
                    <th>User</th>
                    <th>Periode</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($item['no_barang']) ?></td>
                    <td><?= htmlspecialchars($item['user']) ?></td>
                    <td><?= htmlspecialchars($item['periode']) ?></td>
                    <td><?= htmlspecialchars($item['ket']) ?></td>
                    <td class="text-center">
                        <a href="detail.php?index=<?= $index ?> " class="btn btn-warning">Detail</a>
                        <a href="delete.php?index=<?= $index ?>" class="btn btn-danger"
                            onclick="return confirm('yakin mau hapus data?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="popupForm" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <div class="card mt-4">
                <div class="card-header">
                    Tambah User
                </div>
                <br>
                <div class="card-body">
                    <form method="POST" action="index.php">
                        <div class="mb-3">
                            <label for="user" class="form-label">User:</label>
                            <input type="text" class="form-control" id="user" name="user" required>
                        </div>
                        <div class="mb-3">
                            <label for="periode" class="form-label">Periode:</label>
                            <input type="date" class="form-control" id="periode" name="periode" required>
                        </div>
                        <div class="mb-3">
                            <label for="ket" class="form-label">Keterangan:</label>
                            <input type="text" class="form-control" id="ket" name="ket" required>
                        </div>
                        <br>
                        <div class="row">
                            <div class="justify content">
                                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const addBtn = document.getElementById('addBtn');
        const popupForm = document.getElementById('popupForm');
        const closeBtn = popupForm.querySelector('.close');

        addBtn.addEventListener('click', () => {
            popupForm.style.display = 'block';
        });

        closeBtn.addEventListener('click', () => {
            popupForm.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target == popupForm) {
                popupForm.style.display = 'none';
            }
        });

        // Fungsi untuk mendapatkan tanggal hari ini (format YYYY-MM-DD)
        function getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Atur nilai elemen input dengan tanggal hari ini
        document.getElementById('periode').value = getCurrentDate();
    });
    </script>
</body>

</html>
