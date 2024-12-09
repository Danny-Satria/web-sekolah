<?php
// Koneksi ke database
include "../include/config.php";

// Ambil data artikel untuk ditampilkan di tabel
$result = $koneksi->query("SELECT * FROM post");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_post'])) {
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Post</title>
    <style>
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
            max-height: 60px;
            border-radius: 5px;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            background: #0056b3;
            cursor: pointer;
        }
        .btn:hover {
            background: #003f8a;
        }
        .btn-danger {
            background: #d9534f;
        }
        .btn-danger:hover {
            background: #c9302c;
        }
        .modal-content {
        background: white;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        font-family: Arial, sans-serif;
    }
    .modal-content h2 {
        font-size: 20px;
        margin-bottom: 20px;
        color: #333;
    }
    .modal-content label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }
    .modal-content input[type="text"],
    .modal-content textarea,
    .modal-content input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .modal-content textarea {
        resize: vertical;
    }
    .modal-content button {
        background: #0056b3;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    .modal-content button:hover {
        background: #003f8a;
    }
    .close {
        float: right;
        font-size: 20px;
        color: #aaa;
        cursor: pointer;
    }
    .close:hover {
        color: #000;
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
                <th>Tanggal Publikasi</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>";
                    echo !empty($row['gambar']) ? "<img src='" . htmlspecialchars($row['gambar']) . "' alt='Gambar'>" : "<em>Tidak ada gambar</em>";
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
                    echo "<td>" . date("d F Y", strtotime($row['tgl_post'])) . "</td>";
                    echo "<td>
                            <button class='btn' onclick='openModal(" . json_encode($row) . ")'>Edit</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada artikel yang ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal untuk Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Artikel</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_post" id="editId">
            <label for="editTitle">Judul Artikel:</label>
            <input type="text" name="judul" id="editTitle" placeholder="Masukkan judul artikel" required>
            
            <label for="editImage">Upload Gambar:</label>
            <input type="file" name="gambar" id="editImage" accept="image/*">
            
            <label for="editContent">Isi Artikel:</label>
            <textarea name="isi" id="editContent" rows="5" placeholder="Masukkan isi artikel" required></textarea>
            
            <label for="editAuthor">Penulis:</label>
            <input type="text" name="penulis" id="editAuthor" placeholder="Masukkan nama penulis" required>
            
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    function openModal(data) {
        document.getElementById('editId').value = data.id_post || '';
        document.getElementById('editTitle').value = data.judul || '';
        document.getElementById('editContent').value = data.isi || '';
        document.getElementById('editAuthor').value = data.penulis || '';
        document.getElementById('editModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>

</body>
</html>
