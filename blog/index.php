<?php
// Include konfigurasi database
include "../include/config.php";

// Ambil parameter ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query database untuk mendapatkan data artikel berdasarkan ID
$sql = "SELECT * FROM post WHERE id_post = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if ($article) {
  $updateViewsSql = "UPDATE post SET views = views + 1 WHERE id_post = ?";
  $updateStmt = $koneksi->prepare($updateViewsSql);
  $updateStmt->bind_param("i", $id);
  $updateStmt->execute();
}

// Periksa apakah artikel ditemukan
if (!$article) {
    echo "<h1>Artikel tidak ditemukan</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Berita</title>
    <style>
      /* Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Global Styles */
body {
  font-family: "Arial", sans-serif;
  line-height: 1.6;
  background-color: #f4f4f4;
  color: #333;
}


h1 {
  color: #000;
}
h2 {
  color: #000;
}
h3 {
  color: #0056b3;
}

ul {
  list-style: none;
  padding: 0;
}

a {
  color: #0056b3;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

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

/* Header */
.header {
            background: #4dccec;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Content Layout */
        .content {
            display: flex;
            margin: 20px;
            gap: 20px;
        }

        /* Main Article */
        .main-article {
            flex: 3;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-article img {
            max-width: 100%;
            border-radius: 8px;
            margin: 10px 0;
        }

        .main-article p {
            margin-top: 10px;
        }

        /* Sidebar */
        .sidebar {
            flex: 1;
        }

        .sidebar section {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin: -15px -15px 10px;
            border-radius: 8px 8px 0 0;
            font-size: 1.2rem;
        }

        .sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
        }

        .sidebar ul li img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
        }

        .sidebar ul li .post-details {
            flex: 1;
        }

        .sidebar ul li .post-details a {
            font-weight: bold;
            color: #333;
            font-size: 1rem;
        }

        .sidebar ul li .post-details a:hover {
            color: #007bff;
        }

        .sidebar ul li .post-details small {
            color: #999;
            font-size: 0.8rem;
        }

        /* footer */

.main-content {
  flex: 1;
}

.footer {
  background-color: #222;
  padding: 40px 20px;
  width: 100%;
  position: relative;
  bottom: -40em;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-section {
  flex: 1;
  min-width: 200px;
  margin-bottom: 20px;
}

.footer-section h3 {
  color: #00bfff;
  margin-bottom: 20px;
}

.footer-section p,
.footer-section ul {
  line-height: 1.6;
  color: #abaaa9;
}

.footer-section ul {
  list-style: none;
}

.footer-section ul li {
  margin-bottom: 10px;
}

.footer-section ul li a {
  color: #bbb;
  text-decoration: none;
}

.footer-section ul li a:hover {
  color: #fff;
}

.footer-logo {
  width: 150px;
  margin-bottom: 20px;
}

.footer-social {
  text-align: center;
  margin-top: 20px;
  border-top: 1px solid #444;
  padding-top: 20px;
}

.footer-social ul {
  list-style: none;
  display: flex;
  justify-content: center;
  padding: 0;
}

.footer-social ul li {
  margin: 0 10px;
}

.footer-social ul li a img {
  width: 30px;
  height: 30px;
}

/* footer end */

    </style>
  </head>
  <body>

        <?php include "../include/header-blog.php";?>

<header class="header">
    <h1 style="color: white;">Portal Berita</h1>
</header>

<main class="content">
    <!-- Artikel Utama -->
    <article class="main-article" >
        <h2 style="color: black;"><?= htmlspecialchars($article['judul']) ?></h2>
        <p><small>Diposting pada <?= htmlspecialchars($article['tgl_post']) ?></small></p>
        <img src="<?= htmlspecialchars($article['gambar']) ?>" alt="<?= htmlspecialchars($article['judul']) ?>">
        <p><?= nl2br(htmlspecialchars($article['artikel'])) ?></p>
        <p><small>Dilihat: <?= $article['views'] ?> kali</small></p>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- New Post Section -->
        <section class="new-posts">
            <h3>New Post</h3>
            <ul>
                <?php
                $newPostSql = "SELECT id_post, judul, gambar, SUBSTRING(artikel, 1, 50) AS deskripsi, tgl_post, views 
                               FROM post ORDER BY tgl_post DESC LIMIT 5";
                $newPosts = $koneksi->query($newPostSql);
                while ($post = $newPosts->fetch_assoc()) {
                    echo '<li>';
                    echo '<img src="' . htmlspecialchars($post['gambar']) . '" alt="' . htmlspecialchars($post['judul']) . '">';
                    echo '<div class="post-details">';
                    echo '<a href="index.php?id=' . $post['id_post'] . '">' . htmlspecialchars($post['judul']) . '</a><br/> ';
                    echo '<small>' . date("d F Y", strtotime($post['tgl_post'])) . ', ' . $post['views'] . 'x Views</small>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
            </ul>
        </section>

        <!-- Popular Post Section -->
        <section class="popular-posts">
            <h3>Popular Post</h3>
            <ul>
                <?php
                $popularPostSql = "SELECT id_post, judul, gambar, tgl_post, views FROM post ORDER BY views DESC LIMIT 5";
                $popularPosts = $koneksi->query($popularPostSql);
                while ($post = $popularPosts->fetch_assoc()) {
                    echo '<li>';
                    echo '<img src="' . htmlspecialchars($post['gambar']) . '" alt="' . htmlspecialchars($post['judul']) . '">';
                    echo '<div class="post-details">';
                    echo '<a href="index.php?id=' . $post['id_post'] . '">' . htmlspecialchars($post['judul']) . '</a><br/>';
                    echo '<small>' . date("d F Y", strtotime($post['tgl_post'])) . ', ' . $post['views'] . 'x Views</small>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
            </ul>
        </section>

        <!-- Related Post Section -->
        <section class="related-posts">
            <h3>Related Post</h3>
            <ul>
                <?php
                $relatedPostSql = "SELECT id_post, judul, gambar, tgl_post, views FROM post WHERE id_post != ? ORDER BY RAND() LIMIT 5";
                $relatedStmt = $koneksi->prepare($relatedPostSql);
                $relatedStmt->bind_param("i", $id);
                $relatedStmt->execute();
                $relatedPosts = $relatedStmt->get_result();
                while ($post = $relatedPosts->fetch_assoc()) {
                    echo '<li>';
                    echo '<img src="' . htmlspecialchars($post['gambar']) . '" alt="' . htmlspecialchars($post['judul']) . '">';
                    echo '<div class="post-details">';
                    echo '<a href="index.php?id=' . $post['id_post'] . '">' . htmlspecialchars($post['judul']) . '</a>';
                    echo '<small>' . date("d F Y", strtotime($post['tgl_post'])) . ', ' . $post['views'] . 'x Views</small>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
            </ul>
        </section>
    </aside>
</main>

<!-- Footer -->
<?php  include "../include/footer-blog.php";?>
<!-- Footer End -->

<script>
  // fungsi navbar responsif
document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.querySelector(".tombol");
  const menu = document.querySelector(".menu");
  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

  toggleButton.addEventListener("click", function () {
    menu.classList.toggle("aktif");
  });

  dropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      this.parentElement.classList.toggle("active");
    });
  });
});

// fungsi navbar responsif end

</script>

</body>
</html>
