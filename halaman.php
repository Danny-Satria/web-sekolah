<?php

if(isset($_GET['url'])){
    $url = $_GET['url'];
    switch ($url){

        case 'software':
        include "include/software.php";
        break;

        case 'game':
        include "include/game.php";
        break;

        case 'multimedia' :
        include "include/multimedia.php";
        break;

        case 'training' :
        include "include/training.php";
        break;
    }
}else{?>
    
    

<!-- divisi -->
<div class="container">
      <div class="text-section">
        <h1>Divisi Software Development</h1>
        <p>
          Pembuatan dan pengembangan aplikasi berbasis web, dekstop dan mobile
          untuk kebutuhan perusahaan, lembaga swasta dan pemerintah dalam
          memenuhi kebutuhan yang sangat tinggi terhadap teknologi informasi
        </p>
        <div class="horizontal-scroll">
          <div class="container-horizontal">
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/swift.png"
                alt=""
                width="100px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/C.png"
                alt=""
                width="100px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/codeigniter.png"
                alt=""
                width="90px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/node.png"
                alt=""
                width="150px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/java.png"
                alt=""
                width="150px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/sass.png"
                alt=""
                width="100px"
              />
            </div>
            <div class="item">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/handoop.png"
                alt=""
                width="200px"
              />
            </div>
          </div>
        </div>
        <div class="horizontal-scroll2">
          <div class="container-horizontal2">
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/kotlin.png"
                alt=""
                width="200px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/xamarine.png"
                alt=""
                width="250px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/angular.png"
                alt=""
                width="250px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/bootstrap.png"
                alt=""
                width="90px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/firebase.png"
                alt=""
                width="200px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/php.png"
                alt=""
                width="130px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/nginx.png"
                alt=""
                width="70px"
              />
            </div>
            <div class="item2">
              <img
                src="assets/images/Pictures/carousel horizontal/software dev/mongodb.png"
                alt=""
                width="200px"
              />
            </div>
          </div>
        </div>
        <a href="#" class="button">Lihat Proyek</a>
      </div>
      <div class="image-section">
        <img
          src="assets/images/Pictures/divisi/softdev.png"
          alt="Developer Workspace"
        />
      </div>
    </div>
    <!-- divisi end -->

    <?php
}
    ?>

