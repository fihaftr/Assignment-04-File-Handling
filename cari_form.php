<!DOCTYPE html>
<html>
<head>
    <title>Cari Kata Kunci</title>
</head>
<body>
    <h2>Cari Kata Kunci</h2>
    <form action="proses.php" method="POST" enctype="multipart/form-data">
        <label>Kata Kunci:</label><br>
        <input type="text" name="katakunci" required><br><br>

        <label>Upload File (.txt/.html):</label><br>
        <input type="file" name="file" accept=".txt,.html" required><br><br>

        <label>Operasi:</label><br>
        <select name="operasi">
            <option value="cari">Hanya Cari</option>
            <option value="redact">Redact (sensor jadi ***)</option>
        </select><br><br>

        <label>Tipe Keluaran:</label><br>
        <select name="output">
            <option value="O">Simpan ke file asli</option>
            <option value="N">Simpan ke file baru</option>
        </select><br><br>

        <input type="submit" value="Proses">
    </form>
</body>
</html>
