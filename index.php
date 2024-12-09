<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>M1 Solution</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/responsive.css" />
  </head>
  <body>
    <!-- Navbar -->
    <?php include "include/header.php";?>
    <!-- Navbar -->

    <!-- carousel -->

    <div class="slider">
      <div class="slides">
        <!-- Slide 1 -->
        <div class="slide">
          <img
            src="assets/images/Pictures/carousel/Screenshot 2024-06-24 084234.png"
            alt="Slide 1"
          />
        </div>
        <!-- Slide 2 -->
        <div class="slide">
          <img
            src="assets/images/Pictures/carousel/Screenshot 2024-07-30 114509.png"
            alt="Slide 2"
          />
        </div>
        <!-- Slide 3 -->
        <div class="slide">
          <img
            src="assets/images/Pictures/carousel/Screenshot 2024-07-02 084653.png"
            alt="Slide 3"
          />
        </div>
      </div>
      <a class="prev" onclick="showPrevSlide()"> &#10094;</a>
      <a class="next" onclick="showNextSlide()">&#10095;</a>
      <div class="indicators">
        <span class="indicator" onclick="currentSlide(0)"></span>
        <span class="indicator" onclick="currentSlide(1)"></span>
        <span class="indicator" onclick="currentSlide(2)"></span>
      </div>
    </div>

    <!-- carousel -->

    <!-- content -->

    <div class="image-menu">
      <div class="image">
        <a href="?url=software"><img
          src="assets/images/Icon/SOFTWARE_DEV.png"
          alt="SOFTWARE_DEV"
        /></a>
        
      </div>
      <div class="image">
        <a href="?url=game"><img src="assets/images/Icon/GAME_DEV.png" alt="GAME_DEV"/></a>
        
      </div>
      <div class="image">
        <a href="?url=multimedia"><img
          src="assets/images/Icon/MULTIMEDIA.png"
          alt="MULTIMEDIA"
        /></a>
        
      </div>
      <div class="image">
        <a href="?url=training"><img
          src="assets/images/Icon/TRAINING.png"
          alt="TRAINING"
        /></a>
      </div>
    </div>

    <!-- divisi -->
      <?php include "halaman.php";?>

    <!-- divisi end -->

    <!-- break -->

    <div class="break"></div>

    <!-- break end -->

    <!-- summary -->
    <div class="container-sum">
      <div class="heading-text">
        <h1>Produk-produk ungulan kami</h1>
        <p>
          Beberapa daftar produk kami yang telah dipasarkan ke seluruh
          Indonesia.
        </p>
      </div>
      <div class="image-summary">
        <img src="assets/images/Pictures/summary/summary.png" alt="Gambar summary" />
      </div>
      <div class="container-summary">
        <div class="accordion-item">
          <div class="accordion-header">Software Development</div>
          <div class="accordion-content show">
            <div class="logos">
              <img
                src="assets/images/Pictures/summary/b80a8-logo_eholiday.png"
                alt="eHoliday"
              />
              <img
                src="assets/images/Pictures/summary/584a0-3db78-logo_kawan_cd4c66ea990ccf613ee177c54db8b5ef.png"
                alt="Kawan Messenger"
              />
              <img
                src="assets/images/Pictures/summary/ebd22-7f340-logo_eticketing_c9ffc45622d36d83e3b45524feb1ab50.png"
                alt="eTicketing"
              />
              <img
                src="assets/images/Pictures/summary/e6c27-logo_picksite.png"
                alt="PickSite"
              />
              <img
                src="assets/images/Pictures/summary/536ae-0d5c6-logo_cardealers_8eb06a318297c9fecb1766aeef079cb4.png"
                alt="Car Dealers"
              />
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header">Game Development</div>
          <div class="accordion-content">
            <div class="logos">
              <img
                src="assets/images/Pictures/summary/295ba-eduraces.png"
                alt="edu race"
              />
              <img
                src="assets/images/Pictures/summary/90023-log2.png"
                alt="the ocean"
              />
              <img
                src="assets/images/Pictures/summary/083c5-logo-new2.png"
                alt="tak gentar"
              />
              <img
                src="assets/images/Pictures/summary/f3a2b-election-day1.png"
                alt="election day"
              />
              <img
                src="assets/images/Pictures/summary/ead9f-qurban-farm1.png"
                alt="qurban farm"
              />
              <img
                src="assets/images/Pictures/summary/96569-mission-on-mars1.png"
                alt="mars mission"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- summary end -->

    <!-- layanan -->

    <div class="services-container">
      <h2>Our Service</h2>
      <p>These are some of the services we work on</p>
      <div class="services-grid">
        <div class="service-item">
          <img src="assets/images/Pictures/layanan/mobile app.png" alt="Mobile App" />
          <h3>MOBILE APP</h3>
          <p>
            Pembuatan Aplikasi Android dan Ios menggunakan Xamarin, Ionic maupun
            Native
          </p>
        </div>
        <div class="service-item">
          <img
            src="assets/images/Pictures/layanan/training & workshop.png"
            alt="Training & Workshop"
          />
          <h3>TRAINING & WORKSHOP</h3>
          <p>
            UI/UX Design, Mikrotik, Web Programming, Animasi 2D/3D, Video
            Editing, dll
          </p>
        </div>
        <div class="service-item">
          <img src="assets/images/Pictures/layanan/game AR.png" alt="Game & AR" />
          <h3>GAME & AR</h3>
          <p>
            Pembuatan game untuk pendidikan, promosi dengan fitur Augmented
            Reality.
          </p>
        </div>
        <div class="service-item">
          <img
            src="assets/images/Pictures/layanan/animasi.png"
            alt="Animasi & Periklanan"
          />
          <h3>ANIMASI & PERIKLANAN</h3>
          <p>
            Jasa pembuatan design, photo maupun video Promosi (Iklan), Profil
            Perusahaan/ Pemerintahan dll.
          </p>
        </div>
        <div class="service-item">
          <img
            src="assets/images/Pictures/layanan/sistem informasi.png"
            alt="Sistem Informasi"
          />
          <h3>SISTEM INFORMASI</h3>
          <p>
            E-sekolah, E-goverment, E-ticketing, dll berbasis Desktop, Mobile
            App maupun Website
          </p>
        </div>
        <div class="service-item">
          <img
            src="assets/images/Pictures/layanan/photo.png"
            alt="Photo & Video VR360"
          />
          <h3>PHOTO & VIDEO VR360</h3>
          <p>
            Pembuatan video dan foto 360° untuk promosi atau pembuatan pemetaan
            keadaan sebenarnya dari sebuah lokasi.
          </p>
        </div>
      </div>
    </div>

    <!-- layanan end -->

    <!-- client -->

    <div class="clients-container">
      <div class="clients-content">
        <h2>OUR CLIENTS</h2>
        <p>More than 100 customers have used our services</p>
        <div class="clients-logos">
          <img src="logo1.png" alt="Client Logo 1" />
          <img src="logo2.png" alt="Client Logo 2" />
          <img src="logo3.png" alt="Client Logo 3" />
          <!-- Tambahkan logo lainnya sesuai kebutuhan -->
        </div>
      </div>
      <div class="clients-video">
        <iframe
          width="560"
          height="315"
          src="https://www.youtube.com/embed/your_video_id"
          title="YouTube video player"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
        ></iframe>
      </div>
    </div>

    <!-- client end -->

    <!-- content end -->

    <!-- footer -->

    <?php include "include/footer.php";?>

    <!-- footer end -->
    <!-- script js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- script js -->
  </body>
</html>
