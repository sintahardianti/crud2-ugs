<?php
$dataFile = 'data.json';
$data = json_decode(file_get_contents($dataFile), true);
$index = $_GET['index'];
$item = $data[$index];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data[$index]['no_barang'] = $_POST['no_barang'];
    $data[$index]['user'] = $_POST['user'];
    $data[$index]['periode'] = $_POST['periode'];
    $data[$index]['ket'] = $_POST['ket'];
    
    file_put_contents($dataFile, json_encode($data));
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header ">
                Edit Barang
            </div>
            <div class="card-body ">
                <form method="POST" action="detail.php?index=<?= $index ?>">
                    <div class="input-group mb-3">
                        <label for="no_barang" class="input-group-text">No Barang:</label>
                        <input type="text" id="no_barang" name="no_barang" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                            value="<?= htmlspecialchars($item['no_barang']) ?>" required readonly>
                    </div>
                    <div class="input-group mb-3">
                        <label for="user" class="input-group-text">User:</label>
                        <input type="text" id="user" name="user" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" value="<?= htmlspecialchars($item['user']) ?>"
                            required>
                    </div>
                    <div class="input-group mb-3">
                        <label for="periode" class="input-group-text">Periode:</label>
                        <input type="date" id="periode" name="periode" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                            value="<?= htmlspecialchars($item['periode']) ?>" required>
                    </div>
                    <div class="input-group mb-3">
                        <label for="ket" class="input-group-text">Keterangan:</label>
                        <input type="text" id="ket" name="ket" class="form-control" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" value="<?= htmlspecialchars($item['ket']) ?>"
                            required>
                    </div>
                    <div>
                        <input type="submit" name="simpan" value="Update Data" class="btn btn-primary"
                            onclick="return confirm('yakin mau update data?')">
                    </div>
                </form>
            </div>
        </div>
        <div class="container" style="width: 95%;">
            <h4>Detail Barang</h4>
            <div class="d-flex justify-content-end">
                <button id="addDetailBtn" class="btn btn-success">Tambah Barang <i class="fas fa-plus"></i></button>
            </div>
            <table id="detailTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
    if(isset($item['details']) && is_array($item['details'])) {
        foreach ($item['details'] as $detailIndex => $detail): ?>
                    <tr>
                        <td><?= $detailIndex + 1 ?></td>
                        <td><?= htmlspecialchars($detail['nama_barang']) ?></td>
                        <td><?= htmlspecialchars($detail['jumlah']) ?></td>
                        <td><?= htmlspecialchars($detail['ket2']) ?></td>
                        <td><a class="btn btn-danger" onclick="return confirm('yakin mau hapus data?')"
                                href="delete_detail.php?index=<?= $index ?>&detailIndex=<?= $detailIndex ?>">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; 
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada detail tersedia.</td></tr>";
                        }
                        ?>
                </tbody>
            </table>
            <br>
            <div class="d-flex justify-content-end">
                <a href="print.php?index=<?= $index ?>" id="print" class="btn btn-success" target="_blank">Print <i
                        class="fas fa-print"></i></a>
            </div>
        </div>
    </div>

    <div id="detailPopupForm" class="popup">
        <div class=" popup-content">
            <span class="close">&times;</span>
            <div class="container" style="padding:0; margin:0 auto;">
                <div class="card">
                    <div class="card-header">
                        Form Tambah Barang
                    </div>
                    <br>
                    <form action="add_detail.php?index=<?php echo $index; ?>" method="POST">
                        <div class="input-group mb-3">
                            <label for="nama_barang">Nama Barang: <icon style="color:red"> *
                                </icon></label>
                            <input type="text" id="nama_barang" name="nama_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah">Jumlah: <icon style="color:red"> *
                                </icon></label>
                            <input type="text" id="jumlah" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="ket2">Keterangan: <icon style="color:red"> *
                                </icon></label>
                            <input type="text" id="ket2" name="ket2" required>
                        </div>
                        <input type="submit" value="Simpan" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const addDetailBtn = document.getElementById('addDetailBtn');
        const detailPopupForm = document.getElementById('detailPopupForm');
        const detailCloseBtn = detailPopupForm.querySelector('.close');

        addDetailBtn.addEventListener('click', () => {
            detailPopupForm.style.display = 'block';
        });

        detailCloseBtn.addEventListener('click', () => {
            detailPopupForm.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target == detailPopupForm) {
                detailPopupForm.style.display = 'none';
            }
        });
    });
    </script>
</body>

</html>
