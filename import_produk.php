<?php
include 'config/db.php'; // pastikan path ini benar

if (isset($_POST['import'])) {
    if ($_FILES['file']['name']) {
        $filename = $_FILES['file']['tmp_name'];

        if (($handle = fopen($filename, "r")) !== FALSE) {
            $isFirstRow = true;

            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($isFirstRow) {
                    $isFirstRow = false; // lewati baris header
                    continue;
                }

                $name         = $data[0] ?? '';
                $description  = $data[1] ?? '';
                $price        = $data[2] ?? 0;
                $stock        = $data[3] ?? 0;
                $image        = $data[4] ?? '';
                $category_id  = $data[5] ?? 0;
                $supplier_id  = $data[6] ?? 0;

                // Query insert ke tabel produk
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image, category_id, supplier_id) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdisii", $name, $description, $price, $stock, $image, $category_id, $supplier_id);
                $stmt->execute();
            }

            fclose($handle);
            echo "✅ Import selesai!";
        } else {
            echo "❌ Gagal membuka file.";
        }
    } else {
        echo "❌ Tidak ada file yang dipilih.";
    }
}
?>

<!-- Form upload CSV -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h2 class="mb-4">🛒 Import Produk dari CSV</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Pilih file CSV:</label>
                <input type="file" name="file" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" name="import" class="btn btn-primary">Import</button>
        </form>
    </div>
</body>
</html>
