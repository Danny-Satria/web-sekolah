<?php

include "../include/config.php";

$sql = "SELECT id_post, judul,gambar,artikel,tgl_post FROM post ORDER BY tgl_post DESC ";
$result = mysqli_query($koneksi, $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    <title>Informasi</title>
    <style>
        /* navbar */
.navbar {
  width: 100%;
  position: fixed;
  top: 0;
  background-color: white;
  margin: 0;
  padding: 10px 30px;
  z-index: 999999;
}

.logo {
  position: relative;
  color: #4dccec;
  font-size: 1.5em;
  padding: 15px;
  left: 3em;
  z-index: 9999;
}

.logo-outter {
  position: relative;
  color: #4dccec;
  font-size: 1.5em;
  padding: 15px;
  left: 3em;
  z-index: 9999;
}
.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dropdown-toggle {
  background-color: white;
}

.tombol {
  display: none;
  color: rgb(131, 131, 131);
  font-size: 2em;
  user-select: none;
}

.tombol:hover {
  cursor: pointer;
}

.menu {
  margin: 0;
  display: flex;
  list-style: none;
  padding: 0;
}

.menu li {
  list-style-type: none;
  padding-left: 0;
  margin-right: 10px;
  position: relative;
}

.menu li a {
  padding: 10px;
  color: rgb(131, 131, 131);
  text-decoration: none;
  display: inline-block;
  font-size: 1.2em;
}

.menu .dropdown {
  display: none;
  position: absolute;
  background-color: white;
  padding: 10px;
  top: 100%;
  left: 0;
  width: 150px;
}
.menu .divisi {
  display: none;
  position: absolute;
  background: white;
  top: 100%;
  left: 0;
  width: 230px;
}

.menu li:hover > .dropdown {
  display: block;
  background-color: white;
}

.menu li a:hover {
  color: #4dccec;
  transition: all 0.2s ease-in-out;
  -webkit-transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -ms-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
}

.menu .dropdown li {
  margin: 5px 0;
}

.menu .dropdown li a {
  padding: 5px;
  display: block;
}

.menu .nested-dropdown {
  position: relative;
  background-color: white;
}

.menu .nested-dropdown .dropdown {
  top: 0;
  left: 100%;
  width: 350px;
  background-color: white;
}

/* navbar end */

.header {
            background: #4dccec;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            top: 7em;
        }

    /* Global Card Styling */
    /* Card styling sesuai desain sebelumnya */
    .card {
            max-width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 10px;
        }

        .image-container {
            width: 100%; /* Sesuaikan dengan lebar card */
            height: 180px; /* Tetapkan tinggi yang konsisten */
            overflow: hidden; /* Potong bagian gambar yang melampaui area */
            position: relative;
        }

        .image-container img {
            border-radius: 0 !important;
            width: 600px; /* Pastikan gambar mengisi lebar penuh */
            height: 100%; /* Sesuaikan tinggi */
            object-fit: cover; /* Isi pembungkus tanpa mengubah proporsi */
            display: block;
            z-index: -1;
        }

        .card-img {
          width: 100%;
          height: 100%;
          object-fit: cover; /* Menjamin gambar akan mengisi ruang tanpa merubah rasio aspek */
      }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 0.85rem;
            padding: 0.5rem;
            display: flex;
            justify-content: space-between;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 0 0 0.5rem 0;
        }

        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
            margin: 0 0 1rem 0;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: #fff;
            background-color: #0d6efd;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .article-list {
            position: relative;
            top: 7em;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Bisa juga gunakan 'space-around' atau 'space-between' */
            gap: 10px; /* Jarak antar-card */
            padding: 10px; /* Tambahkan padding jika diperlukan */
        }

        .card {
            transition: none !important;
            transform: none !important;
            perspective: none !important;
        }
        
        .card:hover {
            transform: none !important;
            transition: none !important;
        }

        .form button {
        border: none;
        background: none;
        color: #8b8ba7;
      }
    </style>
</head>
<body>
    
<!-- Header -->
<?php  include "../include/header-page.php";?>
<header class="header">
    <h1>Blog</h1>
</header>
<!-- Header End -->

<!-- card -->

<div class="container">

        <div class="article-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <!-- Card Image -->
                    <div class="image-container">
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" 
                    alt="<?= htmlspecialchars($row['judul']) ?>" 
                    class="card-img"/>


                        <!-- Overlay -->
                        <div class="overlay">
                            <small><?= htmlspecialchars($row['tgl_post']) ?></small>
                            <small>
                                <i class="icon-eye"></i> <?= rand(1000, 10000) ?> <!-- Dummy view count -->
                            </small>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                        <p class="card-text">
                            <?= htmlspecialchars(substr($row['artikel'], 0, 100)) ?>...
                        </p>
                        <div>
                            <a href="../blog/index.php?id=<?= urlencode($row['id_post']) ?>" class="btn">Baca Selengkapnya...</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

<!-- card end -->



<!-- Footer -->
<?php  include "../include/footer-page.php";?>
<!-- Footer End -->

<!-- js -->
    <script src="assets/js/main.js"></script>
</body>
</html>