<?php
include "../include/config.php";

// Fungsi untuk menangani permintaan AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'get_article') {
        $id = intval($_POST['id']);
        $sql = "SELECT id_post, judul, artikel, penulis FROM post WHERE id_post = $id";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            echo json_encode($result->fetch_assoc());
        } else {
            echo json_encode(['error' => 'Data tidak ditemukan']);
        }
        exit;
    } elseif ($_POST['action'] === 'update_article') {
        $id = intval($_POST['id_post']);
        $judul = $koneksi->real_escape_string($_POST['judul']);
        $isi = $koneksi->real_escape_string($_POST['isi']);
        $penulis = $koneksi->real_escape_string($_POST['penulis']);

        $gambar = '';
        if (!empty($_FILES['gambar']['name'])) {
            $targetDir = "../uploads/";
            $gambar = $targetDir . basename($_FILES["gambar"]["name"]);
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar);
        }

        $sql = "UPDATE post SET judul = '$judul', artikel = '$isi', penulis = '$penulis'";
        if (!empty($gambar)) {
            $sql .= ", gambar = '$gambar'";
        }
        $sql .= " WHERE id_post = $id";

        if ($koneksi->query($sql) === TRUE) {
            echo json_encode(['success' => 'Artikel berhasil diperbarui']);
        } else {
            echo json_encode(['error' => 'Gagal memperbarui artikel: ' . $koneksi->error]);
        }
        exit;
    } elseif ($_POST['action'] === 'delete_article') {
        $id = intval($_POST['id']);
        $sql = "DELETE FROM post WHERE id_post = $id";
        if ($koneksi->query($sql) === TRUE) {
            echo json_encode(['success' => 'Artikel berhasil dihapus']);
        } else {
            echo json_encode(['error' => 'Gagal menghapus artikel: ' . $koneksi->error]);
        }
        exit;
    }
}

// Query untuk mendapatkan semua data artikel
$sql = "SELECT id_post, judul, gambar, penulis, tgl_post FROM post ORDER BY tgl_post DESC";
$result = $koneksi->query($sql);
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
        .btn-danger {
            background: #d9534f;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
        }
        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Daftar Artikel</h2>
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
                            <button class='btn' onclick='openModal(" . $row['id_post'] . ")'>Edit</button>
                            <button class='btn btn-danger' onclick='deleteArticle(" . $row['id_post'] . ")'>Hapus</button>
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
            <input type="text" name="judul" id="editTitle" required>
            <label for="editImage">Upload Gambar:</label>
            <input type="file" name="gambar" id="editImage" accept="image/*">
            <label for="editContent">Isi Artikel:</label>
            <textarea name="isi" id="editContent" rows="5" required></textarea>
            <label for="editAuthor">Penulis:</label>
            <input type="text" name="penulis" id="editAuthor" required>
            <button type="button" class="btn" onclick="updateArticle()">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
// Fungsi untuk membuka modal
function openModal(id) {
    const modal = document.getElementById('editModal');
    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=get_article&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            document.getElementById('editId').value = data.id_post;
            document.getElementById('editTitle').value = data.judul;
            document.getElementById('editContent').value = data.artikel;
            document.getElementById('editAuthor').value = data.penulis;
            modal.style.display = 'block';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Fungsi untuk menutup modal
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Fungsi untuk memperbarui artikel
function updateArticle() {
    const formData = new FormData(document.getElementById('editForm'));
    formData.append('action', 'update_article');
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success || data.error);
        if (data.success) location.reload();
    })
    .catch(error => console.error('Error:', error));
}

// Fungsi untuk menghapus artikel
function deleteArticle(id) {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
        fetch('', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=delete_article&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success || data.error);
            if (data.success) location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
</body>
</html>
