<?php
include "../include/config.php";

// Implement image path caching to reduce file system checks
class ImagePathCache {
    private static $cache = [];
    private static $uploadDir = "../upload/";
    private static $defaultImage = "../assets/images/default-profile.jpg";

    public static function getImagePath($imageName) {
        // Use cache to reduce file system checks
        if (isset(self::$cache[$imageName])) {
            return self::$cache[$imageName];
        }

        // Handle empty or null image names
        if (empty($imageName)) {
            return self::$defaultImage;
        }

        $imagePath = self::$uploadDir . $imageName;
        
        // Check file existence with error suppression for performance
        $resolvedPath = is_file($imagePath) ? $imagePath : self::$defaultImage;
        
        // Cache the result
        self::$cache[$imageName] = $resolvedPath;
        
        return $resolvedPath;
    }
}

// Optimize database query with prepared statement
$stmt = $koneksi->prepare("SELECT id_profile, nama, role, deskripsi, foto_profile, kontak FROM profile ORDER BY nama");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Tim</title>
    <style>
        .card-assamble {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            padding: 2rem;
        }

        .card-container {
            perspective: 1000px;
            width: 300px;
            height: 400px;
        }

        .card {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.8s;
        }

        .card-container:hover .card {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            background: white;
        }

        .card-back {
            transform: rotateY(180deg);
            background-color: #3498db;
            color: white;
        }

        .profile-pic {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            border: 3px solid #3498db;
        }

        .card h2 {
            text-align: center;
            color: #2c3e50;
            margin: 10px 0;
        }

        .card .title {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.1em;
        }

        .card-back h3 {
            color: white;
            margin-bottom: 15px;
        }

        .card-back p {
            color: white;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .kontak {
            margin-top: 20px;
            padding: 10px;
            background: #edf2f7;
            border-radius: 8px;
        }

        .kontak span {
            display: block;
            color: #2c3e50;
            margin: 0px 0;
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #666;
            font-size: 1.2em;
        }

        /* Error handling for images */
        .profile-pic.error {
            border: 2px solid #e74c3c;
        }
    </style>
</head>
<body>
    <?php include "../include/header-page.php"; ?>
    
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="card-assamble">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card-container">
                    <div class="card">
                        <!-- Bagian Depan Card -->
                        <div class="card-front">
                            <?php 
                            $imagePath = ImagePathCache::getImagePath($row['foto_profile']);
                            $sanitizedName = htmlspecialchars($row['nama']);
                            ?>
                            <img 
                                src="<?php echo $imagePath; ?>" 
                                alt="<?php echo $sanitizedName; ?>" 
                                class="profile-pic loading"
                                data-src="<?php echo $imagePath; ?>"
                                onload="this.classList.remove('loading')"
                                onerror="handleImageError(this)"
                            >
                            <h2><?php echo $sanitizedName; ?></h2>
                            <p class="title"><?php echo htmlspecialchars($row['role']); ?></p>
                        </div>
                        <!-- Bagian Belakang Card -->
                        <div class="card-back">
                            <h3>About Me</h3>
                            <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                            <div class="kontak">
                                <span>Contact: <?php echo htmlspecialchars($row['kontak']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="no-data">
            <p>Tidak ada data untuk ditampilkan.</p>
        </div>
    <?php endif; ?>

    <script>
        // Menangani error loading gambar
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.profile-pic');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.src = '../assets/images/default-profile.jpg';
                    this.classList.add('error');
                });
            });
        });
    </script>
</body>
</html>