<?php
// Koneksi ke database
include "../include/config.php";

// Ambil data artikel untuk ditampilkan di tabel
$result = $koneksi->query("SELECT * FROM post");

$success_message = '';
$error_message = '';

// Proses update artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_post'])) {
    $id = intval($_POST['id_post']);
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $gambar = '';

    // Proses upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $target_file;
        }
    }

    // Update query
    $query = "UPDATE post SET judul = ?, artikel = ?, penulis = ?";
    if (!empty($gambar)) {
        $query .= ", gambar = ?";
    }
    $query .= " WHERE id_post = ?";

    $stmt = $koneksi->prepare($query);
    if (!empty($gambar)) {
        $stmt->bind_param("ssssi", $judul, $isi, $penulis, $gambar, $id);
    } else {
        $stmt->bind_param("sssi", $judul, $isi, $penulis, $id);
    }

    if ($stmt->execute()) {
        $success_message = "Artikel berhasil diperbarui!";
    } else {
        $error_message = "Gagal memperbarui artikel.";
    }

    $stmt->close();
}

// Fungsi hapus artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $sql = "DELETE FROM post WHERE id_post = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $success_message = "Artikel berhasil dihapus!";
    } else {
        $error_message = "Gagal menghapus artikel.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Post</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        .container {
            max-width: 1100px;
            position: relative;
            top: 5em;
            left: 7em;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background: #0056b3;
            color: white;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            color: white;
            background: #0056b3;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background: #d9534f;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background: white;
            padding: 20px;
            margin: 10% auto;
            width: 50%;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Artikel</h2>
    <?php if (!empty($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>
    <?php if (!empty($error_message)) { echo "<p style='color: red;'>$error_message</p>"; } ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tindakan</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_post']) . "</td>";
                echo "<td>";
                echo !empty($row['gambar']) ? "<img src='" . htmlspecialchars($row['gambar']) . "' alt='Gambar'>" : "<em>Tidak ada gambar</em>";
                echo "</td>";
                echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
                echo "<td>
                    <button class='btn' onclick='openModal(" . json_encode($row) . ")'>Edit</button>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id_post']) . "'>
                        <button type='submit' class='btn btn-danger'>Hapus</button>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada artikel ditemukan.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal untuk Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>Edit Artikel</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_post" id="editId">
            <label>Judul Artikel:</label>
            <input type="text" name="judul" id="editTitle" required>
            <label>Isi Artikel:</label>
            <textarea name="isi" id="editContent" required></textarea>
            <label>Penulis:</label>
            <input type="text" name="penulis" id="editAuthor" required>
            <label>Gambar:</label>
            <input type="file" name="gambar">
            <button type="submit">Simpan Perubahan</button>
        </form>
        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<script>
    function openModal(data) {
        document.getElementById('editId').value = data.id_post;
        document.getElementById('editTitle').value = data.judul;
        document.getElementById('editContent').value = data.artikel;
        document.getElementById('editAuthor').value = data.penulis;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</body>
</html>
