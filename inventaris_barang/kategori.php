<?php
session_start();
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nama = $koneksi->real_escape_string($nama); // amankan input dari karakter khusus
    if ($koneksi->query("INSERT INTO kategori (nama_kategori) VALUES ('$nama')")) {
        $_SESSION['msg'] = "Kategori berhasil ditambahkan!";
    } else {
        $_SESSION['msg'] = "Gagal menambahkan kategori: " . $koneksi->error;
    }
    header("Location: kategori.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // amankan input id
    if ($koneksi->query("DELETE FROM kategori WHERE id_kategori = $id")) {
        $_SESSION['msg'] = "Kategori berhasil dihapus!";
    } else {
        $_SESSION['msg'] = "Gagal menghapus kategori: " . $koneksi->error;
    }
    header("Location: kategori.php");
    exit;
}

$kategori = $koneksi->query("SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: rgb(170, 170, 215) !important;
        }
    </style>
</head>
<body class="p-4">
<?php include 'navbar.php'; ?>
<h2>Data Kategori</h2>

<?php if (isset($_SESSION['msg'])): ?>
    <div class="alert alert-info"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
<?php endif; ?>

<form method="post" class="mb-3">
    <input name="nama" class="form-control mb-2" placeholder="Nama Kategori" required>
    <button class="btn btn-primary" name="simpan">Tambah Kategori</button>
</form>

<table class="table table-bordered">
    <tr><th>Nama Kategori</th><th>Update</th></tr>
    <?php while($k = $kategori->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($k['nama_kategori']) ?></td>
        <td><a href="?hapus=<?= $k['id_kategori'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
