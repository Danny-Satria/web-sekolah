<?php

if(isset($_GET['url'])){
    $url = $_GET['url'];
    switch($url){
        case 'tambah-post':
            include 'tambah-post.php';
            break;
        case 'edit-post':
            include 'edit-post.php';
            break;
        case 'profile':
            include 'profile.php';
            break;
    }
}else{?>
    
    
    <?php
include "../include/config.php"; // Koneksi database

// Ambil data artikel dari tabel 'post'
$sql = "SELECT id_post, judul, gambar, penulis, tgl_post FROM post ORDER BY tgl_post DESC";
$result = $koneksi->query($sql);

?>
    <main class="row row-cols-1 row-cols-md-1 ms-5" style="overflow-x : hidden;">

    <div class="container" style="margin-top: 100px;">
        <h2>Daftar Artikel</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tanggal Publikasi</th>
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
                        if (!empty($row['gambar'])) {
                            // Menampilkan gambar jika ada
                            echo "<img src='" . htmlspecialchars($row['gambar']) . "' alt='Gambar Artikel'>";
                        } else {
                            // Placeholder jika gambar tidak tersedia
                            echo "<em>Tidak ada gambar</em>";
                        }
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
                        echo "<td>" . date("d F Y", strtotime($row['tgl_post'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada artikel yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</main>

   <?php
}

?>