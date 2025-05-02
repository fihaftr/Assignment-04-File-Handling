<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kataKunci = $_POST['katakunci'];
    $operasi = strtolower($_POST['operasi']);
    $tipe = strtoupper($_POST['output']);

    $file = $_FILES['file'];
    $fileSementara = $file['tmp_name'];
    $namaAsli = basename($file['name']);

    if (!file_exists($fileSementara)) {
        echo "File tidak ditemukan.";
    }

    // Buat nama file baru (kalau tipe output = N)
    $namaBaru = preg_replace('/(\.html?|\.txt)$/i', '-new$1', $namaAsli);

    // Baca isi file
    $baris = file($fileSementara); // Membaca per baris
    $hasil = [];

    echo "Output:";
    foreach ($baris as $line) {
        if (stripos($line, $kataKunci) !== false) {
            if ($operasi === "redact") {
                $line = preg_replace("/" . preg_quote($kataKunci, "/") . "/i", "***", $line);
            }
            echo "<pre>" . htmlspecialchars($line) . "</pre>";
        }
        $hasil[] = $line;
    }

    // Simpan hasil kalau operasi = redact
    if ($operasi === 'redact') {
        if ($tipe === 'O') {
            // Simpan hasil ke file asli (di folder kerja)
            //$path = __DIR__ . '/' . $namaAsli;
            move_uploaded_file($fileSementara, $namaAsli); // Simpan dulu upload
            file_put_contents($namaAsli, implode("", $hasil));
            echo "<p><b>Perubahan disimpan ke file asli: $namaAsli</b></p>";
        } else {
            // Simpan hasil ke file baru
            //$path = __DIR__ . '/' . $namaBaru;
            file_put_contents($namaBaru, implode("", $hasil));
            echo "<p><b>Perubahan disimpan ke file baru: $namaBaru</b></p>";
        }
    }
}
?>
