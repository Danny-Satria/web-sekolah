<?php

include "../include/config.php";

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $koneksi->real_escape_string($_POST['judul']);
    $isi = $koneksi->real_escape_string($_POST['isi']);
    $penulis = $koneksi->real_escape_string($_POST['penulis']);
    $gambar = '';

    // Proses upload gambar
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../assets/upload/";
        $gambar_name = basename($_FILES['gambar']['name']);
        $gambar = $target_dir . $gambar_name;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar)) {
            echo "Gambar berhasil diupload.";
        } else {
            echo "Gagal mengupload gambar.";
            $gambar = ''; // Kosongkan jika gagal
        }
    }

    // Masukkan data ke database
    $sql = "INSERT INTO post (judul, gambar, artikel, penulis) VALUES ('$judul', '$gambar', '$isi', '$penulis')";

    if ($koneksi->query($sql) === TRUE) {
        // Redirect ke halaman admin setelah data berhasil ditambahkan
        header("Location: admin.php?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}
?>
