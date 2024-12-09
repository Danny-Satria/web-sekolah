<?php


require_once "../include/config.php";


class ProfileManager {
    private $db;
    private $uploadDir = "../upload/";

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function handleRequest() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['tambah'])) {
                $message = $this->addProfile($_POST, $_FILES);
                $this->redirectOnSuccess($message);
            } elseif (isset($_POST['hapus'])) {
                $message = $this->deleteProfile($_POST['id_profile']);
            } elseif (isset($_POST['edit'])) {
                $message = $this->editProfile($_POST, $_FILES);
                $this->redirectOnSuccess($message);
            }
        }

        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        return $message;
    }
    
    private function addProfile($post, $files) {
        if (!isset($files['foto']) || $files['foto']['error'] !== 0) {
            return $this->createMessage("Foto tidak valid atau belum diunggah.", "error");
        }
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($files['foto']['type'], $allowedTypes)) {
            return $this->createMessage("Format file tidak didukung. Gunakan JPG, PNG, atau GIF.", "error");
        }
        
        $fileName = uniqid() . '_' . basename($files['foto']['name']);
        $targetFile = $this->uploadDir . $fileName;
        
        if (!move_uploaded_file($files['foto']['tmp_name'], $targetFile)) {
            return $this->createMessage("Gagal mengunggah foto.", "error");
        }
        
        $query = "INSERT INTO profile (nama, role, deskripsi, foto_profile, kontak) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssss", 
            $post['nama'],
            $post['role'],
            $post['deskripsi'],
            $fileName,
            $post['kontak']
        );
        
        if ($stmt->execute()) {
            return $this->createMessage("Data berhasil ditambahkan!", "success");
        } else {
            return $this->createMessage("Gagal menambahkan data: " . $stmt->error, "error");
        }
    }
    
    private function deleteProfile($id) {
        $id = (int)$id;
        $stmt = $this->db->prepare("SELECT foto_profile FROM profile WHERE id_profile = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $fotoPath = $this->uploadDir . $data['foto_profile'];
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        
        $stmt = $this->db->prepare("DELETE FROM profile WHERE id_profile = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return $this->createMessage("Data berhasil dihapus!", "success");
        } else {
            return $this->createMessage("Gagal menghapus data.", "error");
        }
    }
    
    private function editProfile($post, $files) {
        $id = (int)$post['id_profile'];

        // Ambil data profil lama untuk mendapatkan foto lama
        $stmt = $this->db->prepare("SELECT foto_profile FROM profile WHERE id_profile = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldData = $result->fetch_assoc();
        $oldPhoto = $oldData['foto_profile'];
        
        $fileName = $oldPhoto; // Default tetap menggunakan foto lama

        // Jika ada file baru yang diunggah
        if (isset($files['foto']) && $files['foto']['error'] === 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($files['foto']['type'], $allowedTypes)) {
                return $this->createMessage("Format file tidak didukung. Gunakan JPG, PNG, atau GIF.", "error");
            }

            $fileName = uniqid() . '_' . basename($files['foto']['name']);
            $targetFile = $this->uploadDir . $fileName;

            if (move_uploaded_file($files['foto']['tmp_name'], $targetFile)) {
                // Hapus foto lama jika berbeda
                if ($oldPhoto && file_exists($this->uploadDir . $oldPhoto)) {
                    unlink($this->uploadDir . $oldPhoto);
                }
            } else {
                return $this->createMessage("Gagal mengunggah foto.", "error");
            }
        }

        // Update database
        $query = "UPDATE profile SET nama = ?, role = ?, deskripsi = ?, foto_profile = ?, kontak = ? WHERE id_profile = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sssssi",
            $post['nama'],
            $post['role'],
            $post['deskripsi'],
            $fileName,
            $post['kontak'],
            $id
        );

        if ($stmt->execute()) {
            return $this->createMessage("Data berhasil diperbarui!", "success");
        } else {
            return $this->createMessage("Gagal memperbarui data: " . $stmt->error, "error");
        }
    }

    private function redirectOnSuccess($message) {
        if (strpos($message, 'berhasil') !== false) {
            $_SESSION['message'] = $message;
            ob_clean(); 
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function getProfiles() {
        return $this->db->query("SELECT * FROM profile ORDER BY tgl_dibuat DESC");
    }

    private function createMessage($text, $type) {
        return "<div class='notification $type'>$text</div>";
    }
}

$profileManager = new ProfileManager($koneksi);
$message = $profileManager->handleRequest();
$result = $profileManager->getProfiles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary-color: #3498db;
            --danger-color: #e74c3c;
            --success-color: #4CAF50;
            --error-color: #f44336;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        
        .notification {
            padding: 15px;
            margin: 20px auto;
            max-width: 500px;
            border-radius: 5px;
            text-align: center;
        }
        
        .notification.success { background-color: var(--success-color); color: white; }
        .notification.error { background-color: var(--error-color); color: white; }
        
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        
        .table-container {
            margin: 20px auto;
            max-width: 1000px;
        }
        
        .table {
            position: relative;
            left: 5em;
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .table th {
            background-color: var(--primary-color);
            color: white;
        }
        
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Modal Background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from top and centered */
            padding: 20px;
            border-radius: 8px;
            width: 50%; /* Could be more or less, depending on screen size */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        /* Close Button */
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <?= $message ?>

    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" id="role" name="role" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="kontak">Kontak</label>
                <input type="text" id="kontak" name="kontak" class="form-control">
            </div>
            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Deskripsi</th>
                <th>Kontak</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_profile']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($row['kontak']) ?></td>
                        <td>
                            <img src="../upload/<?= htmlspecialchars($row['foto_profile']) ?>" 
                                 alt="Profile" class="profile-img">
                        </td>
                        <!-- Tombol Edit di Tabel -->
                        <td>
                            <button onclick="openEditModal(<?= htmlspecialchars(json_encode($row)) ?>)" class="btn btn-primary">Edit</button>
                            <!-- Tombol Hapus -->
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="id_profile" value="<?= $row['id_profile'] ?>">
                                <button type="submit" name="hapus" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <h3>Edit Profil</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="edit_id_profile" name="id_profile">
            <div class="form-group">
                <label for="edit_nama">Nama</label>
                <input type="text" id="edit_nama" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_role">Role</label>
                <input type="text" id="edit_role" name="role" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_deskripsi">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="edit_kontak">Kontak</label>
                <input type="text" id="edit_kontak" name="kontak" class="form-control">
            </div>
            <div class="form-group">
                <label for="edit_foto">Foto</label>
                <input type="file" id="edit_foto" name="foto" class="form-control" accept="image/*">
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>




<script>
    // Fungsi untuk membuka modal dan memuat data ke form
function openEditModal(data) {
    document.getElementById('edit_id_profile').value = data.id_profile;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_role').value = data.role;
    document.getElementById('edit_deskripsi').value = data.deskripsi;
    document.getElementById('edit_kontak').value = data.kontak;

    // Tampilkan modal
    document.getElementById('editModal').style.display = 'block';
}

// Fungsi untuk menutup modal
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Tutup modal jika pengguna mengklik di luar modal
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

</script>
</body>
</html>