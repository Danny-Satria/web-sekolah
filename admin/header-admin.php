<?php
// Memulai session dan output buffering
ob_start(); // Memulai output buffering
?>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
          <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Postingan</span>
        </a>
        <a href="?url=tambah-post" class="list-group-item list-group-item-action py-2 ripple ">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Tambah Postingan</span>
        </a>
        <a href="?url=edit-post" class="list-group-item list-group-item-action py-2 ripple ">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Edit Postingan</span>
        </a>
        <a href="?url=profile" class="list-group-item list-group-item-action py-2 ripple ">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>Tambah Profile</span>
        </a>
        <a href="logout.php" class="list-group-item list-group-item-action py-2 ripple">
          <i class="fas fa-chart-pie fa-fw me-3"></i><span>Logout</span>
        </a>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-primary fixed-top" >
    <div class="container-fluid" >
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
        aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <a class="navbar-brand text-white fw-bold" href="#">
        <img src="https://mdbcdn.b-cdn.net/img/logo/mdb-transaprent-noshadows.webp" height="25" alt="JMK LOGO" loading="lazy" />
      </a>

      <h1 class="navbar-brand text-white fw-bold" style="position : relative; top : .2em;">
        <strong><?php echo ucwords($_SESSION['username']); ?></strong>
      </h1>
    </div>
  </nav>
</header>
<!--Main Navigation-->
