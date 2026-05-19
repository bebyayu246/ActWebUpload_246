<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Buat folder uploads jika belum ada
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Periksa apakah berkas sebenarnya adalah gambar atau bukan
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $pesan = "❌ Berkas bukan gambar.";
    }
}

// Periksa apakah berkas sudah ada
if (file_exists($target_file)) {
    $uploadOk = 0;
    $pesan = "❌ Maaf, berkas sudah ada.";
}

// Periksa ukuran berkas (500000 byte = 500 KB)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $uploadOk = 0;
    $pesan = "❌ Maaf, berkas Anda terlalu besar (maks. 500 KB).";
}

// Hanya izinkan format berkas tertentu
if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
    $uploadOk = 0;
    $pesan = "❌ Maaf, hanya berkas JPG, JPEG, PNG & GIF yang diperbolehkan.";
}

// Proses upload
if ($uploadOk == 0) {
    if (empty($pesan)) $pesan = "❌ Berkas tidak dapat diunggah.";
    $status  = "gagal";
    $warna   = "#c0392b";
    $bg      = "#fdecea";
    $border  = "#e74c3c";
    $judul   = "Gagal Diunggah";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $nama_file = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
        $ukuran_kb = round($_FILES["fileToUpload"]["size"] / 1024, 1);
        $pesan     = "✅ Berkas <b>" . $nama_file . "</b> berhasil diunggah.";
        $status    = "berhasil";
        $warna     = "#1e7e34";
        $bg        = "#eafaf1";
        $border    = "#2ecc71";
        $judul     = "Berhasil Diunggah";
    } else {
        $pesan  = "❌ Maaf, terjadi kesalahan saat mengunggah berkas.";
        $status = "gagal";
        $warna  = "#c0392b";
        $bg     = "#fdecea";
        $border = "#e74c3c";
        $judul  = "Gagal Diunggah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Upload</title>
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
      padding: 20px;
      margin-bottom: 24px;
    }
    .result-icon { font-size: 48px; display: block; margin-bottom: 12px; }
    .result-msg {
      font-size: 15px;
      color: <?php echo $warna; ?>;
      line-height: 1.6;
    }
    <?php if ($status === 'berhasil'): ?>
    .preview-wrap {
      margin-bottom: 24px;
    }
    .preview-wrap h3 {
      font-size: 12px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 10px;
    }
    .preview-wrap img {
      max-width: 100%;
      max-height: 220px;
      object-fit: contain;
      border-radius: 8px;
      border: 1px solid #e0e0e0;
    }
    .file-info {
      font-size: 13px;
      color: #666;
      margin-top: 10px;
      line-height: 1.7;
    }
    .action-row {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-bottom: 24px;
    }
    .btn-dl {
      padding: 10px 20px;
      background: #2196F3;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .btn-dl:hover { background: #1976D2; }
    .btn-del {
      padding: 10px 20px;
      background: #e53935;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }
    .btn-del:hover { background: #c62828; }
    <?php endif; ?>
    .btn-back {
      display: inline-block;
      padding: 11px 28px;
      background: #4CAF50;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.2s;
    }
    .btn-back:hover { background: #43a047; }

    /* DELETE RESULT */
    .delete-result {
      display: none;
      background: #fff3e0;
      border: 1px solid #ff9800;
      border-radius: 8px;
      padding: 16px;
      margin-bottom: 16px;
      font-size: 14px;
      color: #e65100;
    }
  </style>
</head>
<body>
<div class="card">
  <h2>📋 Hasil Upload</h2>

  <div class="result-box">
    <span class="result-icon"><?php echo $status === 'berhasil' ? '✅' : '❌'; ?></span>
    <div class="result-msg"><?php echo $pesan; ?></div>
  </div>

  <?php if ($status === 'berhasil'): ?>
  <!-- PREVIEW GAMBAR YANG BARU DIUNGGAH -->
  <div class="preview-wrap">
    <h3>Pratinjau File</h3>
    <img src="<?php echo htmlspecialchars($target_file); ?>" alt="<?php echo htmlspecialchars($nama_file); ?>">
    <div class="file-info">
      📄 <b><?php echo $nama_file; ?></b><br>
      <span style="color:#999">Ukuran:</span> <?php echo $ukuran_kb; ?> KB
      &nbsp;&nbsp;
      <span style="color:#999">Tipe:</span> <?php echo strtoupper($fileType); ?>
    </div>
  </div>

  <!-- AKSI: UNDUH & HAPUS -->
  <div class="action-row">
    <a class="btn-dl" href="<?php echo htmlspecialchars($target_file); ?>" download="<?php echo htmlspecialchars($nama_file); ?>">
      ⬇ Unduh
    </a>
    <a class="btn-del" href="delete.php?file=<?php echo urlencode(basename($target_file)); ?>"
       onclick="return confirm('Hapus file ini?')">
      🗑 Hapus
    </a>
  </div>
  <?php endif; ?>

  <a class="btn-back" href="index.html">← Unggah File Lain</a>
</div>
</body>
</html>