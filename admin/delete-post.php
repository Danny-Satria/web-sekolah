<?php
// Koneksi ke database
include "../include/config.php";

// Cek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data
    $sql = "DELETE FROM profile WHERE id_profile = $id";
    
    if ($koneksi->query($sql) === TRUE) {
        echo "Data berhasil dihapus!";
        // Redirect ke halaman utama setelah berhasil menghapus
        header("Location: profile.php"); // Ganti dengan halaman yang sesuai
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} else {
    echo "ID tidak ditemukan!";
}
?>

<?php

include "header-admin.php";
?>