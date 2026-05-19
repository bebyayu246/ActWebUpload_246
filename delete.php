<?php
$upload_dir = "uploads/";
$file_name  = basename($_GET['file'] ?? '');
$file_path  = $upload_dir . $file_name;

$status = "";
$pesan  = "";

if (empty($file_name)) {
    $status = "gagal";
    $pesan  = "❌ Nama file tidak valid.";
} elseif (!file_exists($file_path)) {
    $status = "gagal";
    $pesan  = "❌ File tidak ditemukan: <b>" . htmlspecialchars($file_name) . "</b>";
} else {
    if (unlink($file_path)) {
        $status = "berhasil";
        $pesan  = "🗑️ File <b>" . htmlspecialchars($file_name) . "</b> berhasil dihapus.";
    } else {
        $status = "gagal";
        $pesan  = "❌ Gagal menghapus file. Periksa izin folder.";
    }
}

$warna  = $status === 'berhasil' ? "#7b3e00"  : "#c0392b";
$bg     = $status === 'berhasil' ? "#fff3e0"  : "#fdecea";
$border = $status === 'berhasil' ? "#ff9800"  : "#e74c3c";
$ikon   = $status === 'berhasil' ? "🗑️"       : "❌";
$judul  = $status === 'berhasil' ? "File Dihapus" : "Gagal Menghapus";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Hapus</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      padding: 40px 16px;
      min-height: 100vh;
    }
    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.1);
      padding: 32px;
      width: 100%;
      max-width: 480px;
      height: fit-content;
      text-align: center;
    }
    h2 {
      font-size: 20px;
      color: #222;
      margin-bottom: 24px;
      border-bottom: 2px solid <?php echo $border; ?>;
      padding-bottom: 10px;
    }
    .result-box {
      background: <?php echo $bg; ?>;
      border: 1px solid <?php echo $border; ?>;
      border-radius: 8px;
      padding: 24px 20px;
      margin-bottom: 24px;
    }
    .result-icon { font-size: 48px; display: block; margin-bottom: 12px; }
    .result-msg { font-size: 15px; color: <?php echo $warna; ?>; line-height: 1.6; }
    .btn-back {
      display: inline-block;
      padding: 11px 28px;
      background: #4CAF50;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
    }
    .btn-back:hover { background: #43a047; }
  </style>
</head>
<body>
<div class="card">
  <h2>🗑️ <?php echo $judul; ?></h2>

  <div class="result-box">
    <span class="result-icon"><?php echo $ikon; ?></span>
    <div class="result-msg"><?php echo $pesan; ?></div>
  </div>

  <a class="btn-back" href="index.html">← Kembali ke Upload</a>
</div>
</body>
</html>