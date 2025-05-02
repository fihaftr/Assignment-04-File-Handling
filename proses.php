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

    $namaBaru = preg_replace('/(\.html?|\.txt)$/i', '-new$1', $namaAsli);

    $baris = file($fileSementara); 
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

    if ($operasi === 'redact') {
        if ($tipe === 'O') {
            move_uploaded_file($fileSementara, $namaAsli); 
            file_put_contents($namaAsli, implode("", $hasil));
            echo "<p><b>Perubahan disimpan ke file asli: $namaAsli</b></p>";
        } else {
            file_put_contents($namaBaru, implode("", $hasil));
            echo "<p><b>Perubahan disimpan ke file baru: $namaBaru</b></p>";
        }
    }
}
?>
